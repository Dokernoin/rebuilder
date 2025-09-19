<?php
// rb/rb.lib/ajax.widget_load.php
include_once('../../common.php');
header('Content-Type: application/json; charset=utf-8');

@ini_set('display_errors','0');
@error_reporting(E_ALL);

/* ---------- 공통 보안: 슈퍼관리자, CSRF, Origin/Referer ---------- */

// 1) 슈퍼관리자만
if ($is_admin !== 'super') {
  echo json_encode(['ok'=>false,'msg'=>'권한이 없습니다.']); exit;
}

// 2) CSRF 토큰 (GET에도 부여 권장)
$csrf = $_GET['csrf'] ?? '';
if (!isset($_SESSION['rb_widget_csrf']) || !hash_equals($_SESSION['rb_widget_csrf'], $csrf)) {
  echo json_encode(['ok'=>false,'msg'=>'CSRF 검증 실패']); exit;
}

// 3) Origin/Referer 검사
$host    = parse_url(G5_URL, PHP_URL_HOST);
$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$bad_origin  = $origin  && (parse_url($origin,  PHP_URL_HOST) !== $host);
$bad_referer = $referer && (parse_url($referer, PHP_URL_HOST) !== $host);
if ($bad_origin || $bad_referer) {
  echo json_encode(['ok'=>false,'msg'=>'잘못된 요청 출처']); exit;
}

/* ---------- 입력/검증 ---------- */

$folder = isset($_GET['folder']) ? trim($_GET['folder']) : '';
// 읽기: 점(.) 허용
if ($folder === '' ||
    !preg_match('/^(?!\.)(?!.*\.\.)[A-Za-z0-9_.-]+$/', $folder) ||
    strpos($folder,'/')!==false || strpos($folder,'\\')!==false) {
  echo json_encode(['ok'=>false,'msg'=>'폴더명 형식 오류']); exit;
}

$BASE = G5_PATH . '/rb/rb.widget';
$target_dir  = $BASE . '/' . $folder;
$target_file = $target_dir . '/widget.php';

if (!is_dir($target_dir) || !file_exists($target_file)) {
  echo json_encode(['ok'=>false,'msg'=>'파일이 없습니다.']); exit;
}

/* ---------- 로드 ---------- */

$code = @file_get_contents($target_file);
if ($code === false) { echo json_encode(['ok'=>false,'msg'=>'읽기 실패']); exit; }

// UTF-8 보정(선택)
if (!mb_detect_encoding($code, 'UTF-8', true)) {
  $code = mb_convert_encoding($code, 'UTF-8');
}

/* ---------- 감사 로그 (위젯 폴더별) ---------- */
$log_dir  = G5_DATA_PATH . '/rb_log/custom_widget/' . $folder;
if (!is_dir($log_dir) && !@mkdir($log_dir, 0755, true)) {
    echo json_encode(['ok'=>false,'msg'=>'로그 디렉터리 생성 실패: '.$log_dir]); exit;
}
$log_file = $log_dir . '/load.log.txt';

$now  = date('Y-m-d H:i:s');
$ip   = $_SERVER['REMOTE_ADDR'] ?? '-';
$mb   = isset($member['mb_id']) ? $member['mb_id'] : '-';
$line = sprintf("[%s] %s %s LOAD folder=%s size=%d\n",
    $now, $ip, $mb, $folder, strlen($code));

$written = @file_put_contents($log_file, $line, FILE_APPEND | LOCK_EX);
if ($written === false) {
    echo json_encode(['ok'=>false,'msg'=>'로그 기록 실패: '.$log_file]); exit;
}
@chmod($log_file, 0644);

/* ---------- 응답 ---------- */

echo json_encode(['ok'=>true, 'code'=>$code]);
