<?php
// /rb/rb.config/ajax.module_lib.php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;

// CSRF
if (!isset($_POST['csrf']) && !isset($_GET['csrf'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status'=>'error','msg'=>'CSRF required']);
    exit;
}
$csrf = isset($_POST['csrf']) ? $_POST['csrf'] : $_GET['csrf'];
if (!isset($_SESSION['rb_widget_csrf']) || $_SESSION['rb_widget_csrf'] !== $csrf) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status'=>'error','msg'=>'Invalid CSRF']);
    exit;
}

// 권한
if (!$is_admin) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['status'=>'error','msg'=>'권한이 없습니다.']);
    exit;
}

$is_shop = isset($_REQUEST['is_shop']) ? trim($_REQUEST['is_shop']) : '0';
$table = ($is_shop == '1') ? 'rb_module_lib_shop' : 'rb_module_lib';

$action = isset($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
header('Content-Type: application/json; charset=utf-8');

// 안전 이스케이프 헬퍼
if (!function_exists('rb_sql_escape')) {
    function rb_sql_escape($s) {
        if (function_exists('sql_real_escape_string')) return sql_real_escape_string($s);
        return addslashes($s);
    }
}

if ($action === 'save') {
    $md_theme  = isset($_POST['md_theme'])  ? $_POST['md_theme']  : '';
    $md_layout = isset($_POST['md_layout']) ? $_POST['md_layout'] : '';

    // 화이트리스트: md_ 접두어만 payload에 담기 + 제어 파라미터 제거
    $payload = [];
    foreach ($_POST as $k => $v) {
        if ($k === 'csrf' || $k === 'action' || $k === 'is_shop') continue;
        if (strpos($k, 'md_') === 0) $payload[$k] = $v;
    }
    // 테마/레이아웃은 보장
    $payload['md_theme']  = $md_theme;
    $payload['md_layout'] = $md_layout;

    // 표시용 컬럼 매핑(빈 md_type이면 md_module로 대체)
    $title       = isset($_POST['md_title']) ? $_POST['md_title'] : '';
    $md_type     = (isset($_POST['md_type']) && $_POST['md_type'] !== '')
                    ? $_POST['md_type']
                    : (isset($_POST['md_module']) ? $_POST['md_module'] : '');
    $width_txt   = isset($_POST['md_size']) ? $_POST['md_size'] : '';
    $md_show   = isset($_POST['md_show']) ? $_POST['md_show'] : '';

    $payload_json = json_encode($payload, JSON_UNESCAPED_UNICODE);

    $sql = "INSERT INTO {$table}
            (md_theme, md_layout, title, md_type, md_show, width_text, payload_json, created_at, updated_at)
            VALUES
            ('".rb_sql_escape($md_theme)."',
             '".rb_sql_escape($md_layout)."',
             '".rb_sql_escape($title)."',
             '".rb_sql_escape($md_type)."',
             '".rb_sql_escape($md_show)."',
             '".rb_sql_escape($width_txt)."',
             '".rb_sql_escape($payload_json)."',
             '".G5_TIME_YMDHIS."', '".G5_TIME_YMDHIS."')";
    sql_query($sql);

    echo json_encode(['status'=>'ok']);
    exit;
}


if ($action === 'list') {
    $md_theme  = isset($_GET['md_theme'])  ? $_GET['md_theme']  : '';
    $md_layout = isset($_GET['md_layout']) ? $_GET['md_layout'] : '';
    $q = "SELECT lib_id, title, md_type, md_show, width_text, created_at
          FROM {$table}
          WHERE 1 ";
    if ($md_theme !== '')  $q .= " AND md_theme = '".rb_sql_escape($md_theme)."' ";
    if ($md_layout !== '') $q .= " AND md_layout = '".rb_sql_escape($md_layout)."' ";
    $q .= " ORDER BY lib_id DESC ";
    $rs = sql_query($q);

    $rows = [];
    for ($i=0; $row = sql_fetch_array($rs); $i++) {
        $rows[] = $row;
    }
    echo json_encode(['status'=>'ok','rows'=>$rows]);
    exit;
}

if ($action === 'get') {
    $lib_id = isset($_GET['lib_id']) ? (int)$_GET['lib_id'] : 0;
    if ($lib_id < 1) { echo json_encode(['status'=>'error','msg'=>'invalid id']); exit; }

    $row = sql_fetch("SELECT payload_json FROM {$table} WHERE lib_id = {$lib_id}");
    if (!$row) { echo json_encode(['status'=>'error','msg'=>'not found']); exit; }

    $payload = json_decode($row['payload_json'], true);
    if (!is_array($payload)) $payload = [];

    echo json_encode(['status'=>'ok','payload'=>$payload]);
    exit;
}

echo json_encode(['status'=>'error','msg'=>'unknown action']);
