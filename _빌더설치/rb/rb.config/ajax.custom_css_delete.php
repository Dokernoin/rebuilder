<?php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;

header('Content-Type: application/json; charset=utf-8');

if (!$is_admin) {
  echo json_encode(['status'=>'fail','message'=>'권한이 없습니다.']); exit;
}

// ── is_shop 플래그 (POST)
$is_shop = (isset($_POST['is_shop']) && $_POST['is_shop'] === '1') ? '1' : '0';
$shop_suffix = ($is_shop === '1') ? '_shop' : '';

$sec_id     = $_POST['sec_id']     ?? '';
$sec_layout = $_POST['sec_layout'] ?? '';
$md_id      = $_POST['md_id']      ?? '';
$md_layout  = $_POST['md_layout']  ?? '';

function slug($s){ return preg_replace('~[^A-Za-z0-9_\-]~', '-', (string)$s); }

$fname = '';
if ($md_layout !== '' && $md_id !== '') {
  // 모듈 CSS 파일명: mod_shop_{layout}_{id}.css 또는 mod_{layout}_{id}.css
  $fname = 'mod' . $shop_suffix . '_' . slug($md_layout) . '_' . slug($md_id) . '.css';
} elseif ($sec_layout !== '' && $sec_id !== '') {
  // 섹션 CSS 파일명: sec_shop_{layout}_{id}.css 또는 sec_{layout}_{id}.css
  $fname = 'sec' . $shop_suffix . '_' . slug($sec_layout) . '_' . slug($sec_id) . '.css';
} else {
  echo json_encode(['status'=>'fail','message'=>'대상 식별 정보 없음']); exit;
}

$dir  = G5_DATA_PATH . '/rb_custom_css';
$path = $dir . '/' . $fname;

$existed = file_exists($path);
if ($existed) {
  if (!@unlink($path)) {
    echo json_encode(['status'=>'fail','message'=>'파일 삭제 실패']); exit;
  }
}

echo json_encode([
  'status'  => 'ok',
  'is_shop' => $is_shop,
  'file'    => $fname,
  'existed' => $existed,
  'deleted' => $existed ? $fname : null
]);
