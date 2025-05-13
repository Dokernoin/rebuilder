<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

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

// 파일 저장 (현재 노드용 .txt)
$main_file = $save_dir . '/' . $key . '.txt';
file_put_contents($main_file, implode("\n", $final_lines));

// ✅ 조건 체크: co_topvisual_style_all = 1 인 경우에만 하위에 복사
$parent_info = sql_fetch("SELECT co_topvisual_style_all FROM rb_topvisual WHERE v_code = '{$me_code}'");
if (isset($parent_info['co_topvisual_style_all']) && intval($parent_info['co_topvisual_style_all']) === 1) {
    $sub_nodes = sql_query("SELECT v_code FROM rb_topvisual WHERE v_code LIKE '{$me_code}-%'");
    while ($row = sql_fetch_array($sub_nodes)) {
        $sub_code = $row['v_code'];

        // 하위 .txt 복사
        $sub_txt = $save_dir . '/' . $sub_code . '.txt';
        @copy($main_file, $sub_txt);

        // 하위 .jpg 복사 (이미지가 있을 경우만)
        $source_jpg = $save_dir . '/' . $me_code . '.jpg';
        $target_jpg = $save_dir . '/' . $sub_code . '.jpg';

        if (file_exists($source_jpg)) {
            @copy($source_jpg, $target_jpg);
        }
    }
}

echo '저장이 완료되었습니다.';
