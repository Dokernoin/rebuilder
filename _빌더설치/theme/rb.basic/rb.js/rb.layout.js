$(document).ready(function () {

    function getBasePathFromG5() {
        try {
            var u = new URL(typeof g5_url === 'string' ? g5_url : '/', window.location.origin);
            return (u.pathname || '/').replace(/\/+$/, '');
        } catch (e) {
            return '';
        }
    }

    function getPathRelativeToBase() {
        var base = getBasePathFromG5();
        var cur = window.location.pathname || '/';
        if (base && cur.indexOf(base) === 0) {
            cur = cur.slice(base.length);
            if (!cur.startsWith('/')) cur = '/' + cur;
        }
        return cur.replace(/^\/+/, '').replace(/\/{2,}/g, '/');
    }

    function getGETFromRewrite() {
        var path = getPathRelativeToBase();
        var qsParams = new URLSearchParams(window.location.search);
        var qsObj = Object.fromEntries(qsParams.entries());

        var rules = [
            {
                re: /^content\/([0-9a-zA-Z_]+)\/?$/,
                map: m => ({
                    co_id: m[1],
                    rewrite: '1'
                })
            },
            {
                re: /^content\/([^\/]+)\/$/,
                map: m => ({
                    co_seo_title: m[1],
                    rewrite: '1'
                })
            },
            {
                re: /^rss\/([0-9a-zA-Z_]+)\/?$/,
                map: m => ({
                    bo_table: m[1]
                })
            },
            {
                re: /^([0-9a-zA-Z_]+)\/write$/,
                map: m => ({
                    bo_table: m[1],
                    rewrite: '1'
                })
            },
            {
                re: /^([0-9a-zA-Z_]+)\/([0-9]+)\/?$/,
                map: m => ({
                    bo_table: m[1],
                    wr_id: m[2],
                    rewrite: '1'
                })
            },
            {
                re: /^([0-9a-zA-Z_]+)\/([^\/]+)\/$/,
                map: m => ({
                    bo_table: m[1],
                    wr_seo_title: m[2],
                    rewrite: '1'
                })
            },
            {
                re: /^([0-9a-zA-Z_]+)\/?$/,
                map: m => ({
                    bo_table: m[1],
                    rewrite: '1'
                })
            },
        ];

        var fromPath = {};
        for (var i = 0; i < rules.length; i++) {
            var m = path.match(rules[i].re);
            if (m) {
                fromPath = rules[i].map(m);
                break;
            }
        }
        return Object.assign({}, fromPath, qsObj);
    }

    function toQueryString(obj) {
        var usp = new URLSearchParams();
        Object.keys(obj || {}).forEach(function (k) {
            if (obj[k] !== undefined && obj[k] !== null) usp.append(k, obj[k]);
        });
        var s = usp.toString();
        return s ? ('?' + s) : '';
    }


    window._GET = getGETFromRewrite();

    function processFlexBoxesOnce($scope, callback) {
        // 1) 로드 대상 수집: 섹션 내부는 제외
        var flexBoxes = $scope.find('.flex_box').addBack('.flex_box').filter(function () {
            var $box = $(this);
            if ($box.data('layout-loaded')) return false;
            if ($box.closest('.rb_section_box').length) return false; // 섹션 내부 제외
            return true;
        });

        // 2) 레이아웃 목록 만들기 (없으면 자동 부여)
        var layoutNumbers = [];
        var seq = 0;
        flexBoxes.each(function () {
            var $box = $(this);
            var lay = String($box.attr('data-layout') || '').trim();

            if (!lay) {
                // 최상위 컨테이너에만 임시 번호 부여 (1,2,3…)
                seq += 1;
                lay = String(seq);
                $box.attr('data-layout', lay);
            }

            if (layoutNumbers.indexOf(lay) === -1) layoutNumbers.push(lay);
            // 여기서는 아직 layout-loaded 찍지 않음 (성공 후에 찍음)
        });

        if (!layoutNumbers.length) {
            if (callback) callback();
            return;
        }

        var qs = toQueryString(getGETFromRewrite());

        // 3) AJAX 로드
        $.ajax({
            url: g5_url + '/rb/rb.config/ajax.layout_set.php' + qs,
            method: 'POST',
            dataType: 'json',
            data: {
                layouts: layoutNumbers,
                is_index: is_index
            },
            success: function (res) {
                flexBoxes.each(function () {
                    var $box = $(this);
                    var lay = String($box.attr('data-layout') || '').trim();
                    if (res[lay] !== undefined) {
                        $box.html(res[lay]);
                        $box.data('layout-loaded', true); // 성공 후에 표시
                    }
                });

                // 로드 후: 키(sec_uid) 일치 모듈만 섹션으로 이동
                packModulesIntoSectionsOnce();

                if (callback) callback();
            },
            error: function () {
                console.error('레이아웃 로드 실패');
                if (callback) callback();
            }
        });
    }

    // 섹션으로 모듈을 '키 일치'할 때만 이동
    function packModulesIntoSectionsOnce() {
        $('.rb_section_box').each(function () {
            var $sec = $(this);
            var secUid = String($sec.attr('data-sec-uid') || '').trim();
            if (!secUid) return;

            var $inner = $sec.children('.flex_box').first();

            // 현재 섹션 바깥에 있는 모듈 중 sec_uid가 같은 것만 흡수
            var $cand = $('.rb_layout_box').filter(function () {
                var $m = $(this);
                var mUid = String($m.attr('data-sec-uid') || '').trim();
                var outside = ($m.closest('.rb_section_box').length === 0);
                return !!mUid && mUid === secUid && outside;
            });

            if ($cand.length) {
                $inner.append($cand);
                // 보너스: 표시용 layout도 섹션 layout로 맞춤
                var layout = String($sec.attr('data-layout') || '').trim();
                $cand.attr('data-layout', layout);
            }
        });
    }

    // 2회 로드 패턴 유지
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
            autoplay: $rb_slider.data('autoplay') == 1 ? {
                delay: parseInt($rb_slider.data('autoplay-time'), 10) || 3000,
                disableOnInteraction: false,
            } : false,
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
