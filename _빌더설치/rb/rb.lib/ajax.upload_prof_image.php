<?php
include_once('../../common.php');

if (!$is_member) {
    alert('회원만 이용하실 수 있습니다.');
}

// JSON 응답 함수
function send_json_response($success, $message, $image_url = '') {
    echo json_encode(['success' => $success, 'message' => $message, 'image_url' => $image_url]);
    exit;
}

// 요청 방식과 파일 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $mb_id = isset($member['mb_id']) ? $member['mb_id'] : '';

    if (empty($mb_id)) {
        send_json_response(false, '회원 아이디가 없습니다.');
    }

    // 회원 ID 앞 두 글자로 디렉토리 생성
    $first_two_chars = substr($mb_id, 0, 2);
    $upload_dir = G5_DATA_PATH . "/member_image/$first_two_chars";

    // 디렉토리 존재 확인 및 생성
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, G5_DIR_PERMISSION, true) && !is_dir($upload_dir)) {
            send_json_response(false, '디렉토리를 생성할 수 없습니다.');
        }
        chmod($upload_dir, G5_DIR_PERMISSION);
    }

    // 파일 확장자 확인
    $allowed_ext = ['gif', 'jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        send_json_response(false, '허용되지 않은 파일 형식입니다.');
    }

    // 용량 제한 검사
    if ($file['size'] > $config['cf_member_img_size']) {
        send_json_response(false, '파일 크기가 너무 큽니다. 최대 ' . number_format($config['cf_member_img_size']) . ' 바이트까지 업로드 가능합니다.');
    }

    // 파일명 지정 (고정된 GIF 이름 사용)
    $new_filename = "$mb_id.gif";
    $upload_path = "$upload_dir/$new_filename";

    // 파일 업로드
    if (!move_uploaded_file($file['tmp_name'], $upload_path)) {
        send_json_response(false, '파일 업로드 실패');
    }

    // 업로드된 이미지 정보 확인
    $size = @getimagesize($upload_path);
    if (!$size || !in_array($size[2], [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG])) {
        @unlink($upload_path);
        send_json_response(false, '잘못된 이미지 파일입니다.');
    }

    // 섬네일 생성 (원본 크기보다 크면 생성)
    if ($size[0] > $config['cf_member_img_width'] || $size[1] > $config['cf_member_img_height']) {
        $thumb = thumbnail($new_filename, $upload_dir, $upload_dir, $config['cf_member_img_width'], $config['cf_member_img_height'], true, true);
        if ($thumb) {
            @unlink($upload_path);
            rename("$upload_dir/$thumb", $upload_path);
        } else {
            @unlink($upload_path);
            send_json_response(false, '섬네일 생성 실패');
        }
    }

    // 업로드된 이미지 URL 반환
    $image_url = G5_DATA_URL . "/member_image/$first_two_chars/$new_filename?v=".G5_SERVER_TIME;
    send_json_response(true, '파일 업로드 성공', $image_url);
} else {
    send_json_response(false, '잘못된 요청');
}
