<?php
// rb/rb.lib/ajax.widget_save.php
include_once('../../common.php');
header('Content-Type: application/json; charset=utf-8');

/* ---------- 공통 보안: 슈퍼관리자, CSRF, Origin/Referer ---------- */

// 1) 슈퍼관리자만
if ($is_admin !== 'super') {
  echo json_encode(['ok'=>false,'msg'=>'권한이 없습니다.']); exit;
}

// 2) CSRF 토큰
$csrf = $_POST['csrf'] ?? '';
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

/* ---------- 입력 ---------- */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['ok'=>false,'msg'=>'Invalid method']); exit;
}

$folder    = isset($_POST['folder']) ? trim($_POST['folder']) : '';
$overwrite = isset($_POST['overwrite']) ? trim($_POST['overwrite']) : '0';
$code      = isset($_POST['code']) ? (string)$_POST['code'] : '';

/* ---------- 폴더명 검증(생성: 점 금지 / 편집: 점 허용) ---------- */

$pattern = ($overwrite === '1')
  ? '/^(?!\.)(?!.*\.\.)[A-Za-z0-9_.-]+$/'   // 편집(덮어쓰기) = 점 허용
  : '/^(?!\.)(?!.*\.\.)[A-Za-z0-9_-]+$/';   // 생성 = 점 금지

if ($folder === '' ||
    !preg_match($pattern, $folder) ||
    strpos($folder,'/')!==false || strpos($folder,'\\')!==false) {
  echo json_encode(['ok'=>false,'msg'=>'폴더명 형식 오류']); exit;
}

if ($code === '') { echo json_encode(['ok'=>false,'msg'=>'코드가 비어있습니다.']); exit; }

/* ---------- 위험 함수 필터 / 용량 제한 / 이스케이프 정리 ---------- */

// 4) 위험 함수 필터 (필요시 보완/완화)
$deny = '/\b(eval|exec|system|shell_exec|popen|proc_open|passthru|pcntl_\w+)\s*\(/i';
if (preg_match($deny, $code)) {
  echo json_encode(['ok'=>false,'msg'=>'위험 함수 사용이 감지되어 차단되었습니다.']); exit;
}

// 따옴표 앞 역슬래시만 원복 (\" → ", \' → ')
$code = preg_replace('/\\\\([\'"])/', '$1', $code);

// 개행 정규화
$code = str_replace("\r\n", "\n", $code);

/* ---------- 경로/저장 ---------- */

$BASE = G5_PATH . '/rb/rb.widget';
$target_dir  = $BASE . '/' . $folder;
$target_file = $target_dir . '/widget.php';

// 디렉토리 생성
if (!is_dir($target_dir)) @mkdir($target_dir, 0755, true);

// 경로 검증(디렉토리 탈출 방지)
$base_real = realpath($BASE);
$dir_real  = realpath($target_dir);
if (!$base_real || !$dir_real || strpos($dir_real, $base_real) !== 0) {
  echo json_encode(['ok'=>false,'msg'=>'경로 검증 실패']); exit;
}

// 덮어쓰기 정책
if (file_exists($target_file) && $overwrite !== '1') {
  echo json_encode(['ok'=>false,'msg'=>'이미 파일이 존재합니다.']); exit;
}

// 이전 해시 (감사 로그용)
$prev_hash = file_exists($target_file) ? hash_file('sha256', $target_file) : null;

// 백업
if (file_exists($target_file)) { @copy($target_file, $target_file.'.bak_'.date('Ymd_His')); }

// UTF-8 보정(선택)
if (!mb_detect_encoding($code, 'UTF-8', true)) {
  $code = mb_convert_encoding($code, 'UTF-8');
}

// 원자적 저장
$tmp = $target_file . '.tmp_' . uniqid('', true);
$bytes = @file_put_contents($tmp, $code, LOCK_EX);
if ($bytes === false) { echo json_encode(['ok'=>false,'msg'=>'파일 쓰기 실패(tmp)']); exit; }
if (!@rename($tmp, $target_file)) { @unlink($tmp); echo json_encode(['ok'=>false,'msg'=>'파일 교체 실패']); exit; }
@chmod($target_file, 0644);

/* ---------- 응답 ---------- */

$public_hint = str_replace(G5_PATH, '', $target_file);
echo json_encode(['ok'=>true, 'path'=>$public_hint]);
