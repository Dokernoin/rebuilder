<?php
include_once('../../common.php');
if (!defined('_GNUBOARD_')) exit;

header('Content-Type: application/json; charset=utf-8');

// 관리자만 열람 (원하면 권한 완화 가능)
if (!$is_admin) {
  echo json_encode(['status'=>'fail','message'=>'권한이 없습니다.']); exit;
}

// ── is_shop 플래그 (GET)
$is_shop = (isset($_GET['is_shop']) && $_GET['is_shop'] === '1') ? '1' : '0';
$shop_suffix = ($is_shop === '1') ? '_shop' : '';

$sec_id     = $_GET['sec_id']     ?? '';
$sec_layout = $_GET['sec_layout'] ?? '';
$md_id      = $_GET['md_id']      ?? '';
$md_layout  = $_GET['md_layout']  ?? '';

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

if (!file_exists($path)) {
  echo json_encode(['status'=>'none']); // 저장된 게 없음
  exit;
}

$css = file_get_contents($path);

// 안전: \\" 같은 실수로 섞인 이스케이프 제거 (선택)
$css = str_replace(['\\"',"\\'"], ['"',"'"], $css);

echo json_encode([
  'status'  => 'ok',
  'css'     => $css,
  'is_shop' => $is_shop,
  'file'    => $fname
]);
