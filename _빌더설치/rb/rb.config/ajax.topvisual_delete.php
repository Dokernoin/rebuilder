<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

if (!$is_admin) {
    echo json_encode(['success' => false, 'error' => '권한이 없습니다.']);
    exit;
}

$me_code = isset($_POST['me_code']) ? $_POST['me_code'] : '';
$key = $me_code;

if (!$key) {
    echo json_encode(['success' => false, 'error' => '메뉴 정보가 없습니다. 관리자모드에서 메뉴를 추가해주세요.']);
    exit;
}

$file = G5_DATA_PATH . '/topvisual/' . $key . '.jpg';

if (file_exists($file)) {
    @unlink($file);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => '삭제할 파일이 없습니다.']);
}
