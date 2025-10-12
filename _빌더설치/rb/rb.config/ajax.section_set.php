<?php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;


// 입력
$sec_title        = $_POST['sec_title']        ?? '';
$sec_layout       = $_POST['sec_layout']       ?? '';
$sec_layout_name  = $_POST['sec_layout_name']  ?? '';
$sec_theme        = $_POST['sec_theme']        ?? '';
$sec_id           = $_POST['sec_id']           ?? '';
$sec_uid          = $_POST['sec_uid']          ?? '';

$sec_title_color  = $_POST['sec_title_color']  ?? '#25282b';
$sec_title_size   = $_POST['sec_title_size']   ?? '26';
$sec_title_font   = $_POST['sec_title_font']   ?? 'font-B';
$sec_title_align  = $_POST['sec_title_align']  ?? 'center';
$sec_title_hide   = $_POST['sec_title_hide']   ?? '0';

$sec_sub_title        = $_POST['sec_sub_title']        ?? '';
$sec_sub_title_color  = $_POST['sec_sub_title_color']  ?? '#25282b';
$sec_sub_title_size   = $_POST['sec_sub_title_size']   ?? '18';
$sec_sub_title_font   = $_POST['sec_sub_title_font']   ?? 'font-R';
$sec_sub_title_align  = $_POST['sec_sub_title_align']  ?? 'center';
$sec_sub_title_hide   = $_POST['sec_sub_title_hide']   ?? '0';

$sec_width        = $_POST['sec_width']        ?? '0';
$sec_con_width    = $_POST['sec_con_width']    ?? '0';
$sec_padding_pc   = $_POST['sec_padding_pc']   ?? '0';
$sec_padding_mo   = $_POST['sec_padding_mo']   ?? '0';
$sec_margin_top_pc   = $_POST['sec_margin_top_pc']   ?? '0';
$sec_margin_top_mo   = $_POST['sec_margin_top_mo']   ?? '0';
$sec_margin_btm_pc   = $_POST['sec_margin_btm_pc']   ?? '0';
$sec_margin_btm_mo   = $_POST['sec_margin_btm_mo']   ?? '0';
$sec_bg           = $_POST['sec_bg']           ?? '#FFFFFF';

$sec_padding = isset($_POST['sec_padding']) ? $_POST['sec_padding'] : '0';
$sec_padding_lr_pc = isset($_POST['sec_padding_lr_pc']) ? $_POST['sec_padding_lr_pc'] : '';
$sec_padding_lr_mo = isset($_POST['sec_padding_lr_mo']) ? $_POST['sec_padding_lr_mo'] : '';
$sec_padding_tb_pc = isset($_POST['sec_padding_tb_pc']) ? $_POST['sec_padding_tb_pc'] : '';
$sec_padding_tb_mo = isset($_POST['sec_padding_tb_mo']) ? $_POST['sec_padding_tb_mo'] : '';

$sec_1        = $_POST['sec_1']        ?? '';
$sec_2        = $_POST['sec_2']        ?? '';
$sec_3        = $_POST['sec_3']        ?? '';
$sec_4        = $_POST['sec_4']        ?? '';
$sec_5        = $_POST['sec_5']        ?? '';
$sec_6        = $_POST['sec_6']        ?? '';
$sec_7        = $_POST['sec_7']        ?? '';
$sec_8        = $_POST['sec_8']        ?? '';
$sec_9        = $_POST['sec_9']        ?? '';
$sec_10        = $_POST['sec_10']        ?? '';

$del              = $_POST['del']              ?? '';
$is_shop          = $_POST['is_shop']          ?? '';

$rb_section_tables = ($is_shop == '1') ? "rb_section_shop" : "rb_section";
$rb_module_tables  = ($is_shop == '1') ? "rb_module_shop"  : "rb_module";

// 간단 이스케이프 (그누보드에선 sql_escape_string 사용)
function esc($s){ return sql_escape_string($s); }
// 정수 캐스팅
function i($v){ return (int)$v; }

// 고유키 생성기 (영문+숫자, 접두사 포함)
function gen_sec_key() {
    // 예: sec_k3p9t7d2m4x8 형태
    $seed = bin2hex(random_bytes(6));              // 12 hex
    $ts   = base_convert((string)time(), 10, 36);  // base36 timestamp
    return 'sec_' . $ts . '_' . $seed;
}

// 컬럼 보장(레거시 대비)
$res = sql_query("SHOW COLUMNS FROM {$rb_section_tables} LIKE 'sec_order_id'");
if (sql_num_rows($res) == 0) {
    sql_query("ALTER TABLE {$rb_section_tables} ADD `sec_order_id` INT(11) NOT NULL DEFAULT 0");
}
$res = sql_query("SHOW COLUMNS FROM {$rb_section_tables} LIKE 'sec_key'");
if (sql_num_rows($res) == 0) {
    sql_query("ALTER TABLE {$rb_section_tables} ADD `sec_key` VARCHAR(40) NOT NULL UNIQUE");
}
$res = sql_query("SHOW COLUMNS FROM {$rb_section_tables} LIKE 'sec_uid'");
if (sql_num_rows($res) == 0) {
    sql_query("ALTER TABLE {$rb_section_tables} ADD `sec_uid` VARCHAR(80) NOT NULL, ADD INDEX(`sec_uid`)");
}

function is_new_sec($v) {
    // "", null, "0", 0, "new" 모두 신규로 본다
    if ($v === null) return true;
    if ($v === '' || $v === '0' || $v === 0) return true;
    if (is_string($v) && strtolower($v) === 'new') return true;
    return false;
}

header('Content-Type: application/json; charset=utf-8');

// 삭제
if ($del === "true") {
    if (!$is_admin) { echo json_encode(['status'=>'error','msg'=>'권한 없음']); exit; }
    $sec_id_int = i($sec_id);
    if ($sec_id_int <= 0) { echo json_encode(['status'=>'error','msg'=>'유효하지 않은 sec_id']); exit; }

    // sec_uid가 안 넘어오면 DB에서 조회 (안전망)
    if ($sec_uid === '' || $sec_uid === null) {
        $row = sql_fetch("SELECT sec_uid FROM {$rb_section_tables} WHERE sec_id = {$sec_id_int} LIMIT 1");
        if ($row && isset($row['sec_uid'])) $sec_uid = $row['sec_uid'];
    }

    // 이 섹션에 소속된 모듈(동일 md_sec_uid)을 먼저 삭제
    if ($sec_uid !== '' && $sec_uid !== null) {
        sql_query("DELETE FROM {$rb_module_tables} WHERE md_sec_uid = '".esc($sec_uid)."'");
    }

    sql_query("DELETE FROM {$rb_section_tables} WHERE sec_id = {$sec_id_int}");
    echo json_encode(['status'=>'ok']); exit;
}

// 생성/수정
if (is_new_sec($sec_id)) {

    if (!$is_admin) { echo json_encode(['status'=>'error','msg'=>'권한 없음']); exit; }

    // 같은 레이아웃/테마/레이아웃명 내에서 "모듈+섹션 공통" 최대 순번 + 1
    $layout_no   = esc($sec_layout);
    $layout_name = esc($sec_layout_name);
    $theme_name  = esc($sec_theme);

    $sql_max = "
      SELECT MAX(ordv) AS maxv FROM (
        SELECT md_order_id AS ordv
          FROM {$rb_module_tables}
         WHERE md_layout = '{$layout_no}'
           AND md_theme = '{$theme_name}'
           AND md_layout_name = '{$layout_name}'
        UNION ALL
        SELECT sec_order_id AS ordv
          FROM {$rb_section_tables}
         WHERE sec_layout = '{$layout_no}'
           AND sec_theme = '{$theme_name}'
           AND sec_layout_name = '{$layout_name}'
      ) t
    ";
    $row_max = sql_fetch($sql_max);
    $next_order = isset($row_max['maxv']) && $row_max['maxv'] !== null ? ((int)$row_max['maxv'] + 1) : 1;

    // 전역 유니크 sec_key 생성 (충돌 회피 루프)
    do {
        $sec_key = gen_sec_key();
        $dup = sql_fetch("SELECT COUNT(*) cnt FROM {$rb_section_tables} WHERE sec_key = '".esc($sec_key)."'");
    } while (i($dup['cnt'] ?? 0) > 0);

    $sec_uid = $sec_key . '_' . $next_order;

    // INSERT (sec_id는 AUTO_INCREMENT → 명시 금지)
    $sql = "
    INSERT INTO {$rb_section_tables} SET
        sec_title        = '".esc($sec_title)."',
        sec_layout       = '{$layout_no}',
        sec_layout_name  = '{$layout_name}',
        sec_theme        = '{$theme_name}',

        sec_title_color  = '".esc($sec_title_color)."',
        sec_title_size   = '".esc($sec_title_size)."',
        sec_title_font   = '".esc($sec_title_font)."',
        sec_title_align  = '".esc($sec_title_align)."',
        sec_title_hide   = '".esc($sec_title_hide)."',

        sec_sub_title        = '".esc($sec_sub_title)."',
        sec_sub_title_color  = '".esc($sec_sub_title_color)."',
        sec_sub_title_size   = '".esc($sec_sub_title_size)."',
        sec_sub_title_font   = '".esc($sec_sub_title_font)."',
        sec_sub_title_align  = '".esc($sec_sub_title_align)."',
        sec_sub_title_hide   = '".esc($sec_sub_title_hide)."',

        sec_width        = '".esc($sec_width)."',
        sec_con_width    = '".esc($sec_con_width)."',
        sec_padding_pc   = '".esc($sec_padding_pc)."',
        sec_padding_mo   = '".esc($sec_padding_mo)."',
        sec_margin_top_pc   = '".esc($sec_margin_top_pc)."',
        sec_margin_top_mo   = '".esc($sec_margin_top_mo)."',
        sec_margin_btm_pc   = '".esc($sec_margin_btm_pc)."',
        sec_margin_btm_mo   = '".esc($sec_margin_btm_mo)."',
        sec_bg           = '".esc($sec_bg)."',

        sec_padding   = '".esc($sec_padding)."',
        sec_padding_lr_pc   = '".esc($sec_padding_lr_pc)."',
        sec_padding_lr_mo   = '".esc($sec_padding_lr_mo)."',
        sec_padding_tb_pc   = '".esc($sec_padding_tb_pc)."',
        sec_padding_tb_mo   = '".esc($sec_padding_tb_mo)."',

        sec_1        = '".esc($sec_1)."',
        sec_2        = '".esc($sec_2)."',
        sec_3        = '".esc($sec_3)."',
        sec_4        = '".esc($sec_4)."',
        sec_5        = '".esc($sec_5)."',
        sec_6        = '".esc($sec_6)."',
        sec_7        = '".esc($sec_7)."',
        sec_8        = '".esc($sec_8)."',
        sec_9        = '".esc($sec_9)."',
        sec_10        = '".esc($sec_10)."',

        sec_order_id     = {$next_order},
        sec_key          = '".esc($sec_key)."',
        sec_uid          = '".esc($sec_uid)."',

        sec_datetime     = '".G5_TIME_YMDHIS."',
        sec_ip           = '".esc($_SERVER['REMOTE_ADDR'] ?? '')."'
    ";


    sql_query($sql);
    $new_id = sql_insert_id();

    echo json_encode([
        'status'         => 'ok',
        'mode'           => 'created',
        'sec_id'         => i($new_id),
        'sec_order_id'   => i($next_order),
        'sec_key'        => $sec_key,
        'sec_uid'        => $sec_uid,
        'sec_layout'     => $sec_layout,
        'sec_layout_name'=> $sec_layout_name,
        'sec_theme'      => $sec_theme,
    ]);
    exit;

} else {
    // 업데이트(속성만 변경; order 이동/재배치는 별도 엔드포인트에서 처리)
    if (!$is_admin) { echo json_encode(['status'=>'error','msg'=>'권한 없음']); exit; }

    $sec_id_int = i($sec_id);
    if ($sec_id_int <= 0) { echo json_encode(['status'=>'error','msg'=>'유효하지 않은 sec_id']); exit; }

    $sql = "
    UPDATE {$rb_section_tables} SET
        sec_title        = '".esc($sec_title)."',
        sec_layout       = '".esc($sec_layout)."',
        sec_layout_name  = '".esc($sec_layout_name)."',
        sec_theme        = '".esc($sec_theme)."',

        sec_title_color  = '".esc($sec_title_color)."',
        sec_title_size   = '".esc($sec_title_size)."',
        sec_title_font   = '".esc($sec_title_font)."',
        sec_title_align  = '".esc($sec_title_align)."',
        sec_title_hide   = '".esc($sec_title_hide)."',

        sec_sub_title        = '".esc($sec_sub_title)."',
        sec_sub_title_color  = '".esc($sec_sub_title_color)."',
        sec_sub_title_size   = '".esc($sec_sub_title_size)."',
        sec_sub_title_font   = '".esc($sec_sub_title_font)."',
        sec_sub_title_align  = '".esc($sec_sub_title_align)."',
        sec_sub_title_hide   = '".esc($sec_sub_title_hide)."',

        sec_width        = '".esc($sec_width)."',
        sec_con_width    = '".esc($sec_con_width)."',
        sec_padding_pc   = '".esc($sec_padding_pc)."',
        sec_padding_mo   = '".esc($sec_padding_mo)."',

        sec_margin_top_pc   = '".esc($sec_margin_top_pc)."',
        sec_margin_top_mo   = '".esc($sec_margin_top_mo)."',
        sec_margin_btm_pc   = '".esc($sec_margin_btm_pc)."',
        sec_margin_btm_mo   = '".esc($sec_margin_btm_mo)."',
        sec_bg           = '".esc($sec_bg)."',

        sec_padding   = '".esc($sec_padding)."',
        sec_padding_lr_pc   = '".esc($sec_padding_lr_pc)."',
        sec_padding_lr_mo  = '".esc($sec_padding_lr_mo)."',
        sec_padding_tb_pc   = '".esc($sec_padding_tb_pc)."',
        sec_padding_tb_mo   = '".esc($sec_padding_tb_mo)."',

        sec_1        = '".esc($sec_1)."',
        sec_2        = '".esc($sec_2)."',
        sec_3        = '".esc($sec_3)."',
        sec_4        = '".esc($sec_4)."',
        sec_5        = '".esc($sec_5)."',
        sec_6        = '".esc($sec_6)."',
        sec_7        = '".esc($sec_7)."',
        sec_8        = '".esc($sec_8)."',
        sec_9        = '".esc($sec_9)."',
        sec_10        = '".esc($sec_10)."',

        sec_datetime     = '".G5_TIME_YMDHIS."',
        sec_ip           = '".esc($_SERVER['REMOTE_ADDR'] ?? '')."'
    WHERE sec_id = {$sec_id_int}
    ";
    sql_query($sql);

    echo json_encode([
        'status' => 'ok',
        'mode'   => 'updated',
        'sec_id' => $sec_id_int,
    ]);
    exit;
}
