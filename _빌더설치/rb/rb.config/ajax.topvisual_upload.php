<?php
include_once('../../common.php');

// 관리자만 허용
if (!$is_admin) {
    echo json_encode(['success' => false, 'error' => '권한이 없습니다.']);
    exit;
}

$bo_table = isset($_POST['bo_table']) ? preg_replace('/[^a-z0-9_]/', '', $_POST['bo_table']) : '';
$co_id = isset($_POST['co_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['co_id']) : '';
$ca_id = isset($_POST['ca_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['ca_id']) : '';

// 구분명 추출
function get_topvisual_key() {
    global $bo_table, $co_id, $ca_id;

    if (!empty($bo_table)) return preg_replace('/[^a-z0-9_]/', '', $bo_table);
    if (!empty($co_id))    return preg_replace('/[^a-zA-Z0-9_]/', '', $co_id);
    if (!empty($ca_id))    return preg_replace('/[^a-zA-Z0-9_]/', '', $ca_id);

    // 클라이언트에서 보낸 프론트 페이지 파일명 사용
    if (!empty($_POST['page_id'])) {
        return preg_replace('/[^a-z0-9_]/', '', $_POST['page_id']);
    }

    // fallback (예외 상황)
    return 'unknown';
}

$key = get_topvisual_key();
if (!$key || !isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => '정보가 누락 되었습니다.']);
    exit;
}

$ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
$allow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
if (!in_array($ext, $allow)) {
    echo json_encode(['success' => false, 'error' => '지원되지 않는 형식 입니다.']);
    exit;
}

$save_dir = G5_DATA_PATH . '/topvisual';
@mkdir($save_dir, G5_DIR_PERMISSION, true);

// 저장 경로는 무조건 jpg
$dest_path = $save_dir . '/' . $key . '.jpg';

// move_uploaded_file (보안 업로드)
if (move_uploaded_file($_FILES['image']['tmp_name'], $dest_path)) {
    echo json_encode([
        'success' => true,
        'url' => G5_DATA_URL . '/topvisual/' . $key . '.jpg'
    ]);
} else {
    echo json_encode(['success' => false, 'error' => '업로드에 오류가 있습니다.']);
}
