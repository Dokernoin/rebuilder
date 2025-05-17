$(document).ready(function () {
    function processFlexBoxesOnce($scope, callback) {
        var flexBoxes = $scope.find('.flex_box').addBack('.flex_box').filter(function () {
            return !$(this).data('layout-loaded'); // 중복 방지
        });

        var layoutNumbers = [];

        flexBoxes.each(function (index) {
            var $box = $(this);
            var layout = $box.attr('data-layout');

            if (!layout) {
                layout = layoutNumbers.length + 1;
                $box.attr('data-layout', layout);
            }

            layoutNumbers.push(layout);
            $box.data('layout-loaded', true);
        });

        if (!layoutNumbers.length) {
            if (callback) callback();
            return;
        }

        $.ajax({
            url: g5_url + '/rb/rb.config/ajax.layout_set.shop.php',
            method: 'POST',
            dataType: 'json',
            data: { layouts: layoutNumbers },
            success: function (response) {
                flexBoxes.each(function () {
                    var $box = $(this);
                    var layout = $box.attr('data-layout');
                    var html = response[layout];

                    if (html !== undefined) {
                        $box.html(html);
                    }
                });

                if (callback) callback();
            },
            error: function () {
                console.error('레이아웃 로드 실패');
                if (callback) callback();
            }
        });
    }

    // ✅ 1차 처리 → 2차로 전체 한 번 더 훑어서 놓친 거 있으면 추가 처리
    processFlexBoxesOnce($('body'), function () {
        processFlexBoxesOnce($('body'), function () {
            setTimeout(function () {
                if (typeof initializeAllSliders === "function") initializeAllSliders();
                if (typeof initializeCalendar === "function") initializeCalendar();
            }, 50);
        });
    });
});



    function initializeAllSliders() {
        $('.rb_swiper').each(function () {
            const $slider = $(this);
            setupResponsiveSlider($slider);
        });
    }

    function setupResponsiveSlider($rb_slider) {
        let swiperInstance = null; // Swiper 인스턴스 저장
        let currentMode = ''; // 현재 모드 ('pc' 또는 'mo')

        // 초기 설정
        function initSlider(mode) {
            const isMobile = mode === 'mo';
            const rows = parseInt($rb_slider.data(isMobile ? 'mo-h' : 'pc-h'), 10) || 1;
            const cols = parseInt($rb_slider.data(isMobile ? 'mo-w' : 'pc-w'), 10) || 1;
            const gap = parseInt($rb_slider.data(isMobile ? 'mo-gap' : 'pc-gap'), 10) || 0;
            const swap = $rb_slider.data(isMobile ? 'mo-swap' : 'pc-swap') == 1;
            const slidesPerView = rows * cols;

            // 슬라이드 재구성 및 간격 설정
            configureSlides($rb_slider, slidesPerView, cols, gap);

            // Swiper 초기화
            if (swiperInstance) {
                swiperInstance.destroy(true, true); // 기존 Swiper 삭제
            }

            swiperInstance = new Swiper($rb_slider.find('.rb_swiper_inner')[0], {
                slidesPerView: 1,
                initialSlide: 0,
                spaceBetween: gap,
                resistanceRatio: 0,
                touchRatio: swap ? 1 : 0,
                autoplay: $rb_slider.data('autoplay') == 1
                    ? {
                        delay: parseInt($rb_slider.data('autoplay-time'), 10) || 3000,
                        disableOnInteraction: false,
                    }
                    : false,
                navigation: {
                    nextEl: $rb_slider.find('.rb-swiper-next')[0],
                    prevEl: $rb_slider.find('.rb-swiper-prev')[0],
                },
            });
        }

        // 슬라이드 구성 및 재구성
        function configureSlides($rb_slider, view, cols, gap) {
            const widthPercentage = `calc(${100 / cols}% - ${(gap * (cols - 1)) / cols}px)`;

            $rb_slider.find('.rb_swiper_list').css('width', widthPercentage);

            // 기존 슬라이드 그룹화 제거
            if ($rb_slider.find('.rb_swiper_list').parent().hasClass('rb-swiper-slide')) {
                $rb_slider.find('.swiper-slide-duplicate').remove();
                $rb_slider.find('.rb_swiper_list').unwrap('.rb-swiper-slide');
            }

            // 슬라이드 그룹화
            let groupIndex = 0;
            $rb_slider.find('.rb_swiper_list').each(function (index) {
                $(this).addClass('rb_swiper_group' + Math.floor(index / view));
                groupIndex = Math.floor(index / view);
            }).promise().done(function () {
                for (let i = 0; i <= groupIndex; i++) {
                    $rb_slider.find('.rb_swiper_group' + i).wrapAll('<div class="rb-swiper-slide swiper-slide"></div>');
                    $rb_slider.find('.rb_swiper_group' + i).removeClass('rb_swiper_group' + i);
                }
            });

            // 간격 설정
            $rb_slider.find('.rb-swiper-slide').css({
                'gap': `${gap}px`,
            });

            // 마지막 요소 오른쪽 간격 제거
            $rb_slider.find('.rb_swiper_list').each(function (index) {
                if ((index + 1) % cols === 0) {
                    $(this).css('margin-right', '0');
                }
            });
        }

        // 반응형 설정
        function checkModeAndInit() {
            const winWidth = window.innerWidth;
            const mode = winWidth <= 1024 ? 'mo' : 'pc';

            if (currentMode !== mode) {
                currentMode = mode;
                initSlider(mode); // 모드 변경 시 재초기화
            }
        }

        // 초기 실행 및 이벤트 등록
        $(window).on('load resize', checkModeAndInit);
        checkModeAndInit(); // 첫 실행
    }
