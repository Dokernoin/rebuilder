<?php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;

header('Content-Type: application/json; charset=utf-8');

// 권한
if ($is_admin !== 'super') {
  echo json_encode(['status'=>'fail','message'=>'권한이 없습니다.']); exit;
}

/* ===== 2) CSRF 검증 ===== */
$csrf = $_POST['csrf'] ?? '';
if (!isset($_SESSION['rb_widget_csrf']) || !hash_equals($_SESSION['rb_widget_csrf'], $csrf)) {
  echo json_encode(['status'=>'fail','message'=>'CSRF 검증 실패']); exit;
}

/* ===== 3) Origin/Referer 검사 ===== */
$host    = parse_url(G5_URL, PHP_URL_HOST);
$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$bad_origin  = $origin  && (parse_url($origin,  PHP_URL_HOST) !== $host);
$bad_referer = $referer && (parse_url($referer, PHP_URL_HOST) !== $host);
if ($bad_origin || $bad_referer) {
  echo json_encode(['status'=>'fail','message'=>'잘못된 요청 출처']); exit;
}

// is_shop 플래그
$is_shop = (isset($_POST['is_shop']) && $_POST['is_shop'] === '1') ? '1' : '0';
$shop_suffix = ($is_shop === '1') ? '_shop' : '';
$shop_attr   = $is_shop; // "0" or "1"

// trim() 사용 금지: 개행 보존
$css_code   = isset($_POST['css_code']) ? $_POST['css_code'] : '';
$sec_id     = $_POST['sec_id'] ?? '';
$sec_layout = $_POST['sec_layout'] ?? '';
$md_id      = $_POST['md_id'] ?? '';
$md_layout  = $_POST['md_layout'] ?? '';

if ($css_code === '') {
  echo json_encode(['status'=>'fail','message'=>'CSS 내용이 비어있습니다.']); exit;
}

// 위험 CSS 패턴 차단
$deny = '/(?:
    url\s*\(\s*(["\'])?\s*javascript:
  | expression\s*\(
  | -moz-binding\s*:
  | @import\s+(?:url\s*\()?\s*["\']?\s*(?:https?:)?\/\/
)/ix';
if (preg_match($deny, $css_code)) {
  echo json_encode(['status'=>'fail','message'=>'위험한 CSS 패턴이 감지되어 차단되었습니다.']); exit;
}

// 이스케이프/개행 정리
$css_code = str_replace(['\\"', "\\'"], ['"', "'"], $css_code);
$css_code = str_replace(["\r\n", "\r"], "\n", $css_code);

// 파일명 안전 처리
function slug($s){
  $s = (string)$s;
  return preg_replace('~[^A-Za-z0-9_\-]~', '-', $s);
}

// 타겟 결정
$mode = '';
$selector = '';
if ($md_layout !== '' && $md_id !== '') {
  $mode   = 'mod';
  $fname  = 'mod'.$shop_suffix.'_'.slug($md_layout).'_'.slug($md_id).'.css';
  $selector = '.rb_layout_box'
            .'[data-layout="'. $md_layout .'"]'
            .'[data-id="'. $md_id .'"]'
            .'[data-shop="'. $shop_attr .'"]';
} elseif ($sec_layout !== '' && $sec_id !== '') {
  $mode   = 'sec';
  $fname  = 'sec'.$shop_suffix.'_'.slug($sec_layout).'_'.slug($sec_id).'.css';
  $selector = '.rb_section_box'
            .'[data-layout="'. $sec_layout .'"]'
            .'[data-id="'. $sec_id .'"]'
            .'[data-shop="'. $shop_attr .'"]';
} else {
  echo json_encode(['status'=>'fail','message'=>'대상(섹션/모듈) 식별 정보가 없습니다.']); exit;
}

$save_dir = G5_DATA_PATH . '/rb_custom_css';
$save_url = G5_DATA_URL  . '/rb_custom_css';
if (!is_dir($save_dir)) @mkdir($save_dir, 0755, true);

$path = $save_dir . '/' . $fname;
$url  = $save_url . '/' . $fname;

// 내용 + 마지막 개행 보장
$payload = rtrim($css_code) . "\n";

// 저장(덮어쓰기)
if (file_put_contents($path, $payload, LOCK_EX) === false) {
  echo json_encode(['status'=>'fail','message'=>'파일 저장 실패']); exit;
}
@chmod($path, 0644);

// ===== 저장 로그 (/data/rb_log/custom_css/...) =====
$log_root = G5_DATA_PATH . '/rb_log/custom_css';

// 로그 디렉토리: /data/rb_log/custom_css/{mode}/{layout}_{id}/{shop}/
$layout_part = ($mode === 'mod') ? (slug($md_layout).'_'.slug($md_id))
                                 : (slug($sec_layout).'_'.slug($sec_id));
$log_dir = $log_root . '/' . $mode . '/' . $layout_part . '/' . $shop_attr;

if (!is_dir($log_dir)) @mkdir($log_dir, 0755, true);

$log_file = $log_dir . '/save.log.txt';
$now  = date('Y-m-d H:i:s');
$ip   = $_SERVER['REMOTE_ADDR'] ?? '-';
$mb   = $member['mb_id'] ?? '-';
$size = strlen($payload);
$hash = @hash_file('sha256', $path) ?: '-';
$abs  = $path;

$line = sprintf("[%s] %s %s CSS_SAVE mode=%s target=%s shop=%s size=%d file=%s sha256=%s\n",
  $now, $ip, $mb, $mode, $layout_part, $shop_attr, $size, $abs, $hash
);
@file_put_contents($log_file, $line, FILE_APPEND | LOCK_EX);
@chmod($log_file, 0644);

// 응답
$link_id = 'rb-css-'.pathinfo($fname, PATHINFO_FILENAME);

echo json_encode([
  'status'   => 'ok',
  'file'     => $fname,
  'file_url' => $url,
  'link_id'  => $link_id,
  'mode'     => $mode,
  'is_shop'  => $is_shop,
  'selector' => $selector
]);
