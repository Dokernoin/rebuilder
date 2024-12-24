<?php
include_once('../../common.php');

if (!$is_member)
    alert('회원만 이용하실 수 있습니다.');

// 함수 정의: JSON 응답을 보내고 스크립트 종료
function send_json_response($success, $message, $image_url = '') {
    echo json_encode(['success' => $success, 'message' => $message, 'image_url' => $image_url]);
    exit;
}

// 요청 메서드와 파일 확인
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $mb_id = isset($member['mb_id']) ? $member['mb_id'] : '';
    
    // 회원 아이디가 설정되지 않았으면 오류 응답
    if (empty($mb_id)) {
        send_json_response(false, '회원 아이디가 없습니다.');
    }

    $first_two_chars = substr($mb_id, 0, 2);
    $upload_dir = G5_DATA_PATH."/member_image/$first_two_chars";

    // 디렉토리가 존재하지 않으면 생성
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true) && !is_dir($upload_dir)) {
            send_json_response(false, '디렉토리를 생성할 수 없습니다.');
        }
    }

    // 파일 확장자를 gif로 고정
    $new_filename = "$mb_id.gif";
    $upload_path = "$upload_dir/$new_filename";

    // 파일을 지정된 경로에 저장
    if (move_uploaded_file($file['tmp_name'], $upload_path)) {
        $image_url = G5_DATA_URL."/member_image/$first_two_chars/$new_filename";
        send_json_response(true, '파일 업로드 성공', $image_url);
    } else {
        send_json_response(false, '파일 업로드 실패');
    }
} else {
    send_json_response(false, '잘못된 요청');
}