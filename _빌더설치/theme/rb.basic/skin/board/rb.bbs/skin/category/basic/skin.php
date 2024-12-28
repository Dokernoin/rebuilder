<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

    <!-- 카테고리 { -->
    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="swiper-container swiper-container-category">
        <ul id="bo_cate_ul" class="swiper-wrapper swiper-wrapper-category">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <script>
        $(document).ready(function(){
            $("#bo_cate_ul li").addClass("swiper-slide swiper-slide-category");
        });

        var swiper = new Swiper('.swiper-container-category', {
            slidesPerView: 'auto', //가로갯수
            spaceBetween: 0, // 간격
            //slidesOffsetBefore: 40, //좌측여백
            //slidesOffsetAfter: 40, // 우측여백
            observer: true, //리셋
            observeParents: true, //리셋
            touchRatio: 1, // 드래그 가능여부

        });

    </script>
    <?php } ?>
    <!-- } -->
