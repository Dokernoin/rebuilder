<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

global $rb_core;

$md_id = $this->view_md_id;
$rb_module_table =  $this->view_md_table;

$rb_skin = sql_fetch (" select * from {$rb_module_table} where md_id = '{$md_id}' "); //환경설정 테이블 조회 (삭제금지)

$item_subject = $rb_skin['md_title']; //타이틀


if($rb_skin['md_module'] == 0) {
    $links_url = shop_category_url($rb_skin['md_sca']); //링크
} else { 
    $links_url = shop_type_url($rb_skin['md_module']); //링크
}

/*
모듈설정 연동 변수
$rb_skin['md_id']; // 모듈아이디
$rb_skin['md_col']; // 열
$rb_skin['md_row']; // 행
$rb_skin['md_subject_is']; // 상품명 출력여부
$rb_skin['md_thumb_is']; // 이미지 출력여부
$rb_skin['md_date_is']; // 등록일 출력 여부
$rb_skin['md_ca_is']; // 카테고리명 출력 여부
$rb_skin['md_comment_is']; // 찜갯수 출력 여부
$rb_skin['md_content_is']; // 상품간략설명 출력 여부
$rb_skin['md_icon_is']; // 아이콘 출력 여부
$rb_skin['md_gap']; // 여백
$rb_skin['md_gap_mo']; // 모바일 여백
*/
?>

<div class="rb_shop_list5 shop_main_list_rb">
    <!-- { -->
    <ul class="bbs_main_wrap_tit" style="display:<?php echo (isset($rb_skin['md_title_hide']) && $rb_skin['md_title_hide'] == '1') ? 'none' : 'block'; ?>">

        <li class="bbs_main_wrap_tit_l">
            <!-- 타이틀 { -->
            <?php if($rb_skin['md_sca'] || $rb_skin['md_module']) { ?>
            <a href="<?php echo $links_url; ?>">
            <?php } ?>
                <h2 class="<?php echo isset($rb_skin['md_title_font']) ? $rb_skin['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($rb_skin['md_title_color']) ? $rb_skin['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($rb_skin['md_title_size']) ? $rb_skin['md_title_size'] : '20'; ?>px; "><?php echo $item_subject ?></h2>
            <?php if($rb_skin['md_sca'] || $rb_skin['md_module']) { ?>
            </a>
            <?php } ?>
            <!-- } -->
        </li>

        <li class="bbs_main_wrap_tit_r">
            
            <?php if($rb_skin['md_sca'] || $rb_skin['md_module']) { ?>
            <button type="button" class="more_btn" onclick="location.href='<?php echo $links_url ?>';">전체보기</button>
            <?php } ?>
            
        </li>
        
        

        <div class="cb"></div>
    </ul>
    <!-- } -->
    
    <div class="rb_swiper" 
        id="rb_swiper_<?php echo $rb_skin['md_id'] ?>" 
        data-pc-w="<?php echo $rb_skin['md_col'] ?>" 
        data-pc-h="<?php echo $rb_skin['md_row'] ?>" 
        data-mo-w="<?php echo $rb_skin['md_col_mo'] ?>" 
        data-mo-h="<?php echo $rb_skin['md_row_mo'] ?>" 
        data-pc-gap="<?php echo $rb_skin['md_gap'] ?>" 
        data-mo-gap="<?php echo $rb_skin['md_gap_mo'] ?>" 
        data-autoplay="<?php echo $rb_skin['md_auto_is'] ?>" 
        data-autoplay-time="<?php echo $rb_skin['md_auto_time'] ?>" 
        data-pc-swap="<?php echo $rb_skin['md_swiper_is'] ?>" 
        data-mo-swap="<?php echo $rb_skin['md_swiper_is'] ?>"
    >
                    
    <div class="rb_swiper_inner">
        <div class="rb-swiper-wrapper swiper-wrapper">
<?php

$i = 0;
$this->view_star = (method_exists($this, 'view_star')) ? $this->view_star : true;

foreach((array) $list as $row){
    if( empty($row) ) continue;

    $item_link_href = shop_item_url($row['it_id']);     // 상품링크
    $star_score = $row['it_use_avg'] ? (int) get_star($row['it_use_avg']) : '';     //사용자후기 평균별점
    $is_soldout = is_soldout($row['it_id'], true);   // 품절인지 체크

    $ca = get_shop_item_with_category($row['it_id']);

    //할인율을 구함
    if($row['it_cust_price'] && !$row['it_tel_inq']) {
        $sale_per = ceil(((get_price($row)-$row['it_cust_price'])/$row['it_cust_price'])*100).'%';
    } else { 
        $sale_per = "";
    }
    
    /*
    if ( !$is_soldout ){    // 품절 상태가 아니면 출력합니다.
        echo "<div class=\"sct_btn list-10-btn\">
            <button type=\"button\" class=\"btn_cart sct_cart\" data-it_id=\"{$row['it_id']}\"><i class=\"fa fa-shopping-cart\" aria-hidden=\"true\"></i> 장바구니</button>\n";
        echo "</div>\n";
        
        echo "<div class=\"cart-layer\"></div>\n";
	}
    
    
    // 사용후기 평점표시
	if ($this->view_star && $star_score) {
        echo "<div class=\"sct_star\"><span class=\"sound_only\">고객평점</span><img src=\"".G5_SHOP_URL."/img/s_star".$star_score.".png\" alt=\"별점 ".$star_score."점\" class=\"sit_star\"></div>\n";
    }
    
    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }
    */

    $i++;

?>


     <ul class="rb_swiper_list" onclick="location.href='<?php echo $item_link_href ?>';">
     
        <li class="rb_shop_list_item sct_li">

            <?php if (isset($rb_skin['md_thumb_is']) && $rb_skin['md_thumb_is']) { ?>
            <div class="v_ch_list">

                <div class="rb_shop_list_item_img">
                    <a href="<?php echo $item_link_href ?>">
                    <?php echo rb_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name'])); ?>
                    </a>
                    
                    
                    <?php if ($is_soldout) { ?>
                        <div class="sold_out_wrap">
                            <ul>
                                <li>
                                <span>
                                품절
                                </span>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>

                </div>

            </div>
            <?php } ?>
            

            <div class="v_ch_list_r" <?php if (isset($rb_skin['md_thumb_is']) && $rb_skin['md_thumb_is']) { ?><?php } else { ?>style="float:none; width:100%;"<?php } ?>>
               
                <ul class="v_ch_list_r_l" <?php if (isset($rb_skin['md_thumb_is']) && $rb_skin['md_thumb_is']) { ?><?php } else { ?>style="float:none; width:100%;"<?php } ?>>
                    <?php if (isset($rb_skin['md_ca_is']) && $rb_skin['md_ca_is']) { ?>
                    <div class="rb_shop_list_item_ca"><?php echo $ca['ca_name'];?></div>
                    <?php } ?>

                    <?php if (isset($rb_skin['md_subject_is']) && $rb_skin['md_subject_is']) { ?>
                    <div class="rb_shop_list_item_name" <?php if (!$rb_skin['md_ca_is']) { ?>style="margin-top:0px;"<?php } ?>>
                        <a href="<?php echo $item_link_href ?>" class="font-R cut">
                        <?php echo stripslashes($row['it_name']); ?>
                        </a>
                    </div>
                    <?php } ?>
                    
                    <?php if (isset($rb_skin['md_content_is']) && $rb_skin['md_content_is'] && $row['it_basic']) { ?>
                    <div class="rb_shop_list_item_basic cut">
                        <?php echo stripslashes($row['it_basic']) ?>
                    </div>
                    <?php } ?>
                    
                    <?php if ($this->view_it_cust_price || $this->view_it_price) { ?>
                    <div class="rb_shop_list_item_pri">
                        <?php if ($this->view_it_price) { ?>
                        <dd class="font-B font-16 <?php if ($this->view_it_cust_price && $row['it_cust_price']) { ?>main_color<?php } ?>"><?php echo display_price(get_price($row), $row['it_tel_inq']) ?></dd>
                        <?php } ?>
                        <?php if ($sale_per) { ?>
                        <dd class="font-B font-14"><?php echo $sale_per ?></dd>
                        <?php } ?>
                    </div>
                    <?php } ?>

                </ul>
                
                <div class="mt-10">
                    <?php if(isset($rb_skin['md_date_is']) && $rb_skin['md_date_is']) { ?>
                        <ul class="date_fl"><?php echo substr($row['it_time'], 0, 10); ?></ul>
                    <?php } ?>
                    <?php if (isset($rb_skin['md_icon_is']) && $rb_skin['md_icon_is']) { ?>
                    <ul class="sit_icon_li">

                        <?php echo item_icon($row) ?>
                        <?php if($row['it_sc_type'] == 1) { ?>
                        <span class="shop_icon shop_icon_6">무료배송</span>
                        <?php } ?>

                    </ul>
                    <?php } ?>
                    <div class="cb"></div>

                </div>


            </div>
            
            <div class="cb"></div> 
               
            
                
        </li>
        
        <?php if (isset($rb_skin['md_comment_is']) && $rb_skin['md_comment_is']) { ?>
                    <div class="list_wish_int">
                        <dl>
                            <?php if(isset($rb_skin['md_comment_is']) && $rb_skin['md_comment_is']) { ?>
                            <dd><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></dd>
                            <dd><?php echo get_wishlist_count_by_item($row['it_id']); ?></dd>
                            <?php } ?>
                        </dl>
                        <div class="cb"></div>
                    </div>
        <?php } ?>
                    
    </ul>
    
    <?php } ?>
    <?php if($i === 0) echo "<div class=\"da_data\">등록된 상품이 없습니다.</div>"; ?>
    
    </div>
    
            <?php if($rb_skin['md_swiper_is'] == 1) { //모듈설정:스와이프 사용여부(1,0)?>
            <div class="rb_swiper_paging_btn" style="display:<?php echo (isset($rb_skin['md_title_hide']) && $rb_skin['md_title_hide'] == '1') ? 'none' : 'block'; ?>">
                <!-- 좌우 페이징 { -->
                <button type="button" class="swiper-button-prev rb-swiper-prev">
                    <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_prev.svg">
                </button>
                <button type="button" class="swiper-button-next rb-swiper-next">
                    <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_next.svg">
                </button>
                <!-- } -->
            </div>
            <?php } ?>
            
    </div>
</div>
</div>
