<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

// 관리자만 허용
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

if (!isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => '파일이 잘못되었습니다.']);
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
