<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<div class="rb_shop_list">
<div class="swiper-container swiper-container-list-per">
<div class="swiper-wrapper swiper-wrapper-list-per">

<?php
for ($i=1; $row=sql_fetch_array($result); $i++) {
    $href = G5_SHOP_URL.'/personalpayform.php?pp_id='.$row['pp_id'].'&amp;page='.$page;
?>
   
   <ul class="swiper-slide swiper-slide-list-per sct">
     
            <li class="rb_shop_list_item sct_li">
                <div class="v_ch_list">
                    <div class="rb_shop_list_item_img">
                        <a href="<?php echo $href; ?>">
                        <img src="<?php echo G5_SHOP_SKIN_URL; ?>/img/personal.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="v_ch_list_r">

                    <div class="rb_shop_list_item_ca"></div>
                    
                    <div class="rb_shop_list_item_name">
                        <a href="<?php echo $href; ?>" class="font-B cut2">
                        <?php echo get_text($row['pp_name']).'님 개인결제'; ?>
                        </a>
                    </div>
                    
                    
                    <div class="rb_shop_list_item_pri">
                        <dd class="font-B font-18"><?php echo display_price($row['pp_price']); ?></dd>
                    </div>

                </div>
            </li>
        </ul>

<?php
}
if($i == 1) echo "<div class=\"da_data\">등록된 개인결제가 없습니다.</div>";
?>

</div>
</div>
</div>
                    <script>
                        var swiper = new Swiper('.swiper-container-list-per', {
                            slidesPerColumnFill: 'row',
                            slidesPerView: 6, //가로갯수
                            slidesPerColumn: 9999, // 세로갯수
                            spaceBetween: 25, // 간격
                            touchRatio: 0, // 드래그 가능여부(1, 0)

                            breakpoints: { // 반응형 처리
                                
                                1024: {
                                    slidesPerView: 5,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 25,
                                },                
                                768: {
                                    slidesPerView: 3,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 20,
                                },
                                10: {
                                    slidesPerView: 2,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 20,
                                }
                            },

                        });
                    </script>