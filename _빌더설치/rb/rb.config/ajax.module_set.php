<?php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;

// SQL escape (환경별 안전 처리)
if (!function_exists('rb_sql_esc')) {
  function rb_sql_esc($s){ return function_exists('sql_escape_string') ? sql_escape_string($s) : addslashes($s); }
}

if (!function_exists('rb_norm_list_json')) {
  function rb_norm_list_json($v, $prefix30=false) {
    $arr = [];

    // 배열 그대로 온 경우
    if (is_array($v)) {
      $arr = array_map(fn($x)=>trim((string)$x), $v);
    } else {
      $s = (string)$v;

      // 백슬래시로 이스케이프된 JSON 문자열이면 한번만 언이스케이프
      // 예: [\\\"1010\\\",\\\"1020\\\"] → ["1010","1020"]
      if (strpos($s, '\\"') !== false) $s = stripslashes($s);

      $s = trim($s);

      // JSON 배열 문자열 시도
      if ($s !== '' && $s[0] === '[' && substr($s, -1) === ']') {
        $decoded = json_decode($s, true);
        if (is_array($decoded)) {
          $arr = array_map(fn($x)=>trim((string)$x), $decoded);
        } else {
          // 실패하면 콤마 분리로 폴백
          $arr = array_map('trim', array_filter(explode(',', $s)));
        }
      } else {
        // 콤마 분리
        $arr = array_map('trim', array_filter(explode(',', $s)));
      }
    }

    // 값 정규화: 공백/빈 제거, 문자열화
    $arr = array_values(array_filter(array_map(fn($x)=>trim((string)$x), $arr), fn($x)=>$x !== ''));

    // 필요시 "30" 접두어 자동 부여 (숫자 4자리만 대상으로)
    if ($prefix30) {
      $arr = array_map(function($x){
        if (preg_match('/^\d{4}$/', $x)) return '30'.$x;
        return $x;
      }, $arr);
    }

    // 중복 제거(앞쪽 우선)
    $arr = array_values(array_unique($arr));

    // JSON 배열 문자열로 반환
    return json_encode($arr, JSON_UNESCAPED_UNICODE);
  }
}

// on/off 계열 정규화: 배열 → '1' 또는 '값1,값2' / 스칼라는 문자열, 완전 빈 배열은 ''(=저장 제외 대상)
if (!function_exists('rb_norm_onoff')) {
  function rb_norm_onoff($v){
    if (is_array($v)) {
      $flat = array_values(array_filter($v, fn($x)=>$x!=='' && $x!==null));
      if (!count($flat)) return '';
      if (count(array_unique($flat))===1 && $flat[0]==='1') return '1';
      return implode(',', $flat);
    }
    return (string)$v;
  }
}

// 테이블 컬럼 목록 캐시
if (!function_exists('rb_table_columns')) {
  function rb_table_columns($table){
    static $cache = [];
    if (isset($cache[$table])) return $cache[$table];
    $cols = [];
    $rs = sql_query("SHOW COLUMNS FROM `{$table}`");
    while ($row = sql_fetch_array($rs)) { $cols[$row['Field']] = true; }
    return $cache[$table] = $cols;
  }
}

// POST → SET 절 빌더: md_*만, 빈값('')은 제외, '0'은 저장, 배열은 공백 제거 후 비면 제외
if (!function_exists('rb_build_sets_from_post')) {
  function rb_build_sets_from_post($post, $table, $is_update=false){
    $cols = rb_table_columns($table);
    $sets = [];
    foreach ($post as $k=>$v) {
      if (strpos($k,'md_') !== 0) continue; // md_*만
      if ($k === 'md_id') continue;         // where 키 제외
      if (!isset($cols[$k])) continue;      // 테이블에 없는 컬럼은 스킵

      // *_is on/off 정규화
      if (preg_match('/_is$/', $k)) $v = rb_norm_onoff($v);

        if ($k === 'md_item_tab_list') {
        $json = rb_norm_list_json($v, /*prefix30*/ true);
        if ($json === '[]') continue; // 빈 리스트면 저장 제외
        $sets[] = $k."='".rb_sql_esc($json)."'";
        continue;
      }
      // (선택) 최신글 탭 리스트도 JSON 고정 저장
      if ($k === 'md_tab_list') {
        $json = rb_norm_list_json($v, /*prefix30*/ false);
        if ($json === '[]') continue;
        $sets[] = $k."='".rb_sql_esc($json)."'";
        continue;
      }

      if (is_array($v)) {
        $v = array_values(array_filter($v, fn($x)=>$x!=='' && $x!==null));
        if (!count($v)) continue;            // 완전 빈 배열 → 저장 제외
        $v = implode(',', $v);
      } else {
        if ($v === '' || $v === null) continue; // 빈 문자열/NULL은 저장 제외 (단 '0'은 살아남음)
        $v = (string)$v;
      }

      $sets[] = $k."='".rb_sql_esc($v)."'";
    }
    return $sets;
  }
}

// 메타 컬럼을 "있으면" 추가
if (!function_exists('rb_add_meta_sets_if_exists')) {
  function rb_add_meta_sets_if_exists(&$sets, $table, $meta){
    $cols = rb_table_columns($table);
    foreach ($meta as $col => $val) {
      if (isset($cols[$col])) $sets[] = $col."='".rb_sql_esc($val)."'";
    }
  }
}

// ==== PRESET API (isolated; doesn't affect existing module actions) ====
if (!function_exists('rb_json_output')) {
    function rb_json_output($arr) {
        if (!headers_sent()) header('Content-Type: application/json; charset=utf-8');
        while (ob_get_level()) { ob_end_clean(); }
        echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        exit;
    }
}


if (isset($_REQUEST['preset_action'])) {
    $preset_action = $_REQUEST['preset_action'];

    // CSRF
    $csrf = isset($_REQUEST['csrf']) ? $_REQUEST['csrf'] : '';
    if (!isset($_SESSION['rb_widget_csrf']) || $_SESSION['rb_widget_csrf'] !== $csrf) {
        rb_json_output(['status'=>'error','msg'=>'Invalid CSRF']);
    }

    // 권한
    if (empty($is_admin)) rb_json_output(['status'=>'error','msg'=>'권한이 없습니다.']);

    if (!function_exists('rb_esq')) {
        function rb_esq($s){ return function_exists('sql_real_escape_string') ? sql_real_escape_string($s) : addslashes($s); }
    }

    $req_shop = isset($_REQUEST['is_shop']) ? (int)$_REQUEST['is_shop'] : 0;
    //$table    = ($req_shop === 1) ? 'rb_module_lib_shop' : 'rb_module_lib'; //rb_module_lib_shop 테이블 잠시 사용안함
    $table    = 'rb_module_lib';

    // ensure table
    $create_sql = "CREATE TABLE IF NOT EXISTS `{$table}` (
      `lib_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `md_theme` VARCHAR(100) NOT NULL DEFAULT '',
      `md_layout` VARCHAR(255) NOT NULL DEFAULT '',
      `title` VARCHAR(255) NOT NULL DEFAULT '',
      `md_type` VARCHAR(50) NOT NULL DEFAULT '',
      `md_show` VARCHAR(20) NOT NULL DEFAULT 0,
      `width_text` VARCHAR(50) NOT NULL DEFAULT '',
      `payload_json` MEDIUMTEXT NOT NULL,
      `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`lib_id`),
      KEY `idx_theme_layout` (`md_theme`,`md_layout`)
    )";
    @sql_query($create_sql);

    $filter_payload = function($src){
        $dst = [];
        foreach ($src as $k=>$v) {
            if ($k==='csrf' || $k==='preset_action' || $k==='is_shop') continue;
            if (strpos($k,'md_')===0) $dst[$k]=$v;
        }
        if (isset($src['md_theme']))  $dst['md_theme']=$src['md_theme'];
        if (isset($src['md_layout'])) $dst['md_layout']=$src['md_layout'];
        return $dst;
    };

    if ($preset_action === 'preset_save') {
        $payload     = $filter_payload($_POST);
        $md_theme    = isset($_POST['md_theme'])  ? $_POST['md_theme']  : '';
        $md_layout   = isset($_POST['md_layout']) ? $_POST['md_layout'] : '';
        $title       = isset($_POST['md_title'])  ? $_POST['md_title']  : '';
        $md_type     = isset($_POST['md_type'])   ? $_POST['md_type']   : (isset($_POST['md_module']) ? $_POST['md_module'] : '');
        $unit       = isset($_POST['md_size'])  ? $_POST['md_size']  : '';
        $width_num  = isset($_POST['md_width']) ? $_POST['md_width'] : '';
        $width_text = ($width_num !== '' ? $width_num : '') . ($unit !== '' ? $unit : '');
        $md_show    = isset($_POST['md_show'])  ? $_POST['md_show']  : '';

        $payload_json = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $ins = "INSERT INTO `{$table}`
                (`md_theme`,`md_layout`,`title`,`md_type`,`md_show`,`width_text`,`payload_json`,`created_at`,`updated_at`)
                VALUES (
                    '".rb_esq($md_theme)."',
                    '".rb_esq($md_layout)."',
                    '".rb_esq($title)."',
                    '".rb_esq($md_type)."',
                    '".rb_esq($md_show)."',
                    '".rb_esq($width_text)."',
                    '".rb_esq($payload_json)."',
                    '".G5_TIME_YMDHIS."', '".G5_TIME_YMDHIS."'
                )";
        sql_query($ins);
        $new_id = function_exists('sql_insert_id') ? (int)sql_insert_id() : 0;
        rb_json_output(['status'=>'ok','lib_id'=>$new_id]);
    }

    if ($preset_action === 'preset_list') {
        $md_theme  = isset($_GET['md_theme'])  ? $_GET['md_theme']  : '';
        $q = "SELECT lib_id, title, md_type, md_show, width_text, created_at
              FROM `{$table}` WHERE 1";
        if ($md_theme  !== '') $q .= " AND md_theme  = '".rb_esq($md_theme)."'";

        if ($req_shop !== 1) {
            $q .= " AND md_type NOT IN ('item','item_tab')";
        }

        $q .= " ORDER BY lib_id  ";
        $rs = sql_query($q);
        $rows = [];
        for ($i=0; $row = sql_fetch_array($rs); $i++) $rows[] = $row;
        rb_json_output(['status'=>'ok','rows'=>$rows]);
    }

    if ($preset_action === 'preset_get') {
        $lib_id = isset($_GET['lib_id']) ? (int)$_GET['lib_id'] : 0;
        if ($lib_id < 1) rb_json_output(['status'=>'error','msg'=>'invalid id']);

        $row = sql_fetch("SELECT md_type, payload_json FROM `{$table}` WHERE lib_id = {$lib_id}");
        if (!$row) rb_json_output(['status'=>'error','msg'=>'not found']);

        $payload = json_decode($row['payload_json'], true);
        if (!is_array($payload)) $payload = [];

        // payload/컬럼 중 하나라도 item 계열이면 차단
        $md_type_col = isset($row['md_type']) ? $row['md_type'] : '';
        $md_type_pld = isset($payload['md_type']) ? $payload['md_type'] : '';
        $md_type     = $md_type_pld !== '' ? $md_type_pld : $md_type_col;

        if ($req_shop !== 1 && in_array($md_type, ['item','item_tab'], true)) {
            rb_json_output(['status'=>'error','msg'=>'not allowed']);
        }

        rb_json_output(['status'=>'ok','payload'=>$payload]);
    }

    if ($preset_action === 'preset_delete') {
        $lib_id = isset($_POST['lib_id']) ? (int)$_POST['lib_id'] : 0;
        if ($lib_id < 1) rb_json_output(['status'=>'error','msg'=>'invalid id']);
        sql_query("DELETE FROM `{$table}` WHERE lib_id = {$lib_id}");
        rb_json_output(['status'=>'ok']);
    }

    rb_json_output(['status'=>'error','msg'=>'unknown preset_action']);
}
// ==== END PRESET API ====


$md_id = isset($_POST['md_id']) ? $_POST['md_id'] : '';
$md_title = isset($_POST['md_title']) ? $_POST['md_title'] : '';
$md_title_color = isset($_POST['md_title_color']) ? $_POST['md_title_color'] : '#25282b';
$md_title_size = isset($_POST['md_title_size']) ? $_POST['md_title_size'] : '20';
$md_title_font = isset($_POST['md_title_font']) ? $_POST['md_title_font'] : 'font-B';
$md_title_hide = isset($_POST['md_title_hide']) ? $_POST['md_title_hide'] : '0';
$md_layout = isset($_POST['md_layout']) ? $_POST['md_layout'] : '';
$md_skin = isset($_POST['md_skin']) ? $_POST['md_skin'] : '';
$md_tab_list = isset($_POST['md_tab_list']) ? $_POST['md_tab_list'] : '';
$md_tab_skin = isset($_POST['md_tab_skin']) ? $_POST['md_tab_skin'] : '';
$md_item_tab_list = isset($_POST['md_item_tab_list']) ? $_POST['md_item_tab_list'] : '';
$md_item_tab_skin = isset($_POST['md_item_tab_skin']) ? $_POST['md_item_tab_skin'] : '';
$md_type = isset($_POST['md_type']) ? $_POST['md_type'] : '';
$md_bo_table = isset($_POST['md_bo_table']) ? $_POST['md_bo_table'] : '';
$md_sca = isset($_POST['md_sca']) ? $_POST['md_sca'] : '';
$md_widget = isset($_POST['md_widget']) ? $_POST['md_widget'] : '';
$md_banner = isset($_POST['md_banner']) ? $_POST['md_banner'] : '';
$md_banner_id = isset($_POST['md_banner_id']) ? $_POST['md_banner_id'] : '';
$md_banner_bg = isset($_POST['md_banner_bg']) ? $_POST['md_banner_bg'] : '';
$md_banner_skin = isset($_POST['md_banner_skin']) ? $_POST['md_banner_skin'] : '';
$md_poll = isset($_POST['md_poll']) ? $_POST['md_poll'] : '';
$md_poll_id = isset($_POST['md_poll_id']) ? $_POST['md_poll_id'] : '';
$md_theme = isset($_POST['md_theme']) ? $_POST['md_theme'] : '';
$md_sec_key = isset($_POST['md_sec_key']) ? $_POST['md_sec_key'] : '';
$md_sec_uid = isset($_POST['md_sec_uid']) ? $_POST['md_sec_uid'] : '';
$md_layout_name = isset($_POST['md_layout_name']) ? $_POST['md_layout_name'] : '';
$md_cnt = isset($_POST['md_cnt']) ? $_POST['md_cnt'] : '1';
$md_notice = isset($_POST['md_notice']) ? $_POST['md_notice'] : '0';
$md_wide_is = isset($_POST['md_wide_is']) ? $_POST['md_wide_is'] : '0';
$md_arrow_type = isset($_POST['md_arrow_type']) ? $_POST['md_arrow_type'] : '0';
$md_col = isset($_POST['md_col']) ? $_POST['md_col'] : '1';
$md_row = isset($_POST['md_row']) ? $_POST['md_row'] : '1';
$md_col_mo = isset($_POST['md_col_mo']) ? $_POST['md_col_mo'] : '1';
$md_row_mo = isset($_POST['md_row_mo']) ? $_POST['md_row_mo'] : '1';
$md_width = isset($_POST['md_width']) ? $_POST['md_width'] : '100%';
$md_height = isset($_POST['md_height']) ? $_POST['md_height'] : '';
$md_show = isset($_POST['md_show']) ? $_POST['md_show'] : '';
$md_size = isset($_POST['md_size']) ? $_POST['md_size'] : '%';
$md_subject_is = isset($_POST['md_subject_is']) ? $_POST['md_subject_is'] : '';
$md_thumb_is = isset($_POST['md_thumb_is']) ? $_POST['md_thumb_is'] : '';
$md_nick_is = isset($_POST['md_nick_is']) ? $_POST['md_nick_is'] : '';
$md_date_is = isset($_POST['md_date_is']) ? $_POST['md_date_is'] : '';
$md_comment_is = isset($_POST['md_comment_is']) ? $_POST['md_comment_is'] : '';
$md_content_is = isset($_POST['md_content_is']) ? $_POST['md_content_is'] : '';
$md_icon_is = isset($_POST['md_icon_is']) ? $_POST['md_icon_is'] : '';
$md_ca_is = isset($_POST['md_ca_is']) ? $_POST['md_ca_is'] : '';
$md_gap = isset($_POST['md_gap']) ? $_POST['md_gap'] : '40';
$md_gap_mo = isset($_POST['md_gap_mo']) ? $_POST['md_gap_mo'] : '20';
$md_swiper_is = isset($_POST['md_swiper_is']) ? $_POST['md_swiper_is'] : '';
$md_auto_is = isset($_POST['md_auto_is']) ? $_POST['md_auto_is'] : '';
$md_auto_time = isset($_POST['md_auto_time']) ? $_POST['md_auto_time'] : '';
$md_module = isset($_POST['md_module']) ? $_POST['md_module'] : '';
$md_soldout_hidden = isset($_POST['md_soldout_hidden']) ? $_POST['md_soldout_hidden'] : '';
$md_soldout_asc = isset($_POST['md_soldout_asc']) ? $_POST['md_soldout_asc'] : '';
$md_order = isset($_POST['md_order']) ? $_POST['md_order'] : '';
$md_order_latest = isset($_POST['md_order_latest']) ? $_POST['md_order_latest'] : '';
$md_order_banner = isset($_POST['md_order_banner']) ? $_POST['md_order_banner'] : '';
$md_border = isset($_POST['md_border']) ? $_POST['md_border'] : '';
$md_radius = isset($_POST['md_radius']) ? $_POST['md_radius'] : '0';
$md_padding = isset($_POST['md_padding']) ? $_POST['md_padding'] : '0';
$md_margin_top_pc = isset($_POST['md_margin_top_pc']) ? $_POST['md_margin_top_pc'] : '';
$md_margin_top_mo = isset($_POST['md_margin_top_mo']) ? $_POST['md_margin_top_mo'] : '';
$md_margin_btm_pc = isset($_POST['md_margin_btm_pc']) ? $_POST['md_margin_btm_pc'] : '';
$md_margin_btm_mo = isset($_POST['md_margin_btm_mo']) ? $_POST['md_margin_btm_mo'] : '';
$del = isset($_POST['del']) ? $_POST['del'] : '';
$is_shop = isset($_POST['is_shop']) ? $_POST['is_shop'] : '';

if(isset($is_shop) && $is_shop == 1) {
    $rb_module_tables = "rb_module_shop";
} else { 
    $rb_module_tables = "rb_module";
}

?>


    <?php
        if(isset($del) && $del == "true") { 
            
            if($is_admin) {
                $sql = " delete from {$rb_module_tables} where md_id = '{$md_id}' and md_layout = '{$md_layout}' and md_theme = '{$md_theme}' and md_layout_name = '{$md_layout_name}' ";
                sql_query($sql);
            }
            $data = array(
                'status' => 'ok',
            );
            echo json_encode($data);
            
            
        } else {
            if(isset($md_id) && $md_id == "new") {
                
                // rb_module 테이블에 md_sca 컬럼이 있는지 검사
                $checkColumnQuery = "SHOW COLUMNS FROM `rb_module` LIKE 'md_sca'";
                $result = sql_query($checkColumnQuery);
                
                if (sql_num_rows($result) == 0) {
                    // md_sca 컬럼이 없으면 추가
                    $addColumnQuery = "ALTER TABLE {$rb_module_tables} ADD `md_sca` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `md_bo_table`";
                    sql_query($addColumnQuery);
                }
                
                // rb_module 테이블에 md_order_id 컬럼이 있는지 검사
                $checkColumnQuery2 = "SHOW COLUMNS FROM {$rb_module_tables} LIKE 'md_order_id'";
                $result2 = sql_query($checkColumnQuery2);
                
                if (sql_num_rows($result2) == 0) {
                    // md_order_id 컬럼이 없으면 추가
                    $addColumnQuery2 = "ALTER TABLE {$rb_module_tables} ADD `md_order_id` INT(4) COLLATE 'utf8_general_ci' NOT NULL AFTER `md_ip`";
                    sql_query($addColumnQuery2);
                }


                if ($is_admin) {
                    // 필요하면 md_order_id만 계산 (컬럼이 있을 때만 쓸 거라 안전)
                    $md_order_id = 0;
                    $cols = rb_table_columns($rb_module_tables);
                    if (isset($cols['md_order_id'])) {
                      $row = sql_fetch("SELECT MAX(md_order_id) AS max_value FROM {$rb_module_tables}");
                      $md_order_id = isset($row['max_value']) ? ((int)$row['max_value'] + 1) : 0;
                    }

                    // 1) POST로 실제 들어온 md_* 중 "값 있는 것만" SET 만들기 (0은 저장됨)
                    $md_sets = rb_build_sets_from_post($_POST, $rb_module_tables, false);

                    // 2) 메타 컬럼(있으면) 추가
                    rb_add_meta_sets_if_exists($md_sets, $rb_module_tables, [
                      'md_datetime' => G5_TIME_YMDHIS,
                      'md_ip'       => $_SERVER['REMOTE_ADDR'],
                      'md_order_id' => $md_order_id,
                    ]);

                    // 3) 아무 것도 없으면 최소한 타입/레이아웃/제목 같은 기본 POST가 있으면 자동 포함됨
                    if (empty($md_sets)) {
                      echo json_encode(['status'=>'error','msg'=>'nothing to insert']); exit;
                    }

                    $sql = "INSERT {$rb_module_tables} SET ".implode(',', $md_sets);
                    sql_query($sql);

                    echo json_encode(['status'=>'ok','md_title'=>$md_title]); exit;
                }

            } else {

                if ($is_admin) {
                    // 1) POST md_* 중 값 있는 것만
                    $sets = rb_build_sets_from_post($_POST, $rb_module_tables, true);

                    // 2) 메타(있으면)
                    rb_add_meta_sets_if_exists($sets, $rb_module_tables, [
                      'md_datetime' => G5_TIME_YMDHIS,
                      'md_ip'       => $_SERVER['REMOTE_ADDR'],
                    ]);

                    if (!empty($sets)) {
                        $sql = "UPDATE {$rb_module_tables} SET ".implode(',', $sets)." WHERE md_id='".rb_sql_esc($md_id)."'";
                        sql_query($sql);
                    }

                    echo json_encode(['status'=>'ok','md_title'=>$md_title]); exit;
                }


            }
        }
    ?>

