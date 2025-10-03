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

$client_is_shop = isset($_REQUEST['is_shop']) ? trim((string)$_REQUEST['is_shop']) : '0';
$server_is_shop = defined('_SHOP_') ? '1' : '0';
$is_shop_mode   = ($client_is_shop === '1' || $server_is_shop === '1') ? '1' : '0';

// 단일 테이블 사용
$table = 'rb_module_lib';

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
    // width_text는 사이즈 단위와 숫자 폭을 함께 저장
    $md_size  = isset($_POST['md_size'])  ? trim($_POST['md_size'])  : '';
    $md_width = isset($_POST['md_width']) ? trim($_POST['md_width']) : '';

    // "37.5%" 같은 입력에서 첫 번째 실수만 추출 (음수/소수점 지원, 로케일 무관)
    preg_match('/-?\d+(?:\.\d+)?/', (string)$md_width, $m);
    $md_width_num = isset($m[0]) ? $m[0] : '';

    // 표시 문자열: 빈값이면 단위만 안 붙이고, 소수점 끝 0/점 정리는 원하면 아래 참고
$width_txt = ($md_width_num === '' ? '' : $md_width_num) . $md_size;

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

    $q = "SELECT lib_id, title, md_type, md_show, width_text, created_at
      FROM {$table}
      WHERE 1 ";
    if ($md_theme !== '')  $q .= " AND md_theme = '".rb_sql_escape($md_theme)."' ";

    if ($is_shop_mode !== '1') {
        $q .= " AND (md_type IS NULL OR TRIM(md_type) = '' OR LOWER(TRIM(md_type)) NOT IN ('item','item_tab')) ";
    }

    // md_layout 필터는 사용하지 않음
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
    $payload = array_diff_key($payload, array_flip(['md_layout']));

    echo json_encode(['status'=>'ok','payload'=>$payload]);
    exit;
}

if ($action === 'delete') {
    $lib_id = isset($_POST['lib_id']) ? trim($_POST['lib_id']) : '';
    if ($lib_id === '') {
        echo json_encode(['status'=>'error','msg'=>'lib_id required']);
        exit;
    }
    $q = "DELETE FROM {$table} WHERE lib_id = '".rb_sql_escape($lib_id)."'";
    sql_query($q);
    echo json_encode(['status'=>'ok']);
    exit;
}

echo json_encode(['status'=>'error','msg'=>'unknown action']);
