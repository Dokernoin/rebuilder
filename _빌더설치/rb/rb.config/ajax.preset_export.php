<?php
// rb/rb.config/ajax.preset_export_zip.php
// 성공: application/zip, 실패: application/json
header('X-Robots-Tag: noindex');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'POST만 허용됩니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    include_once('../../common.php'); // GNUBOARD5

    if (!class_exists('ZipArchive')) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'ZipArchive 확장이 필요합니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* ========== 입력 ========== */
    $preset_name = isset($_POST['preset_name']) ? trim($_POST['preset_name']) : '';
    $module_ids  = isset($_POST['module_ids'])  ? $_POST['module_ids']       : [];
    $preset_type = isset($_POST['preset_type']) ? trim($_POST['preset_type']) : '';
    $preset_type = ($preset_type === 'shop' || $preset_type === 'community')
                 ? $preset_type
                 : (defined('_SHOP_') ? 'shop' : 'community');

    // 스킨 실제 경로 계산에 필요
    $theme = isset($_POST['preset_md_theme']) ? trim($_POST['preset_md_theme']) : '';
    if ($theme === '' && isset($rb_core['theme'])) $theme = $rb_core['theme'];

    if ($preset_name === '' || !preg_match('/^[A-Za-z0-9]+$/', $preset_name)) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'프리셋 이름은 영문/숫자만 가능합니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    if (!is_array($module_ids)) $module_ids = explode(',', (string)$module_ids);
    $tmp = [];
    foreach ($module_ids as $v) { $iv = (int)$v; if ($iv>0) $tmp[$iv]=1; }
    $module_ids = array_keys($tmp);
    if (!$module_ids) {
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'선택된 모듈이 없습니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* ========== 테이블 분기 ========== */
    $table_name = ($preset_type === 'shop') ? 'rb_module_shop' : 'rb_module';

    /* ========== 유틸 ========== */
    function _norm($s){ return trim((string)$s, " \t\n\r\0\x0B/"); }
    function _starts_with_preset($s){
        $s = ltrim((string)$s, '/');
        return stripos($s, 'rb.preset/') === 0;
    }

    // 경로 치환 규칙
    // 1) md_widget      : rb.widget/...          -> rb.preset/{preset}/rb.widget/...
    // 2) md_poll        : theme/{x}              -> rb.preset/{preset}/skin/poll/{x}
    // 3) md_banner_skin : rb.mod/banner/skin/... -> rb.preset/{preset}/rb.mod/banner/skin/...
    // 4) md_skin        : theme/{x}              -> rb.preset/{preset}/skin/latest/{x}
    // 5) md_tab_skin    : theme/{x}              -> rb.preset/{preset}/skin/latest_tabs/{x}
    function rewrite_paths_for_preset($row, $preset_name){
        if (array_key_exists('md_widget',$row)){
            $v=_norm($row['md_widget']); if($v!==''&&!_starts_with_preset($v)) $row['md_widget']='rb.preset/'.$preset_name.'/'.$v;
        }
        if (array_key_exists('md_poll',$row)){
            $v=_norm($row['md_poll']); if($v!==''&&!_starts_with_preset($v)){
                if (stripos($v,'theme/')===0) $row['md_poll']='rb.preset/'.$preset_name.'/skin/poll/'._norm(substr($v, 6));
                else $row['md_poll']='rb.preset/'.$preset_name.'/skin/poll/'.$v;
            }
        }
        if (array_key_exists('md_banner_skin',$row)){
            $v=_norm($row['md_banner_skin']); if($v!==''&&!_starts_with_preset($v)) $row['md_banner_skin']='rb.preset/'.$preset_name.'/'.$v;
        }
        if (array_key_exists('md_skin',$row)){
            $v=_norm($row['md_skin']); if($v!==''&&!_starts_with_preset($v)){
                if (stripos($v,'theme/')===0) $row['md_skin']='rb.preset/'.$preset_name.'/skin/latest/'._norm(substr($v, 6));
                else $row['md_skin']='rb.preset/'.$preset_name.'/skin/latest/'.$v;
            }
        }
        if (array_key_exists('md_tab_skin',$row)){
            $v=_norm($row['md_tab_skin']); if($v!==''&&!_starts_with_preset($v)){
                if (stripos($v,'theme/')===0) $row['md_tab_skin']='rb.preset/'.$preset_name.'/skin/latest_tabs/'._norm(substr($v, 6));
                else $row['md_tab_skin']='rb.preset/'.$preset_name.'/skin/latest_tabs/'.$v;
            }
        }
        return $row;
    }

    /* ========== DB 조회 ========== */
    $ids_in = implode(',', array_map('intval',$module_ids));
    $sql = "SELECT * FROM `{$table_name}` WHERE md_id IN ($ids_in)";
    $res = sql_query($sql, false);
    if (!$res) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'DB 조회 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $mods = [];
    $flat = [];
    // ZIP에 넣을 대상 맵: 키=zip내상대경로, 값=소스절대경로(파일) 또는 ['dir'=>$srcDir] (디렉토리)
    $targets = [];

    while ($row = sql_fetch_array($res)) {
        $src_id = (int)$row['md_id'];

        // 관계 메타 (원본 md_layout 기준)
        $parent_src_id = null; $depth = 0;
        $ly = (string)$row['md_layout'];
        if ($ly!==''){ $tok=explode('-', $ly); $depth=max(count($tok)-1, 0); if(count($tok)>=2) $parent_src_id=(int)end($tok); }
        $flat[] = [
            'src_id'        => $src_id,
            'parent_src_id' => $parent_src_id ?: null,
            'title'         => (string)$row['md_title'],
            'order_id'      => isset($row['md_order_id'])?(int)$row['md_order_id']:0,
            'depth'         => $depth
        ];

        // 환경 의존 필드 제거
        unset($row['md_id'], $row['md_layout'], $row['md_layout_name'], $row['md_theme']);

        // 경로 치환
        $row = rewrite_paths_for_preset($row, $preset_name);

        // ZIP 대상 경로(치환 결과 기준) 수집
        foreach (['md_widget','md_poll','md_banner_skin','md_skin','md_tab_skin'] as $k){
            if (!array_key_exists($k,$row)) continue;
            $v=_norm($row[$k]); if($v===''||!_starts_with_preset($v)) continue;
            $zipRel = 'rb/'.$v; // ZIP 내부 상대경로
            $targets[$zipRel] = null; // 값은 아래에서 채움
        }

        unset($row['md_bo_table'], $row['md_tab_list'], $row['md_banner'], $row['md_poll']);

        $mods[] = $row;
    }

    if (!$mods) {
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'조회된 모듈이 없습니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    /* ========== 트리 구성 ========== */
    $nodes = [];
    foreach ($flat as $it){
        $nodes[$it['src_id']] = ['src_id'=>$it['src_id'],'title'=>$it['title'],'order_id'=>$it['order_id'],'parent_src_id'=>$it['parent_src_id'],'children'=>[]];
    }
    foreach ($flat as $it){
        if ($it['parent_src_id'] && isset($nodes[$it['parent_src_id']],$nodes[$it['src_id']])) $nodes[$it['parent_src_id']]['children'][]=&$nodes[$it['src_id']];
    }
    $tree=[];
    foreach($nodes as $id=>$n){ if(!$n['parent_src_id']||!isset($nodes[$n['parent_src_id']])) $tree[]=$n; }
    $sortFn=function(&$arr) use (&$sortFn){ usort($arr,function($a,$b){ if($a['order_id']===$b['order_id']) return strcmp($a['title'],$b['title']); return ($a['order_id']<$b['order_id'])?-1:1; }); foreach($arr as &$n){ if(!empty($n['children'])) $sortFn($n['children']); } };
    $sortFn($tree);

    /* ========== preset.json ========== */
    $payload = [
        'schema_version'=>1,
        'meta'=>[
            'rb_version'  => defined('RB_VER')?RB_VER:'',
            'preset_type' => $preset_type,
            'preset_name' => $preset_name,
            'exported_at' => date('c'),
        ],
        'modules'=>$mods,
        'flat'=>$flat,
        'tree'=>$tree
    ];
    $preset_json = json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);

    /* ========== ZIP 준비 ========== */
    $zip_base   = 'rb/rb.preset/';
    $zip_preset = $zip_base.$preset_name.'/';

    $tmp = tempnam(sys_get_temp_dir(), 'rbpreset_');
    $zip = new ZipArchive();
    if (true !== $zip->open($tmp, ZipArchive::OVERWRITE)) {
        @unlink($tmp);
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok'=>false,'message'=>'ZIP 생성 실패'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 프리셋 폴더 보장 + preset.json을 프리셋 폴더 안에 저장 (요구사항 변경 반영)
    $zip->addEmptyDir(rtrim($zip_preset,'/'));
    $zip->addFromString($zip_preset.'preset.json', $preset_json);

    // 헬퍼
    $added = [];
    $addEmptyDirOnce = function($path) use ($zip,&$added){
        $p = rtrim($path,'/');
        if(isset($added[$p])) return;
        $zip->addEmptyDir($p);
        $added[$p]=true;
    };
    $addFileOnce = function($abs,$dst) use ($zip,&$added){
        if(isset($added[$dst])) return;
        $zip->addFile($abs,$dst);
        $added[$dst]=true;
    };
    $addDirRecursive = function($src,$dst) use (&$addEmptyDirOnce,&$addFileOnce){
        $ignore = ['.','..','.git','.svn','node_modules','vendor','cache','.DS_Store'];
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($src, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach($it as $path=>$info){
            $base = basename($path);
            if(in_array($base,$ignore,true)) continue;
            if($info->isFile() && preg_match('/\.map$/i',$base)) continue;
            $local = rtrim($dst,'/').'/'.str_replace('\\','/',substr($path,strlen($src)+1));
            if($info->isDir()) $addEmptyDirOnce($local);
            else $addFileOnce($path,$local);
        }
    };

    // 실제 소스 루트
    $G5 = rtrim(G5_PATH,'/');
    $rbRoot    = $G5.'/rb/';
    $themeRoot = $G5.'/theme/'. $theme .'/';

    // manifest 작성용
    $manifest = [];
    $man = function($type,$dst,$src) use (&$manifest){ $manifest[] = sprintf("%s %s <- %s",$type,$dst,$src); };

    // 대상 매핑 & 추가
    foreach(array_keys($targets) as $dstRelFull){
        $prefix = 'rb/rb.preset/'.$preset_name.'/';
        if (stripos($dstRelFull,$prefix)!==0) continue;

        // rb.preset/{preset}/ 이후 경로
        $sub  = substr($dstRelFull, strlen('rb/')); // 'rb.preset/{preset}/...'
        $rest = substr($sub, strlen('rb.preset/'.$preset_name.'/')); // 'rb.widget/slug' or 'skin/...'

        // 1) 스킨: theme/<theme>/skin/...
        if (stripos($rest,'skin/latest_tabs/')===0 || stripos($rest,'skin/latest/')===0 || stripos($rest,'skin/poll/')===0) {
            if ($theme==='') continue;
            $srcDir = $themeRoot.$rest;
            if (is_dir($srcDir)) {
                $dst = $zip_preset.$rest;
                $addEmptyDirOnce(rtrim($dst,'/'));
                $addDirRecursive($srcDir, rtrim($dst,'/'));
                $man('D',$dst,$srcDir);
            }
            continue;
        }

        // 2) rb.* (rb.widget / rb.mod …) : /rb/ 하위
        $srcDir = $rbRoot.$rest;

        // 2-1) 디렉토리 그대로 복사
        if (is_dir($srcDir)) {
            $dst = $zip_preset.$rest;
            $addEmptyDirOnce(rtrim($dst,'/'));
            $addDirRecursive($srcDir, rtrim($dst,'/'));
            $man('D',$dst,$srcDir);
        }

        // 2-2) 위젯 느슨 파일을 slug 폴더로 수집해 ZIP에 넣기
        if (stripos($rest,'rb.widget/')===0) {
            $slug = basename($rest); // 예: kbo.match_schedule
            if (preg_match('/^[A-Za-z0-9._-]+$/',$slug)) {
                $widgetBase = $rbRoot.'rb.widget/';
                $dstDirZip  = $zip_preset.'rb.widget/'.$slug.'/';
                $addEmptyDirOnce(rtrim($dstDirZip,'/'));

                // 허용 패턴: slug로 시작 + (widget*.php | .*.php | _*.php)
                foreach (glob($widgetBase.$slug.'*') as $file) {
                    if (is_dir($file)) continue;
                    $base = basename($file);
                    $suffix = substr($base, strlen($slug));
                    $ok = false;
                    if (preg_match('/^widget.*\.php$/i',$suffix)) $ok = true;            // slugwidget*.php
                    elseif (preg_match('/^[._][A-Za-z0-9._-]+\.php$/i',$suffix)) $ok = true; // slug.*.php, slug_*.php
                    if ($ok) {
                        $dst = $dstDirZip.$base; // 폴더 안에
                        $addFileOnce($file,$dst);
                        $man('F',$dst,$file);
                    }
                }
            }
        }
    }

    // manifest.txt도 프리셋 폴더에 생성
    if (!empty($manifest)) {
        $zip->addFromString($zip_preset.'manifest.txt', implode("\n",$manifest)."\n");
    }

    $zip->close();

    // 전송
    $filename = 'preset_'.$preset_name.'.zip';
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="'.$filename.'"');
    header('Content-Length: '.filesize($tmp));
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    readfile($tmp);
    @unlink($tmp);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['ok'=>false,'message'=>'서버 오류','error'=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}
