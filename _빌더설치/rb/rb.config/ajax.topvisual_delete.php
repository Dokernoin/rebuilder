<?php
include_once('../../common.php');

if (!$is_admin) {
    echo json_encode(['success' => false, 'error' => '권한이 없습니다.']);
    exit;
}

$bo_table = isset($_POST['bo_table']) ? preg_replace('/[^a-z0-9_]/', '', $_POST['bo_table']) : '';
$co_id = isset($_POST['co_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['co_id']) : '';
$ca_id = isset($_POST['ca_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['ca_id']) : '';


// 구분명
function get_topvisual_key() {
    global $bo_table, $co_id, $ca_id;

    if (!empty($bo_table)) return preg_replace('/[^a-z0-9_]/', '', $bo_table);
    if (!empty($co_id))    return preg_replace('/[^a-zA-Z0-9_]/', '', $co_id);
    if (!empty($ca_id))    return preg_replace('/[^a-zA-Z0-9_]/', '', $ca_id);
    return '';
}

$key = get_topvisual_key();
if (!$key) {
    echo json_encode(['success' => false, 'error' => '정보가 누락 되었습니다.']);
    exit;
}

$file = G5_DATA_PATH . '/topvisual/' . $key . '.jpg';

if (file_exists($file)) {
    @unlink($file);
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => '삭제할 파일이 없습니다.']);
}
