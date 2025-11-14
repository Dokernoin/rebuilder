<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// rb_preview_config 최초 1회 설치
(function () {
    $row = sql_fetch("
        SELECT COUNT(*) AS cnt
          FROM information_schema.TABLES
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME   = 'rb_preview_config'
    ");
    if ((int)$row['cnt'] > 0) return;

    sql_query("CREATE TABLE `rb_preview_config` LIKE `rb_config`");

    sql_query("
        ALTER TABLE `rb_preview_config`
          ADD COLUMN `pr_title` VARCHAR(255) NOT NULL DEFAULT '' AFTER `co_id`,
          ADD COLUMN `pr_desc`  TEXT         NOT NULL AFTER `pr_title`
    ");
})();

$preview_id = isset($_GET['pr_id']) ? htmlspecialchars2($_GET['pr_id']) : '';

if($preview_id) {
  if(!defined('_PREVIEW_')) define('_PREVIEW_', true);
  $preview_config = sql_fetch(" select * from rb_preview_config where co_id = '$preview_id' "); // 프리뷰설정 테이블 조회
  
  $rb_core['layout'] = !empty($preview_config['co_layout']) ? $preview_config['co_layout'] : ''; // 레이아웃(메인)
  $rb_core['layout_hd'] = !empty($preview_config['co_layout_hd']) ? $preview_config['co_layout_hd'] : ''; // 레이아웃(헤더)
  $rb_core['layout_ft'] = !empty($preview_config['co_layout_ft']) ? $preview_config['co_layout_ft'] : ''; // 레이아웃(푸터)
  $rb_core['color'] = !empty($preview_config['co_color']) ? 'co_'.$preview_config['co_color'] : ''; // 강조컬러
  $rb_core['font'] = !empty($preview_config['co_font']) ? $preview_config['co_font'] : ''; // 폰트스타일
  $rb_core['sub_width'] = !empty($preview_config['co_sub_width']) ? $preview_config['co_sub_width'] : "1400"; // 서브가로사이즈
  $rb_core['main_width'] = !empty($preview_config['co_main_width']) ? $preview_config['co_main_width'] : "1400"; // 메인가로사이즈
  $rb_core['tb_width'] = !empty($preview_config['co_tb_width']) ? $preview_config['co_tb_width'] : "1400"; // 상단, 하단 가로사이즈
  $rb_core['padding_top'] = !empty($preview_config['co_main_padding_top']) ? $preview_config['co_main_padding_top'] : "0"; // 상단, 하단 가로사이즈
  $rb_core['gap_pc'] = !empty($preview_config['co_gap_pc']) ? $preview_config['co_gap_pc'] : '0'; // 간격
  $rb_core['inner_padding_pc'] = !empty($preview_config['co_inner_padding_pc']) ? $preview_config['co_inner_padding_pc'] : '0'; // 내부여백
  $rb_core['side_skin'] = !empty($preview_config['co_side_skin']) ? $preview_config['co_side_skin'] : ''; // 사이드메뉴 스킨
  $rb_core['side_skin_shop'] = !empty($preview_config['co_side_skin_shop']) ? $preview_config['co_side_skin_shop'] : ''; // 사이드메뉴 스킨 (마켓)
  $rb_core['sidemenu'] = !empty($preview_config['co_sidemenu']) ? $preview_config['co_sidemenu'] : ''; // 사이드메뉴 여부, 위치
  $rb_core['sidemenu_shop'] = !empty($preview_config['co_sidemenu_shop']) ? $preview_config['co_sidemenu_shop'] : ''; // 사이드메뉴 여부, 위치 (마켓)
  $rb_core['sidemenu_width'] = !empty($preview_config['co_sidemenu_width']) ? $preview_config['co_sidemenu_width'] : '200'; // 사이드메뉴 가로크기
  $rb_core['sidemenu_width_shop'] = !empty($preview_config['co_sidemenu_width_shop']) ? $preview_config['co_sidemenu_width_shop'] : '200'; // 사이드메뉴 가로크기 (마켓)
  $rb_core['sidemenu_padding'] = !empty($preview_config['co_sidemenu_padding']) ? $preview_config['co_sidemenu_padding'] : '0'; // 사이드메뉴 여백
  $rb_core['sidemenu_padding_shop'] = !empty($preview_config['co_sidemenu_padding_shop']) ? $preview_config['co_sidemenu_padding_shop'] : '0'; // 사이드메뉴 여백 (마켓)
  $rb_core['sidemenu_hide'] = !empty($preview_config['co_sidemenu_hide']) ? $preview_config['co_sidemenu_hide'] : '0'; // 사이드메뉴 숨김
  $rb_core['sidemenu_hide_shop'] = !empty($preview_config['co_sidemenu_hide_shop']) ? $preview_config['co_sidemenu_hide_shop'] : '0'; // 사이드메뉴 숨김 (마켓)
  $rb_core['menu_shop'] = !empty($preview_config['co_menu_shop']) ? $preview_config['co_menu_shop'] : '0'; // 마켓 메뉴설정
  $rb_core['padding_top'] = isset($preview_config['co_padding_top']) ? $preview_config['co_padding_top'] : '';
  $rb_core['padding_top_sub'] = isset($preview_config['co_padding_top_sub']) ? $preview_config['co_padding_top_sub'] : '';
  $rb_core['padding_top_shop'] = isset($preview_config['co_padding_top_shop']) ? $preview_config['co_padding_top_shop'] : '';
  $rb_core['padding_top_sub_shop'] = isset($preview_config['co_padding_top_sub_shop']) ? $preview_config['co_padding_top_sub_shop'] : '';
  $rb_core['padding_btm'] = isset($preview_config['co_padding_btm']) ? $preview_config['co_padding_btm'] : '';
  $rb_core['padding_btm_sub'] = isset($preview_config['co_padding_btm_sub']) ? $preview_config['co_padding_btm_sub'] : '';
  $rb_core['padding_btm_shop'] = isset($preview_config['co_padding_btm_shop']) ? $preview_config['co_padding_btm_shop'] : '';
  $rb_core['padding_btm_sub_shop'] = isset($preview_config['co_padding_btm_sub_shop']) ? $preview_config['co_padding_btm_sub_shop'] : '';
  $rb_core['main_bg'] = !empty($preview_config['co_main_bg']) ? $preview_config['co_main_bg'] : '#ffffff'; // 메인배경컬러
  $rb_core['sub_bg'] = !empty($preview_config['co_sub_bg']) ? $preview_config['co_sub_bg'] : '#ffffff'; // 서브배경컬러
  $rb_core['gap_mo'] = !empty($preview_config['co_gap_mo']) ? $preview_config['co_gap_mo'] : '0'; // 간격
}

// 프리뷰 목록 select 반환
function rb_preview_get_select() {
  $options = '';
  $result = sql_query(" select co_id, pr_title from rb_preview_config order by co_id ");
  while($row = sql_fetch_array($result)) {
    $options .= '<option value="'.$row['co_id'].'">'.get_text($row['co_id']).' - '.get_text($row['pr_title']).'</option>';
  }
  return $options;
}