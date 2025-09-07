<?php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;

header('Content-Type: application/json; charset=utf-8');

// 메서드 검사
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid method']);
    exit;
}

$s_code = isset($_POST['s_code']) ? trim($_POST['s_code']) : '';
$s_use  = isset($_POST['s_use'])  ? trim($_POST['s_use'])  : '';

// 파라미터 검증
if ($s_code === '' || !in_array($s_use, ['0','1'], true)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    exit;
}

$esc_code = sql_escape_string($s_code);

try {
    if ($s_use === '1') {
        // 중복 방지: UNIQUE(s_code) 가정 시 INSERT IGNORE 권장
        sql_query("INSERT IGNORE INTO `rb_sidebar_hide` (`s_code`) VALUES ('{$esc_code}')");
    } else {
        sql_query("DELETE FROM `rb_sidebar_hide` WHERE `s_code` = '{$esc_code}'");
    }

    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
exit;
