<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>
        </section>
    </div>
    
    
    <?php 

    if (isset($rb_core['layout_ft']) && $rb_core['layout_ft'] == "") {
        echo "<div class='no_data' style='padding:30px 0 !important; margin-top:0px; border:0px !important; background-color:#f9f9f9;'><span class='no_data_section_ul1 font-B color-000'>선택된 푸터 레이아웃이 없습니다.</span><br>환경설정 패널에서 먼저 푸터 레이아웃을 설정해주세요.</div>";
    } else if (isset($rb_core['layout_ft'])) { 
        // 레이아웃 인클루드
        include_once(G5_THEME_PATH . '/rb.layout_ft/' . $rb_core['layout_ft'] . '/footer.php'); 
    } else {
        echo "<div class='no_data' style='padding:30px 0 !important; margin-top:0px; border:0px !important; background-color:#f9f9f9;'><span class='no_data_section_ul1 font-B color-000'>푸터 레이아웃 설정이 올바르지 않습니다.</span><br>환경설정 패널에서 먼저 푸터 레이아웃을 설정해주세요.</div>";
    }

    ?>
    
    


                <!-- 전체메뉴 { -->
                <nav id="cbp-hrmenu-btm" class="cbp-hrmenu cbp-hrmenu-btm mobile">
                   
                    <div class="user_prof_bg">
                        <?php if($is_member) { ?>
                            <li class="user_prof_bg_info font-B"><?php echo $member['mb_nick'] ?></li>
                            <li class="user_prof_bg_info font-B"><span><?php echo $member['mb_level'] ?> Lv</span> <a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point font-B"><span><?php echo number_format($member['mb_point']); ?> P</span></a></li>
                        <?php } else { ?>
                            <li class="user_prof_bg_info font-B">Guest</li>
                        <?php } ?>
                    </div>
                    <div class="user_prof">
                        <?php if($is_member) { ?>
                        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="font-B"><?php echo get_member_profile_img($member['mb_id']); ?></a>
                        <?php } else { ?>
                        <?php echo get_member_profile_img($member['mb_id']); ?>
                        <?php } ?>
                    </div>
                    <div class="user_prof_btns">
                        <li class="">
                            <?php if($is_member) { ?>
                            <button type="button" alt="로그아웃" class="btn_round" onclick="location.href='<?php echo G5_BBS_URL ?>/logout.php';">로그아웃</button>
                            <button type="button" alt="마이페이지" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_URL; ?>/rb/home.php?mb_id=<?php echo $member['mb_id']; ?>';">My</button>
                            <?php } else { ?>
                            <button type="button" alt="로그인" class="btn_round" onclick="location.href='<?php echo G5_BBS_URL ?>/login.php';">로그인</button>
                            <button type="button" alt="회원가입" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_BBS_URL ?>/register.php';">회원가입</button>
                            <?php } ?>
                        </li>
                    </div>
                    
                    
                    <ul>
                    <?php
                    $menu_datas = get_menu_db(0, true);
                    $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                    $i = 0;
                    foreach( $menu_datas as $row ){
                        if( empty($row) ) continue;
                        $add_arr = (isset($row['sub']) && $row['sub']) ? 'add_arr_svg' : '';
                        $add_arr_btn = (isset($row['sub']) && $row['sub']) ? '<button type="button" class="add_arr_btn"></button>' : '';
                    ?>
                    <li class="<?php echo $add_arr ?>">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="font-B"><?php echo $row['me_name'] ?></a>
                        <?php echo $add_arr_btn ?>
                        <?php
                        $k = 0;
                        foreach( (array) $row['sub'] as $row2 ){

                            if( empty($row2) ) continue; 
                            
                            if($k == 0)
                                echo '<div class="cbp-hrsub"><div class="cbp-hrsub-inner"><div><!--<h4 class="font-B">그룹</h4>--><ul>'.PHP_EOL;
                            
                        ?>
                            <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                        <?php
                        $k++;
                        }   //end foreach $row2

                        if($k > 0)
                            echo '</ul></div></div></div>'.PHP_EOL;
                        ?>
                    </li>
                    <?php
                    $i++;
                    }   //end foreach $row
                    ?>
                    </ul>
                </nav>
                <!-- } -->



<button type="button" id="m_gnb_close_btn" class="mobile">
    <img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_close.svg">
</button>

<script>
    $(document).ready(function() {
        $('#m_gnb_close_btn').click(function() {
            $('#cbp-hrmenu-btm').removeClass('active');
            $('#m_gnb_close_btn').removeClass('active');
            $('main').removeClass('moves');
            $('header').removeClass('moves');
        });
    });
</script>


<script src="<?php echo G5_THEME_URL ?>/rb.js/cbpHorizontalMenu.min.js"></script>
<script>
    $(function() {
        cbpHorizontalMenu.init();
        cbpHorizontalMenu_btm.init();
    });
</script>
<!-- } -->

<!-- 캘린더 옵션 { -->
<script>
    $.datepicker.setDefaults({
        closeText: "닫기",
        prevText: "이전달",
        nextText: "다음달",
        currentText: "오늘",
        monthNames: ["1월", "2월", "3월", "4월", "5월", "6월",
            "7월", "8월", "9월", "10월", "11월", "12월"
        ],
        monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월",
            "7월", "8월", "9월", "10월", "11월", "12월"
        ],
        dayNames: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"],
        dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
        dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
        weekHeader: "주",
        dateFormat: "yy-mm-dd",
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: "년"
    })

    $(".datepicker_inp").datepicker({
        //minDate: 0
    })
</script>

<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/rb.css/datepicker.css" />
<!-- } -->

<!-- rb 전용 swiper (서브페이지용) { -->
<script>
$(document).ready(function () {
    // DOM이 준비되면 모든 슬라이더 초기화
    initializeAllSliders();
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
</script>
<!-- } -->

<?php
    //리빌드세팅
    if($is_admin) {
        include_once(G5_PATH.'/rb/rb.config/right.php'); //환경설정
    }
         
    // HOOK 추가, (tail.php 가 로드되는 페이지에서만 / 쪽지, 로그인 등의 모듈 페이지에서는 실행 되지않게 하기위함.)
    // 관련 HOOK : add_event('tail_sub', 'aaa');
    $rb_hook_tail = "true";

?>


<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");