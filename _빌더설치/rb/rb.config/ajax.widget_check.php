<?php
// rb/rb.lib/ajax.widget_check.php
include_once('../../common.php');
header('Content-Type: application/json; charset=utf-8');

if ($is_admin !== 'super') {
  echo json_encode(['ok'=>false,'msg'=>'권한 없음']);
  exit;
}

$folder = isset($_GET['folder']) ? trim($_GET['folder']) : '';
if ($folder === '' ||
    !preg_match('/^(?!\.)(?!.*\.\.)[A-Za-z0-9_-]+$/', $folder) ||
    strpos($folder,'/')!==false || strpos($folder,'\\')!==false) {
  echo json_encode(['ok'=>false,'msg'=>'폴더명 형식 오류']); exit;
}

// 체크 대상 경로: /rb/rb.widget/{folder}
$BASE = G5_PATH . '/rb/rb.widget';
$target_dir = $BASE . '/' . $folder;

// 디렉토리 탈출 방지(기본적으로 안전하지만 습관적으로 점검)
$base_real = realpath($BASE);
$dir_real  = is_dir($target_dir) ? realpath($target_dir) : $target_dir; // 없으면 realpath false
$exists    = is_dir($target_dir);
$has_file  = file_exists($target_dir . '/widget.php');

echo json_encode([
  'ok'      => true,
  'exists'  => $exists ? 1 : 0,  // 폴더가 이미 있는지
  'hasFile' => $has_file ? 1 : 0 // 그 폴더 안에 widget.php가 있는지(참고용)
]);
