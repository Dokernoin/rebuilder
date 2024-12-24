<?php
include_once('./_common.php');

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/index.php');
    return;
}

if(! defined('_INDEX_')) define('_INDEX_', TRUE);

include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
?>

<?php 

    if (isset($rb_core['layout_shop']) && $rb_core['layout_shop'] == "") {
        echo "<div class='no_data' style='border:0px;'><span class='no_data_section_ul1 font-B color-000'>선택된 레이아웃이 없습니다.</span><br>환경설정 패널에서 먼저 레이아웃을 설정해주세요.</div>";
    } else if (isset($rb_core['layout_shop'])) { 
        // 레이아웃 인클루드
        include_once(G5_THEME_SHOP_PATH . '/rb.layout/' . $rb_core['layout_shop'] . '/index.php'); 
        //add_javascript('<script src="' . G5_THEME_URL . '/rb.js/rb.layout.js"></script>', 1);
    } else {
        echo "<div class='no_data' style='border:0px;'><span class='no_data_section_ul1 font-B color-000'>레이아웃 설정이 올바르지 않습니다.</span><br>환경설정 패널에서 먼저 레이아웃을 설정해주세요.</div>";
    }

?>

<?php
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');