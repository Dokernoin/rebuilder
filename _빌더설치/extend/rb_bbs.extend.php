<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

/**
 * 지정된 경로의 폴더 목록을 <select> 태그로 반환
 *
 * @param string $path 폴더 경로
 * @param string $select_name 셀렉트 태그의 name 속성
 * @param string $select_id 셀렉트 태그의 id 속성
 * @param string|null $selected_folder 기본 선택된 폴더명
 * @return string <select> 태그 HTML 문자열
 */
function get_folder_list_select($path, $select_name = 'skin_name', $select_id = 'skin_id', $selected_folder = null) {

    if ($selected_folder === null) {
        $selected_folder = '';
    }

    // 결과 HTML 초기화
    $select_html = "<select name=\"$select_name\" id=\"$select_id\" class=\"select input_tiny w100\">\n";

    // 디렉토리 확인
    if (is_dir($path)) {
        $folders = scandir($path);

        foreach ($folders as $folder) {
            // '.'와 '..' 제외, 폴더인지 확인
            if ($folder !== '.' && $folder !== '..' && is_dir($path . '/' . $folder)) {
                $folder_escaped = htmlspecialchars($folder, ENT_QUOTES, 'UTF-8');
                $selected = ($folder === $selected_folder) ? ' selected' : '';
                $select_html .= "<option value=\"$folder_escaped\"$selected>$folder_escaped</option>\n";
            }
        }
    } else {
        $select_html .= "<option value=\"\">스킨이 없습니다.</option>\n";
    }

    $select_html .= "</select>\n";
    return $select_html;
}
