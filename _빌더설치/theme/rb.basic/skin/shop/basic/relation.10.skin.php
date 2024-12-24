<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.bxslider.js"></script>', 10);
?>

<div class="rb_shop_list">

<div class="bx-controls-direction">
    <a class="bx-prev" href="">Prev</a>
    <a class="bx-next" href="">Next</a>
</div>

<div class="swiper-container swiper-container-list-rel">
<div class="swiper-wrapper swiper-wrapper-list-rel">

<!-- 관련상품 10 시작 { -->
<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    
    $item_link_href = shop_item_url($row['it_id']);
    $ca = get_shop_item_with_category($row['it_id']);

    $i++;
?>

	<ul class="swiper-slide swiper-slide-list-rel sct">
     
        <li class="rb_shop_list_item sct_li">
            <div class="v_ch_list">
                <?php if ($this->view_it_img) { ?>
                <div class="rb_shop_list_item_img">
                    <a href="<?php echo $item_link_href ?>">
                    <?php echo rb_it_image($row['it_id'], $this->img_width, $this->img_height, '', '', stripslashes($row['it_name'])); ?>
                    </a>
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
                </div>
                <?php } ?>
            </div>
        </li>
    </ul>

<?php } ?>
   
    <?php if($i === 0) echo "<div class=\"no_data\">등록된 상품이 없습니다.</div>"; ?>
    
    </div>
    </div>
</div>


                <script>
                        var swiper = new Swiper('.swiper-container-list-rel', {
                            slidesPerView: <?php echo $default['de_rel_list_mod']; ?>, //가로갯수
                            slidesPerColumn: 1, // 세로갯수
                            spaceBetween: 25, // 간격
                            touchRatio: 1, // 드래그 가능여부(1, 0)
                            
                            navigation: { //네비
                                nextEl: '.bx-next',
                                prevEl: '.bx-prev',
                            },

                            breakpoints: { // 반응형 처리
                                
                                1024: {
                                    slidesPerView: <?php echo $default['de_rel_list_mod']; ?>,
                                    slidesPerColumn: 1,
                                    spaceBetween: 25,
                                },                
                                768: {
                                    slidesPerView: 3,
                                    slidesPerColumn: 1,
                                    spaceBetween: 20,
                                },
                                10: {
                                    slidesPerView: <?php echo $default['de_mobile_rel_list_mod']; ?>,
                                    slidesPerColumn: 1,
                                    spaceBetween: 20,
                                }
                            },

                        });
                    </script>