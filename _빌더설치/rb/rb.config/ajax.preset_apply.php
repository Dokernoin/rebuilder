<?php
// rb/rb.config/ajax.preset_apply.php
// 응답: application/json
header('Content-Type: application/json; charset=utf-8');
header('X-Robots-Tag: noindex');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['ok'=>false,'message'=>'POST만 허용됩니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    include_once('../../common.php'); // GNUBOARD5

    // ===== 입력 =====
    $preset_dir   = isset($_POST['preset_dir']) ? trim($_POST['preset_dir']) : '';
    $preset_type  = isset($_POST['preset_type']) ? trim($_POST['preset_type']) : ''; // 'shop' | 'community' (옵션)
    $md_theme     = isset($_POST['preset_md_theme']) ? trim($_POST['preset_md_theme']) : '';
    $md_layout_nm = isset($_POST['preset_md_layout']) ? trim($_POST['preset_md_layout']) : ''; // 레이아웃 이름
    $md_layout_id = isset($_POST['preset_selected_layout']) ? trim($_POST['preset_selected_layout']) : ''; // 레이아웃 ID

    // 기본 검증
    if ($preset_dir === '' || !preg_match('/^[A-Za-z0-9._-]+$/', $preset_dir)) {
        http_response_code(400);
        echo json_encode(['ok'=>false,'message'=>'유효하지 않은 프리셋입니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    if ($md_theme === '' || $md_layout_nm === '' || $md_layout_id === '') {
        http_response_code(400);
        echo json_encode(['ok'=>false,'message'=>'테마/레이아웃 값이 누락되었습니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // 프리셋 로드
    $preset_json_path = rtrim(G5_PATH,'/').'/rb/rb.preset/'.$preset_dir.'/preset.json';
    if (!is_file($preset_json_path)) {
        http_response_code(404);
        echo json_encode(['ok'=>false,'message'=>'preset.json을 찾을 수 없습니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }
    $jtxt = @file_get_contents($preset_json_path);
    $j = json_decode($jtxt, true);
    if (!is_array($j) || !isset($j['modules']) || !is_array($j['modules'])) {
        http_response_code(400);
        echo json_encode(['ok'=>false,'message'=>'올바르지 않은 preset.json 형식입니다.'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // preset_type 결정: POST 우선 → preset.json → 실행 컨텍스트
    $meta_ptype = '';
    if (isset($j['meta']['preset_type'])) $meta_ptype = strtolower(trim($j['meta']['preset_type']));
    $preset_type = ($preset_type === 'shop' || $preset_type === 'community') ? $preset_type
                 : ($meta_ptype === 'shop' || $meta_ptype === 'community' ? $meta_ptype
                 : (defined('_SHOP_') ? 'shop' : 'community'));

    $table = ($preset_type === 'shop') ? 'rb_module_shop' : 'rb_module';

    // 인덱스 정렬 가정: export 시 flat[]와 modules[]는 같은 순서로 생성됨
    $modules = $j['modules'];
    $flat    = isset($j['flat']) && is_array($j['flat']) ? $j['flat'] : [];

    // src_id -> flat index 맵
    $idx_by_src = [];
    foreach ($flat as $i => $f) {
        if (isset($f['src_id'])) $idx_by_src[(int)$f['src_id']] = $i;
    }

    // tree는 부모→자식 순서 삽입용
    $tree = isset($j['tree']) && is_array($j['tree']) ? $j['tree'] : [];

    // ===== 기존 동일 환경(테마/레이아웃이름/레이아웃ID) 데이터 삭제 =====
    // MyISAM이라 트랜잭션 불가. 순차 실행
    $esc = function($v){
        if (function_exists('sql_escape_string')) return sql_escape_string($v);
        return addslashes($v);
    };
    $q_del = "DELETE FROM `{$table}` 
              WHERE md_theme = '". $esc($md_theme) ."' 
                AND md_layout_name = '". $esc($md_layout_nm) ."' 
                AND md_layout = '". $esc($md_layout_id) ."'";
    sql_query($q_del, false);

    // ===== INSERT: 부모 → 자식 DFS =====
    $new_id_map = []; // old src_id -> new md_id
    $inserted = 0;

    // INSERT 1개
    $insert_one = function($src_id, $parent_new_id = null) use ($modules,$flat,$idx_by_src,$table,$md_theme,$md_layout_nm,$md_layout_id,$esc,&$new_id_map,&$inserted) {

        if (!isset($idx_by_src[$src_id])) return false;
        $idx = $idx_by_src[$src_id];

        if (!isset($modules[$idx]) || !is_array($modules[$idx])) return false;

        $row = $modules[$idx];

        // 환경 필드 덮어쓰기
        $row['md_theme']      = $md_theme;
        $row['md_layout_name']= $md_layout_nm;
        // md_layout: 부모가 없으면 L, 있으면 L-<부모신규ID>
        $row['md_layout']     = $parent_new_id ? ($md_layout_id . '-' . (int)$parent_new_id) : $md_layout_id;

        // SET 절 작성
        $sets = [];
        foreach ($row as $k => $v) {
            // 안전하게 컬럼명 백틱 처리
            $sets[] = '`'.$k.'`' . "='" . $esc($v) . "'";
        }
        $sql = "INSERT INTO `{$table}` SET ". implode(',', $sets);
        $ok = sql_query($sql, false);
        if (!$ok) return false;

        // 신규 ID
        $new_id = sql_insert_id();
        if (!$new_id) {
            // 일부 환경은 sql_insert_id() 가 0을 줄 수 있음 → 보조 조회
            $res = sql_query("SELECT MAX(md_id) AS mid FROM `{$table}`", false);
            $tmp = $res ? sql_fetch($res) : null;
            $new_id = $tmp && isset($tmp['mid']) ? (int)$tmp['mid'] : 0;
        }

        if ($new_id) {
            $new_id_map[$src_id] = $new_id;
            $inserted++;
            return $new_id;
        }
        return false;
    };

    // DFS로 삽입
    $dfs = function($node, $parent_new_id = null) use (&$dfs,$insert_one,&$new_id_map) {
        $src = isset($node['src_id']) ? (int)$node['src_id'] : 0;
        if (!$src) return;

        // 부모 먼저
        $cur_new = $insert_one($src, $parent_new_id);
        if (!$cur_new) return;

        // 자식들
        if (!empty($node['children']) && is_array($node['children'])) {
            foreach ($node['children'] as $ch) {
                $dfs($ch, $cur_new);
            }
        }
    };

    // 루트 노드들부터
    foreach ($tree as $root) $dfs($root, null);

    echo json_encode([
        'ok'=>true,
        'message'=>'프리셋 적용 완료',
        'applied_to'=>[
            'table'=>$table,
            'md_theme'=>$md_theme,
            'md_layout_name'=>$md_layout_nm,
            'md_layout'=>$md_layout_id
        ],
        'inserted'=>$inserted
    ], JSON_UNESCAPED_UNICODE);
    exit;

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['ok'=>false,'message'=>'서버 오류','error'=>$e->getMessage()], JSON_UNESCAPED_UNICODE);
    exit;
}
