<?php
include_once('../../common.php');

// 관리자만 허용
if (!$is_admin) {
    echo '권한이 없습니다.';
    exit;
}

$me_code = isset($_POST['me_code']) ? $_POST['me_code'] : '';
$key = $me_code;

if (!$key) {
    echo '메뉴 정보가 없습니다. 관리자모드에서 메뉴를 추가해주세요.';
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
