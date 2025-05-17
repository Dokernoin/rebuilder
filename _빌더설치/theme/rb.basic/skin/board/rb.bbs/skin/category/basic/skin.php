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
        $(document).ready(function() {
            $("#bo_cate_ul li").addClass("swiper-slide swiper-slide-category");

            var activeElement = document.querySelector('#bo_cate_on'); // ID로 바로 찾기
            var initialSlideIndex = 0;

            if (activeElement) {
                var parentLi = activeElement.closest('li.swiper-slide-category');
                var allSlides = document.querySelectorAll('li.swiper-slide-category');
                initialSlideIndex = Array.prototype.indexOf.call(allSlides, parentLi);
            }

            //console.log('초기 인덱스:', initialSlideIndex);

            var swiper = new Swiper('.swiper-container-category', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                observer: true,
                observeParents: true,
                touchRatio: 1,
                initialSlide: initialSlideIndex
            });
        });
    </script>
    <?php } ?>
    <!-- } -->
