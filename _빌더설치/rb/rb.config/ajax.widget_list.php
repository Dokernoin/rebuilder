<?php
// rb/rb.lib/ajax.widget_list.php
include_once('../../common.php');
header('Content-Type: text/html; charset=utf-8');

// 권한 정책은 필요에 맞게 조정 (관리자만/회원만/전체 등)
if (!$is_member || !$is_admin) {
  http_response_code(403);
  echo '<!-- no permission -->';
  exit;
}

// 현재 선택값(있으면 선택 표시에 사용)
$md_widget = isset($_GET['md_widget']) ? trim($_GET['md_widget']) : '';

// rb_widget_select()가 문자열을 반환한다면 그대로 echo,
// 출력해버리는 함수라면 output buffering으로 받아서 echo.
if (function_exists('rb_widget_select')) {
  $opts = rb_widget_select('rb.widget', $md_widget);
  if ($opts !== null && $opts !== false) {
    echo $opts; // 함수가 문자열을 반환하는 케이스
  } else {
    ob_start();
    rb_widget_select('rb.widget', $md_widget);
    echo ob_get_clean();
  }
} else {
  echo '<!-- rb_widget_select not found -->';
}
