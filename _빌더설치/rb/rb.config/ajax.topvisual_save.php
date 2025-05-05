<?php
include_once('../../common.php');

// 관리자만 허용
if (!$is_admin) {
    echo '권한이 없습니다.';
    exit;
}

// 파라미터 정리
$bo_table = isset($_POST['bo_table']) ? preg_replace('/[^a-z0-9_]/', '', $_POST['bo_table']) : '';
$co_id    = isset($_POST['co_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['co_id']) : '';
$ca_id    = isset($_POST['ca_id']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['ca_id']) : '';

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
if (!$key) {
    echo '잘못된 요청입니다.';
    exit;
}

// 워딩 입력값 정리
$main = isset($_POST['main']) ? trim($_POST['main']) : '';
$sub  = isset($_POST['sub'])  ? trim($_POST['sub'])  : '';

// 줄 단위로 분리 (줄바꿈 호환 처리)
$main_lines = preg_split('/\r\n|\r|\n/', $main);
$sub_lines  = preg_split('/\r\n|\r|\n/', $sub);

// 메인 워딩 정리
$final_lines = [];
foreach ($main_lines as $line) {
    $line = trim($line);
    if ($line !== '') $final_lines[] = $line;
}

// 서브 워딩이 있는 경우 [SUB] 구분자 추가
$sub_has_content = false;
foreach ($sub_lines as $line) {
    if (trim($line) !== '') {
        $sub_has_content = true;
        break;
    }
}

if ($sub_has_content) {
    $final_lines[] = '[SUB]';
    foreach ($sub_lines as $line) {
        $line = trim($line);
        if ($line !== '') $final_lines[] = $line;
    }
}

// 저장 디렉토리
$save_dir = G5_DATA_PATH . '/topvisual';
@mkdir($save_dir, G5_DIR_PERMISSION, true);

// 파일 저장
file_put_contents($save_dir . '/' . $key . '.txt', implode("\n", $final_lines));
echo '저장이 완료되었습니다.';
