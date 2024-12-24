<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');

$layout_no = isset($_POST['layout']) ? $_POST['layout'] : ''; // 기본값을 빈 문자열로 설정
$layout_name = isset($rb_core['layout']) ? $rb_core['layout'] : ''; // 기본값을 빈 문자열로 설정
$theme_name = isset($rb_core['theme']) ? $rb_core['theme'] : ''; // 기본값을 빈 문자열로 설정
?>


<?php
    $sql = "SELECT * FROM rb_module WHERE md_layout = '{$layout_no}' AND md_theme = '{$theme_name}' AND md_layout_name = '{$layout_name}' ORDER BY md_order_id, md_id ASC";
    $sql_cnts = sql_fetch("SELECT COUNT(*) as cnt FROM rb_module WHERE md_layout = '{$layout_no}' AND md_theme = '{$theme_name}' AND md_layout_name = '{$layout_name}'");
    $result = sql_query($sql);
    $rb_module_table = "rb_module";

if ($result) { // 결과가 유효한지 확인
    for ($i = 0; $row_mod = sql_fetch_array($result); $i++) {
?>

        
        <ul class="content_box rb_module_<?php echo $row_mod['md_id'] ?> rb_module_border_<?php echo $row_mod['md_border'] ?> rb_module_radius_<?php echo $row_mod['md_radius'] ?> <?php if(isset($row_mod['md_padding']) && $row_mod['md_padding'] > 0) { ?>rb_module_padding_<?php echo $row_mod['md_padding'] ?><?php } ?>" style="width:<?php echo $row_mod['md_width'] ?>%; height:<?php echo $row_mod['md_height'] ?>;" data-layout="<?php echo $row_mod['md_layout'] ?>" data-title="<?php echo $row_mod['md_title'] ?>" data-id="<?php echo $row_mod['md_id'] ?>" data-order-id="<?php echo $row_mod['md_id'] ?>">
            
            <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "latest") { ?>
                
                <div class="module_latest_wrap">
                <?php echo rb_latest($row_mod['md_skin'], $row_mod['md_bo_table'], $row_mod['md_cnt'], 999, 1, $row_mod['md_id'], $row_mod['md_sca']); ?>
                </div>
                
                <?php if($is_admin) { ?>
                    <?php if(rb_skin_select_is('latest', $row_mod['md_skin']) != "true") { ?>

                    <div class="no_data_section">
                        <ul><img src="./theme/rb.basic/rb.img/icon/icon_error.svg" style="width:50px;"></ul>
                        <ul class="no_data_section_ul1 font-B">출력 스킨이 잘못되었습니다.</ul>
                        <ul class="no_data_section_ul2"><?php echo $row_mod['md_title'] ?>의 스킨폴더가 삭제 되었거나<br>출력스킨이 지정되지 않았습니다.</ul>
                    </div>

                    <?php } ?>


                    <!-- 설정 { -->
                    <span class="admin_ov">
                        <div class="mod_edit">
                            <ul class="middle_y text-center">
                                <h2 class="font-B"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?> <span>모듈 설정</span></h2>
                                <h6 class="font-R">해당 모듈의 설정을 변경할 수 있습니다.</h6>
                                <button type="button" alt="설정열기" class="btn_round btn_round_bg admin_set_btn" onclick="set_module_send(this);">설정</button>
                                <button type="button" alt="모듈삭제" class="btn_round admin_set_btn" onclick="set_module_del(this);">삭제</button>
                            </ul>
                        </div>
                    </span>
                    <!-- } -->
                    
                <?php } ?>
                
            <?php } ?>
            
            <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "widget") { ?>
               
                <div class="module_widget_wrap">
                <?php include(G5_PATH.'/rb/'.$row_mod['md_widget'].'/widget.php'); ?>
                </div>
                <?php if($is_admin) { ?>
                    <?php if(rb_widget_select_is('rb.widget', $row_mod['md_widget']) != "true") { ?>

                    <div class="no_data_section">
                        <ul><img src="./theme/rb.basic/rb.img/icon/icon_error.svg" style="width:50px;"></ul>
                        <ul class="no_data_section_ul1 font-B">출력 위젯이 잘못되었습니다.</ul>
                        <ul class="no_data_section_ul2"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?>의 위젯폴더가 삭제 되었거나<br>출력위젯이 지정되지 않았습니다.</ul>
                    </div>

                    <?php } ?>


                    <!-- 설정 { -->
                    <span class="admin_ov">
                        <div class="mod_edit">
                            <ul class="middle_y text-center">
                                <h2 class="font-B"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?> <span>모듈 설정</span></h2>
                                <h6 class="font-R">해당 모듈의 설정을 변경할 수 있습니다.</h6>
                                <button type="button" alt="설정열기" class="btn_round btn_round_bg admin_set_btn" onclick="set_module_send(this);">설정</button>
                                <button type="button" alt="모듈삭제" class="btn_round admin_set_btn" onclick="set_module_del(this);">삭제</button>
                            </ul>
                        </div>
                    </span>
                    <!-- } -->
                    
                <?php } ?>
            <?php } ?>
            
            
            <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "banner") { ?>
               
                <div class="module_banner_wrap">
                <?php echo rb_banners($row_mod['md_banner'], $row_mod['md_banner_id'], $row_mod['md_banner_skin']); ?>
                </div>
                
                <?php if($is_admin) { ?>
                  
                   <?php if(rb_banner_select_is($row_mod['md_banner']) != "true") { ?>
                   
                    <div class="no_data_section">
                        <ul><img src="./theme/rb.basic/rb.img/icon/icon_error.svg" style="width:50px;"></ul>
                        <ul class="no_data_section_ul1 font-B">배너 출력이 잘못되었습니다.</ul>
                        <ul class="no_data_section_ul2"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?>의 배너가 삭제 되었거나<br>배너가 지정되지 않았습니다.</ul>
                    </div>

                    <?php } ?>


                    <!-- 설정 { -->
                    <span class="admin_ov">
                        <div class="mod_edit">
                            <ul class="middle_y text-center">
                                <h2 class="font-B"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?> <span>모듈 설정</span></h2>
                                <h6 class="font-R">해당 모듈의 설정을 변경할 수 있습니다.</h6>
                                <button type="button" alt="설정열기" class="btn_round btn_round_bg admin_set_btn" onclick="set_module_send(this);">설정</button>
                                <button type="button" alt="모듈삭제" class="btn_round admin_set_btn" onclick="set_module_del(this);">삭제</button>
                            </ul>
                        </div>
                    </span>
                    <!-- } -->
                    
                <?php } ?>
            <?php } ?>
            
            
            <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "poll") { ?>
                <?php
                    $md_poll_id = isset($row_mod['md_poll_id']) ? $row_mod['md_poll_id'] : '';
                ?>
                
                <div class="module_poll_wrap">
                <?php echo poll($row_mod['md_poll'], $md_poll_id); ?>
                </div>
                
                <?php if($is_admin) { ?>
                    <?php if(rb_skin_select_is('poll', $row_mod['md_poll']) != "true") { ?>

                    <div class="no_data_section">
                        <ul><img src="./theme/rb.basic/rb.img/icon/icon_error.svg" style="width:50px;"></ul>
                        <ul class="no_data_section_ul1 font-B">출력 스킨이 잘못되었습니다.</ul>
                        <ul class="no_data_section_ul2"><?php echo $row_mod['md_title'] ?>의 스킨폴더가 삭제 되었거나<br>출력스킨이 지정되지 않았습니다.</ul>
                    </div>

                    <?php } ?>


                    <!-- 설정 { -->
                    <span class="admin_ov">
                        <div class="mod_edit">
                            <ul class="middle_y text-center">
                                <h2 class="font-B"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?> <span>모듈 설정</span></h2>
                                <h6 class="font-R">해당 모듈의 설정을 변경할 수 있습니다.</h6>
                                <button type="button" alt="설정열기" class="btn_round btn_round_bg admin_set_btn" onclick="set_module_send(this);">설정</button>
                                <button type="button" alt="모듈삭제" class="btn_round admin_set_btn" onclick="set_module_del(this);">삭제</button>
                            </ul>
                        </div>
                    </span>
                    <!-- } -->
                    
                <?php } ?>
                
            <?php } ?>

        </ul>
        

    <?php } ?>
<?php } ?>

<?php if($is_admin) { ?>
    <?php if (!isset($sql_cnts['cnt']) || !$sql_cnts['cnt']) { ?>
    <div class="no_data_section"><ul><img src="./theme/rb.basic/rb.img/icon/icon_error.svg" style="width:50px;"></ul><ul class="no_data_section_ul1 font-B">추가된 모듈이 없습니다.</ul><?php if($is_admin) { ?><ul class="no_data_section_ul2">모듈추가 버튼을 클릭하셔서 모듈을 추가해주세요.<br>모듈은 계속 추가할 수 있습니다.</ul><?php } ?></div>
    <?php } ?>

    <div class="add_module_wrap adm_co_gap_pc_<?php echo $rb_core['gap_pc'] ?>">
    <button type="button" class="add_module_btns font-B" onclick="set_module_send(this);">모듈추가</button>
    </div>
<?php } ?>


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