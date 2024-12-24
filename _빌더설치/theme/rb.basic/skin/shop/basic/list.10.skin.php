<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);

// 장바구니 또는 위시리스트 ajax 스크립트
add_javascript('<script src="'.G5_THEME_JS_URL.'/theme.shop.list.js"></script>', 10);

?>

<div class="rb_shop_list">
<div class="swiper-container swiper-container-list-list">
<div class="swiper-wrapper swiper-wrapper-list-list">
<?php

$i = 0;
$this->view_star = (method_exists($this, 'view_star')) ? $this->view_star : true;

foreach((array) $list as $row){
    if( empty($row) ) continue;

    $item_link_href = shop_item_url($row['it_id']);     // 상품링크
    $star_score = $row['it_use_avg'] ? (int) get_star($row['it_use_avg']) : '';     //사용자후기 평균별점
    $list_mod = $this->list_mod;    // 분류관리에서 1줄당 이미지 수 값 또는 파일에서 지정한 가로 수
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
    
    if ($this->view_it_icon) {
        // 품절
        if ($is_soldout) {
            echo '<span class="shop_icon_soldout"><span class="soldout_txt">SOLD OUT</span></span>';
        }
    }
    
    // 사용후기 평점표시
	if ($this->view_star && $star_score) {
        echo "<div class=\"sct_star\"><span class=\"sound_only\">고객평점</span><img src=\"".G5_SHOP_URL."/img/s_star".$star_score.".png\" alt=\"별점 ".$star_score."점\" class=\"sit_star\"></div>\n";
    }
    
    if ($this->view_it_id) {
        echo "<div class=\"sct_id\">&lt;".stripslashes($row['it_id'])."&gt;</div>\n";
    }
    
        // 위시리스트 + 공유 버튼 시작
        echo "<div class=\"sct_op_btn\">\n";
        echo "<button type=\"button\" class=\"btn_wish\" data-it_id=\"{$row['it_id']}\"><span class=\"sound_only\">위시리스트</span><i class=\"fa fa-heart-o\" aria-hidden=\"true\"></i></button>\n";
        if ($this->view_sns) {
            echo "<button type=\"button\" class=\"btn_share\"><span class=\"sound_only\">공유하기</span><i class=\"fa fa-share-alt\" aria-hidden=\"true\"></i></button>\n";
        }
        
        echo "<div class=\"sct_sns_wrap\">";
        if ($this->view_sns) {
            $sns_top = $this->img_height + 10;
            $sns_url  = $item_link_href;
            $sns_title = get_text($row['it_name']).' | '.get_text($config['cf_title']);
            echo "<div class=\"sct_sns\">";
            echo "<h3>SNS 공유</h3>";
            echo get_sns_share_link('facebook', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/facebook.png');
            echo get_sns_share_link('twitter', $sns_url, $sns_title, G5_SHOP_SKIN_URL.'/img/twitter.png');
            echo "<button type=\"button\" class=\"sct_sns_cls\"><span class=\"sound_only\">닫기</span><i class=\"fa fa-times\" aria-hidden=\"true\"></i></button>";
            echo "</div>\n";
        }
        echo "<div class=\"sct_sns_bg\"></div>";
        echo "</div></div>\n";
        // 위시리스트 + 공유 버튼 끝
    */

        $i++;

?>


     <ul class="swiper-slide swiper-slide-list-list sct">
     
        <li class="rb_shop_list_item sct_li">
            <div class="v_ch_list">
                <?php if ($this->view_it_img) { ?>
                <div class="rb_shop_list_item_img">
                    <a href="<?php echo $item_link_href ?>">
                    <?php echo rb_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name'])); ?>
                    </a>
                    
                    <div class="sit_icon_li">
                    <?php if ($this->view_it_icon) { ?>
                        <?php echo item_icon($row) ?>
                        <?php if($row['it_sc_type'] == 1) { ?> 
                            <span class="shop_icon shop_icon_6">무료배송</span>
                        <?php } ?>
                    <?php } ?>
                    
                    </div>
                    <?php if ($is_soldout) { ?>
                        <div class="sold_out_wrap">
                            <ul>
                                <li>
                                <span>
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g id="alert_fill" fill='none' fill-rule='nonzero'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#ffffff' d='m13.299 3.148 8.634 14.954a1.5 1.5 0 0 1-1.299 2.25H3.366a1.5 1.5 0 0 1-1.299-2.25l8.634-14.954c.577-1 2.02-1 2.598 0ZM12 15a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm0-7a1 1 0 0 0-.993.883L11 9v4a1 1 0 0 0 1.993.117L13 13V9a1 1 0 0 0-1-1Z'/></g></svg><br>
                                일시품절
                                </span>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>

                </div>
                <?php } ?>
                
                


            </div>
            <div class="v_ch_list_r">
                <?php if ($this->view_it_name) { ?>
                <div class="rb_shop_list_item_ca"><?php echo $ca['ca_name'];?></div>
                <div class="rb_shop_list_item_name">
                    <a href="<?php echo $item_link_href ?>" class="font-B cut2">
                    <?php echo stripslashes($row['it_name']); ?>
                    </a>
                </div>
                <?php } ?>
                <?php if ($this->view_it_basic && $row['it_basic']) { ?>
                <div class="rb_shop_list_item_basic cut2">
                    <?php echo stripslashes($row['it_basic']) ?>
                </div>
                <?php } ?>
                <?php if ($this->view_it_cust_price || $this->view_it_price) { ?>
                <div class="rb_shop_list_item_pri">
                    <?php if ($this->view_it_price) { ?>
                    <dd class="font-B font-18 <?php if ($this->view_it_cust_price && $row['it_cust_price']) { ?>main_color<?php } ?>"><?php echo display_price(get_price($row), $row['it_tel_inq']) ?></dd>
                    <?php } ?>
                    <?php if ($this->view_it_cust_price && $row['it_cust_price']) { ?>
                    <dd class="font-B font-16"><?php echo $sale_per ?></dd>
                    <?php } ?>
                </div>
                <?php } ?>
                
                <div class="list_wish_int">
                    <dl>
                        <dd><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></dd>
                        <dd><?php echo get_wishlist_count_by_item($row['it_id']); ?></dd>
                    </dl>
                </div>

            </div>
            
                
                
        </li>
    </ul>
    
    <?php } ?>
    <?php if($i === 0) echo "<div class=\"da_data\">등록된 상품이 없습니다.</div>"; ?>
    
    </div>
    </div>
</div>

                    <script>
                        var swiper = new Swiper('.swiper-container-list-list', {
                            slidesPerColumnFill: 'row',
                            slidesPerView: <?php echo $list_mod ?>, //가로갯수
                            slidesPerColumn: 9999, // 세로갯수
                            spaceBetween: 25, // 간격
                            touchRatio: 0, // 드래그 가능여부(1, 0)

                            breakpoints: { // 반응형 처리
                                
                                1024: {
                                    slidesPerView: <?php echo $list_mod ?>,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 25,
                                },                
                                768: {
                                    slidesPerView: 3,
                                    slidesPerColumn: 999,
                                    spaceBetween: 20,
                                },
                                10: {
                                    slidesPerView: 2,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 20,
                                }
                            }

                        });
                    </script>


