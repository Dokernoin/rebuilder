<?php
// rb/rb.lib/ajax.widget_save.php
include_once('../../common.php');
header('Content-Type: application/json; charset=utf-8');

@ini_set('display_errors','0');
@error_reporting(E_ALL);

// 1) 슈퍼관리자만
if ($is_admin !== 'super') {
    echo json_encode(['ok'=>false,'msg'=>'권한이 없습니다.']); exit;
}

// 2) CSRF
$csrf = $_POST['csrf'] ?? '';
if (!isset($_SESSION['rb_widget_csrf']) || !hash_equals($_SESSION['rb_widget_csrf'], $csrf)) {
    echo json_encode(['ok'=>false,'msg'=>'CSRF 검증 실패']); exit;
}

// 3) Origin/Referer
$host    = parse_url(G5_URL, PHP_URL_HOST);
$origin  = $_SERVER['HTTP_ORIGIN']  ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$bad_origin  = $origin  && (parse_url($origin,  PHP_URL_HOST) !== $host);
$bad_referer = $referer && (parse_url($referer, PHP_URL_HOST) !== $host);
if ($bad_origin || $bad_referer) {
    echo json_encode(['ok'=>false,'msg'=>'잘못된 요청 출처']); exit;
}

// ---- 입력 ----
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok'=>false,'msg'=>'Invalid method']); exit;
}
$folder    = isset($_POST['folder']) ? trim($_POST['folder']) : '';
$overwrite = isset($_POST['overwrite']) ? trim($_POST['overwrite']) : '0';
$code      = isset($_POST['code']) ? (string)$_POST['code'] : '';

$pattern = ($overwrite === '1')
    ? '/^(?!\.)(?!.*\.\.)[A-Za-z0-9_.-]+$/'
    : '/^(?!\.)(?!.*\.\.)[A-Za-z0-9_-]+$/';
if ($folder === '' ||
    !preg_match($pattern, $folder) ||
    strpos($folder,'/')!==false || strpos($folder,'\\')!==false) {
    echo json_encode(['ok'=>false,'msg'=>'폴더명 형식 오류']); exit;
}
if ($code === '') {
    echo json_encode(['ok'=>false,'msg'=>'코드가 비어있습니다.']); exit;
}

// 위험 함수 필터
$deny = '/\b(eval|exec|system|shell_exec|popen|proc_open|passthru|pcntl_\w+)\s*\(/i';
if (preg_match($deny, $code)) {
    echo json_encode(['ok'=>false,'msg'=>'위험 함수 사용이 감지되어 차단되었습니다.']); exit;
}
// 이스케이프 원복/개행 정규화
$code = preg_replace('/\\\\([\'"])/', '$1', $code);
$code = str_replace("\r\n", "\n", $code);

// ---- 경로 준비 ----
$BASE = G5_PATH . '/rb/rb.widget';
if (!is_dir($BASE)) {
    echo json_encode(['ok'=>false,'msg'=>'BASE 경로가 없습니다: '.$BASE]); exit;
}
if (!is_writable($BASE)) {
    echo json_encode(['ok'=>false,'msg'=>'BASE 경로에 쓰기 권한이 없습니다: '.$BASE]); exit;
}

$target_dir  = $BASE . '/' . $folder;
$target_file = $target_dir . '/widget.php';

// 디렉터리 생성
if (!is_dir($target_dir)) {
    $mk = @mkdir($target_dir, 0755, true);
    clearstatcache();
    if (!$mk && !is_dir($target_dir)) {
        $e = error_get_last();
        echo json_encode([
            'ok'=>false,
            'msg'=>'디렉터리 생성 실패',
            'raw'=>($e['message'] ?? '').' path='.$target_dir
        ]);
        exit;
    }
}

// 경로 검증 (realpath가 실패하는 호스팅 대비)
$base_real = realpath($BASE);
$dir_real  = realpath($target_dir);
if ($base_real === false) {
    echo json_encode(['ok'=>false,'msg'=>'realpath(BASE) 실패: 권한/설정 확인','raw'=>$BASE]); exit;
}
$check_dir = $dir_real ?: $target_dir;
$prefixOk = (strpos(rtrim($check_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR,
                    rtrim($base_real, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR) === 0);
if (!$prefixOk) {
    echo json_encode([
        'ok'=>false,
        'msg'=>'경로 검증 실패',
        'raw'=>'base_real='.$base_real.'; dir_real=' . ($dir_real ?: '(false)').'; target='.$target_dir
    ]);
    exit;
}

// 덮어쓰기 정책
if (file_exists($target_file) && $overwrite !== '1') {
    echo json_encode(['ok'=>false,'msg'=>'이미 파일이 존재합니다.']); exit;
}

// ==== (신규) DATA 동일폴더 백업 준비 ====
// 로그/백업 베이스 디렉터리(미리 만들어둔다)
$data_base_dir = G5_DATA_PATH . '/rb_log/custom_widget/' . $folder;
if (!is_dir($data_base_dir)) { @mkdir($data_base_dir, 0755, true); }
$backup_dir = $data_base_dir . '/backup';
if (!is_dir($backup_dir)) { @mkdir($backup_dir, 0755, true); }

// 이전 해시 (감사 로그용)
$prev_hash = file_exists($target_file) ? @hash_file('sha256', $target_file) : null;

// ==== (변경) 백업: DATA 동일폴더에 저장 ====
// 기존 소스 디렉터리에 .bak_... 파일을 만들지 않고 DATA/backup에 저장
if (file_exists($target_file)) {
    $backup_name = 'widget.php.bak_' . date('Ymd_His');
    $backup_path = $backup_dir . '/' . $backup_name;
    if (!@copy($target_file, $backup_path)) {
        $e = error_get_last();
        echo json_encode([
            'ok'=>false,
            'msg'=>'백업 파일 생성 실패',
            'raw'=>($e['message'] ?? '').' backup_path='.$backup_path
        ]);
        exit;
    }
    @chmod($backup_path, 0644);
}

// UTF-8 보정
if (!mb_detect_encoding($code, 'UTF-8', true)) {
    $code = mb_convert_encoding($code, 'UTF-8');
}

// 원자 저장
$tmp = $target_file . '.tmp_' . uniqid('', true);
$bytes = @file_put_contents($tmp, $code, LOCK_EX);
if ($bytes === false) {
    $e = error_get_last();
    echo json_encode([
        'ok'=>false,
        'msg'=>'파일 쓰기 실패(tmp)',
        'raw'=>($e['message'] ?? '').' tmp='. $tmp
    ]);
    exit;
}
if (!@rename($tmp, $target_file)) {
    $e = error_get_last();
    @unlink($tmp);
    echo json_encode([
        'ok'=>false,
        'msg'=>'파일 교체 실패(rename)',
        'raw'=>($e['message'] ?? '').' target='. $target_file
    ]);
    exit;
}
@chmod($target_file, 0644);

// ---- 저장 로그 (data/widget_log/{folder}) ----
$log_dir = $data_base_dir; // 위에서 만든 동일 폴더 재사용
if (!is_dir($log_dir)) { @mkdir($log_dir, 0755, true); }
$log_file = $log_dir . '/save.log.txt';
$now  = date('Y-m-d H:i:s');
$ip   = $_SERVER['REMOTE_ADDR'] ?? '-';
$mb   = $member['mb_id'] ?? '-';
$line = sprintf("[%s] %s %s SAVE folder=%s size=%d prev=%s backup_dir=%s\n",
    $now, $ip, $mb, $folder, strlen($code), ($prev_hash ?: '-'), $backup_dir);
@file_put_contents($log_file, $line, FILE_APPEND | LOCK_EX);
@chmod($log_file, 0644);

// ---- 응답 ----
$public_hint = str_replace(G5_PATH, '', $target_file);
echo json_encode(['ok'=>true, 'path'=>$public_hint]);
