<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sct_sort_href = $_SERVER['SCRIPT_NAME'].'?';

if($ca_id) {
	$shop_category_url = shop_category_url($ca_id);
    $sct_sort_href = (strpos($shop_category_url, '?') === false) ? $shop_category_url.'?1=1' : $shop_category_url;
} else if($ev_id) {
    $sct_sort_href .= 'ev_id='.$ev_id;
}

if($skin)
    $sct_sort_href .= '&amp;skin='.$skin;
$sct_sort_href .= '&amp;sort=';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<!-- 상품 정렬 선택 시작 { -->
<section id="sct_sort" class="pc">
    <h2>상품 정렬</h2>

    <!-- 기타 정렬 옵션 
    <ul>
        <li><a href="<?php echo $sct_sort_href; ?>it_name&amp;sortodr=asc">상품명순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type1&amp;sortodr=desc">히트상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type2&amp;sortodr=desc">추천상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type3&amp;sortodr=desc">최신상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type4&amp;sortodr=desc">인기상품</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_type5&amp;sortodr=desc">할인상품</a></li>
    </ul>
	-->

    <ul id="ssch_sort">
        <li><a href="<?php echo $sct_sort_href; ?>it_sum_qty&amp;sortodr=desc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "it_sum_qty") { ?>selected_sort<?php } ?>">판매순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=asc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "it_price"  && $_GET['sortodr'] == "asc") { ?>selected_sort<?php } ?>">낮은가격순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_price&amp;sortodr=desc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "it_price" && $_GET['sortodr'] == "desc") { ?>selected_sort<?php } ?>">높은가격순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_use_avg&amp;sortodr=desc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "it_use_avg") { ?>selected_sort<?php } ?>">평점순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_use_cnt&amp;sortodr=desc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "it_use_cnt") { ?>selected_sort<?php } ?>">후기순</a></li>
        <li><a href="<?php echo $sct_sort_href; ?>it_update_time&amp;sortodr=desc" class="<?php if(isset($_GET['sort']) && $_GET['sort'] == "it_update_time") { ?>selected_sort<?php } ?>">등록일순</a></li>
    </ul>
</section>

        <select onchange="if(this.value) location.href=(this.value);" class="select mobile ssch_sort_mobile">
            <option value=''>상품정렬</option>
            <option value='<?php echo $sct_sort_href; ?>it_sum_qty&amp;sortodr=desc'  <?php if(isset($_GET['sort']) && $_GET['sort'] == "it_sum_qty") { ?>selected<?php } ?>>판매순</option>
            <option value='<?php echo $sct_sort_href; ?>it_price&amp;sortodr=asc' <?php if(isset($_GET['sort']) && $_GET['sort'] == "it_price" && $_GET['sortodr'] == "asc") { ?>selected<?php } ?>>낮은가격순</option>
            <option value='<?php echo $sct_sort_href; ?>it_price&amp;sortodr=desc' <?php if(isset($_GET['sort']) && $_GET['sort'] == "it_price" && $_GET['sortodr'] == "desc") { ?>selected<?php } ?>>높은가격순</option>
            <option value='<?php echo $sct_sort_href; ?>it_use_avg&amp;sortodr=desc' <?php if(isset($_GET['sort']) && $_GET['sort'] == "it_use_avg") { ?>selected<?php } ?>>평점순</option>
            <option value='<?php echo $sct_sort_href; ?>it_use_cnt&amp;sortodr=desc' <?php if(isset($_GET['sort']) && $_GET['sort'] == "it_use_cnt") { ?>selected<?php } ?>>후기순</option>
            <option value='<?php echo $sct_sort_href; ?>it_update_time&amp;sortodr=desc' <?php if(isset($_GET['sort']) && $_GET['sort'] == "it_update_time") { ?>selected<?php } ?>>등록일순</option>
        </select>
<!-- } 상품 정렬 선택 끝 -->