<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.config/style.css?ver='.G5_TIME_YMDHIS.'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.config/coloris/coloris.css?ver='.G5_TIME_YMDHIS.'">', 0);
add_javascript('<script src="'.G5_URL.'/rb/rb.config/coloris/coloris.js"></script>', 0);

//CSRF 보안
if (!isset($_SESSION['rb_widget_csrf'])) {
  $_SESSION['rb_widget_csrf'] = bin2hex(function_exists('random_bytes') ? random_bytes(32) : openssl_random_pseudo_bytes(32));
}
?>

<script>
    window.RB_WIDGET_CSRF = "<?php echo $_SESSION['rb_widget_csrf'] ?>";

    (function fixShopRadioCheckboxNamesOnce() {
        if (window.RB_IS_SHOP != 1) return;

        // 1) id가 *_shop 인 라디오/체크박스 → name을 base+"_shop"로 강제
        $('[id$="_shop"][type="radio"], [id$="_shop"][type="checkbox"]').each(function() {
            var id = this.id;
            var base = id.replace(/_shop$/, ''); // ex) md_title_hide_shop → md_title_hide
            $(this).attr('name', base + '_shop'); // name=md_title_hide_shop 으로 강제
        });

        // 2) 같은 name의 일반 쌍둥이 → name에 __common 붙여서 무시되게
        $('input[type="radio"], input[type="checkbox"]').each(function() {
            var $el = $(this);
            var id = $el.attr('id') || '';
            var name = $el.attr('name') || '';

            // 이미 *_shop 그룹이면 건드리지 않음
            if (/_shop$/.test(id) || /_shop$/.test(name)) return;

            // 내 base에 해당하는 *_shop 쌍둥이가 존재하면 일반 쪽 name을 치움
            var base = id || name;
            var hasShopTwin =
                document.getElementById(base + '_shop') ||
                document.getElementsByName(base + '_shop').length;

            if (hasShopTwin) {
                $el.attr('name', (name || base) + '__common'); // 저장 시 제외됨
            }
        });
    })();
</script>

<div class="sh-side-options-container" style="margin-top:100px">

    <a href="<?php echo G5_ADMIN_URL  ?>" target="_blank" class="sh-side-options-item sh-accent-color" data-tooltip="관리자모드" data-tooltip-pos="top">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_setting.svg"></div>
    </a>


    <a class="sh-side-options-item sh-accent-color mobule_set_btn" onclick="toggleSideOptions();" data-tooltip="모듈설정" data-tooltip-pos="top">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_mod.svg"></div>
    </a>

    <a href="javascript:void(0);" class="sh-side-options-item sh-accent-color" id="saveOrderButton" data-tooltip="현재순서 저장" data-tooltip-pos="top">
        <div class="sh-side-options-item-container" style="height:38px;">

            <svg width="22" height="22" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M10.7749 0.391876C16.2979 0.391876 20.7749 4.86888 20.7749 10.3919C20.7749 15.9149 16.2979 20.3919 10.7749 20.3919C5.2519 20.3919 0.774902 15.9149 0.774902 10.3919C0.774902 4.86888 5.2519 0.391876 10.7749 0.391876ZM14.3099 6.77288L9.3599 11.7229L7.2399 9.60188C7.14706 9.50897 7.03682 9.43525 6.91549 9.38494C6.79416 9.33464 6.6641 9.30872 6.53276 9.30867C6.26749 9.30858 6.01304 9.41387 5.8254 9.60138C5.63776 9.78888 5.53229 10.0433 5.5322 10.3085C5.53211 10.5738 5.63739 10.8282 5.8249 11.0159L8.5829 13.7739C8.68505 13.8761 8.80634 13.9571 8.93983 14.0125C9.07332 14.0678 9.21641 14.0962 9.3609 14.0962C9.5054 14.0962 9.64848 14.0678 9.78197 14.0125C9.91547 13.9571 10.0368 13.8761 10.1389 13.7739L15.7249 8.18788C15.9125 8.00024 16.018 7.74574 16.018 7.48038C16.018 7.21501 15.9125 6.96052 15.7249 6.77288C15.5373 6.58524 15.2828 6.47982 15.0174 6.47982C14.752 6.47982 14.4975 6.58524 14.3099 6.77288Z" fill="#00d6ee"/>
            </svg>


        </div>
    </a>

    <?php if (defined("_INDEX_") || !empty($_GET['gr_id']) || !empty($_GET['co_id'])) { ?>
    <a class="sh-side-options-item sh-accent-color section_set_btn" onclick="toggleSideSection();" data-tooltip="섹션설정" data-tooltip-pos="top">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_sec.svg"></div>
    </a>
    <?php } ?>

    <a class="sh-side-options-item sh-accent-color setting_set_btn" onclick="toggleSideOptions_open_set();" data-tooltip="환경설정" data-tooltip-pos="top">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_set.svg"></div>
    </a>
</div>

<div class="sh-side-options sh-side-options-pages">

    <div class="sh-side-demos-container">

        <div class="sh-side-demos-container-close" onclick="toggleSideOptions_close();">
            <img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_close.svg">
        </div>


        <div class="sh-side-demos-loop">
            <div class="sh-side-demos-loop-container">

                <div class="rb_config rb_config_mod3" id="inq_res_section">
                    <h2 class="font-B">섹션설정</h2>
                    <div class="rb_config_sec">
                        <div class="no_data">
                            변경할 섹션을 선택해주세요.<br>
                            메인페이지의 각 섹션에 마우스를 오버해주세요.
                        </div>
                    </div>
                </div>


                <div class="rb_config rb_config_mod2" id="inq_res">
                    <h2 class="font-B">모듈설정</h2>
                    <div class="rb_config_sec">
                        <div class="no_data">
                            변경할 모듈을 선택해주세요.<br>
                            메인페이지의 각 영역에 마우스를 오버해주세요.
                        </div>
                    </div>
                </div>

                <div class="rb_config rb_config_mod1">

                    <h2 class="font-B">환경설정</h2>
                    <h6 class="font-R rb_config_sub_txt">웹사이트의 전반적인 환경설정 입니다.<br>서브영역 전용 설정의 경우<br>서브페이지에서 패널을 오픈해주세요.</h6>
                    <ul class="rb_config_sec">
                        <h6 class="font-B">강조컬러 설정 (공용)</h6>
                        <h6 class="font-R rb_config_sub_txt">버튼, 뱃지, 오버 등 강조되는 컬러를 설정할 수 있습니다.</h6>
                        <div class="config_wrap">
                            <ul>

                                <div class="color_set_wrap square" style="position: relative;">
                                    <input type="text" class="coloris mod_co_color" name="co_color" value="<?php echo !empty($rb_config['co_color']) ? $rb_config['co_color'] : ''; ?>">
                                </div>


                            </ul>
                        </div>
                    </ul>



                    <ul class="rb_config_sec">
                        <h6 class="font-B">헤더컬러 설정 (공용)</h6>
                        <h6 class="font-R rb_config_sub_txt">헤더 컬러 적용시 헤더의 텍스트는 흰색으로 고정 됩니다.<br>밝은톤의 헤더 컬러의 경우 자동 감지하여 강조컬러가 적용됩니다.<br>투명도가 30% 이하로 떨어지는 경우 강조컬러가 적용 됩니다.</h6>
                        <div class="config_wrap">

                            <ul>

                                <div class="color_set_wrap square" style="position: relative;">
                                    <input type="text" class="coloris coloris2 mod_co_header" name="co_header" value="<?php echo !empty($rb_config['co_header']) ? $rb_config['co_header'] : ''; ?>">
                                </div>

                                <div class="cb"></div>
                            </ul>

                        </div>
                    </ul>

                    <?php if (!defined("_INDEX_")) { ?>
                    <ul class="rb_config_sec">
                        <h6 class="font-B">서브 배경컬러 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">서브페이지 전체 백그라운드 컬러를 설정할 수 있습니다.</h6>
                        <div class="config_wrap">
                            <ul>

                                <div class="color_set_wrap square" style="position: relative;">
                                    <input type="text" class="coloris mod_co_sub_bg" name="co_sub_bg" value="<?php echo !empty($rb_config['co_sub_bg']) ? $rb_config['co_sub_bg'] : '#ffffff'; ?>">
                                    <input type="hidden" name="co_main_bg" value="<?php echo !empty($rb_config['co_main_bg']) ? $rb_config['co_main_bg'] : '#ffffff'; ?>">
                                </div>

                            </ul>
                        </div>
                    </ul>
                    <?php } else { ?>
                    <ul class="rb_config_sec">
                        <h6 class="font-B">메인 배경컬러 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">메인페이지 백그라운드 컬러를 설정할 수 있습니다.</h6>
                        <div class="config_wrap">
                            <ul>

                                <div class="color_set_wrap square" style="position: relative;">
                                    <input type="text" class="coloris mod_co_main_bg" name="co_main_bg" value="<?php echo !empty($rb_config['co_main_bg']) ? $rb_config['co_main_bg'] : '#ffffff'; ?>">
                                    <input type="hidden" name="co_sub_bg" value="<?php echo !empty($rb_config['co_sub_bg']) ? $rb_config['co_sub_bg'] : '#ffffff'; ?>">
                                </div>

                            </ul>
                        </div>
                    </ul>
                    <?php } ?>


                    <ul class="rb_config_sec">
                        <h6 class="font-B">
                            모듈간격 설정 (공용)

                            <div class="rb-help" data-open="false">
                                <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-2.png" data-txt="삽입된 모듈간의 간격을 일괄 조정할 수 있어요. 설정된 간격은 모바일에서도 동일하게 적용 되요." data-title="모듈 간격설정 이란?" data-alt="미리보기" aria-expanded="false">
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
                                        <g fill='none'>
                                            <path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z' />
                                            <path fill='#DDDDDDFF' d='M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 14a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-9.5a3.625 3.625 0 0 0-3.625 3.625 1 1 0 1 0 2 0 1.625 1.625 0 1 1 2.23 1.51c-.676.27-1.605.962-1.605 2.115V14a1 1 0 1 0 2 0c0-.244.05-.366.261-.47l.087-.04A3.626 3.626 0 0 0 12 6.5' />
                                        </g>
                                    </svg>
                                </button>
                                <aside role="tooltip" class="rb-help-pop" aria-hidden="true"></aside>
                            </div>

                        </h6>
                        <h6 class="font-R rb_config_sub_txt">모듈간 간격을 일괄 설정할 수 있습니다.<br>설정된 간격은 모바일에서 동일하게 적용 됩니다.</h6>
                        <div class="config_wrap">

                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">간격</span><br>
                                    0~30px
                                </li>
                                <li class="rows_inp_r mt-15">
                                    <div id="co_gap_pc_range" class="rb_range_item"></div>
                                    <input type="hidden" id="co_gap_pc" class="co_range_send" name="co_gap_pc" value="<?php echo !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '0'; ?>">
                                </li>

                                <script type="text/javascript">
                                    $("#co_gap_pc_range").slider({
                                        range: "min",
                                        min: 0,
                                        max: 30,
                                        value: <?php echo !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '0'; ?>,
                                        step: 5,
                                        slide: function(e, ui) {
                                            $("#co_gap_pc_range .ui-slider-handle").html(ui.value);
                                            $("#co_gap_pc").val(ui.value); // hidden input에 값 업데이트

                                            //executeAjax();

                                            // 기존 클래스 제거 후 새로운 클래스 추가
                                            /*
                                            $('.contents_wrap section.index').removeClass(function(index, className) {
                                                return (className.match(/co_gap_pc_\d+/g) || []).join(' ');
                                            }).addClass('co_gap_pc_' + ui.value);

                                            $('.contents_wrap section.sub').removeClass(function(index, className) {
                                                return (className.match(/co_gap_pc_\d+/g) || []).join(' ');
                                            }).addClass('co_gap_pc_' + ui.value);

                                            $('.add_module_wrap').removeClass(function(index, className) {
                                                return (className.match(/adm_co_gap_pc_\d+/g) || []).join(' ');
                                            }).addClass('adm_co_gap_pc_' + ui.value);
                                            */

                                        }
                                    });

                                    $("#co_gap_pc_range .ui-slider-handle").html("<?php echo !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '0'; ?>");
                                    $("#co_gap_pc").val("<?php echo !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '0'; ?>"); // 초기값 설정
                                </script>
                                <div class="cb"></div>
                            </ul>

                            <input type="hidden" id="co_inner_padding_pc" class="" name="co_inner_padding_pc" value="">

                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">모바일 간격</span><br>
                                    gap
                                </li>
                                <li class="rows_inp_r mt-5">
                                    <input type="checkbox" name="co_gap_mo" id="co_gap_mo" class="magic-checkbox" value="1" <?php if (isset($rb_core['gap_mo']) && $rb_core['gap_mo'] == "1") { ?>checked<?php } ?>><label for="co_gap_mo">Gap 적용</label>
                                </li>
                                <div class="cb"></div>

                                <div class="rb-help" data-open="false">
                                    <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-2.png" data-txt="간격이 20px 설정인 경우 각 모듈에 20px씩 여백이 들어가면 실제 간격은 40px 이 되요. 모바일에서는 다소 넓어보일 수 있으므로 Gap 적용 시 각 모듈에 여백을 제거하고 간격설정 값 만큼의 Gap이 적용되어 넓어진 간격을 좁힐 수 있어요." data-title="Gap 적용이란?" data-alt="미리보기" aria-expanded="false">
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
                                            <g fill='none'>
                                                <path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z' />
                                                <path fill='#DDDDDDFF' d='M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 14a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-9.5a3.625 3.625 0 0 0-3.625 3.625 1 1 0 1 0 2 0 1.625 1.625 0 1 1 2.23 1.51c-.676.27-1.605.962-1.605 2.115V14a1 1 0 1 0 2 0c0-.244.05-.366.261-.47l.087-.04A3.626 3.626 0 0 0 12 6.5' />
                                            </g>
                                        </svg>
                                    </button>
                                    <aside role="tooltip" class="rb-help-pop" aria-hidden="true"></aside>
                                </div>
                            </ul>


                        </div>


                    </ul>



                    <?php if(defined('_SHOP_')) { // 영카트?>
                    <ul class="rb_config_sec">
                        <h6 class="font-B">마켓 헤더 메뉴설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            헤더 메뉴 구성을 상품 카테고리로 자동설정 할 수 있어요.
                        </h6>
                        <div class="config_wrap">
                            <ul>

                                <input type="radio" name="co_menu_shop" id="co_menu_shop_1" class="magic-radio mod_send" value="0" <?php if (isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == "" || isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == "0") { ?>checked<?php } ?>><label for="co_menu_shop_1">기본</label>
                                <input type="radio" name="co_menu_shop" id="co_menu_shop_2" class="magic-radio mod_send" value="1" <?php if (isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == "1") { ?>checked<?php } ?>><label for="co_menu_shop_2">카테고리</label>
                                <input type="radio" name="co_menu_shop" id="co_menu_shop_3" class="magic-radio mod_send" value="2" <?php if (isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == "2") { ?>checked<?php } ?>><label for="co_menu_shop_3">카테고리+기본</label>

                            </ul>
                        </div>
                    </ul>
                    <?php } else { ?>
                    <input type="hidden" name="co_menu_shop" id="co_menu_shop" value="<?php echo !empty($rb_core['menu_shop']) ? $rb_core['menu_shop'] : ''; ?>">
                    <?php } ?>




                    <ul class="rb_config_sec">
                        <h6 class="font-B"><?php if (defined('_SHOP_')) { // 영카트?>마켓 <?php } ?>레이아웃 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            메인, 헤더, 푸터 레이아웃을 설정 합니다.<br>레아아웃 세트는 자유롭게 추가할 수 있습니다.
                        </h6>


                        <div <?php if(defined('_SHOP_')) { // 영카트?>style="display:block !important;" <?php } else { ?>style="display:none !important;" <?php } ?>>

                            <div class="config_wrap">
                                <ul>
                                    <select class="select w100 mod_send" name="co_layout_shop">
                                        <option value="">메인 레이아웃 선택</option>
                                        <?php echo rb_dir_select_shop("rb.layout", $rb_core['layout_shop']); ?>
                                    </select>
                                </ul>

                                <?php if(isset($rb_core['layout_shop']) && $rb_core['layout_shop']) { ?>
                                <ul class="skin_path_url mt-5">
                                    <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                    <li class="skin_path_url_txt">
                                        /theme/rb.basic/shop/rb.layout/<?php echo $rb_core['layout_shop'] ?>/
                                    </li>
                                    <div class="cb"></div>
                                </ul>
                                <?php } ?>

                            </div>

                            <div class="config_wrap">
                                <ul>
                                    <select class="select w100 mod_send" name="co_layout_hd_shop">
                                        <option value="">헤더 레이아웃 선택</option>
                                        <?php echo rb_dir_select_shop("rb.layout_hd", $rb_core['layout_hd_shop']); ?>
                                    </select>
                                </ul>

                                <?php if(isset($rb_core['layout_hd_shop']) && $rb_core['layout_hd_shop']) { ?>
                                <ul class="skin_path_url mt-5">
                                    <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                    <li class="skin_path_url_txt">
                                        /theme/rb.basic/shop/rb.layout_hd/<?php echo $rb_core['layout_hd_shop'] ?>/
                                    </li>
                                    <div class="cb"></div>
                                </ul>
                                <?php } ?>

                            </div>

                            <div class="config_wrap">
                                <ul>
                                    <select class="select w100 mod_send" name="co_layout_ft_shop">
                                        <option value="">푸터 레이아웃 선택</option>
                                        <?php echo rb_dir_select_shop("rb.layout_ft", $rb_core['layout_ft_shop']); ?>
                                    </select>
                                </ul>

                                <?php if(isset($rb_core['layout_ft_shop']) && $rb_core['layout_ft_shop']) { ?>
                                <ul class="skin_path_url mt-5">
                                    <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                    <li class="skin_path_url_txt">
                                        /theme/rb.basic/shop/rb.layout_ft/<?php echo $rb_core['layout_ft_shop'] ?>/
                                    </li>
                                    <div class="cb"></div>
                                </ul>
                                <?php } ?>

                            </div>


                        </div>

                        <div <?php if(defined('_SHOP_')) { // 영카트?>style="display:none !important;" <?php } else { ?>style="display:block !important;" <?php } ?>>
                            <div class="config_wrap">
                                <ul>
                                    <select class="select w100 mod_send" name="co_layout">
                                        <option value="">메인 레이아웃 선택</option>
                                        <?php echo rb_dir_select("rb.layout", $rb_core['layout']); ?>
                                    </select>
                                </ul>

                                <?php if(isset($rb_core['layout']) && $rb_core['layout']) { ?>
                                <ul class="skin_path_url mt-5">
                                    <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                    <li class="skin_path_url_txt">
                                        /theme/rb.basic/rb.layout/<?php echo $rb_core['layout'] ?>/
                                    </li>
                                    <div class="cb"></div>
                                </ul>
                                <?php } ?>

                            </div>

                            <div class="config_wrap">
                                <ul>
                                    <select class="select w100 mod_send" name="co_layout_hd">
                                        <option value="">헤더 레이아웃 선택</option>
                                        <?php echo rb_dir_select("rb.layout_hd", $rb_core['layout_hd']); ?>
                                    </select>
                                </ul>

                                <?php if(isset($rb_core['layout_hd']) && $rb_core['layout_hd']) { ?>
                                <ul class="skin_path_url mt-5">
                                    <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                    <li class="skin_path_url_txt">
                                        /theme/rb.basic/rb.layout_hd/<?php echo $rb_core['layout_hd'] ?>/
                                    </li>
                                    <div class="cb"></div>
                                </ul>
                                <?php } ?>

                            </div>

                            <div class="config_wrap">
                                <ul>
                                    <select class="select w100 mod_send" name="co_layout_ft">
                                        <option value="">푸터 레이아웃 선택</option>
                                        <?php echo rb_dir_select("rb.layout_ft", $rb_core['layout_ft']); ?>
                                    </select>
                                </ul>

                                <?php if(isset($rb_core['layout_ft']) && $rb_core['layout_ft']) { ?>
                                <ul class="skin_path_url mt-5">
                                    <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                    <li class="skin_path_url_txt">
                                        /theme/rb.basic/rb.layout_ft/<?php echo $rb_core['layout_ft'] ?>/
                                    </li>
                                    <div class="cb"></div>
                                </ul>
                                <?php } ?>

                            </div>

                        </div>

                    </ul>

                    <?php if (!defined("_INDEX_")) { ?>
                    <ul class="rb_config_sec" <?php if(defined('_SHOP_')) { // 영카트?>style="display:block !important;" <?php } else { ?>style="display:none !important;" <?php } ?>>

                        <h6 class="font-B">마켓 서브 사이드 영역 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            서브 페이지 사이드 영역을 설정할 수 있습니다.
                        </h6>

                        <div class="config_wrap">
                            <ul class="rows_inp_lr mt-10">

                                <li class="rows_inp_r mt-5">
                                    <input type="radio" name="co_sidemenu_shop" id="co_sidemenu_shop_1" class="magic-radio mod_send" value="" <?php if (isset($rb_core['sidemenu_shop']) && $rb_core['sidemenu_shop'] == "") { ?>checked<?php } ?>><label for="co_sidemenu_shop_1">없음</label>
                                    <input type="radio" name="co_sidemenu_shop" id="co_sidemenu_shop_2" class="magic-radio mod_send" value="left" <?php if (isset($rb_core['sidemenu_shop']) && $rb_core['sidemenu_shop'] == "left") { ?>checked<?php } ?>><label for="co_sidemenu_shop_2">좌측</label>
                                    <input type="radio" name="co_sidemenu_shop" id="co_sidemenu_shop_3" class="magic-radio mod_send" value="right" <?php if (isset($rb_core['sidemenu_shop']) && $rb_core['sidemenu_shop'] == "right") { ?>checked<?php } ?>><label for="co_sidemenu_shop_3">우측</label>
                                </li>

                                <div class="cb"></div>
                            </ul>

                            <ul class="rows_inp_lr mt-5 js-sidemenu-shop-dep">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">모바일 버전</span><br>
                                    숨김설정
                                </li>

                                <li class="rows_inp_r mt-3">
                                    <input type="checkbox" name="co_sidemenu_hide_shop" id="co_sidemenu_hide_shop" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_core['sidemenu_hide_shop']) && $rb_core['sidemenu_hide_shop'] == 1) { ?>checked<?php } ?>>
                                    <label for="co_sidemenu_hide_shop">숨김처리 (모바일 전용)</label>
                                </li>
                                <div class="cb"></div>
                            </ul>

                            <ul class="rows_inp_lr mt-10 js-sidemenu-shop-dep">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">가로 크기</span><br>
                                    200~500px
                                </li>

                                <li class="rows_inp_r mt-15">
                                    <div id="co_sidemenu_width_shop_range" class="rb_range_item"></div>
                                    <input type="hidden" name="co_sidemenu_width_shop" id="co_sidemenu_width_shop" class="co_range_send" value="<?php echo !empty($rb_core['sidemenu_width_shop']) ? $rb_core['sidemenu_width_shop'] : '200'; ?>">
                                </li>

                                <script type="text/javascript">
                                    $("#co_sidemenu_width_shop_range").slider({
                                        range: "min",
                                        min: 200,
                                        max: 500,
                                        value: <?php echo !empty($rb_core['sidemenu_width_shop']) ? $rb_core['sidemenu_width_shop'] : '200'; ?>,
                                        step: 10,
                                        slide: function(e, ui) {
                                            $("#co_sidemenu_width_shop_range .ui-slider-handle").html(ui.value);
                                            $("#co_sidemenu_width_shop").val(ui.value); // hidden input에 값 업데이트

                                            //executeAjax();

                                            // 가로사이즈 반영
                                            $('#rb_sidemenu_shop').css('width', ui.value);
                                            $('#rb_sidemenu_float_shop').css('width', 'calc(100% - ' + ui.value + 'px)');

                                        }
                                    });

                                    $("#co_sidemenu_width_shop_range .ui-slider-handle").html("<?php echo !empty($rb_core['sidemenu_width_shop']) ? $rb_core['sidemenu_width_shop'] : '200'; ?>");
                                    $("#co_sidemenu_width_shop").val("<?php echo !empty($rb_core['sidemenu_width_shop']) ? $rb_core['sidemenu_width_shop'] : '200'; ?>"); // 초기값 설정
                                </script>


                                </li>
                                <div class="cb"></div>
                            </ul>


                            <ul class="rows_inp_lr mt-10 js-sidemenu-shop-dep">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">여백</span><br>
                                    0~30px
                                </li>
                                <li class="rows_inp_r mt-15">
                                    <div id="co_sidemenu_padding_shop_range" class="rb_range_item"></div>
                                    <input type="hidden" id="co_sidemenu_padding_shop" class="co_range_send" name="co_sidemenu_padding_shop" value="<?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>">
                                </li>

                                <script type="text/javascript">
                                    $("#co_sidemenu_padding_shop_range").slider({
                                        range: "min",
                                        min: 0,
                                        max: 70,
                                        value: <?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>,
                                        step: 1,
                                        slide: function(e, ui) {
                                            $("#co_sidemenu_padding_shop_range .ui-slider-handle").html(ui.value);
                                            $("#co_sidemenu_padding_shop").val(ui.value); // hidden input에 값 업데이트

                                            //executeAjax();

                                            var co_sidemenu_shop = $('input[name="co_sidemenu_shop"]:checked').val();

                                            if (co_sidemenu_shop == 'left') {
                                                $('#rb_sidemenu_shop').css('padding-right', ui.value);
                                            } else if (co_sidemenu_shop == 'right') {
                                                $('#rb_sidemenu_shop').css('padding-left', ui.value);
                                            }


                                        }
                                    });

                                    $("#co_sidemenu_padding_shop_range .ui-slider-handle").html("<?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>");
                                    $("#co_sidemenu_padding_shop").val("<?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>"); // 초기값 설정
                                </script>
                                <div class="cb"></div>
                            </ul>

                            <script>
                                // 테두리 의존 섹션 토글
                                function rb_togglesidemenushopDeps() {
                                    var v = $('input[name="co_sidemenu_shop"]:checked').val() || '';
                                    if (v === '') {
                                        // 없음 → 숨김
                                        $('.js-sidemenu-shop-dep').css('display', 'none');
                                    } else {
                                        // 실선/점선 등 → 표시
                                        $('.js-sidemenu-shop-dep').css('display', '');
                                    }
                                }

                                // 페이지 로드 시 & 라디오 변경 시 반영
                                $(function() {
                                    rb_togglesidemenushopDeps();
                                    $(document).on('change', 'input[name="co_sidemenu_shop"]', rb_togglesidemenushopDeps);
                                });
                            </script>


                        </div>

                    </ul>

                    <ul class="rb_config_sec" <?php if(defined('_SHOP_')) { // 영카트?>style="display:none !important;" <?php } else { ?>style="display:block !important;" <?php } ?>>

                        <h6 class="font-B"><?php if(defined('_SHOP_')) { // 영카트?>마켓 <?php } ?>서브 사이드 영역 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            서브 페이지 사이드 영역을 설정할 수 있습니다.<br>
                            서브 사이드 영역은 공용으로 해당영역에 모듈을 추가할 수 있으며, 마켓과 구분됩니다.
                        </h6>

                        <div class="config_wrap">
                            <ul class="rows_inp_lr mt-10">

                                <li class="rows_inp_r mt-5">
                                    <input type="radio" name="co_sidemenu" id="co_sidemenu_1" class="magic-radio mod_send" value="" <?php if (isset($rb_core['sidemenu']) && $rb_core['sidemenu'] == "") { ?>checked<?php } ?>><label for="co_sidemenu_1">없음</label>
                                    <input type="radio" name="co_sidemenu" id="co_sidemenu_2" class="magic-radio mod_send" value="left" <?php if (isset($rb_core['sidemenu']) && $rb_core['sidemenu'] == "left") { ?>checked<?php } ?>><label for="co_sidemenu_2">좌측</label>
                                    <input type="radio" name="co_sidemenu" id="co_sidemenu_3" class="magic-radio mod_send" value="right" <?php if (isset($rb_core['sidemenu']) && $rb_core['sidemenu'] == "right") { ?>checked<?php } ?>><label for="co_sidemenu_3">우측</label>
                                </li>

                                <div class="cb"></div>
                            </ul>

                            <ul class="rows_inp_lr mt-5 js-sidemenu-dep">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">모바일 버전</span><br>
                                    숨김설정
                                </li>

                                <li class="rows_inp_r mt-3">
                                    <input type="checkbox" name="co_sidemenu_hide" id="co_sidemenu_hide" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_core['sidemenu_hide']) && $rb_core['sidemenu_hide'] == 1) { ?>checked<?php } ?>>
                                    <label for="co_sidemenu_hide">숨김처리 (모바일 전용)</label>
                                </li>
                                <div class="cb"></div>
                            </ul>

                            <ul class="rows_inp_lr mt-10 js-sidemenu-dep">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">가로 크기</span><br>
                                    200~500px
                                </li>


                                <li class="rows_inp_r mt-15">
                                    <div id="co_sidemenu_width_range" class="rb_range_item"></div>
                                    <input type="hidden" name="co_sidemenu_width" id="co_sidemenu_width" class="co_range_send" value="<?php echo !empty($rb_core['sidemenu_width']) ? $rb_core['sidemenu_width'] : '200'; ?>">
                                </li>

                                <script type="text/javascript">
                                    $("#co_sidemenu_width_range").slider({
                                        range: "min",
                                        min: 200,
                                        max: 500,
                                        value: <?php echo !empty($rb_core['sidemenu_width']) ? $rb_core['sidemenu_width'] : '200'; ?>,
                                        step: 10,
                                        slide: function(e, ui) {
                                            $("#co_sidemenu_width_range .ui-slider-handle").html(ui.value);
                                            $("#co_sidemenu_width").val(ui.value); // hidden input에 값 업데이트

                                            //executeAjax();

                                            // 가로사이즈 반영
                                            $('#rb_sidemenu').css('width', ui.value);
                                            $('#rb_sidemenu_float').css('width', 'calc(100% - ' + ui.value + 'px)');
                                        }
                                    });

                                    $("#co_sidemenu_width_range .ui-slider-handle").html("<?php echo !empty($rb_core['sidemenu_width']) ? $rb_core['sidemenu_width'] : '200'; ?>");
                                    $("#co_sidemenu_width").val("<?php echo !empty($rb_core['sidemenu_width']) ? $rb_core['sidemenu_width'] : '200'; ?>"); // 초기값 설정
                                </script>


                                </li>
                                <div class="cb"></div>
                            </ul>


                            <ul class="rows_inp_lr mt-10 js-sidemenu-dep">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">여백</span><br>
                                    0~30px
                                </li>
                                <li class="rows_inp_r mt-15">
                                    <div id="co_sidemenu_padding_range" class="rb_range_item"></div>
                                    <input type="hidden" id="co_sidemenu_padding" class="co_range_send" name="co_sidemenu_padding" value="<?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>">
                                </li>

                                <script type="text/javascript">
                                    $("#co_sidemenu_padding_range").slider({
                                        range: "min",
                                        min: 0,
                                        max: 70,
                                        value: <?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>,
                                        step: 1,
                                        slide: function(e, ui) {
                                            $("#co_sidemenu_padding_range .ui-slider-handle").html(ui.value);
                                            $("#co_sidemenu_padding").val(ui.value); // hidden input에 값 업데이트

                                            //executeAjax();

                                            var co_sidemenu = $('input[name="co_sidemenu"]:checked').val();

                                            if (co_sidemenu == 'left') {
                                                $('#rb_sidemenu').css('padding-right', ui.value);
                                            } else if (co_sidemenu == 'right') {
                                                $('#rb_sidemenu').css('padding-left', ui.value);
                                            }

                                        }
                                    });

                                    $("#co_sidemenu_padding_range .ui-slider-handle").html("<?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>");
                                    $("#co_sidemenu_padding").val("<?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>"); // 초기값 설정
                                </script>
                                <div class="cb"></div>
                            </ul>


                            <script>
                                // 테두리 의존 섹션 토글
                                function rb_togglesidemenuDeps() {
                                    var v = $('input[name="co_sidemenu"]:checked').val() || '';
                                    if (v === '') {
                                        // 없음 → 숨김
                                        $('.js-sidemenu-dep').css('display', 'none');
                                    } else {
                                        // 실선/점선 등 → 표시
                                        $('.js-sidemenu-dep').css('display', '');
                                    }
                                }

                                // 페이지 로드 시 & 라디오 변경 시 반영
                                $(function() {
                                    rb_togglesidemenuDeps();
                                    $(document).on('change', 'input[name="co_sidemenu"]', rb_togglesidemenuDeps);
                                });
                            </script>


                        </div>

                    </ul>


                    <ul class="rb_config_sec">

                        <h6 class="font-B">서브 사이드 영역 노출 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            서브 사이드 영역을 현재페이지(노드) 에서 숨길 수 있습니다.<br>
                            서브 사이드 영역 설정 여부와 무관하게 우선적용 됩니다.
                        </h6>

                        <div class="font-12 rb_sub_page_cr">
                            <?php
                        $inherit_node = rb_get_inherited_topvisual_node($rb_page_urls);

                        if ($inherit_node) {
                            $name = $inherit_node['v_name'] ?: $inherit_node['v_code'];
                            $url  = $inherit_node['v_url'] ?: '#';
                            echo "<div class='mb-15'><a href=\"{$url}\"><span class='main_rb_bg'>상속 노드 : {$name}</span></a></div>";
                        }

                        ?>
                            <span>현재 노드 : <?php echo cut_str($rb_page_urls, 40) ?></span>
                        </div>

                        <div>
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_r mt-5">
                                    <?php
                                    // SQL 인젝션 방지
                                    $rb_page_esc = sql_escape_string($rb_page_urls);
                                    $sidebar_hide_sql = "SELECT `s_code` FROM `rb_sidebar_hide` WHERE `s_code` = '{$rb_page_esc}'";
                                    $sidebar_hide = sql_fetch($sidebar_hide_sql);

                                    // 존재하면 미노출(1), 없으면 노출(0)
                                    $sidebar_hidden = $sidebar_hide ? 1 : 0;
                                    ?>
                                    <input type="hidden" name="s_code" id="s_code" value="<?php echo $rb_page_urls; ?>">

                                    <input type="radio" name="s_use" id="s_use_0" class="magic-radio" value="0" <?php echo ($sidebar_hidden == 0 ? 'checked' : ''); ?>>
                                    <label for="s_use_0">노출</label>

                                    <input type="radio" name="s_use" id="s_use_1" class="magic-radio" value="1" <?php echo ($sidebar_hidden == 1 ? 'checked' : ''); ?>>
                                    <label for="s_use_1">미노출</label>
                                </li>

                                <div class="cb"></div>
                            </ul>
                        </div>

                    </ul>


                    <ul class="rb_config_sec">

                        <h6 class="font-B">서브 상단 비주얼 영역 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            각 페이지에서 설정할 수 있으며, 현재 노드를 기준으로 저장 됩니다.
                            마켓에는 <span class="font-B">하위적용</span> 옵션을 사용할 수 있으며, 현재 노드의 하위 노드를 <span class="font-B">사용</span>으로 일괄 설정하고, 설정을 복제적용 할 수 있습니다.
                        </h6>

                        <div class="font-12 rb_sub_page_cr">
                            <?php
                        $inherit_node = rb_get_inherited_topvisual_node($rb_page_urls);

                        if ($inherit_node) {
                            $name = $inherit_node['v_name'] ?: $inherit_node['v_code'];
                            $url = $inherit_node['v_url'] ?: '#';
                            echo "<div class='mb-15'><a href=\"{$url}\"><span class='main_rb_bg'>상속 노드 : {$name}</span></a></div>";
                        } else {
                            echo "";
                        }

                        ?>


                            <span>현재 노드 : <?php echo cut_str($rb_page_urls, 40) ?></span>
                        </div>

                        <div>
                            <ul class="rows_inp_lr mt-10">

                                <li class="rows_inp_r mt-5">
                                    <input type="hidden" name="v_code" id="v_code" value="<?php echo $rb_page_urls ?>">

                                    <input type="radio" name="v_use" id="v_use_0" class="magic-radio" value="0" <?php if (!isset($rb_v_info['v_use']) || intval($rb_v_info['v_use']) === 0) { ?>checked<?php } ?>>
                                    <label for="v_use_0">없음</label>

                                    <input type="radio" name="v_use" id="v_use_1" class="magic-radio" value="1" <?php if (isset($rb_v_info['v_use']) && intval($rb_v_info['v_use']) === 1) { ?>checked<?php } ?>>
                                    <label for="v_use_1">사용</label>

                                    <?php if(isset($cate_id) && $cate_id) { // 영카트?>
                                    <input type="radio" name="v_use" id="v_use_2" class="magic-radio" value="2" <?php if (isset($rb_v_info['v_use']) && intval($rb_v_info['v_use']) === 2) { ?>checked<?php } ?>>
                                    <label for="v_use_2">하위적용</label>
                                    <?php } ?>

                                </li>

                                <div class="cb"></div>
                            </ul>
                        </div>

                        <script>
                            function toggleTopVisualBox() {
                                const useVal = $('input[name="v_use"]:checked').val();
                                if (useVal === '1') {
                                    $('#rb_top_vis_wrap').show();
                                    $('#co_topvisual_style_all').prop('checked', false);
                                    $('#topvisual_style_all_wrap').hide();
                                } else if (useVal === '2') {
                                    $('#rb_top_vis_wrap').show();
                                    $('#topvisual_style_all_wrap').show();
                                } else {
                                    $('#rb_top_vis_wrap').hide();
                                    $('#co_topvisual_style_all').prop('checked', false);
                                    $('#topvisual_style_all_wrap').hide();
                                }
                            }


                            $(document).ready(function() {
                                // 페이지 로드시 적용
                                toggleTopVisualBox();

                                // v_use 라디오 변경 시 AJAX + 표시제어
                                $(document).on('change', 'input[name="v_use"]', function() {
                                    const v_use = $(this).val();
                                    const v_code = $('#v_code').val();
                                    const fullUrl = window.location.pathname + window.location.search;

                                    $.ajax({
                                        url: '<?php echo G5_URL ?>/rb/rb.config/ajax.topvisual_add.php',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            v_code: v_code,
                                            v_use: v_use,
                                            v_url: fullUrl
                                        },
                                        success: function(data) {
                                            if (data.status === 'ok') {
                                                toggleTopVisualBox(); // AJAX 성공 후 표시 여부 적용

                                                if (data.v_use == "1" || data.v_use == "2") {
                                                    $('#rb_topvisual').css('display', 'block');
                                                    $('#topvisual_btn_wrap').css('display', 'block');
                                                } else {
                                                    $('#rb_topvisual').css('display', 'none');
                                                    $('#topvisual_btn_wrap').css('display', 'none');
                                                }

                                            } else {
                                                alert('오류 발생: ' + (data.message || '알 수 없는 오류'));
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            alert('서버 오류 발생: ' + error);
                                            console.error(xhr.responseText);
                                        }
                                    });
                                });
                            });
                        </script>


                        <div class="config_wrap" id="rb_top_vis_wrap" style="display:none;">
                            <input type="hidden" name="co_topvisual" id="co_topvisual_4" value="imgtxt">

                            <div class="config_wrap_bg" id="topvisual_style_all_wrap" style="display:none;">
                                <li class="">
                                    <input type="checkbox" name="co_topvisual_style_all" id="co_topvisual_style_all" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_v_info['topvisual_style_all']) && $rb_v_info['topvisual_style_all'] == 1) { ?>checked<?php } ?>>
                                    <label for="co_topvisual_style_all">하위노드 동일 설정 적용</label>
                                </li>
                                <h6 class="font-R rb_config_sub_txt">
                                    하위 노드에 동일한 스타일을 적용 합니다.<br>
                                    상속 노드에 스타일이 변경되면 동시 적용 됩니다.<br>
                                    워딩과 이미지도 적용 됩니다.
                                </h6>
                            </div>

                            <div class="config_wrap_bg mt-10">
                                <label class="config_wrap_sub_tit">영역 스타일</label><br>

                                <ul class="rows_inp_lr mt-15">
                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">배경 컬러</span><br>
                                        컬러선택
                                    </li>

                                    <li class="rows_inp_r mt-3">
                                        <div class="color_set_wrap square none_inp_cl tiny_inp_cl" style="position: relative;">
                                            <input type="text" class="coloris mod_co_color" name="co_topvisual_bg_color" value="<?php echo !empty($rb_v_info['topvisual_bg_color']) ? $rb_v_info['topvisual_bg_color'] : '#f9f9f9'; ?>" style="width:200px !important;">
                                        </div>
                                    </li>
                                    <div class="cb"></div>
                                </ul>

                                <ul class="rows_inp_lr mt-5">
                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">가로 크기</span><br>
                                        자동/채우기
                                    </li>

                                    <li class="rows_inp_r mt-3">
                                        <input type="checkbox" name="co_topvisual_width" id="co_topvisual_width" class="magic-checkbox mod_send" value="100" <?php if(isset($rb_v_info['topvisual_width']) && $rb_v_info['topvisual_width'] == 100) { ?>checked<?php } ?>>
                                        <label for="co_topvisual_width">100% 채우기</label>
                                    </li>
                                    <div class="cb"></div>
                                </ul>

                                <ul class="rows_inp_lr mt-5">

                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">테두리</span><br>
                                        영역 테두리
                                    </li>

                                    <li class="rows_inp_r mt-5 font-12">
                                        <input type="radio" name="co_topvisual_border" id="co_topvisual_border_0" class="magic-radio mod_send" value="0" <?php if (isset($rb_v_info['topvisual_border']) && $rb_v_info['topvisual_border'] == "0") { ?>checked<?php } ?>><label for="co_topvisual_border_0">없음</label>
                                        <input type="radio" name="co_topvisual_border" id="co_topvisual_border_1" class="magic-radio mod_send" value="1" <?php if (isset($rb_v_info['topvisual_border']) && $rb_v_info['topvisual_border'] == "1") { ?>checked<?php } ?>><label for="co_topvisual_border_1">점선</label>
                                        <input type="radio" name="co_topvisual_border" id="co_topvisual_border_2" class="magic-radio mod_send" value="2" <?php if (isset($rb_v_info['topvisual_border']) && $rb_v_info['topvisual_border'] == "2") { ?>checked<?php } ?>><label for="co_topvisual_border_2">실선</label>
                                    </li>

                                    <div class="cb"></div>

                                </ul>


                                <ul class="rows_inp_lr mt-5">
                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">상단여백</span><br>
                                        0~100px
                                    </li>

                                    <li class="rows_inp_r mt-15">
                                        <div id="co_topvisual_mt_range" class="rb_range_item"></div>
                                        <input type="hidden" name="co_topvisual_mt" id="co_topvisual_mt" class="co_range_send" value="<?php echo !empty($rb_v_info['topvisual_mt']) ? $rb_v_info['topvisual_mt'] : '0'; ?>">
                                    </li>

                                    <script type="text/javascript">
                                        $("#co_topvisual_mt_range").slider({
                                            range: "min",
                                            min: 0,
                                            max: 100,
                                            value: <?php echo !empty($rb_v_info['topvisual_mt']) ? $rb_v_info['topvisual_mt'] : '0'; ?>,
                                            step: 5,
                                            slide: function(e, ui) {
                                                $("#co_topvisual_mt_range .ui-slider-handle").html(ui.value);
                                                $("#co_topvisual_mt").val(ui.value); // hidden input에 값 업데이트

                                                //executeAjax();

                                                // 세로사이즈 반영
                                                $('#rb_topvisual').css('margin-top', ui.value);

                                            }
                                        });

                                        $("#co_topvisual_mt_range .ui-slider-handle").html("<?php echo !empty($rb_v_info['topvisual_mt']) ? $rb_v_info['topvisual_mt'] : '0'; ?>");
                                        $("#co_topvisual_mt").val("<?php echo !empty($rb_v_info['topvisual_mt']) ? $rb_v_info['topvisual_mt'] : '0'; ?>"); // 초기값 설정
                                    </script>


                                    </li>
                                    <div class="cb"></div>
                                </ul>






                                <ul class="rows_inp_lr mt-5">
                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">세로 크기</span><br>
                                        50~500px
                                    </li>

                                    <li class="rows_inp_r mt-15">
                                        <div id="co_topvisual_height_range" class="rb_range_item"></div>
                                        <input type="hidden" name="co_topvisual_height" id="co_topvisual_height" class="co_range_send" value="<?php echo !empty($rb_v_info['topvisual_height']) ? $rb_v_info['topvisual_height'] : '200'; ?>">
                                    </li>

                                    <script type="text/javascript">
                                        $("#co_topvisual_height_range").slider({
                                            range: "min",
                                            min: 50,
                                            max: 500,
                                            value: <?php echo !empty($rb_v_info['topvisual_height']) ? $rb_v_info['topvisual_height'] : '200'; ?>,
                                            step: 5,
                                            slide: function(e, ui) {
                                                $("#co_topvisual_height_range .ui-slider-handle").html(ui.value);
                                                $("#co_topvisual_height").val(ui.value); // hidden input에 값 업데이트

                                                //executeAjax();

                                                // 세로사이즈 반영
                                                $('#rb_topvisual').css('height', ui.value);

                                            }
                                        });

                                        $("#co_topvisual_height_range .ui-slider-handle").html("<?php echo !empty($rb_v_info['topvisual_height']) ? $rb_v_info['topvisual_height'] : '200'; ?>");
                                        $("#co_topvisual_height").val("<?php echo !empty($rb_v_info['topvisual_height']) ? $rb_v_info['topvisual_height'] : '200'; ?>"); // 초기값 설정
                                    </script>


                                    </li>
                                    <div class="cb"></div>
                                </ul>


                                <ul class="rows_inp_lr mt-5">
                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">밝기</span><br>
                                        0~100%
                                    </li>

                                    <li class="rows_inp_r mt-15">
                                        <div id="co_topvisual_bl_range" class="rb_range_item"></div>
                                        <input type="hidden" name="co_topvisual_bl" id="co_topvisual_bl" class="co_range_send" value="<?php echo isset($rb_v_info['topvisual_bl']) ? $rb_v_info['topvisual_bl'] : '10'; ?>">
                                    </li>

                                    <script type="text/javascript">
                                        $("#co_topvisual_bl_range").slider({
                                            range: "min",
                                            min: 0,
                                            max: 100,
                                            value: <?php echo isset($rb_v_info['topvisual_bl']) ? $rb_v_info['topvisual_bl'] : '10'; ?>,
                                            step: 1,
                                            slide: function(e, ui) {
                                                $("#co_topvisual_bl_range .ui-slider-handle").html(ui.value);
                                                $("#co_topvisual_bl").val(ui.value); // hidden input에 값 업데이트

                                                //executeAjax();

                                                // 블라인드 반영
                                                $('#rb_topvisual_bl').css('background-color', 'rgba(0,0,0,' + (ui.value / 100) + ')')

                                            }
                                        });

                                        $("#co_topvisual_bl_range .ui-slider-handle").html("<?php echo isset($rb_v_info['topvisual_bl']) ? $rb_v_info['topvisual_bl'] : '10'; ?>");
                                        $("#co_topvisual_bl").val("<?php echo isset($rb_v_info['topvisual_bl']) ? $rb_v_info['topvisual_bl'] : '10'; ?>"); // 초기값 설정
                                    </script>


                                    </li>
                                    <div class="cb"></div>
                                </ul>


                                <ul class="rows_inp_lr mt-5">
                                    <li class="rows_inp_l rows_inp_l_span">
                                        <span class="font-B">라운드</span><br>
                                        0~100
                                    </li>

                                    <li class="rows_inp_r mt-15">
                                        <div id="co_topvisual_radius_range" class="rb_range_item"></div>
                                        <input type="hidden" name="co_topvisual_radius" id="co_topvisual_radius" class="co_range_send" value="<?php echo isset($rb_v_info['topvisual_radius']) ? $rb_v_info['topvisual_radius'] : '0'; ?>">
                                    </li>

                                    <script type="text/javascript">
                                        $("#co_topvisual_radius_range").slider({
                                            range: "min",
                                            min: 0,
                                            max: 100,
                                            value: <?php echo isset($rb_v_info['topvisual_radius']) ? $rb_v_info['topvisual_radius'] : '0'; ?>,
                                            step: 1,
                                            slide: function(e, ui) {
                                                $("#co_topvisual_radius_range .ui-slider-handle").html(ui.value);
                                                $("#co_topvisual_radius").val(ui.value); // hidden input에 값 업데이트

                                                //executeAjax();

                                                // 반영
                                                $('#rb_topvisual').css('border-radius', ui.value);
                                                $('#rb_topvisual_bl').css('border-radius', ui.value);

                                            }
                                        });

                                        $("#co_topvisual_radius_range .ui-slider-handle").html("<?php echo isset($rb_v_info['topvisual_radius']) ? $rb_v_info['topvisual_radius'] : '0'; ?>");
                                        $("#co_topvisual_radius").val("<?php echo isset($rb_v_info['topvisual_radius']) ? $rb_v_info['topvisual_radius'] : '0'; ?>"); // 초기값 설정
                                    </script>


                                    </li>
                                    <div class="cb"></div>
                                </ul>







                            </div>

                            <div class="skin_path_url mt-5">
                                <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                <li class="skin_path_url_txt">
                                    /data/topvisual/<?php echo $rb_page_urls ?>.jpg
                                </li>
                                <div class="cb"></div>
                            </div>


                            <div class="config_wrap_bg">
                                <label class="config_wrap_sub_tit">메인워딩 스타일</label><br>
                                <ul class="config_wrap_flex mt-15">

                                    <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                                        <input type="text" class="coloris mod_co_color" name="co_topvisual_m_color" value="<?php echo !empty($rb_v_info['topvisual_m_color']) ? $rb_v_info['topvisual_m_color'] : '#ffffff'; ?>" style="width:25px !important;">
                                    </div>컬러


                                    <select class="select select_tiny mod_send" name="co_topvisual_m_size" id="co_topvisual_m_size">
                                        <option value="">사이즈</option>
                                        <option value="12" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "12") { ?>selected<?php } ?>>12px</option>
                                        <option value="14" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "14") { ?>selected<?php } ?>>14px</option>
                                        <option value="16" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "16") { ?>selected<?php } ?>>16px</option>
                                        <option value="18" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "18") { ?>selected<?php } ?>>18px</option>
                                        <option value="20" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "20") { ?>selected<?php } ?>>20px</option>
                                        <option value="22" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "22") { ?>selected<?php } ?>>22px</option>
                                        <option value="24" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "24") { ?>selected<?php } ?>>24px</option>
                                        <option value="26" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "26") { ?>selected<?php } ?>>26px</option>
                                        <option value="28" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "28") { ?>selected<?php } ?>>28px</option>
                                        <option value="30" <?php if (isset($rb_v_info['topvisual_m_size']) && $rb_v_info['topvisual_m_size'] == "30") { ?>selected<?php } ?>>30px</option>
                                    </select>

                                    <select class="select select_tiny mod_send" name="co_topvisual_m_font" id="co_topvisual_m_font">
                                        <option value="">스타일</option>
                                        <option value="font-R" <?php if (isset($rb_v_info['topvisual_m_font']) && $rb_v_info['topvisual_m_font'] == "font-R") { ?>selected<?php } ?>>Regular</option>
                                        <option value="font-B" <?php if (isset($rb_v_info['topvisual_m_font']) && $rb_v_info['topvisual_m_font'] == "font-B") { ?>selected<?php } ?>>Bold</option>
                                        <option value="font-H" <?php if (isset($rb_v_info['topvisual_m_font']) && $rb_v_info['topvisual_m_font'] == "font-H") { ?>selected<?php } ?>>Heavy</option>
                                    </select>

                                </ul>


                                <ul class="config_wrap_flex">
                                    <li class="rows_inp_r mt-5">
                                        <input type="radio" name="co_topvisual_m_align" id="co_topvisual_m_align1" class="magic-radio mod_send" value="left" <?php if (isset($rb_v_info['topvisual_m_align']) && $rb_v_info['topvisual_m_align'] == "left") { ?>checked<?php } ?>><label for="co_topvisual_m_align1">좌측</label>
                                        <input type="radio" name="co_topvisual_m_align" id="co_topvisual_m_align2" class="magic-radio mod_send" value="center" <?php if (isset($rb_v_info['topvisual_m_align']) && $rb_v_info['topvisual_m_align'] == "center") { ?>checked<?php } ?>><label for="co_topvisual_m_align2">중앙</label>
                                        <input type="radio" name="co_topvisual_m_align" id="co_topvisual_m_align3" class="magic-radio mod_send" value="right" <?php if (isset($rb_v_info['topvisual_m_align']) && $rb_v_info['topvisual_m_align'] == "right") { ?>checked<?php } ?>><label for="co_topvisual_m_align3">우측</label>
                                    </li>
                                </ul>

                            </div>

                            <div class="skin_path_url mt-5">
                                <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                <li class="skin_path_url_txt">
                                    /data/topvisual/<?php echo $rb_page_urls ?>.txt
                                </li>
                                <div class="cb"></div>
                            </div>




                            <div class="config_wrap_bg">
                                <label class="config_wrap_sub_tit">서브워딩 스타일</label><br>
                                <ul class="config_wrap_flex mt-15">

                                    <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                                        <input type="text" class="coloris mod_co_color" name="co_topvisual_s_color" value="<?php echo !empty($rb_v_info['topvisual_s_color']) ? $rb_v_info['topvisual_s_color'] : '#ffffff'; ?>" style="width:25px !important;">
                                    </div>컬러

                                    <select class="select select_tiny mod_send" name="co_topvisual_s_size" id="co_topvisual_s_size">
                                        <option value="">사이즈</option>
                                        <option value="12" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "12") { ?>selected<?php } ?>>12px</option>
                                        <option value="14" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "14") { ?>selected<?php } ?>>14px</option>
                                        <option value="16" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "16") { ?>selected<?php } ?>>16px</option>
                                        <option value="18" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "18") { ?>selected<?php } ?>>18px</option>
                                        <option value="20" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "20") { ?>selected<?php } ?>>20px</option>
                                        <option value="22" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "22") { ?>selected<?php } ?>>22px</option>
                                        <option value="24" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "24") { ?>selected<?php } ?>>24px</option>
                                        <option value="26" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "26") { ?>selected<?php } ?>>26px</option>
                                        <option value="28" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "28") { ?>selected<?php } ?>>28px</option>
                                        <option value="30" <?php if (isset($rb_v_info['topvisual_s_size']) && $rb_v_info['topvisual_s_size'] == "30") { ?>selected<?php } ?>>30px</option>
                                    </select>

                                    <select class="select select_tiny mod_send" name="co_topvisual_s_font" id="co_topvisual_s_font">
                                        <option value="">스타일</option>
                                        <option value="font-R" <?php if (isset($rb_v_info['topvisual_s_font']) && $rb_v_info['topvisual_s_font'] == "font-R") { ?>selected<?php } ?>>Regular</option>
                                        <option value="font-B" <?php if (isset($rb_v_info['topvisual_s_font']) && $rb_v_info['topvisual_s_font'] == "font-B") { ?>selected<?php } ?>>Bold</option>
                                        <option value="font-H" <?php if (isset($rb_v_info['topvisual_s_font']) && $rb_v_info['topvisual_s_font'] == "font-H") { ?>selected<?php } ?>>Heavy</option>
                                    </select>

                                </ul>


                                <ul class="config_wrap_flex">
                                    <li class="rows_inp_r mt-5">
                                        <input type="radio" name="co_topvisual_s_align" id="co_topvisual_s_align1" class="magic-radio mod_send" value="left" <?php if (isset($rb_v_info['topvisual_s_align']) && $rb_v_info['topvisual_s_align'] == "left") { ?>checked<?php } ?>><label for="co_topvisual_s_align1">좌측</label>
                                        <input type="radio" name="co_topvisual_s_align" id="co_topvisual_s_align2" class="magic-radio mod_send" value="center" <?php if (isset($rb_v_info['topvisual_s_align']) && $rb_v_info['topvisual_s_align'] == "center") { ?>checked<?php } ?>><label for="co_topvisual_s_align2">중앙</label>
                                        <input type="radio" name="co_topvisual_s_align" id="co_topvisual_s_align3" class="magic-radio mod_send" value="right" <?php if (isset($rb_v_info['topvisual_s_align']) && $rb_v_info['topvisual_s_align'] == "right") { ?>checked<?php } ?>><label for="co_topvisual_s_align3">우측</label>
                                    </li>
                                </ul>

                            </div>

                            <div class="skin_path_url mt-5">
                                <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                <li class="skin_path_url_txt">
                                    /data/topvisual/<?php echo $rb_page_urls ?>.txt
                                </li>
                                <div class="cb"></div>
                            </div>

                            <button type="button" id="clear_top_btn" class="font-R">상단영역 전체 초기화</button>
                            <script>
                                document.getElementById('clear_top_btn').addEventListener('click', function() {


                                    rb_confirm("현재 설정된 서브 상단영역을 모두 초기화 합니다.\n입력된 내용 및 설정값이 모두 삭제 됩니다.\n\n계속 하시겠습니까?").then(function(confirmed) {
                                        if (confirmed) {
                                            fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.clear_topvisual.php', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/x-www-form-urlencoded'
                                                    },
                                                    body: 'act=top_clear'
                                                })
                                                .then(res => res.text())
                                                .then(res => {
                                                    if (res.trim() === 'ok') {
                                                        //alert('초기화 완료 되었습니다.');
                                                        location.reload();
                                                    } else {
                                                        alert('초기화 실패: ' + res);
                                                    }
                                                })
                                                .catch(err => {
                                                    alert('에러 발생: ' + err);
                                                });
                                        } else {
                                            // 취소 시 실행 코드
                                        }
                                    });

                                });
                            </script>


                        </div>


                    </ul>
                    <?php } ?>






                    <ul class="rb_config_sec">
                        <h6 class="font-B">가로폭 설정 (공용)</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            상단/하단, 메인 및 서브 컨텐츠 영역의 가로폭을 설정해주세요.<br>
                            설정이 없는 경우 1400px 으로 고정 됩니다.
                        </h6>
                        <div class="config_wrap">
                            <ul>

                                <select class="select w30 mod_send" name="co_tb_width">
                                    <option value="">상단/하단</option>
                                    <option value="100" <?php if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "100") { ?>selected<?php } ?>>100%</option>
                                    <option value="1400" <?php if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "1400") { ?>selected<?php } ?>>1400px</option>
                                    <option value="1280" <?php if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "1280") { ?>selected<?php } ?>>1280px</option>
                                    <option value="1024" <?php if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "1024") { ?>selected<?php } ?>>1024px</option>
                                    <option value="960" <?php if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "960") { ?>selected<?php } ?>>960px</option>
                                    <option value="750" <?php if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "750") { ?>selected<?php } ?>>750px</option>
                                </select>

                                <select class="select w30 mod_send" name="co_main_width">
                                    <option value="">메인</option>
                                    <!--
                                    <option value="100" <?php if(isset($rb_core['main_width']) && $rb_core['main_width'] == "100") { ?>selected<?php } ?>>100%</option>
                                    -->
                                    <option value="1400" <?php if(isset($rb_core['main_width']) && $rb_core['main_width'] == "1400") { ?>selected<?php } ?>>1400px</option>
                                    <option value="1280" <?php if(isset($rb_core['main_width']) && $rb_core['main_width'] == "1280") { ?>selected<?php } ?>>1280px</option>
                                    <option value="1024" <?php if(isset($rb_core['main_width']) && $rb_core['main_width'] == "1024") { ?>selected<?php } ?>>1024px</option>
                                    <option value="960" <?php if(isset($rb_core['main_width']) && $rb_core['main_width'] == "960") { ?>selected<?php } ?>>960px</option>
                                    <option value="750" <?php if(isset($rb_core['main_width']) && $rb_core['main_width'] == "750") { ?>selected<?php } ?>>750px</option>
                                </select>

                                <select class="select w30 mod_send" name="co_sub_width">
                                    <option value="">서브</option>
                                    <!--
                                    <option value="100" <?php if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "100") { ?>selected<?php } ?>>100%</option>
                                    -->
                                    <option value="1400" <?php if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "1400") { ?>selected<?php } ?>>1400px</option>
                                    <option value="1280" <?php if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "1280") { ?>selected<?php } ?>>1280px</option>
                                    <option value="1024" <?php if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "1024") { ?>selected<?php } ?>>1024px</option>
                                    <option value="960" <?php if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "960") { ?>selected<?php } ?>>960px</option>
                                    <option value="750" <?php if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "750") { ?>selected<?php } ?>>750px</option>
                                </select>


                            </ul>
                        </div>
                    </ul>


                    <ul class="rb_config_sec">
                        <h6 class="font-B"><?php if(defined('_SHOP_')) { // 영카트?>마켓 <?php } ?>여백 설정 (PC)</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            PC버전 상/하단 여백을 설정할 수 있습니다.<br>
                            0을 입력하시는 경우 여백이 제거 됩니다. (설정값-모듈간격)<br>
                            값이 없으면 기본값이 들어갑니다.
                        </h6>
                        <div class="config_wrap">

                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">상단 여백</span><br>
                                    padding-top
                                </li>
                                <li class="rows_inp_r mt-5">
                                    <?php if(defined('_SHOP_')) { // 영카트?>
                                    <input type="number" id="co_padding_top_shop" class="tiny_input w25 ml-0" name="co_padding_top_shop" placeholder="메인" value="<?php echo isset($rb_core['padding_top_shop']) ? $rb_core['padding_top_shop'] : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="co_padding_top_sub_shop" class="tiny_input w25 ml-0" name="co_padding_top_sub_shop" placeholder="서브" value="<?php echo isset($rb_core['padding_top_sub_shop']) ? $rb_core['padding_top_sub_shop'] : ''; ?>"> <span class="font-12">px</span>
                                    <input type="hidden" id="co_padding_top" name="co_padding_top" value="<?php echo isset($rb_core['padding_top']) ? $rb_core['padding_top'] : ''; ?>">
                                    <input type="hidden" id="co_padding_top_sub" name="co_padding_top_sub" value="<?php echo isset($rb_core['padding_top_sub']) ? $rb_core['padding_top_sub'] : ''; ?>">
                                    <?php } else { ?>
                                    <input type="number" id="co_padding_top" class="tiny_input w25 ml-0" name="co_padding_top" placeholder="메인" value="<?php echo isset($rb_core['padding_top']) ? $rb_core['padding_top'] : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="co_padding_top_sub" class="tiny_input w25 ml-0" name="co_padding_top_sub" placeholder="서브" value="<?php echo isset($rb_core['padding_top_sub']) ? $rb_core['padding_top_sub'] : ''; ?>"> <span class="font-12">px</span>
                                    <input type="hidden" id="co_padding_top_shop" name="co_padding_top_shop" value="<?php echo isset($rb_core['padding_top_shop']) ? $rb_core['padding_top_shop'] : ''; ?>">
                                    <input type="hidden" id="co_padding_top_sub_shop" name="co_padding_top_sub_shop" value="<?php echo isset($rb_core['padding_top_sub_shop']) ? $rb_core['padding_top_sub_shop'] : ''; ?>">
                                    <?php } ?>
                                </li>

                                <div class="cb"></div>
                            </ul>

                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">하단 여백</span><br>
                                    padding-bottom
                                </li>
                                <li class="rows_inp_r mt-5">
                                    <?php if(defined('_SHOP_')) { // 영카트?>
                                    <input type="number" id="co_padding_btm_shop" class="tiny_input w25 ml-0" name="co_padding_btm_shop" placeholder="메인" value="<?php echo isset($rb_core['padding_btm_shop']) ? $rb_core['padding_btm_shop'] : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="co_padding_btm_sub_shop" class="tiny_input w25 ml-0" name="co_padding_btm_sub_shop" placeholder="서브" value="<?php echo isset($rb_core['padding_btm_sub_shop']) ? $rb_core['padding_btm_sub_shop'] : ''; ?>"> <span class="font-12">px</span>
                                    <input type="hidden" id="co_padding_btm" name="co_padding_btm" value="<?php echo isset($rb_core['padding_btm']) ? $rb_core['padding_btm'] : ''; ?>">
                                    <input type="hidden" id="co_padding_btm_sub" name="co_padding_btm_sub" value="<?php echo isset($rb_core['padding_btm_sub']) ? $rb_core['padding_btm_sub'] : ''; ?>">
                                    <?php } else { ?>
                                    <input type="number" id="co_padding_btm" class="tiny_input w25 ml-0" name="co_padding_btm" placeholder="메인" value="<?php echo isset($rb_core['padding_btm']) ? $rb_core['padding_btm'] : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="co_padding_btm_sub" class="tiny_input w25 ml-0" name="co_padding_btm_sub" placeholder="서브" value="<?php echo isset($rb_core['padding_btm_sub']) ? $rb_core['padding_btm_sub'] : ''; ?>"> <span class="font-12">px</span>
                                    <input type="hidden" id="co_padding_btm_shop" name="co_padding_btm_shop" value="<?php echo isset($rb_core['padding_btm_shop']) ? $rb_core['padding_btm_shop'] : ''; ?>">
                                    <input type="hidden" id="co_padding_btm_sub_shop" name="co_padding_btm_sub_shop" value="<?php echo isset($rb_core['padding_btm_sub_shop']) ? $rb_core['padding_btm_sub_shop'] : ''; ?>">
                                    <?php } ?>
                                </li>

                                <div class="cb"></div>
                            </ul>

                        </div>
                    </ul>




                    <ul class="rb_config_sec">
                        <h6 class="font-B">웹폰트 설정 (공용)</h6>
                        <h6 class="font-R rb_config_sub_txt">선택하신 폰트가 웹사이트 전체에 적용 됩니다.<br>웹폰트 세트를 자유롭게 추가할 수 있습니다.</h6>
                        <div class="config_wrap">
                            <ul>
                                <select class="select w100 mod_send" name="co_font">
                                    <option value="">웹폰트 선택</option>
                                    <?php echo rb_dir_select("rb.fonts", $rb_core['font']); ?>
                                </select>
                            </ul>

                            <?php if(isset($rb_core['font']) && $rb_core['font']) { ?>
                            <ul class="skin_path_url mt-5">
                                <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                                <li class="skin_path_url_txt">
                                    /theme/rb.basic/rb.fonts/<?php echo $rb_core['font'] ?>/
                                </li>
                                <div class="cb"></div>
                            </ul>
                            <?php } ?>

                        </div>
                    </ul>

                    <ul class="rb_config_sec">
                        <h6 class="font-B">사이트맵(xml)생성</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            버튼을 클릭하시면 루트에 sitemap.xml 파일이 생성 됩니다.<br>
                            생성 완료 시 사이트맵 다운로드 버튼이 활성화 되며,<br>
                            빌더설정 > SEO관리 robots.txt 에 자동으로 등록 됩니다.
                            <!--
                        만들어진 파일은 검색엔진에 제출할 수 있습니다.<br><br>
                        게시판, 게시물, 일반페이지, 상품분류, 상품이 대상이 됩니다.<br>
                        비밀글, 비공개상품 등은 포함되지 않습니다.<br><br>

                        우선순위 1.0 : 게시물 및 히트/추천/신/인기/할인 상품<br>
                        우선순위 0.9 : 나머지 상품<br>
                        우선순위 0.7 : 게시판, 상품분류<br>
                        우선순위 0.5 : 일반페이지<br><br>

                        Sitemap: <?php echo G5_URL ?>/sitemap.xml
                        -->

                        </h6>
                        <div class="config_wrap">

                            <ul>
                                <a id="sitemap_gen_btn" href="javascript:void(0);"><span id="sitemap_btn_text">사이트맵 생성</span></a>
                                <a id="sitemap_download_link" class="main_rb_bg" href="javascript:void(0);">사이트맵 다운로드</a>
                            </ul>


                            <script>
                                $('#sitemap_gen_btn').on('click', function() {
                                    var $btn = $(this);
                                    var $txt = $('#sitemap_btn_text');

                                    // "생성중..." 상태로 표시 (비활성화)
                                    $btn.prop('disabled', true);
                                    $txt.text('생성중..');

                                    // AJAX로 sitemap 생성
                                    $.post('<?php echo G5_URL ?>/rb/sitemap.php', {}, function(res) {
                                        if (res.success) {
                                            // 버튼 숨기고 다운로드 링크로 교체
                                            $btn.hide();

                                            $('#sitemap_download_link')
                                                .attr('href', res.url)
                                                .attr('download', 'sitemap.xml')
                                                .css('display', 'inline-block')
                                                .show()

                                        } else {
                                            $btn.prop('disabled', false);
                                            $txt.text('사이트맵 생성');
                                            alert('생성 실패: ' + res.msg);
                                        }
                                    }, 'json');
                                });
                            </script>

                        </div>
                    </ul>


                    <ul class="rb_config_sec">

                        <button type="button" class="main_rb_bg" id="clear_cache_btn">캐시 삭제</button>
                        <script>
                            document.getElementById('clear_cache_btn').addEventListener('click', function() {


                                rb_confirm("/data/cache/ 폴더의 모든 캐시파일이 제거되며,\n비로그인 접속시 메인 레이아웃 캐시가 재생성 됩니다.\n\n계속하시겠습니까?").then(function(confirmed) {
                                    if (confirmed) {
                                        fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.clear_cache.php', {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                },
                                                body: 'act=clear'
                                            })
                                            .then(res => res.text())
                                            .then(res => {
                                                if (res.trim() === 'ok') {
                                                    //alert('캐시 파일이 모두 삭제되었습니다.');
                                                    location.reload();
                                                } else {
                                                    alert('삭제 실패: ' + res);
                                                }
                                            })
                                            .catch(err => {
                                                alert('에러 발생: ' + err);
                                            });
                                    } else {
                                        // 취소 시 실행 코드
                                    }
                                });


                            });
                        </script>
                        <div class="cb"></div>
                        <button type="button" class="rb_config_reload mt-5 font-B" onclick="executeAjax()">적용하기</button>
                        <button type="button" class="rb_config_close mt-5 font-B" onclick="toggleSideOptions_close()">취소</button>
                        <div class="cb"></div>
                    </ul>


                </div>


            </div>
        </div>

    </div>


</div>


<div class="rb-sh-side-css">
    <div class="rb-sh-side-css-top-wrap">
        <ul class="rb-sh-side-css-top-tit font-B">CSS 라이브 커스텀<br><span class="font-R">선택된 영역의 CSS를 오버라이드 합니다.</span></ul>
        <ul class="rb-sh-side-css-top-btn">
            <button type="button" id="css_save_btn" class="main_rb_bg">저장</button>
            <button type="button" id="css_reset_btn">삭제</button>
            <button type="button" id="css_close_btn" onclick="edit_css_close();">닫기</button>
        </ul>
    </div>
    <div id="rb-css-fileinfo"></div>
    <div id="rb-css-editor" contenteditable="true" spellcheck="false" autocomplete="off" autocorrect="off" autocapitalize="off" data-gramm="false" data-gramm_editor="false" data-enable-grammarly="false" data-ms-editor="false" data-ginger="false">
    </div>
</div>


<div class="rb-sh-side-lib">
    <div class="rb-sh-side-lib-top-wrap">
        <ul class="rb-sh-side-lib-top-tit font-B">라이브러리<br><span class="font-R">저장된 모듈 목록 입니다.</span></ul>
        <ul class="rb-sh-side-lib-top-btn">
            <button type="button" id="lib_close_btn" onclick="lib_close();">
                <img src="https://demo.rebuilder.co.kr/rb/rb.config/image/icon_close.svg">
            </button>
        </ul>
    </div>
    <div id="rb-lib-list">

        <button type="button" class="rb_config_save_btn font-R main_rb_bg" onclick="saveAjax()" data-tooltip="우측 모듈설정 패널의 내용 그대로 저장되요" data-tooltip-pos="top">현재설정 저장</button>

        <div class="rb-lib-st-top mt-5">
            <select class="select select_tiny" id="rbLibTypeFilter">
                <option value="">출력타입 전체</option>
                <option value="latest">최신글(단일)</option>
                <option value="tab">최신글(탭)</option>
                <option value="widget">위젯</option>
                <option value="banner">배너</option>
                <option value="poll">투표</option>
                <?php if(defined('_SHOP_')) { // 영카트?>
                <option value="item">상품</option>
                <option value="item_tab">상품(탭)</option>
                <?php } ?>
            </select>
        </div>


        <div class="rb-lib-st-list"></div>
    </div>
</div>
</div>


<script type="text/javascript">
    Coloris({
        el: '.coloris'
    });
    Coloris.setInstance('.coloris', {
        parent: '.sh-side-demos-container', // 상위 container
        formatToggle: false, // Hex, RGB, HSL 토글버튼 활성
        format: 'hex', // 색상 포맷지정
        margin: 0, // margin
        swatchesOnly: false, // 색상 견본만 표시여부
        alpha: true, // 알파(투명) 활성여부
        theme: 'polaroid', // default, large, polaroid, pill
        themeMode: 'Light', // dark, Light
        focusInput: true, // 색상코드 Input에 포커스 여부
        selectInput: true, // 선택기가 열릴때 색상값을 select 여부
        autoClose: true, // 자동닫기 - 확인 안됨
        inline: false, // color picker를 인라인 위젯으로 사용시 true
        defaultColor: '#ffffff', // 기본 색상인 인라인 mode
        // Clear Button 설정
        clearButton: true,
        //clearLabel: '초기화',
        // Close Button 설정
        closeButton: true, // true, false
        closeLabel: '닫기', // 닫기버튼 텍스트
        swatches: [
            '#AA20FF',
            '#FFC700',
            '#00A3FF',
            '#8ED100',
            '#FF5A5A',
            '#25282B'
        ]
    });
</script>

<script type="text/javascript">
    Coloris({
        el: '.coloris2',
        swatches: [
            '#AA20FF',
            '#FFC700',
            '#00A3FF',
            '#8ED100',
            '#FF5A5A',
            '#25282B'
        ]
    });
</script>


<script type="text/javascript">
    // === 전역 모드 플래그: html에 부착 ===
    function rbSetMode(mode) { // 'mod' | 'sec' | null
        document.documentElement.classList.toggle('rb-mode-mod', mode === 'mod');
        document.documentElement.classList.toggle('rb-mode-sec', mode === 'sec');
    }

    function rbIsMod() {
        return document.documentElement.classList.contains('rb-mode-mod');
    }

    function rbIsSec() {
        return document.documentElement.classList.contains('rb-mode-sec');
    }


    $(document).ready(function() {
        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').hide();
        $('.rb_config_mod3').hide();
        $("#saveOrderButton").hide();
    });


    //모듈설정 토글

    function toggleSideOptions() {

        // PHP에서 관리자만 스타일 삽입!
        <?php if($is_admin) { ?>
        // 토글 ON(열기)할 때만 스타일 삽입
        if (!$('.rb_layout_box').hasClass('ui-sortable-handle')) {
            if (!document.getElementById('rb_layout_box_dynamic_style')) {
                var style = document.createElement('style');
                style.id = 'rb_layout_box_dynamic_style';
                style.innerHTML = `

                    .rb_layout_box .content_box.pc {display: block; opacity: 0.6;}
                    .rb_layout_box .content_box.mobile {display: block; opacity: 0.6;}
                    .rb_layout_box.pc {display: block; opacity: 1;}
                    .rb_layout_box.mobile {display: block; opacity: 1;}

                    .rb_layout_box .content_box.pc::after {
                        content: "PC 전용";
                        position: absolute;
                        top: 50%; left: 50%;
                        transform: translate(-50%, -50%);
                        background-color: #000;
                        padding: 5px 5px 5px 5px;
                        border-radius: 4px;
                        font-size: 10px;
                        color: #fff;
                        z-index: 96;
                    }

                    .rb_layout_box .content_box.mobile::after {
                        content: "Mobile 전용";
                        position: absolute;
                        top: 50%; left: 50%;
                        transform: translate(-50%, -50%);
                        background-color: #000;
                        padding: 5px 5px 5px 5px;
                        border-radius: 4px;
                        font-size: 10px;
                        color: #fff;
                        z-index: 96;
                    }
                `;
                document.head.appendChild(style);
            }
        } else {
            // 토글 OFF(닫기)할 때 style도 제거
            var dynStyle = document.getElementById('rb_layout_box_dynamic_style');
            if (dynStyle) dynStyle.remove();
            var dynStyle = document.getElementById('rb_section_box_dynamic_style');
            if (dynStyle) dynStyle.remove();
        }
        <?php } ?>

        //클래스로 확인한다.
        if (rbIsMod()) {
            toggleSideOptions_close_mod();
        } else {
            toggleSideOptions_open_mod();
        }
    }

    //섹션설정 토글
    function toggleSideSection() {

        if (rbIsSec()) {
            toggleSideOptions_close_sec();
        } else {
            toggleSideOptions_open_sec();
        }

    }

    function hasSortable($el) {
        if (!$el || !$el.length) return false;
        try {
            return !!$el.sortable('instance');
        } catch (e) {
            return false;
        }
    }

    function sortableSafe($el, method /*, ...args */ ) {
        if (!hasSortable($el)) return false;
        var args = Array.prototype.slice.call(arguments, 2);
        $el.sortable.apply($el, [method].concat(args));
        return true;
    }


    // 모듈설정 오픈
    function toggleSideOptions_open_mod() {

        // 섹션 모드 잔여물 정리
        cleanupSecArtifacts();

        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').show();
        $('.rb_config_mod3').hide();

        // 모듈설정 활성
        $('.content_box').addClass('content_box_set');
        $('.rb_layout_box').addClass('bg_fff');
        $('.mobule_set_btn').addClass('open');
        $('.setting_set_btn').removeClass('open');
        $('.section_set_btn').removeClass('open');
        $('.add_module_wrap').show();
        $('.add_section_wrap').hide();
        $('.rb-mod-label').show();
        $('.rb-sec-label').hide();

        rbSetMode('mod'); // 전역 플래그만 갱신

        // 공통: 섹션 속성 전파 (섹션 내부 flex/모듈까지)
        function recomputeSecUid(secKey, orderId) {
            return secKey ? (secKey + '_' + orderId) : '';
        }

        function propagateSectionAttrs($sec) {
            var secKey = String($sec.attr('data-sec-key') || '').trim();
            var orderId = String($sec.attr('data-order-id') || '').trim();
            var layout = String($sec.attr('data-layout') || '').trim();
            var secUid = recomputeSecUid(secKey, orderId);

            $sec.attr('data-sec-uid', secUid);

            var $fx = $sec.children('.flex_box');
            $fx.attr({
                'data-layout': layout,
                'data-order-id': orderId,
                'data-sec-key': secKey,
                'data-sec-uid': secUid
            });

            $fx.find('.rb_layout_box').each(function() {
                $(this).attr({
                    'data-layout': layout,
                    'data-order-id': orderId,
                    'data-sec-key': secKey,
                    'data-sec-uid': secUid
                });
            });
        }

        function getVisualRows($flex) {
            var rowsMap = new Map(),
                order = [],
                eps = 3;
            var baseTop = $flex[0].getBoundingClientRect().top;

            $flex.children('.rb_layout_box:visible').each(function() {
                var rect = this.getBoundingClientRect();
                var top = Math.round(rect.top - baseTop);
                var key = null;
                for (var k of rowsMap.keys()) {
                    if (Math.abs(k - top) <= eps) {
                        key = k;
                        break;
                    }
                }
                key = (key !== null) ? key : top;
                if (!rowsMap.has(key)) {
                    rowsMap.set(key, []);
                    order.push(key);
                }
                rowsMap.get(key).push(this);
            });

            order.sort(function(a, b) {
                return a - b;
            });
            // 같은 행 내부는 좌→우
            return order.map(function(k) {
                var arr = rowsMap.get(k);
                arr.sort(function(a, b) {
                    return a.getBoundingClientRect().left - b.getBoundingClientRect().left;
                });
                return arr;
            });
        }

        // 행 경계 마커 재구성
        function ensureRowBreaks($flex, forceVisual) {
            var insideSection = $flex.closest('.rb_section_box').length > 0;

            function applyLineBreaker($el) {
                var isFlex = ($flex.css('display') || '').indexOf('flex') !== -1;
                var common = {
                    width: '100%',
                    minHeight: '1px',
                    height: '1px',
                    margin: 0,
                    padding: 0,
                    border: 0,
                    overflow: 'hidden',
                    visibility: 'hidden',
                    pointerEvents: 'none',
                    display: 'block'
                };
                if (isFlex) $el.css(Object.assign({}, common, {
                    flex: '0 0 100%',
                    WebkitFlex: '0 0 100%',
                    msFlex: '0 0 100%'
                }));
                else $el.css(common);
            }

            // forceVisual===true 이면 기존 마커 무시하고 새로 계산
            var hasExistingBreak = !forceVisual && $flex.children('.rb-row-break, .rb-row-break-end').length > 0;

            var groups = [];
            if (hasExistingBreak) {
                var markers = Array.prototype.slice.call($flex.children('.rb-row-break, .rb-row-break-end'));
                var last = markers[markers.length - 1];
                var lastIsEnd = last && last.classList && last.classList.contains('rb-row-break-end');
                if (!lastIsEnd) markers = markers.concat([null]); // null = 끝

                for (var i = 0; i < markers.length - 1; i++) {
                    var start = markers[i];
                    var end = markers[i + 1];
                    var row = [],
                        n = start.nextSibling;
                    while (n && n !== end) {
                        if (n.nodeType === 1 && $(n).is(':visible') &&
                            (n.classList.contains('rb_layout_box') || n.classList.contains('rb_section_box'))) {
                            row.push(n);
                        }
                        n = n.nextSibling;
                    }
                    if (row.length) groups.push(row);
                }
            } else {
                // 시각적 top 기반 그룹핑
                var eps = 3,
                    tops = [],
                    topMap = new Map();
                var baseTop = $flex[0].getBoundingClientRect().top;
                var $cands = $flex.children('.rb_layout_box:visible, .rb_section_box:visible');
                if (!$cands.length) return;

                $cands.each(function() {
                    var t = Math.round(this.getBoundingClientRect().top - baseTop);
                    var key = null;
                    for (var k of topMap.keys()) {
                        if (Math.abs(k - t) <= eps) {
                            key = k;
                            break;
                        }
                    }
                    key = (key !== null) ? key : t;
                    if (!topMap.has(key)) {
                        topMap.set(key, []);
                        tops.push(key);
                    }
                    topMap.get(key).push(this);
                });

                tops.sort(function(a, b) {
                    return a - b;
                });
                groups = tops.map(function(k) {
                    var arr = topMap.get(k);
                    arr.sort(function(a, b) {
                        return a.getBoundingClientRect().left - b.getBoundingClientRect().left;
                    });
                    return arr;
                });
            }

            // 기존 마커 제거 후 재생성
            $flex.children('.rb-row-break, .rb-row-break-end').remove();
            if (!groups.length) return;

            groups.forEach(function(rowArr) {
                var first = rowArr[0];
                var $br = $('<i class="rb-row-break" aria-hidden="true"></i>');
                applyLineBreaker($br);
                $(first).before($br);
            });

            if (insideSection) return;

            var $end = $('<i class="rb-row-break-end" aria-hidden="true"></i>');
            applyLineBreaker($end);
            var $tb = $flex.children('.add_module_wrap, .add_section_wrap').first();
            if ($tb.length) $end.insertBefore($tb[0]);
            else $flex.append($end);
        }

        function queueRowHandleRefresh($flex) {
            if (!$flex || !$flex.length) return;

            var raf1 = $flex.data('rbRaf1'),
                raf2 = $flex.data('rbRaf2');
            if (raf1) cancelAnimationFrame(raf1);
            if (raf2) cancelAnimationFrame(raf2);

            var id1 = requestAnimationFrame(function() {
                // 1프레임: 마커를 시각적 기준으로 강제 재계산
                ensureRowBreaks($flex, true);
                var id2 = requestAnimationFrame(function() {
                    // 2프레임: 핸들 위치 렌더
                    renderRowHandles($flex);
                });
                $flex.data('rbRaf2', id2);
            });
            $flex.data('rbRaf1', id1);
        }


        function getRowsByMarkers($flex) {
            var rows = [];
            var markers = Array.prototype.slice.call($flex.children('.rb-row-break, .rb-row-break-end'));
            if (!markers.length) return rows;

            // 마지막 마커가 rb-row-break-end 가 아니면 "컨테이너 끝(null)"을 가상 엔드로 추가
            var last = markers[markers.length - 1];
            var lastIsEnd = last && last.classList && last.classList.contains('rb-row-break-end');
            if (!lastIsEnd) markers = markers.concat([null]); // null은 컨테이너 끝을 의미

            for (var i = 0; i < markers.length - 1; i++) {
                var start = markers[i];
                var end = markers[i + 1]; // null이면 컨테이너 끝까지
                var curr = [],
                    n = start.nextSibling;
                while (n && n !== end) {
                    if (n.nodeType === 1 && n.classList.contains('rb_layout_box') && $(n).is(':visible')) {
                        curr.push(n);
                    }
                    n = n.nextSibling;
                }
                if (curr.length) rows.push(curr);
            }
            return rows;
        }


        function getFlexRows($flex) {
            var rowsMap = new Map();
            var order = [];
            var eps = 3;
            var flexRectTop = $flex[0].getBoundingClientRect().top;

            $flex.children('.rb_layout_box:visible').each(function() {
                var $el = $(this);
                var rect = this.getBoundingClientRect();
                var top = Math.round(rect.top - flexRectTop); // 컨테이너 기준 top

                var foundKey = null;
                for (var k of rowsMap.keys()) {
                    if (Math.abs(k - top) <= eps) {
                        foundKey = k;
                        break;
                    }
                }
                var key = (foundKey !== null) ? foundKey : top;
                if (!rowsMap.has(key)) {
                    rowsMap.set(key, []);
                    order.push(key);
                }
                rowsMap.get(key).push(this);
            });

            order.sort(function(a, b) {
                return a - b;
            });

            return order.map(function(k) {
                var arr = rowsMap.get(k);
                arr.sort(function(a, b) {
                    return a.getBoundingClientRect().left - b.getBoundingClientRect().left;
                });
                return arr;
            });
        }

        // ===== 행 핸들: 왼쪽에 Up/Down 버튼 붙임 =====
        function renderRowHandles($flex) {
            // 최상위 flex만 대상
            if (!isTopLevelFlex($flex)) {
                $flex.find('> .rb-row-handle').remove();
                return;
            }

            // 마커 최신화
            ensureRowBreaks($flex);

            // 컨테이너 기준 배치
            if ($flex.css('position') === 'static') $flex.css('position', 'relative');

            // 기존 핸들 제거
            $flex.find('> .rb-row-handle').remove();

            // 마커 기준으로 "행 구간"을 만든다
            var markers = Array.prototype.slice.call($flex.children('.rb-row-break, .rb-row-break-end'));
            if (!markers.length) return;

            var last = markers[markers.length - 1];
            var hasEnd = last && last.classList && last.classList.contains('rb-row-break-end');
            var virtEnd = !hasEnd; // 섹션 내부 등 end가 없을 때 마지막 구간을 위해 +1

            for (var i = 0; i < markers.length - 1 + (virtEnd ? 1 : 0); i++) {
                var start = markers[i];
                var end = (i + 1 < markers.length) ? markers[i + 1] : null; // null = 컨테이너 끝

                // 이 구간의 첫 요소(섹션/모듈)과 모듈 목록 수집
                var currFirstEl = null;
                var currLayouts = [];
                var n = start.nextSibling;

                while (n && n !== end) {
                    if (n.nodeType === 1 && $(n).is(':visible')) {
                        if (!currFirstEl && (n.classList.contains('rb_layout_box') || n.classList.contains('rb_section_box'))) {
                            currFirstEl = n; // 행의 앵커(섹션 or 모듈)
                        }
                        if (n.classList.contains('rb_layout_box')) currLayouts.push(n); // 모듈만 카운트
                    }
                    n = n && n.nextSibling;
                }

                // 위치 계산: 문서기준 offset → 컨테이너 기준 top
                var top = Math.round($(currFirstEl).offset().top - $flex.offset().top + ($flex.scrollTop() || 0));
                var height = Math.max.apply(null, currLayouts.map(function(el) {
                    return Math.round($(el).outerHeight(true));
                }));

                // 모듈이 하나도 없는 행은 핸들 안 붙임
                if (!currFirstEl || !currLayouts.length) continue;

                // 핸들 생성 (마커 인덱스를 저장)
                var $handle = $('<div class="rb-row-handle" data-marker="' + i + '" aria-label="행 이동"></div>');
                var $up = $("<button type='button' class='rb-row-btn rb-row-up'  title='이 행을 위로'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#FFFFFFFF' d='M11.293 8.293a1 1 0 0 1 1.414 0l5.657 5.657a1 1 0 0 1-1.414 1.414L12 10.414l-4.95 4.95a1 1 0 0 1-1.414-1.414l5.657-5.657Z'/></g></svg></button>");
                var $dn = $("<button type='button' class='rb-row-btn rb-row-down' title='이 행을 아래로'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#FFFFFFFF' d='M12.707 15.707a1 1 0 0 1-1.414 0L5.636 10.05A1 1 0 1 1 7.05 8.636l4.95 4.95 4.95-4.95a1 1 0 0 1 1.414 1.414l-5.657 5.657Z'/></g></svg></button>");
                $handle.append($up, $dn).css({
                    position: 'absolute',
                    left: '12px',
                    top: (top + Math.max(0, (height - 24) / 2)) + 'px',
                    width: '24px',
                    height: '24px',
                    display: 'flex',
                    flexDirection: 'column',
                    gap: '4px',
                    alignItems: 'center',
                    justifyContent: 'center',
                    zIndex: 10000
                }).attr({
                    'data-tooltip': '모듈의 행 전체를 이동할 수 있어요.',
                    'data-tooltip-pos': 'right'
                });

                $flex.append($handle);


            }

            // 클릭 이벤트(중복 방지 후 바인딩) — 마커 인덱스로 moveRowByMarker 호출
            $flex.off('click.rbRowHandle').on('click.rbRowHandle', '.rb-row-handle .rb-row-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var $btn = $(this);
                var $h = $btn.closest('.rb-row-handle');
                var markerIdx = parseInt($h.attr('data-marker'), 10);
                $('.mobule_set_btn').css('display', 'none');
                if ($btn.hasClass('rb-row-up')) moveRowByMarker($flex, markerIdx, -1);
                if ($btn.hasClass('rb-row-down')) moveRowByMarker($flex, markerIdx, +1);

            });
        }

        function moveRowByMarker($flex, markerIdx, dir) {
            ensureRowBreaks($flex);

            var insideSection = $flex.closest('.rb_section_box').length > 0;
            var flexEl = $flex[0];
            var markers = Array.prototype.slice.call($flex.children('.rb-row-break, .rb-row-break-end'));
            if (!markers.length) return;

            // 가상 end 판단
            var last = markers[markers.length - 1];
            var hasEnd = last && last.classList && last.classList.contains('rb-row-break-end');

            function endNodeFor(i) {
                var nextMarker = markers[i + 1];
                if (nextMarker) return nextMarker;
                if (insideSection) return null; // 섹션 내부: 툴바 무시 → 끝
                var $tb = $flex.children('.add_module_wrap, .add_section_wrap').first();
                return $tb.length ? $tb[0] : null;
            }

            var srcIdx = markerIdx;
            var dstIdx = markerIdx + dir;

            // 범위 체크
            var maxInterval = (markers.length - 2) + (hasEnd ? 1 : 0) + (!hasEnd ? 1 : 0);
            if (dstIdx < 0 || dstIdx > maxInterval) return;

            // 스크롤 포커스 타겟 잡기 (이동 행의 첫 요소)
            var focusEl = (function() {
                var start = markers[srcIdx],
                    end = endNodeFor(srcIdx);
                var n = start.nextSibling;
                while (n && n !== end) {
                    if (n.nodeType === 1 && $(n).is(':visible') &&
                        (n.classList.contains('rb_layout_box') || n.classList.contains('rb_section_box'))) {
                        return n; // 첫 모듈/섹션
                    }
                    n = n.nextSibling;
                }
                return null;
            })();

            // 1) 잘라내기(시작 마커 포함 ~ 다음 경계 직전)
            var range = document.createRange();
            range.setStartBefore(markers[srcIdx]);
            var endNode = endNodeFor(srcIdx);
            if (endNode) range.setEndBefore(endNode);
            else {
                var lastChild = flexEl.lastChild;
                if (lastChild) range.setEndAfter(lastChild);
                else range.setEndAfter(flexEl);
            }
            var frag = range.extractContents();

            // 2) 꽂기
            if (dir < 0) {
                // 위로: 대상 구간 시작 마커 앞
                flexEl.insertBefore(frag, markers[dstIdx]);
            } else {
                // 아래로: 대상 구간의 다음 경계 앞(없으면 컨테이너 끝)
                var afterNode = endNodeFor(dstIdx);
                if (afterNode) flexEl.insertBefore(frag, afterNode);
                else flexEl.appendChild(frag);
            }

            // 3) 툴바는 끝으로
            if (!insideSection) {
                $flex.children('.add_module_wrap, .add_section_wrap').appendTo($flex);
            }

            // 4) 기존 마커를 활용해 행을 먼저 재확정(끼워넣기 방지)
            ensureRowBreaks($flex);

            // 5) order-id 재기입
            $flex.children('.rb_layout_box').each(function(i) {
                $(this).attr('data-order-id', i + 1);
            });

            // 6) 스크롤(모션 없이)
            if (focusEl && typeof focusEl.scrollIntoView === 'function') {
                // 가장 가까운 스크롤 부모로도 시도
                try {
                    focusEl.scrollIntoView({
                        behavior: 'auto',
                        block: 'nearest',
                        inline: 'nearest'
                    });
                } catch (e) {}
            }

            $('#saveOrderButton').show();
            renderRowHandles($flex);
        }

        window.renderRowHandles = renderRowHandles; // 전역 노출

        function keepToolbarsLast($flex) {
            $flex.children('.add_module_wrap, .add_section_wrap').appendTo($flex);
        }

        // ===== 행 이동: 같은 행의 모든 .rb_layout_box 를 통째로 위/아래 행과 맞바꾸거나 끼워넣기 =====
        function moveRow($flex, rowIdx, dir) {
            // 1) 지금 보이는 배치 기준으로 마커 보정
            ensureRowBreaks($flex);

            var flexEl = $flex[0];
            var markers = Array.prototype.slice.call($flex.children('.rb-row-break, .rb-row-break-end'));
            var rows = getRowsByMarkers($flex);

            var srcIdx = rowIdx,
                dstIdx = rowIdx + dir;
            if (dstIdx < 0 || dstIdx >= rows.length) return;

            var insideSection = $flex.closest('.rb_section_box').length > 0;

            function nextBoundary(i) {
                var nextMarker = markers[i + 1];
                if (nextMarker) return nextMarker;
                if (insideSection) return null; // 섹션 내부: 툴바 무시 → 컨테이너 끝까지
                var $tb = $flex.children('.add_module_wrap, .add_section_wrap').first();
                return $tb.length ? $tb[0] : null;
            }

            function afterRowBoundary(i) {
                var nb = nextBoundary(i);
                if (nb) return nb; // 다음 마커/엔드까지
                // 다음 마커가 없으면: 섹션 내부면 툴바 앞, 아니면 컨테이너 끝
                var $tb = $flex.children('.add_module_wrap, .add_section_wrap').first();
                if (insideSection && $tb.length) return $tb[0]; // 툴바 "앞"이 진짜 끝
                return null; // 컨테이너 진짜 끝
            }

            // 1) 잘라낼 범위
            var range = document.createRange();
            range.setStartBefore(markers[srcIdx]);

            var endNode = nextBoundary(srcIdx);
            if (endNode) {
                range.setEndBefore(endNode);
            } else {
                var lastChild = flexEl.lastChild;
                if (lastChild) range.setEndAfter(lastChild);
                else range.setEndAfter(flexEl);
            }

            var frag = range.extractContents();

            // 2) 꽂기
            if (dir < 0) {
                // 위로: 대상 행 시작 마커 앞
                flexEl.insertBefore(frag, markers[dstIdx]);
            } else {
                // 아래로: 대상 행의 "다음 경계" 앞(섹션 내부면 툴바 앞), 없으면 컨테이너 끝
                var insertBeforeNode = afterRowBoundary(dstIdx);
                if (insertBeforeNode) flexEl.insertBefore(frag, insertBeforeNode);
                else flexEl.appendChild(frag);
            }

            // 3) 후처리 (툴바는 끝으로, 마커/핸들 재계산)
            keepToolbarsLast($flex); // 섹션에서도 툴바는 항상 맨 끝
            ensureRowBreaks($flex);

            $flex.children(".rb_layout_box").each(function(i) {
                $(this).attr("data-order-id", i + 1);
            });

            $("#saveOrderButton").show();
            renderRowHandles($flex);
        }

        function isTopLevelFlex($flex) {
            // ① .flex_box 바로 아래에 .rb_layout_box가 있고
            // ② .flex_box 바로 아래에 .flex_box_inner는 없어야 함
            return $flex.is('.flex_box') &&
                $flex.find('> .rb_layout_box').length > 0 &&
                $flex.find('> .flex_box_inner').length === 0;
        }

        // 모듈이동
        $(function() {
            $(".flex_box").each(function() {
                var $flexBox = $(this);
                var originalWidth, originalHeight;

                // 기존 sortable 파괴
                try {
                    if ($flexBox.data("ui-sortable")) $flexBox.sortable("destroy");
                } catch (e) {}


                function enforceToolbarRule($flexBox, $item) {
                    var $toolbar = $flexBox.children(".add_module_wrap").first();
                    if (!$toolbar.length) return;

                    var tbIdx = $toolbar.index();
                    var lastIdx = $flexBox.children().length - 1;
                    var itIdx = $item.index();

                    // 툴바가 맨 위(앞 금지) → 앞에 오면 after로 보정
                    if (tbIdx === 0) {
                        if (itIdx <= tbIdx) $toolbar.after($item);
                        return;
                    }

                    // 툴바가 맨 아래(뒤 금지) → 뒤로 가면 before로 보정
                    if (tbIdx === lastIdx) {
                        if (itIdx > tbIdx) $toolbar.before($item);
                        return;
                    }

                    // 툴바가 중간이면 보정하지 않음(드랍 위치 유지)
                }

                function refreshRowHandlesAfterDrop($flex) {
                    if (!$flex || !$flex.length) return;

                    // 먼저 기존 핸들 제거 (잔상 방지)
                    $flex.find('> .rb-row-handle').remove();

                    var id1 = requestAnimationFrame(function() {
                        ensureRowBreaks($flex); // 1프레임: DOM 배치 반영 후 마커 재구성
                        var id2 = requestAnimationFrame(function() {
                            renderRowHandles($flex); // 2프레임: 핸들 위치 계산/부착
                        });
                        $flex.data('rbRaf2', id2);
                    });
                    $flex.data('rbRaf1', id1);

                    // 일부 브라우저에서 jQuery UI 정리 타이밍이 늦는 경우 안전망
                    setTimeout(function() {
                        ensureRowBreaks($flex);
                        renderRowHandles($flex);
                    }, 0);
                }

                function hideRowHandles($flex) {
                    if (!$flex || !$flex.length) return;
                    $flex.find('> .rb-row-handle').remove();
                }

                $flexBox.sortable({
                    items: "> .rb_layout_box",
                    placeholder: "placeholders_box",
                    tolerance: "pointer",
                    helper: "clone",
                    appendTo: "body",
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    scroll: true,
                    containment: "document",
                    connectWith: false,
                    cancel: '.rb-resize-s, .rb-resize-s-reset, .admin_set_btn',

                    start: function(event, ui) {

                        ui.helper.addClass("dragging");
                        $('.mobule_set_btn').css('display', 'none');

                        originalWidth = ui.item.outerWidth();
                        originalHeight = ui.item.outerHeight();
                        ui.helper.addClass("dragging").css({
                            width: originalWidth,
                            height: originalHeight,
                            zIndex: 99999,
                            pointerEvents: "none",
                        });

                        $(".placeholders_box").css({
                            width: originalWidth - 1,
                            height: originalHeight,
                            marginLeft: ui.item.css('margin-left'),
                            marginRight: ui.item.css('margin-right'),
                            marginTop: ui.item.css('margin-top'),
                            marginBottom: ui.item.css('margin-bottom')
                        });

                        hideRowHandles($flexBox);
                    },



                    receive: function(event, ui) {


                        var layout = String($flexBox.attr('data-layout') || '').trim();
                        ui.item.attr('data-layout', layout).data('layout', layout);

                        var $sec = $flexBox.closest('.rb_section_box');
                        if ($sec.length) {
                            var secKey = String($sec.attr('data-sec-key') || '').trim();
                            var orderId = String($sec.attr('data-order-id') || '').trim();
                            var secUid = recomputeSecUid(secKey, orderId);
                            ui.item.attr({
                                'data-sec-key': secKey,
                                'data-sec-uid': secUid,
                                'data-order-id': orderId
                            }).data('sec-key', secKey).data('sec-uid', secUid).data('order-id', orderId);
                        } else {
                            ui.item.removeAttr('data-sec-key data-sec-uid');
                            ui.item.removeData('sec-key').removeData('sec-uid');
                        }

                        // 위치 보정
                        enforceToolbarRule($flexBox, ui.item);
                        queueRowHandleRefresh($flexBox); // 타겟 컨테이너
                        if (ui.sender) queueRowHandleRefresh($(ui.sender)); // 출발지 컨테이너도 갱신
                    },

                    update: function(event, ui) {
                        // 출발지 컨테이너 update 무시(되돌림 방지)
                        if (!$.contains(this, ui.item[0])) return;

                        // 같은 컨테이너 내 이동에서도 보정은 '필요할 때만'
                        enforceToolbarRule($flexBox, ui.item);

                        // data-order-id 재기입 (모듈만)
                        $flexBox.children(".rb_layout_box").each(function(index) {
                            $(this).attr("data-order-id", index + 1);
                        });

                        // 순서 미리보기
                        window.currentOrder = $flexBox.children(".rb_layout_box").map(function() {
                            return $(this).attr('data-id') || '';
                        }).get();

                        $("#saveOrderButton").show();
                        queueRowHandleRefresh($flexBox)
                    },
                    stop: function(event, ui) {
                        ui.item.removeClass("dragging");

                        var $sec = ui.item.closest('.rb_section_box');
                        if ($sec.length) propagateSectionAttrs($sec);

                        $("#saveOrderButton").show();
                        enforceToolbarRule($flexBox, ui.item);
                        queueRowHandleRefresh($flexBox); // 현재 컨테이너
                        // 크롬 레이아웃 늦게 반영되는 케이스 보강
                        setTimeout(function() {
                            queueRowHandleRefresh($flexBox);
                        }, 0);
                    },
                    deactivate: function(event, ui) {
                        refreshRowHandlesAfterDrop($flexBox); // 현재 컨테이너
                        if (ui && ui.sender && ui.sender.length) {
                            refreshRowHandlesAfterDrop(ui.sender); // 출발지 컨테이너
                        }
                    },
                    remove: function(event, ui) {
                        refreshRowHandlesAfterDrop($flexBox);
                    }
                }).disableSelection();

                renderRowHandles($flexBox);
            });

            // 시각적 클릭 효과
            $(".rb_layout_box").on("mousedown", function() {
                $(".rb_layout_box").removeClass("dragging");
            });

            $(".rb_layout_box").on("mouseup", function() {});

            // 저장(모듈 모드에서는 기존 로직 유지)
            $("#saveOrderButton").off("click").on("click", function() {
                <?php if($is_admin) { ?><?php } else { ?>
                alert('편집 권한이 없습니다.');
                return false;
                <?php } ?>

                var modOrder = [];
                var secOrder = [];
                var idx = 1;

                $(".flex_box").each(function() {
                    $(this).children(".rb_layout_box, .rb_section_box").each(function() {
                        var $it = $(this);
                        var id = $it.data('id');
                        if (!id) return;
                        if ($it.hasClass("rb_layout_box")) {
                            modOrder.push({
                                id: id,
                                order_id: idx
                            });
                        } else if ($it.hasClass("rb_section_box")) {
                            secOrder.push({
                                id: id,
                                order_id: idx
                            });
                        }
                        idx++;
                    });
                });

                var saveModules = function() {
                    if (!modOrder.length) return $.Deferred().resolve().promise();
                    return $.ajax({
                        url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                        method: 'POST',
                        data: {
                            order: modOrder,
                            mod_type: "mod_order",
                            <?php if (defined('_SHOP_')) { ?>
                            is_shop: "1"
                            <?php } else { ?>
                            is_shop: "0"
                            <?php } ?>
                        }
                    });
                };

                var saveSections = function() {
                    if (!secOrder.length) return $.Deferred().resolve().promise();
                    return $.ajax({
                        url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                        method: 'POST',
                        data: {
                            order: secOrder,
                            mod_type: "sec_order",
                            <?php if (defined('_SHOP_')) { ?>is_shop: "1"
                            <?php } else { ?>is_shop: "0"
                            <?php } ?>
                        }
                    });
                };

                $.when(saveModules()).then(saveSections)
                    .done(function(resp) {
                        $("#saveOrderButton").hide();
                        location.reload();
                    })
                    .fail(function(xhr, status, err) {
                        console.error('Error saving order:', err);
                        alert('모듈 순서 저장 중 오류가 발생했습니다.');
                    });
            });

        });

    }

    function refreshTopLevelRowHandles() {
        requestAnimationFrame(function() {
            // 전역 또는 네임스페이스에 노출된 함수 포인터를 확보
            var fn = window.renderRowHandles || (window.RBRow && window.RBRow.renderRowHandles);
            if (typeof fn !== 'function') return; // 아직 로드 전이면 조용히 패스

            $('.flex_box').not('.flex_box_inner').each(function() {
                fn($(this));
            });
        });
    }


    function toggleSideOptions_open_sec() {

        // 모듈 모드 잔여물 정리
        cleanupModArtifacts();

        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').hide();
        $('.rb_config_mod3').show();

        // 섹션설정 활성
        $('.rb_section_box').addClass('rb_section_box_set');
        $('.content_box').removeClass('content_box_set');
        $('.rb_layout_box').removeClass('bg_fff');
        $('.mobule_set_btn').removeClass('open');
        $('.setting_set_btn').removeClass('open');
        $('.section_set_btn').addClass('open');
        $('.add_module_wrap').hide();
        $('.rb-row-handle').hide();
        $('.add_section_wrap').show();
        $('.rb-mod-label').hide();
        $('.rb-sec-label').show();

        rbSetMode('sec'); // 전역 플래그만 갱신


        // 공통: 섹션 속성 전파
        function recomputeSecUid(secKey, orderId) {
            return secKey ? (secKey + '_' + orderId) : '';
        }

        function propagateSectionAttrs($sec) {
            var secKey = String($sec.attr('data-sec-key') || '').trim();
            var orderId = String($sec.attr('data-order-id') || '').trim();
            var layout = String($sec.attr('data-layout') || '').trim();
            var secUid = recomputeSecUid(secKey, orderId);

            $sec.attr('data-sec-uid', secUid);

            var $fx = $sec.children('.flex_box');
            $fx.attr({
                'data-layout': layout,
                'data-order-id': orderId,
                'data-sec-key': secKey,
                'data-sec-uid': secUid
            });

            $fx.find('.rb_layout_box').each(function() {
                $(this).attr({
                    'data-layout': layout,
                    'data-order-id': orderId,
                    'data-sec-key': secKey,
                    'data-sec-uid': secUid
                });
            });
        }

        // 컨테이너 내 공통 순번(섹션+모듈) 재기입
        function syncUnifiedOrder($container) {
            var idx = 1;
            $container.children('.rb_layout_box, .rb_section_box').each(function() {
                $(this).attr('data-order-id', idx).data('order-id', idx);
                if ($(this).hasClass('rb_section_box')) propagateSectionAttrs($(this));
                idx++;
            });
        }

        // 섹션 이동
        $(function() {
            $(".flex_box").each(function() {
                var $flexBox = $(this);

                if ($flexBox.hasClass('flex_box_inner')) return;
                if ($flexBox.closest(".rb_section_box").length > 0) return;

                try {
                    if ($flexBox.data("ui-sortable")) $flexBox.sortable("destroy");
                } catch (e) {}

                $flexBox.sortable({
                    items: "> .rb_layout_box, > .rb_section_box",
                    cancel: ".rb_layout_box, a, button, input, textarea, select, .no-drag",
                    placeholder: "placeholders_section",
                    tolerance: "pointer",
                    appendTo: "body",
                    //connectWith: ".flex_box", // 서로 다른 컨테이너 간 이동 허용
                    connectWith: ".flex_box:not(.flex_box_inner)",

                    helper: function(e, item) {
                        var $it = $(item);
                        if (!$it.hasClass('rb_section_box')) return item;

                        // 클릭 오프셋 계산
                        var off = $it.offset();
                        var w = $it.outerWidth();
                        var h = $it.outerHeight();
                        var cx = e.pageX - off.left;
                        var cy = e.pageY - off.top;
                        var map = function(v, src, dst) {
                            if (src <= 0) return Math.round(dst / 2);
                            var m = Math.round(v * (dst / src));
                            return Math.max(8, Math.min(dst - 8, m));
                        };
                        var left = map(cx, w, 100);
                        var top = map(cy, h, 100);
                        $it.parent().sortable("option", "cursorAt", {
                            left: left,
                            top: top
                        });

                        // 원본 비우고 data-title만 표시
                        if (!$it.data('orig-html-saved')) {
                            $it.data('orig-html', $it.html());
                            $it.data('orig-html-saved', true);
                        }
                        var title = $it.attr('data-title') || '섹션';
                        $it.html('<div class="rb-sec-ghost-title">' + title + '</div>');

                        return $('<div class="ui-sortable-helper rb-sec-helper"/>')
                            .css({
                                width: 100,
                                height: 100,
                                margin: 0,
                                boxSizing: 'border-box',
                                zIndex: 99999,
                                pointerEvents: 'none'
                            })
                            .append($('<div class="rb-sec-helper-inner"/>').text(title));
                    },

                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    scroll: true,
                    containment: "document",

                    start: function(event, ui) {
                        ui.item.data('_fromFlex', $flexBox);
                         $('.section_set_btn').css('display', 'none');
                        $(".placeholders_section").css({
                            width: 100,
                            height: 100,
                            margin: <?php echo $rb_core['gap_pc'] ?>,
                            boxSizing: "border-box"
                        });
                        if (ui.item.hasClass('rb_section_box')) {
                            ui.item.addClass('rb-sec-dragging');
                            $flexBox.addClass('rb-sec-sorting');
                        }
                    },

                    receive: function(event, ui) {

                        // 도착 컨테이너에서 공통 순번
                        syncUnifiedOrder($flexBox);
                        // 섹션이면 내부까지 전파
                        if (ui.item.hasClass('rb_section_box')) {
                            // 부모 flex의 data-layout(문자열)을 섹션으로 복사
                            var layout = String($flexBox.attr('data-layout') || '').trim();
                            ui.item.attr('data-layout', layout).data('layout', layout);
                            propagateSectionAttrs(ui.item);
                        }
                        $("#saveOrderButton").show();

                    },

                    update: function(event, ui) {
                        // 섹션 아닌 아이템은 취소
                        if (!ui.item.hasClass('rb_section_box')) {
                            $flexBox.sortable("cancel");
                            return;
                        }

                        // 공통 순번 재기입
                        syncUnifiedOrder($flexBox);

                        // 부모 flex의 data-layout(문자열)을 섹션 및 내부로 전파
                        var layout = String($flexBox.attr('data-layout') || '').trim();
                        ui.item.attr('data-layout', layout).data('layout', layout);
                        propagateSectionAttrs(ui.item);

                        // 미리보기용
                        window.currentSectionOrder = $flexBox
                            .children(".rb_section_box")
                            .map(function() {
                                return $(this).attr("data-id");
                            })
                            .get();

                        $("#saveOrderButton").show();

                    },

                    stop: function(event, ui) {
                        if (ui.item.hasClass('rb_section_box')) {
                            if (ui.item.data('orig-html-saved')) {
                                ui.item.html(ui.item.data('orig-html'));
                                ui.item.removeData('orig-html-saved');
                            }
                            ui.item.removeClass('rb-sec-dragging');
                            $flexBox.removeClass('rb-sec-sorting');
                        }

                        // 출발/도착 컨테이너 모두 공통 순번 재기입
                        var $from = ui.item.data('_fromFlex');
                        var $to = ui.item.closest('.flex_box');
                        if ($from && $from.length) syncUnifiedOrder($from);
                        if ($to && $to.length) syncUnifiedOrder($to);

                        $("#saveOrderButton").show();

                    }
                }).disableSelection();
            });

            // 마우스 누르면 grabbing 클래스 추가/해제
            $(document).on('mousedown', '.rb_section_box', function() {
                $(this).addClass('rb-sec-grabbing');
            });
            $(document).on('mouseup', function() {
                $('.rb_section_box').removeClass('rb-sec-grabbing');
            });


            // 저장 클릭 핸들러
            $("#saveOrderButton").off("click").on("click", function() {
                <?php if($is_admin) { ?><?php } else { ?>
                alert('편집 권한이 없습니다.');
                return false;
                <?php } ?>

                var modOrder = [];
                var secOrder = [];
                var idx = 1;

                // 화면상의 공통 순서대로 수집
                $(".flex_box").each(function() {
                    $(this).children(".rb_layout_box, .rb_section_box").each(function() {
                        var $it = $(this);
                        var id = $it.data('id');
                        if (!id) return;
                        if ($it.hasClass("rb_layout_box")) {
                            modOrder.push({
                                id: id,
                                order_id: idx
                            });
                        } else if ($it.hasClass("rb_section_box")) {
                            secOrder.push({
                                id: id,
                                order_id: idx
                            });
                        }
                        idx++;
                    });
                });

                // 섹션의 현재 레이아웃(문자열) 수집
                var secLayoutMaps = [];
                $(".rb_section_box").each(function() {
                    var $sec = $(this);
                    var secId = parseInt($sec.data('id'), 10);
                    var secLayout = String($sec.attr('data-layout') || '').trim();
                    if (secId && secLayout) {
                        secLayoutMaps.push({
                            sec_id: secId,
                            sec_layout: secLayout
                        });
                    }
                });

                // 섹션별 모듈 소속키/UID 수집
                var modSecMaps = [];
                $(".rb_section_box").each(function() {
                    var $sec = $(this);
                    var secKey = String($sec.attr('data-sec-key') || '').trim();
                    var orderId = String($sec.attr('data-order-id') || '').trim();
                    var secUid = recomputeSecUid(secKey, orderId);
                    var ids = $sec.find('> .flex_box .rb_layout_box').map(function() {
                        return parseInt($(this).data('id'), 10);
                    }).get().filter(Boolean);
                    if (secKey && secUid && ids.length) {
                        modSecMaps.push({
                            md_sec_key: secKey,
                            md_sec_uid: secUid,
                            mod_ids: ids
                        });
                    }
                });

                // 섹션 밖 모듈은 소속 해제(NULL)
                var outside = $('.rb_layout_box').filter(function() {
                    return $(this).closest('.rb_section_box').length === 0;
                }).map(function() {
                    return parseInt($(this).data('id'), 10);
                }).get().filter(Boolean);
                if (outside.length) {
                    modSecMaps.push({
                        md_sec_key: null,
                        md_sec_uid: null,
                        mod_ids: outside
                    });
                }

                // 모듈 md_layout 동기화(섹션 레이아웃으로)
                var modMoveMaps = [];
                $(".rb_section_box").each(function() {
                    var $sec = $(this);
                    var secLayout = String($sec.attr("data-layout") || '').trim();
                    var modIds = $sec.find("> .flex_box .rb_layout_box").map(function() {
                        return parseInt($(this).data("id"), 10);
                    }).get().filter(Boolean);
                    if (secLayout && modIds.length) {
                        modMoveMaps.push({
                            sec_layout: secLayout,
                            mod_ids: modIds
                        });
                    }
                });

                // 저장 순서:
                // 1) 모듈 순서 → 2) 섹션 순서(sec_uid 자동 갱신됨, res.php) → 3) 섹션 레이아웃 → 4) 모듈 소속 → 5) 모듈 레이아웃
                var saveModules = function() {
                    if (!modOrder.length) return $.Deferred().resolve().promise();
                    return $.ajax({
                        url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                        method: 'POST',
                        data: {
                            order: modOrder,
                            mod_type: "mod_order",
                            <?php if (defined('_SHOP_')) { ?>is_shop: "1"
                            <?php } else { ?>is_shop: "0"
                            <?php } ?>
                        }
                    });
                };

                var saveSections = function() {
                    if (!secOrder.length) return $.Deferred().resolve().promise();
                    return $.ajax({
                        url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                        method: 'POST',
                        data: {
                            order: secOrder,
                            mod_type: "sec_order",
                            <?php if (defined('_SHOP_')) { ?>is_shop: "1"
                            <?php } else { ?>is_shop: "0"
                            <?php } ?>
                        }
                    });
                };

                $.when(saveModules())
                    .then(saveSections)
                    .then(function() {
                        // 섹션 레이아웃 반영
                        if (!secLayoutMaps.length) return $.Deferred().resolve().promise();
                        return $.ajax({
                            url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                            method: 'POST',
                            data: {
                                mod_type: "sec_move_to_layout",
                                maps: JSON.stringify(secLayoutMaps),
                                <?php if (defined('_SHOP_')) { ?>is_shop: "1"
                                <?php } else { ?>is_shop: "0"
                                <?php } ?>
                            }
                        });
                    }).then(function() {
                        // 모듈 섹션 소속키/UID 반영
                        if (!modSecMaps.length) return $.Deferred().resolve().promise();
                        return $.ajax({
                            url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                            method: 'POST',
                            data: {
                                mod_type: "mod_update_sec",
                                maps: JSON.stringify(modSecMaps),
                                <?php if (defined('_SHOP_')) { ?>is_shop: "1"
                                <?php } else { ?>is_shop: "0"
                                <?php } ?>
                            }
                        });
                    }).then(function() {
                        // 모듈 md_layout 반영
                        if (!modMoveMaps.length) return $.Deferred().resolve().promise();
                        return $.ajax({
                            url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                            method: 'POST',
                            data: {
                                mod_type: "mod_move_to_layout",
                                maps: JSON.stringify(modMoveMaps),
                                <?php if (defined('_SHOP_')) { ?>is_shop: "1"
                                <?php } else { ?>is_shop: "0"
                                <?php } ?>
                            }
                        });
                    }).done(function() {
                        $("#saveOrderButton").hide();
                        location.reload();

                    }).fail(function(xhr, status, err) {
                        console.error('Error saving order/layout:', err);
                        alert('순서/레이아웃 저장 중 오류가 발생했습니다.');
                    });

            });
        });
    }




    function cleanupSecArtifacts() {
        // 진행중 드래그 취소
        $(".flex_box").each(function() {
            sortableSafe($(this), 'cancel');
        });

        // 섹션 원본 HTML 복구
        $(".rb_section_box").each(function() {
            var $it = $(this);
            if ($it.data("orig-html-saved")) {
                $it.html($it.data("orig-html"));
                $it.removeData("orig-html").removeData("orig-html-saved");
            }
            $it.removeClass("rb-sec-dragging rb-sec-grabbing");
        });

        // 컨테이너 및 전역 커서 원복
        $(".flex_box").removeClass("rb-sec-sorting");
        $("body").removeClass("sec-grabbing-cursor");

        // 기존 sortable 파괴
        $(".flex_box").each(function() {
            var $c = $(this);
            if (hasSortable($c)) $c.sortable('destroy');
        });
    }

    function cleanupModArtifacts() {
        try {
            $(".flex_box").sortable("cancel");
        } catch (e) {}
        $(".rb_layout_box").removeClass("dragging clicked");
        $(".flex_box").each(function() {
            var $c = $(this);
            try {
                if ($c.data("ui-sortable")) $c.sortable("destroy");
            } catch (e) {}
        });
    }


    // 모듈설정 닫기
    function toggleSideOptions_close_mod() {

        cleanupSecArtifacts();
        cleanupModArtifacts();

        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').hide();
        $('.rb_config_mod3').hide();

        // 모듈설정 비활성
        //$(".flex_box").sortable("destroy");
        $('.content_box').removeClass('handles');
        $('.mobule_set_btn').removeClass('open');
        $('.setting_set_btn').removeClass('open');
        $('.section_set_btn').removeClass('open');
        $('.add_module_wrap').hide();
        $('.add_section_wrap').hide();
        $('.rb-row-handle').hide();
        $('.rb-mod-label').hide();
        $('.rb-sec-label').hide();


        var dynStyle = document.getElementById('rb_layout_box_dynamic_style');
        if (dynStyle) dynStyle.remove();

        rbSetMode(null);
        toggleSideOptions_close();
    }


    // 섹션설정 닫기
    function toggleSideOptions_close_sec() {

        cleanupSecArtifacts();
        cleanupModArtifacts();

        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').hide();
        $('.rb_config_mod3').hide();

        // 섹션설정 비활성
        //$(".rb_section_box").sortable("destroy");
        $('.rb_section_box').removeClass('handles');
        $('.rb_section_box').removeClass('rb_section_box_set');
        $('.rb_section_box').removeClass('ui-sortable-handle');
        $('.mobule_set_btn').removeClass('open');
        $('.setting_set_btn').removeClass('open');
        $('.section_set_btn').removeClass('open');
        $('.add_module_wrap').hide();
        $('.add_section_wrap').hide();
        $('.rb-row-handle').hide();
        $('.rb-mod-label').hide();
        $('.rb-sec-label').hide();

        rbSetMode(null);
        toggleSideOptions_close();
    }


    //환경설정 오픈
    function toggleSideOptions_open_set() {
        toggleSideOptions_open();
        cleanupModArtifacts();

        $('.rb_config_mod1').show();
        $('.rb_config_mod2').hide();
        $('.rb_config_mod3').hide();

        //환경설정 활성
        $('.setting_set_btn').addClass('open');
        $('.mobule_set_btn').removeClass('open');
        $('.section_set_btn').removeClass('open');
        $('.content_box').removeClass('content_box_set');
        $('.rb_layout_box').removeClass('bg_fff');
        $('.add_module_wrap').hide();
        $('.add_section_wrap').hide();
        $('.rb-row-handle').hide();
        $('.flex_box').removeClass('ui-sortable');
        $('.rb-mod-label').hide();
        $('.rb-sec-label').hide();


    }

    //환경설정 열기
    function toggleSideOptions_open() {
        $('.sh-side-options').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.sh-side-options').addClass('open');
        rbSetMode(null);
    }

    //설정 닫기
    function toggleSideOptions_close() {
        $('.sh-side-options').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.sh-side-options').removeClass('open');

        $('.setting_set_btn').removeClass('open');
        $('.mobule_set_btn').removeClass('open');
        $('.section_set_btn').removeClass('open');
        $('.content_box').removeClass('content_box_set');
        $('.rb_layout_box').removeClass('bg_fff');
        $('.rb_section_box').removeClass('bg_fff');
        $('.add_module_wrap').hide();
        $('.add_section_wrap').hide();
        $('.rb-row-handle').hide();
        $('.rb_layout_box').removeClass('ui-sortable-handle');
        $('.rb_section_box').removeClass('ui-sortable-handle');
        $('.flex_box').removeClass('ui-sortable');
        $('.rb_section_box').removeClass('ui-sortable');


        edit_css_close();
        lib_close();

    }

    //섹션설정
    function set_section_send(element) {

        // 부모 요소의 값을 가져옴
        var set_layout = $(element).closest('.rb_section_box').data('layout');
        var set_title = $(element).closest('.rb_section_box').data('title');
        var set_id = $(element).closest('.rb_section_box').data('id');
        var theme_name = '<?php echo $rb_core['theme']; ?>';
        var mod_type = '3';

        //모듈의 데이터를 비운다
        $('input[name="md_layout"]').val('');
        $('input[name="md_theme"]').val('');
        $('input[name="md_id"]').val('');
        $('input[name="md_sec_key"]').val('');
        $('input[name="md_sec_uid"]').val('');

        if (!set_layout) {
            var set_layout = $(element).closest('.flex_box').data('layout');
        }


        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.config_set.php', // PHP 파일 경로
            method: 'POST', // POST 방식으로 전송
            dataType: 'html',
            data: {
                "set_layout": set_layout,
                "set_id": set_id,
                "set_title": set_title,
                "theme_name": theme_name,
                "mod_type": mod_type,
                <?php if (defined('_SHOP_')) { ?> "is_shop": "1",
                <?php } else { ?> "is_shop": "0",
                <?php } ?>

            },
            success: function(response) {
                $("#inq_res_section").html(response); //성공
                toggleSideOptions_open_sec()
                toggleSideOptions_open()

                Coloris({
                    el: '.coloris'
                });
                Coloris.setInstance('.coloris', {
                    parent: '.sh-side-demos-container'
                });

            },
            error: function(xhr, status, error) {
                console.error('처리에 문제가 있습니다. 잠시 후 이용해주세요.');
            }
        });

    }




    //모듈설정
    function set_module_send(element) {

        // 부모 요소의 값을 가져옴
        var $fx = $(element).closest('.flex_box');
        var set_layout = String($fx.attr('data-layout') || '').trim();
        var set_title = String($(element).closest('.rb_layout_box').attr('data-title') || '');
        var set_id = String($(element).closest('.rb_layout_box').attr('data-id') || '');
        var theme_name = '<?php echo $rb_core['theme']; ?>';
        var mod_type = '2';

        //섹션의 데이터를 비운다
        $('input[name="sec_layout"]').val('');
        $('input[name="sec_theme"]').val('');
        $('input[name="sec_id"]').val('');

        // 섹션 안에서 눌렀을 때 섹션 키 전달
        var $sec = $(element).closest('.rb_section_box');
        var md_sec_key = '';
        var md_sec_uid = '';
        if ($sec.length) {
            // flex_box에 이미 복사돼 있으면 그 값을 우선 사용
            md_sec_key = String(($fx.attr('data-sec-key') || $sec.attr('data-sec-key') || '')).trim();
            md_sec_uid = String(($fx.attr('data-sec-uid') || $sec.attr('data-sec-uid') || '')).trim();
        }

        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.config_set.php',
            method: 'POST',
            dataType: 'html',
            data: {
                set_layout: set_layout,
                set_id: set_id,
                set_title: set_title,
                theme_name: theme_name,
                mod_type: mod_type,
                <?php if (defined('_SHOP_')) { ?>is_shop: '1'
                <?php } else { ?>is_shop: '0'
                <?php } ?>,
                md_sec_key: md_sec_key,
                md_sec_uid: md_sec_uid
            },
            success: function(response) {
                $("#inq_res").html(response);
                toggleSideOptions_open_mod();
                toggleSideOptions_open();
            },
            error: function() {
                console.error('처리에 문제가 있습니다. 잠시 후 이용해주세요.');
            }
        });
    }


    //모듈 삭제
    function set_module_del(element) {

        // 부모 요소의 값을 가져옴
        var set_layout = $(element).closest('.flex_box').data('layout');
        var set_title = $(element).closest('.rb_layout_box').data('title');
        var set_id = $(element).closest('.rb_layout_box').data('id');
        var theme_name = '<?php echo $rb_core['theme']; ?>';
        var mod_type = 'del';

        <?php if($is_admin) { ?>
        <?php } else { ?>
        alert('편집 권한이 없습니다.');
        return false;
        <?php } ?>


        // Ajax를 사용하여 PHP로 값 전달
        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.config_set.php', // PHP 파일 경로
            method: 'POST', // POST 방식으로 전송
            dataType: 'html',
            data: {
                "set_layout": set_layout,
                "set_id": set_id,
                "set_title": set_title,
                "theme_name": theme_name,
                "mod_type": mod_type,
                <?php if (defined('_SHOP_')) { ?> "is_shop": "1",
                <?php } else { ?> "is_shop": "0",
                <?php } ?>

            },
            success: function(response) {
                $("#inq_res").html(response); //성공
                toggleSideOptions_open_mod()
                toggleSideOptions_open()

            },
            error: function(xhr, status, error) {
                console.error('처리에 문제가 있습니다. 잠시 후 이용해주세요.');
            }
        });

    }


    //섹션 삭제
    function set_section_del(element) {

        // 부모 요소의 값을 가져옴
        var set_layout = $(element).closest('.rb_section_box').data('layout');
        var set_title = $(element).closest('.rb_section_box').data('title');
        var set_id = $(element).closest('.rb_section_box').data('id');
        var theme_name = '<?php echo $rb_core['theme']; ?>';
        var mod_type = 'del_sec';

        <?php if($is_admin) { ?>
        <?php } else { ?>
        alert('편집 권한이 없습니다.');
        return false;
        <?php } ?>


        // Ajax를 사용하여 PHP로 값 전달
        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.config_set.php', // PHP 파일 경로
            method: 'POST', // POST 방식으로 전송
            dataType: 'html',
            data: {
                "set_layout": set_layout,
                "set_id": set_id,
                "set_title": set_title,
                "theme_name": theme_name,
                "mod_type": mod_type,
                <?php if (defined('_SHOP_')) { ?> "is_shop": "1",
                <?php } else { ?> "is_shop": "0",
                <?php } ?>

            },
            success: function(response) {
                $("#inq_res_section").html(response); //성공
                toggleSideOptions_open_sec()
                toggleSideOptions_open()

            },
            error: function(xhr, status, error) {
                console.error('처리에 문제가 있습니다. 잠시 후 이용해주세요.');
            }
        });

    }


    document.addEventListener('DOMContentLoaded', function() {

        //페이지 로드후 컬러감지 자동적용
        function isLightColor2(hex) { //밝은계통인지, 어두운 계통인지 판단 함수
            var r, g, b, a = 1; // 기본 알파 값

            // 8자리 HEX (RGBA) 체크
            if (hex.length === 9) {
                r = parseInt(hex.slice(1, 3), 16);
                g = parseInt(hex.slice(3, 5), 16);
                b = parseInt(hex.slice(5, 7), 16);
                a = parseInt(hex.slice(7, 9), 16) / 255; // 0~255를 0~1로 변환
            } else {
                r = parseInt(hex.slice(1, 3), 16);
                g = parseInt(hex.slice(3, 5), 16);
                b = parseInt(hex.slice(5, 7), 16);
            }

            var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
            return {
                isLight: yiq >= 210,
                alpha: a
            }; // 밝기와 알파 값을 반환

        }

        var colorInfo2 = isLightColor2("<?php echo $rb_config['co_header'] ?>");

        if (colorInfo2.alpha < 0.2) {
            var newTextCode2 = 'black'; // 투명도가 낮으면 회색
        } else if (colorInfo2.isLight) {
            var newTextCode2 = 'black'; // 밝은색이면 검은색
        } else {
            var newTextCode2 = 'white'; // 어두운색이면 흰색
        }

        // 링크 태그의 href 속성 변경
        $('link[href*="set.header.php"]').attr('href', '<?php echo G5_URL ?>/rb/rb.css/set.header.php?rb_header_set=<?php echo $rb_core['header'] ?>&rb_header_code=' + encodeURIComponent("<?php echo $rb_config['co_header'] ?>") + '&rb_header_txt=' + newTextCode2);

        if (newTextCode2 == 'black') {
            <?php if (isset($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w'])) { ?>
            var newSrcset1 = "<?php echo G5_URL ?>/data/logos/mo?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } else { ?>
            var newSrcset1 = "<?php echo G5_THEME_URL ?>/rb.img/logos/mo.png?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } ?>

            <?php if (isset($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w'])) { ?>
            var newSrcset2 = "<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } else { ?>
            var newSrcset2 = "<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } ?>

        } else {

            <?php if (isset($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w'])) { ?>
            var newSrcset1 = "<?php echo G5_URL ?>/data/logos/mo_w?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } else { ?>
            var newSrcset1 = "<?php echo G5_THEME_URL ?>/rb.img/logos/mo_w.png?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } ?>

            <?php if (isset($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w'])) { ?>
            var newSrcset2 = "<?php echo G5_URL ?>/data/logos/pc_w?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } else { ?>
            var newSrcset2 = "<?php echo G5_THEME_URL ?>/rb.img/logos/pc_w.png?ver=<?php echo G5_SERVER_TIME ?>";
            <?php } ?>
        }

        $('#sourceSmall').attr('srcset', newSrcset1);
        $('#sourceLarge').attr('srcset', newSrcset2);
        $('#fallbackImage').attr('src', newSrcset2);


        ////
    });


    // Ajax 실행 함수 정의
    async function executeAjax() {

        var co_color = $('input[name="co_color"]').val();
        var co_header = $('input[name="co_header"]').val();

        var co_main_bg = $('input[name="co_main_bg"]').val();
        var co_sub_bg = $('input[name="co_sub_bg"]').val();

        var co_font = $('select[name="co_font"]').val();
        var co_gap_pc = $('input[name="co_gap_pc"]').val();
        var co_gap_mo = $('input[name="co_gap_mo"]:checked').val();
        var co_inner_padding_pc = $('input[name="co_inner_padding_pc"]').val();

        var co_layout_shop = $('select[name="co_layout_shop"]').val();
        var co_layout_hd_shop = $('select[name="co_layout_hd_shop"]').val();
        var co_layout_ft_shop = $('select[name="co_layout_ft_shop"]').val();

        var co_layout = $('select[name="co_layout"]').val();
        var co_layout_hd = $('select[name="co_layout_hd"]').val();
        var co_layout_ft = $('select[name="co_layout_ft"]').val();

        var co_sub_width = $('select[name="co_sub_width"]').val();
        var co_main_width = $('select[name="co_main_width"]').val();
        var co_tb_width = $('select[name="co_tb_width"]').val();


        var co_padding_top = $('input[name="co_padding_top"]').val();
        var co_padding_top_sub = $('input[name="co_padding_top_sub"]').val();
        var co_padding_top_shop = $('input[name="co_padding_top_shop"]').val();
        var co_padding_top_sub_shop = $('input[name="co_padding_top_sub_shop"]').val();

        var co_padding_btm = $('input[name="co_padding_btm"]').val();
        var co_padding_btm_sub = $('input[name="co_padding_btm_sub"]').val();
        var co_padding_btm_shop = $('input[name="co_padding_btm_shop"]').val();
        var co_padding_btm_sub_shop = $('input[name="co_padding_btm_sub_shop"]').val();

        <?php if(defined('_SHOP_')) { // 영카트?>
        var co_menu_shop = $('input[name="co_menu_shop"]:checked').val();
        <?php } else { ?>
        var co_menu_shop = $('input[name="co_menu_shop"]').val();
        <?php } ?>

        <?php if (defined("_INDEX_")) { ?>

        var co_side_skin = "<?php echo !empty($rb_core['side_skin']) ? $rb_core['side_skin'] : ''; ?>";
        var co_side_skin_shop = "<?php echo !empty($rb_core['side_skin_shop']) ? $rb_core['side_skin_shop'] : ''; ?>";
        var co_sidemenu = "<?php echo !empty($rb_core['sidemenu']) ? $rb_core['sidemenu'] : ''; ?>";
        var co_sidemenu_shop = "<?php echo !empty($rb_core['sidemenu_shop']) ? $rb_core['sidemenu_shop'] : ''; ?>";
        var co_sidemenu_width = "<?php echo !empty($rb_core['sidemenu_width']) ? $rb_core['sidemenu_width'] : ''; ?>";
        var co_sidemenu_width_shop = "<?php echo !empty($rb_core['sidemenu_width_shop']) ? $rb_core['sidemenu_width_shop'] : ''; ?>";

        var co_sidemenu_padding = "<?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>";
        var co_sidemenu_padding_shop = "<?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>";
        var co_sidemenu_hide = "<?php echo !empty($rb_core['sidemenu_hide']) ? $rb_core['sidemenu_hide'] : '0'; ?>";
        var co_sidemenu_hide_shop = "<?php echo !empty($rb_core['sidemenu_hide_shop']) ? $rb_core['sidemenu_hide_shop'] : '0'; ?>";

        var co_topvisual_mt = "<?php echo !empty($rb_v_info['topvisual_mt']) ? $rb_v_info['topvisual_mt'] : '0'; ?>";
        var co_topvisual_height = "<?php echo !empty($rb_v_info['topvisual_height']) ? $rb_v_info['topvisual_height'] : ''; ?>";
        var co_topvisual_width = "<?php echo !empty($rb_v_info['topvisual_width']) ? $rb_v_info['topvisual_width'] : ''; ?>";
        var co_topvisual_bl = "<?php echo isset($rb_v_info['topvisual_bl']) ? $rb_v_info['topvisual_bl'] : '10'; ?>";

        var co_topvisual_border = "<?php echo isset($rb_v_info['topvisual_border']) ? $rb_v_info['topvisual_border'] : '0'; ?>";
        var co_topvisual_radius = "<?php echo isset($rb_v_info['topvisual_radius']) ? $rb_v_info['topvisual_radius'] : '0'; ?>";

        var co_topvisual_m_color = "<?php echo !empty($rb_v_info['topvisual_m_color']) ? $rb_v_info['topvisual_m_color'] : ''; ?>";
        var co_topvisual_m_size = "<?php echo !empty($rb_v_info['topvisual_m_size']) ? $rb_v_info['topvisual_m_size'] : ''; ?>";
        var co_topvisual_m_font = "<?php echo !empty($rb_v_info['topvisual_m_font']) ? $rb_v_info['topvisual_m_font'] : ''; ?>";
        var co_topvisual_m_align = "<?php echo !empty($rb_v_info['topvisual_m_align']) ? $rb_v_info['topvisual_m_align'] : ''; ?>";

        var co_topvisual_s_color = "<?php echo !empty($rb_v_info['topvisual_s_color']) ? $rb_v_info['topvisual_s_color'] : ''; ?>";
        var co_topvisual_s_size = "<?php echo !empty($rb_v_info['topvisual_s_size']) ? $rb_v_info['topvisual_s_size'] : ''; ?>";
        var co_topvisual_s_font = "<?php echo !empty($rb_v_info['topvisual_s_font']) ? $rb_v_info['topvisual_s_font'] : ''; ?>";
        var co_topvisual_s_align = "<?php echo !empty($rb_v_info['topvisual_s_align']) ? $rb_v_info['topvisual_s_align'] : ''; ?>";

        var co_topvisual_bg_color = "<?php echo !empty($rb_v_info['topvisual_bg_color']) ? $rb_v_info['topvisual_bg_color'] : ''; ?>";

        var co_topvisual_style_all = "<?php echo !empty($rb_v_info['topvisual_style_all']) ? $rb_v_info['topvisual_style_all'] : ''; ?>";

        var v_code = "<?php echo !empty($rb_v_info['v_code']) ? $rb_v_info['v_code'] : ''; ?>";

        <?php } else { ?>

        var co_side_skin = $('select[name="co_side_skin"]').val();
        var co_side_skin_shop = $('select[name="co_side_skin_shop"]').val();
        var co_sidemenu = $('input[name="co_sidemenu"]:checked').val();
        var co_sidemenu_shop = $('input[name="co_sidemenu_shop"]:checked').val();
        var co_sidemenu_width = $('input[name="co_sidemenu_width"]').val();
        var co_sidemenu_width_shop = $('input[name="co_sidemenu_width_shop"]').val();

        var co_sidemenu_padding = $('input[name="co_sidemenu_padding"]').val();
        var co_sidemenu_padding_shop = $('input[name="co_sidemenu_padding_shop"]').val();
        var co_sidemenu_hide = $('input[name="co_sidemenu_hide"]:checked').val();
        var co_sidemenu_hide_shop = $('input[name="co_sidemenu_hide_shop"]:checked').val();

        var co_topvisual_mt = $('input[name="co_topvisual_mt"]').val();
        var co_topvisual_height = $('input[name="co_topvisual_height"]').val();
        var co_topvisual_width = $('input[name="co_topvisual_width"]:checked').val();
        var co_topvisual_bl = $('input[name="co_topvisual_bl"]').val();
        var co_topvisual_border = $('input[name="co_topvisual_border"]:checked').val();
        var co_topvisual_radius = $('input[name="co_topvisual_radius"]').val();
        var co_topvisual_m_color = $('input[name="co_topvisual_m_color"]').val();
        var co_topvisual_m_size = $('select[name="co_topvisual_m_size"]').val();
        var co_topvisual_m_font = $('select[name="co_topvisual_m_font"]').val();
        var co_topvisual_m_align = $('input[name="co_topvisual_m_align"]:checked').val();
        var co_topvisual_s_color = $('input[name="co_topvisual_s_color"]').val();
        var co_topvisual_s_size = $('select[name="co_topvisual_s_size"]').val();
        var co_topvisual_s_font = $('select[name="co_topvisual_s_font"]').val();
        var co_topvisual_s_align = $('input[name="co_topvisual_s_align"]:checked').val();

        var co_topvisual_bg_color = $('input[name="co_topvisual_bg_color"]').val();
        var co_topvisual_style_all = $('input[name="co_topvisual_style_all"]:checked').val();
        var v_code = $('#v_code').val();

        <?php } ?>

        var mod_type = '1';

        <?php if($is_admin) { ?>
        <?php } else { ?>
        alert('편집 권한이 없습니다.');
        return false;
        <?php } ?>

        // Ajax 요청 실행
        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.config_set.php', // Ajax 요청을 보낼 엔드포인트 URL
            method: 'POST', // 또는 'GET' 등의 HTTP 메서드
            dataType: 'json',
            data: {
                "co_color": co_color,
                "co_header": co_header,
                "co_main_bg": co_main_bg,
                "co_sub_bg": co_sub_bg,
                "co_font": co_font,
                "co_gap_pc": co_gap_pc,
                "co_gap_mo": co_gap_mo,
                "co_inner_padding_pc": co_inner_padding_pc,

                "co_layout_shop": co_layout_shop,
                "co_layout_hd_shop": co_layout_hd_shop,
                "co_layout_ft_shop": co_layout_ft_shop,

                "co_layout": co_layout,
                "co_layout_hd": co_layout_hd,
                "co_layout_ft": co_layout_ft,

                "co_sub_width": co_sub_width,
                "co_main_width": co_main_width,
                "co_tb_width": co_tb_width,

                "co_padding_top": co_padding_top,
                "co_padding_top_sub": co_padding_top_sub,
                "co_padding_top_shop": co_padding_top_shop,
                "co_padding_top_sub_shop": co_padding_top_sub_shop,

                "co_padding_btm": co_padding_btm,
                "co_padding_btm_sub": co_padding_btm_sub,
                "co_padding_btm_shop": co_padding_btm_shop,
                "co_padding_btm_sub_shop": co_padding_btm_sub_shop,

                "co_menu_shop": co_menu_shop,

                "co_side_skin": co_side_skin,
                "co_side_skin_shop": co_side_skin_shop,
                "co_sidemenu": co_sidemenu,
                "co_sidemenu_shop": co_sidemenu_shop,
                "co_sidemenu_width": co_sidemenu_width,
                "co_sidemenu_width_shop": co_sidemenu_width_shop,
                "co_sidemenu_padding": co_sidemenu_padding,
                "co_sidemenu_padding_shop": co_sidemenu_padding_shop,
                "co_sidemenu_hide": co_sidemenu_hide,
                "co_sidemenu_hide_shop": co_sidemenu_hide_shop,

                "mod_type": mod_type,
            },
            success: function(data) {
                if (data.status == 'ok') {

                    var colorValues = data.co_color.substring(1).toUpperCase(); // #제거 후 대문자로 변환 추가 2.1.4
                    var headerValues = data.co_header.substring(1).toUpperCase(); // #제거 후 대문자로 변환 추가 2.1.4

                    $('main').removeClass();
                    $('main').addClass('co_' + colorValues);
                    $('main').addClass(' co_header_' + headerValues);

                    // 새로운 파라미터 설정
                    var newColorSet = 'co_' + colorValues; // 예: co_6B4285
                    var newColorCode = data.co_color; // 원본 컬러 값 (#6b4285)

                    var newHeaderSet = 'co_header_' + headerValues; // 예: co_6B4285
                    var newHeaderCode = data.co_header; // 원본 컬러 값 (#6b4285)

                    if (data.co_sidemenu_hide == 1) {
                        $('#rb_sidemenu').addClass('pc');
                    } else {
                        $('#rb_sidemenu').removeClass('pc');
                    }

                    if (data.co_sidemenu_hide_shop == 1) {
                        $('#rb_sidemenu_shop').addClass('pc');
                    } else {
                        $('#rb_sidemenu_shop').removeClass('pc');
                    }

                    function isLightColor(hex) { //밝은계통인지, 어두운 계통인지 판단 함수
                        var r, g, b, a = 1; // 기본 알파 값

                        // 8자리 HEX (RGBA) 체크
                        if (hex.length === 9) {
                            r = parseInt(hex.slice(1, 3), 16);
                            g = parseInt(hex.slice(3, 5), 16);
                            b = parseInt(hex.slice(5, 7), 16);
                            a = parseInt(hex.slice(7, 9), 16) / 255; // 0~255를 0~1로 변환
                        } else {
                            r = parseInt(hex.slice(1, 3), 16);
                            g = parseInt(hex.slice(3, 5), 16);
                            b = parseInt(hex.slice(5, 7), 16);
                        }

                        var yiq = ((r * 299) + (g * 587) + (b * 114)) / 1000;
                        return {
                            isLight: yiq >= 210,
                            alpha: a
                        }; // 밝기와 알파 값을 반환

                    }

                    var colorInfo = isLightColor(data.co_header);

                    if (colorInfo.alpha < 0.2) {
                        var newTextCode = 'black'; // 투명도가 낮으면 회색
                    } else if (colorInfo.isLight) {
                        var newTextCode = 'black'; // 밝은색이면 검은색
                    } else {
                        var newTextCode = 'white'; // 어두운색이면 흰색
                    }

                    // 링크 태그의 href 속성 변경
                    $('link[href*="set.color.php"]').attr('href', '<?php echo G5_URL ?>/rb/rb.css/set.color.php?rb_color_set=' + newColorSet + '&rb_color_code=' + encodeURIComponent(newColorCode));
                    $('link[href*="set.header.php"]').attr('href', '<?php echo G5_URL ?>/rb/rb.css/set.header.php?rb_header_set=' + newHeaderSet + '&rb_header_code=' + encodeURIComponent(newHeaderCode) + '&rb_header_txt=' + newTextCode);

                    if (newTextCode == 'black') {
                        <?php if (isset($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w'])) { ?>
                        var newSrcset1 = "<?php echo G5_URL ?>/data/logos/mo?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } else { ?>
                        var newSrcset1 = "<?php echo G5_THEME_URL ?>/rb.img/logos/mo.png?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } ?>

                        <?php if (isset($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w'])) { ?>
                        var newSrcset2 = "<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } else { ?>
                        var newSrcset2 = "<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } ?>

                    } else {

                        <?php if (isset($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w'])) { ?>
                        var newSrcset1 = "<?php echo G5_URL ?>/data/logos/mo_w?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } else { ?>
                        var newSrcset1 = "<?php echo G5_THEME_URL ?>/rb.img/logos/mo_w.png?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } ?>

                        <?php if (isset($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w'])) { ?>
                        var newSrcset2 = "<?php echo G5_URL ?>/data/logos/pc_w?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } else { ?>
                        var newSrcset2 = "<?php echo G5_THEME_URL ?>/rb.img/logos/pc_w.png?ver=<?php echo G5_SERVER_TIME ?>";
                        <?php } ?>
                    }

                    $('#sourceSmall').attr('srcset', newSrcset1);
                    $('#sourceLarge').attr('srcset', newSrcset2);
                    $('#fallbackImage').attr('src', newSrcset2);

                    //console.log('강조컬러 설정:#'+ data.co_color);
                    //console.log('헤더 설정:header'+ data.co_header);
                    //console.log('메인 레이아웃 설정:'+ data.co_layout);
                    //console.log('헤더 레이아웃 설정:'+ data.co_layout_hd);
                    //console.log('풋터 레이아웃 설정:'+ data.co_layout_ft);
                    //console.log('폰트 설정:'+ data.co_font);
                    //console.log('서브 가로폭 설정:'+ data.co_sub_width);
                    //console.log('메인 가로폭 설정:'+ data.co_main_width);
                    //console.log('상단/하단 가로폭 설정:'+ data.co_tb_width);

                    location.reload();
                } else {
                    console.log('문제가 발생 했습니다. 다시 시도해주세요.');
                }
            },
            error: function(err) {
                alert('문제가 발생 했습니다. 다시 시도해주세요.');
            }
        });


        <?php if (!defined("_INDEX_")) { ?>
        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.topvisual_add.php', // Ajax 요청을 보낼 엔드포인트 URL
            method: 'POST', // 또는 'GET' 등의 HTTP 메서드
            dataType: 'json',
            data: {
                "co_topvisual_mt": co_topvisual_mt,
                "co_topvisual_height": co_topvisual_height,
                "co_topvisual_width": co_topvisual_width,
                "co_topvisual_bl": co_topvisual_bl,
                "co_topvisual_border": co_topvisual_border,
                "co_topvisual_radius": co_topvisual_radius,
                "co_topvisual_m_color": co_topvisual_m_color,
                "co_topvisual_m_size": co_topvisual_m_size,
                "co_topvisual_m_font": co_topvisual_m_font,
                "co_topvisual_m_align": co_topvisual_m_align,
                "co_topvisual_s_color": co_topvisual_s_color,
                "co_topvisual_s_size": co_topvisual_s_size,
                "co_topvisual_s_font": co_topvisual_s_font,
                "co_topvisual_s_align": co_topvisual_s_align,
                "co_topvisual_bg_color": co_topvisual_bg_color,
                "co_topvisual_style_all": co_topvisual_style_all,
                "v_code": v_code,
                "mod_type": mod_type,
            },
            success: function(data) {
                if (data.status == 'ok') {

                    if (data.co_topvisual_width == "100") {
                        $('#rb_topvisual').css('width', '100%');
                        $('#rb_topvisual').css('margin-top', '0');
                        $('#rb_topvisual').css('overflow', 'inherit');
                        $('.main_wording').css('padding-left', '0');
                        $('.main_wording').css('padding-right', '0');
                        $('.sub_wording').css('padding-left', '0');
                        $('.sub_wording').css('padding-right', '0');
                    } else {
                        $('#rb_topvisual').css('width', '<?php echo $rb_core['sub_width'] ?>px');
                        $('#rb_topvisual').css('margin-top', '50px');
                        $('#rb_topvisual').css('overflow', 'hidden');
                        $('.main_wording').css('padding-left', '50px');
                        $('.main_wording').css('padding-right', '50px');
                        $('.sub_wording').css('padding-left', '50px');
                        $('.sub_wording').css('padding-right', '50px');
                    }

                    if (data.co_topvisual_border == "0") {
                        $('.rb_topvisual').css('border', '0px');
                    } else if (data.co_topvisual_border == "1") {
                        $('.rb_topvisual').css('border', '1px dashed rgba(0,0,0,0.1)');
                    } else if (data.co_topvisual_border == "2") {
                        $('.rb_topvisual').css('border', '1px solid rgba(0,0,0,0.1)');
                    } else {
                        $('.rb_topvisual').css('border', '0px');
                    }


                    $('.rb_topvisual').css('background-color', data.co_topvisual_bg_color);

                    $('.main_wording').css('color', data.co_topvisual_m_color);
                    $('.main_wording').css('font-size', data.co_topvisual_m_size + 'px');
                    $('.main_wording').css('font-family', data.co_topvisual_m_font);
                    $('.main_wording').css('text-align', data.co_topvisual_m_align);

                    $('.sub_wording').css('color', data.co_topvisual_s_color);
                    $('.sub_wording').css('font-size', data.co_topvisual_s_size + 'px');
                    $('.sub_wording').css('font-family', data.co_topvisual_s_font);
                    $('.sub_wording').css('text-align', data.co_topvisual_s_align);

                } else {
                    console.log('변경실패');
                }
            },
            error: function(err) {
                alert('문제가 발생 했습니다. 다시 시도해주세요.');
            }
        });


        // 영역 숨기기
        const s_use = $('input[name="s_use"]:checked').val();
        const s_code = $('#s_code').val(); // ← #v_code → #s_code 로 수정

        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.subside_hide.php',
            type: 'POST',
            dataType: 'json',
            data: {
                s_code: s_code,
                s_use: s_use
            },
            success: function(data) {
                if (data.status === 'ok') {

                } else {
                    alert('오류 발생: ' + (data.message || '알 수 없는 오류'));
                }
            },
            error: function(xhr, status, error) {
                alert('서버 오류 발생: ' + error);
                console.error(xhr.responseText);
            }
        });


        <?php } ?>


    }

    // Ajax 실행 함수 정의 (섹션저장)
    function executeAjax_section() {

        if ($('input[name="sec_id"]').val()) {
            var sec_id = $('input[name="sec_id"]').val();
        } else {
            var sec_id = "new";
        }


        var sec_title = $('input[name="sec_title"]').val();
        var sec_layout = $('input[name="sec_layout"]').val();
        var sec_theme = $('input[name="sec_theme"]').val();

        <?php if(defined('_SHOP_')) { // 영카트?>
        var sec_layout_name = '<?php echo $rb_core['layout_shop'] ?>';
        <?php } else { ?>
        var sec_layout_name = '<?php echo $rb_core['layout'] ?>';
        <?php } ?>

        var sec_title_color = $('input[name="sec_title_color"]').val();
        var sec_title_size = $('input[name="sec_title_size"]').val();
        var sec_title_font = $('select[name="sec_title_font"]').val();
        var sec_title_align = $('select[name="sec_title_align"]').val();
        var sec_title_hide = $('input[name="sec_title_hide"]:checked').val();

        var sec_sub_title = $('textarea[name="sec_sub_title"]').val();
        var sec_sub_title_color = $('input[name="sec_sub_title_color"]').val();
        var sec_sub_title_size = $('input[name="sec_sub_title_size"]').val();
        var sec_sub_title_font = $('select[name="sec_sub_title_font"]').val();
        var sec_sub_title_align = $('select[name="sec_sub_title_align"]').val();
        var sec_sub_title_hide = $('input[name="sec_sub_title_hide"]:checked').val();

        var sec_width = $('input[name="sec_width"]').val();
        var sec_con_width = $('input[name="sec_con_width"]:checked').val();
        var sec_padding_pc = $('input[name="sec_padding_pc"]').val();
        var sec_padding_mo = $('input[name="sec_padding_mo"]').val();

        var sec_padding = $('input[name="sec_padding"]').val();
        var sec_padding_lr_pc = $('input[name="sec_padding_lr_pc"]').val();
        var sec_padding_lr_mo = $('input[name="sec_padding_lr_mo"]').val();
        var sec_padding_tb_pc = $('input[name="sec_padding_tb_pc"]').val();
        var sec_padding_tb_mo = $('input[name="sec_padding_tb_mo"]').val();

        var sec_margin_top_pc = $('input[name="sec_margin_top_pc"]').val();
        var sec_margin_top_mo = $('input[name="sec_margin_top_mo"]').val();
        var sec_margin_btm_pc = $('input[name="sec_margin_btm_pc"]').val();
        var sec_margin_btm_mo = $('input[name="sec_margin_btm_mo"]').val();

        // 여분필드가 필요한 경우 사용하세요. input 은 상황에 맞게 변경하세요.
        //var sec_1 = $('input[name="sec_1"]').val();
        //var sec_2 = $('input[name="sec_2"]').val();
        //var sec_3 = $('input[name="sec_3"]').val();
        //var sec_4 = $('input[name="sec_4"]').val();
        //var sec_5 = $('input[name="sec_5"]').val();
        //var sec_6 = $('input[name="sec_6"]').val();
        //var sec_7 = $('input[name="sec_7"]').val();
        //var sec_8 = $('input[name="sec_8"]').val();
        //var sec_9 = $('input[name="sec_9"]').val();
        //var sec_10 = $('input[name="sec_10"]').val();

        var sec_bg = $('input[name="sec_bg"]').val();

        if (sec_title == "") {
            alert('섹션 타이틀을 입력해주세요.\n타이틀은 숨김처리 하실 수 있습니다.');
            $('input[name="sec_title"]').focus();
            return false;
        } else if (sec_layout == "") {
            alert('레이아웃 정보가 없습니다. 레이아웃 파일을 확인해주세요.');
            return false;
        } else if (sec_theme == "") {
            alert('테마 정보가 없습니다. 테마 설정 후 이용해주세요.');
            return false;
        } else if (sec_layout_name == "") {
            alert('레이아웃 정보가 없습니다. 레이아웃을 먼저 설정해주세요.');
            return false;
        } else {


            <?php if($is_admin) { ?>
            <?php } else { ?>
            alert('편집 권한이 없습니다.');
            return false;
            <?php } ?>

            // Ajax 요청 실행
            $.ajax({
                url: '<?php echo G5_URL ?>/rb/rb.config/ajax.section_set.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    <?php if(defined('_SHOP_')) { // 영카트?> "is_shop": "1",
                    <?php } else { ?> "is_shop": "0",
                    <?php } ?>

                    "sec_title": sec_title,
                    "sec_layout": sec_layout,
                    "sec_layout_name": sec_layout_name,
                    "sec_theme": sec_theme,
                    "sec_id": sec_id,

                    "sec_title_color": sec_title_color,
                    "sec_title_size": sec_title_size,
                    "sec_title_font": sec_title_font,
                    "sec_title_align": sec_title_align,
                    "sec_title_hide": sec_title_hide,

                    "sec_sub_title": sec_sub_title,
                    "sec_sub_title_color": sec_sub_title_color,
                    "sec_sub_title_size": sec_sub_title_size,
                    "sec_sub_title_font": sec_sub_title_font,
                    "sec_sub_title_align": sec_sub_title_align,
                    "sec_sub_title_hide": sec_sub_title_hide,

                    "sec_width": sec_width,
                    "sec_con_width": sec_con_width,
                    "sec_padding_pc": sec_padding_pc,
                    "sec_padding_mo": sec_padding_mo,

                    "sec_padding": sec_padding,
                    "sec_padding_lr_pc": sec_padding_lr_pc,
                    "sec_padding_lr_mo": sec_padding_lr_mo,
                    "sec_padding_tb_pc": sec_padding_tb_pc,
                    "sec_padding_tb_mo": sec_padding_tb_mo,

                    "sec_margin_top_pc": sec_margin_top_pc,
                    "sec_margin_top_mo": sec_margin_top_mo,
                    "sec_margin_btm_pc": sec_margin_btm_pc,
                    "sec_margin_btm_mo": sec_margin_btm_mo,

                    // 여분필드가 필요한 경우 사용하세요. input 은 상황에 맞게 변경하세요.
                    //"sec_1": sec_1,
                    //"sec_2": sec_2,
                    //"sec_3": sec_3,
                    //"sec_4": sec_4,
                    //"sec_5": sec_5,
                    //"sec_6": sec_6,
                    //"sec_7": sec_7,
                    //"sec_8": sec_8,
                    //"sec_9": sec_9,
                    //"sec_10": sec_10,

                    "sec_bg": sec_bg
                },


                success: function(data) {
                    if (data.status == 'ok') {
                        console.log('섹션저장:' + data.md_title);
                        location.reload();

                    } else {
                        console.log('변경실패');
                    }
                },
                error: function(err) {
                    alert('문제가 발생 했습니다. 다시 시도해주세요.');
                }

            });

        }
    }


    // Ajax 실행 함수 정의 (섹션삭제)
    function executeAjax_section_del() {


        var sec_id = $('input[name="sec_id"]').val();
        var sec_layout = $('input[name="sec_layout"]').val();
        var sec_theme = $('input[name="sec_theme"]').val();
        <?php if(defined('_SHOP_')) { // 영카트?>
        var sec_layout_name = '<?php echo $rb_core['layout_shop'] ?>';
        <?php } else { ?>
        var sec_layout_name = '<?php echo $rb_core['layout'] ?>';
        <?php } ?>
        var del = 'true';

        // 현재 화면의 해당 섹션 엘리먼트에서 sec_uid 추출
        var $secEl = $('.rb_section_box').filter(function() {
            return String($(this).data('id')) === String(sec_id);
        }).first();
        var sec_uid = $secEl.data('sec-uid') || '';

        if (sec_id == "") {
            alert('섹션 ID정보가 없습니다. 다시 시도해주세요.');
            return false;
        } else {

            <?php if($is_admin) { ?>
            <?php } else { ?>
            alert('편집 권한이 없습니다.');
            return false;
            <?php } ?>


            // Ajax 요청 실행
            $.ajax({
                url: '<?php echo G5_URL ?>/rb/rb.config/ajax.section_set.php', // Ajax 요청을 보낼 엔드포인트 URL
                method: 'POST',
                dataType: 'json',
                data: {
                    "sec_id": sec_id,
                    "sec_layout": sec_layout,
                    "sec_theme": sec_theme,
                    "sec_layout_name": sec_layout_name,
                    "del": del,
                    "sec_uid": sec_uid,
                    <?php if(defined('_SHOP_')) { // 영카트?> "is_shop": "1",
                    <?php } else { ?> "is_shop": "0",
                    <?php } ?>
                },
                success: function(data) {
                    if (data.status == 'ok') {
                        location.reload();
                    } else {
                        console.log('변경실패');
                    }
                },
                error: function(err) {
                    alert('문제가 발생 했습니다. 다시 시도해주세요.');
                }
            });

        }
    }


    // Ajax 실행 함수 정의 (모듈저장)
    function executeAjax_module() {

        if ($('input[name="md_id"]').val()) {
            var md_id = $('input[name="md_id"]').val();
        } else {
            var md_id = "new";
        }

        var md_type = $('select[name="md_type"]').val();

        var md_title = $('input[name="md_title"]').val();
        var md_title_color = $('input[name="md_title_color"]').val();
        var md_title_size = $('input[name="md_title_size"]').val();
        var md_title_font = $('select[name="md_title_font"]').val();
        var md_title_hide = $('input[name="md_title_hide"]:checked').val();
        var md_layout = $('input[name="md_layout"]').val();
        var md_theme = $('input[name="md_theme"]').val();

        var md_sec_key = $('input[name="md_sec_key"]').val();
        var md_sec_uid = $('input[name="md_sec_uid"]').val();

        if (md_type == "item") {
            var md_skin = $('#md_skin_shop').val();
            var md_sca = $('#md_sca_shop').val();
        } else {
            var md_skin = $('#md_skin').val();
            var md_sca = $('#md_sca').val();
        }

        var md_bo_table = $('select[name="md_bo_table"]').val();
        var md_notice = $('input[name="md_notice"]:checked').val();
        var md_widget = $('select[name="md_widget"]').val();
        var md_banner = $('select[name="md_banner"]').val();
        var md_banner_id = $('select[name="md_banner_id"]').val();
        var md_banner_bg = $('input[name="md_banner_bg"]').val();
        var md_banner_skin = $('select[name="md_banner_skin"]').val();
        var md_poll = $('select[name="md_poll"]').val();
        var md_poll_id = $('select[name="md_poll_id"]').val();

        var md_soldout_hidden = $('input[name="md_soldout_hidden"]:checked').val();
        var md_soldout_asc = $('input[name="md_soldout_asc"]:checked').val();

        <?php if(defined('_SHOP_')) { // 영카트?>
        var layout_name = '<?php echo $rb_core['layout_shop'] ?>';
        <?php } else { ?>
        var layout_name = '<?php echo $rb_core['layout'] ?>';
        <?php } ?>

        // 일괄설정 항목
        var md_cb_batch = $('input[name="md_cb_batch"]').val();
        var md_border_batch = $('input[name="md_border_batch"]').val();
        var md_shadow_batch = $('input[name="md_shadow_batch"]').val();
        var md_margin_batch = $('input[name="md_margin_batch"]').val();
        var md_padding_batch = $('input[name="md_padding_batch"]').val();

        var md_wide_is = $('input[name="md_wide_is"]:checked').val();
        var md_border = $('input[name="md_border"]:checked').val();
        var md_border_width = $('input[name="md_border_width"]').val();
        var md_border_color = $('input[name="md_border_color"]').val();
        var md_box_shadow = $('input[name="md_box_shadow"]:checked').val();
        var md_box_shadow_w = $('input[name="md_box_shadow_w"]').val();
        var md_box_shadow_c = $('input[name="md_box_shadow_c"]').val();
        var md_radius = $('#md_radius').val();
        var md_padding = $('#md_padding').val();
        var md_padding_lr_pc = $('#md_padding_lr_pc').val();
        var md_padding_lr_mo = $('#md_padding_lr_mo').val();
        var md_padding_tb_pc = $('#md_padding_tb_pc').val();
        var md_padding_tb_mo = $('#md_padding_tb_mo').val();

        var md_margin_top_pc = $('#md_margin_top_pc').val();
        var md_margin_top_mo = $('#md_margin_top_mo').val();
        var md_margin_btm_pc = $('#md_margin_btm_pc').val();
        var md_margin_btm_mo = $('#md_margin_btm_mo').val();

        if (md_type == "item" || md_type == "item_tab") {
            var md_cnt = $('#md_cnt_shop').val();
            var md_col = $('#md_col_shop').val();
            var md_row = $('#md_row_shop').val();
            var md_col_mo = $('#md_col_mo_shop').val();
            var md_row_mo = $('#md_row_mo_shop').val();
            var md_arrow_type = $('input[name="md_arrow_type_shop"]:checked').val();
        } else {
            var md_cnt = $('#md_cnt').val();
            var md_col = $('#md_col').val();
            var md_row = $('#md_row').val();
            var md_col_mo = $('#md_col_mo').val();
            var md_row_mo = $('#md_row_mo').val();
            var md_arrow_type = $('input[name="md_arrow_type"]:checked').val();
        }

        var md_width = $('input[name="md_width"]').val();
        var md_height = $('input[name="md_height"]').val();
        var md_size = $('input[name="md_size"]:checked').val();
        var md_show = $('input[name="md_show"]:checked').val();
        var md_level = $('select[name="md_level"]').val();
        var md_level_is = $('select[name="md_level_is"]').val();

        if (md_type == "item" || md_type == "item_tab") {
            var md_subject_is = $('#md_subject_is_shop:checked').val();
            var md_thumb_is = $('#md_thumb_is_shop:checked').val();
            var md_nick_is = $('#md_nick_is_shop:checked').val();
            var md_date_is = $('#md_date_is_shop:checked').val();
            var md_comment_is = $('#md_comment_is_shop:checked').val();
            var md_content_is = $('#md_content_is_shop:checked').val();
            var md_icon_is = $('#md_icon_is_shop:checked').val();
            var md_ca_is = $('#md_ca_is_shop:checked').val();
            var md_gap = $('#md_gap_shop').val();
            var md_gap_mo = $('#md_gap_mo_shop').val();
            var md_swiper_is = $('#md_swiper_is_shop:checked').val();
            var md_auto_is = $('#md_auto_is_shop:checked').val();
            var md_auto_time = $('#md_auto_time_shop').val();
        } else {
            var md_subject_is = $('#md_subject_is:checked').val();
            var md_thumb_is = $('#md_thumb_is:checked').val();
            var md_nick_is = $('#md_nick_is:checked').val();
            var md_date_is = $('#md_date_is:checked').val();
            var md_comment_is = $('#md_comment_is:checked').val();
            var md_content_is = $('#md_content_is:checked').val();
            var md_icon_is = $('#md_icon_is:checked').val();
            var md_ca_is = $('#md_ca_is:checked').val();
            var md_gap = $('#md_gap').val();
            var md_gap_mo = $('#md_gap_mo').val();
            var md_swiper_is = $('#md_swiper_is:checked').val();
            var md_auto_is = $('#md_auto_is:checked').val();
            var md_auto_time = $('#md_auto_time').val();
        }


        var md_module = $('select[name="md_module"]').val();
        var md_order = $('select[name="md_order"]').val();
        var md_order_latest = $('select[name="md_order_latest"]').val();
        var md_order_banner = $('select[name="md_order_banner"]').val();

        var md_tab_list = $('input[name="md_tab_list"]').val();
        var md_tab_skin = $('select[name="md_tab_skin"]').val();

        var md_item_tab_list = $('input[name="md_item_tab_list"]').val();
        var md_item_tab_skin = $('select[name="md_item_tab_skin"]').val();

        // 여분필드가 필요한 경우 사용하세요. input 은 상황에 맞게 변경하세요.
        //var md_1 = $('input[name="md_1"]').val();
        //var md_2 = $('input[name="md_2"]').val();
        //var md_3 = $('input[name="md_3"]').val();
        //var md_4 = $('input[name="md_4"]').val();
        //var md_5 = $('input[name="md_5"]').val();
        //var md_6 = $('input[name="md_6"]').val();
        //var md_7 = $('input[name="md_7"]').val();
        //var md_8 = $('input[name="md_8"]').val();
        //var md_9 = $('input[name="md_9"]').val();
        //var md_10 = $('input[name="md_10"]').val();


        if (md_title == "") {
            alert('모듈 타이틀을 입력해주세요.');
            $('input[name="md_title"]').focus();
            return false;
        } else if (md_layout == "") {
            alert('레이아웃 정보가 없습니다. 레이아웃 파일을 확인해주세요.');
            return false;
        } else if (md_theme == "") {
            alert('테마 정보가 없습니다. 테마 설정 후 이용해주세요.');
            return false;
        } else if (layout_name == "") {
            alert('레이아웃 정보가 없습니다. 레이아웃을 먼저 설정해주세요.');
            return false;
        } else if (md_type == "") {
            alert('출력 타입을 선택해주세요.');
            $('select[name="md_type"]').focus();
            return false;
        } else if (md_type == "latest" && md_skin == "") {
            alert('최신글 스킨을 선택해주세요.');
            $('#md_skin').focus();
            return false;
        } else if (md_type == "latest" && md_bo_table == "") {
            alert('연결할 게시판을 선택해주세요.');
            $('select[name="md_bo_table"]').focus();
            return false;
        } else if (md_type == "latest" && md_cnt < 1) {
            alert('게시물 출력개수를 입력해주세요.');
            $('#md_cnt').focus();
            return false;
        } else if (md_type == "latest" && md_col < 1 || md_type == "latest" && md_row < 1 || md_type == "latest" && md_col_mo < 1 || md_type == "latest" && md_row_mo < 1) {
            alert('게시물 출력(열X행) 옵션을 설정해주세요.');
            return false;
        } else if (md_type == "tab" && md_tab_list == "" || md_type == "tab" && md_tab_list == "[]") {
            alert('탭으로 출력할 게시판 또는 카테고리를 선택해주세요.');
            $('select[name="md_bo_table_tab"]').focus();
            return false;
        } else if (md_type == "item_tab" && md_item_tab_list == "" || md_type == "item_tab" && md_item_tab_list == "[]") {
            alert('상품탭의 분류는 최소 2개이상 선택해주세요.');
            $('select[name="md_sca_shop"]').focus();
            return false;
        } else if (md_type == "tab" && md_tab_skin == "") {
            alert('최신글 탭 스킨을 선택해주세요.');
            $('#md_tab_skin').focus();
            return false;
        } else if (md_type == "widget" && md_widget == "") {
            alert('출력 위젯을 선택해주세요.');
            $('select[name="md_widget"]').focus();
            return false;
        } else if (md_type == "banner" && md_banner == "") {
            alert('출력할 배너그룹을 선택해주세요.');
            $('select[name="md_banner"]').focus();
            return false;
        } else if (md_type == "banner" && md_banner_skin == "") {
            alert('배너 스킨을 선택해주세요.');
            $('select[name="md_banner_skin"]').focus();
            return false;
        } else if (md_type == "poll" && md_poll == "") {
            alert('투표 스킨을 선택해주세요.');
            $('select[name="md_poll"]').focus();
            return false;
        } else if (md_type == "item" && md_module == "" || md_type == "item_tab" && md_module == "") {
            alert('상품 타입을 선택해주세요.');
            $('#md_module_shop').focus();
            return false;
        } else if (md_type == "item" && md_order == "" || md_type == "item_tab" && md_order == "") {
            alert('상품 출력옵션을 선택해주세요.');
            $('#md_order_shop').focus();
            return false;
        } else if (md_type == "latest" && md_order_latest == "" || md_type == "tab" && md_order_latest == "") {
            alert('게시물 출력옵션을 선택해주세요.');
            $('#md_order_latest').focus();
            return false;
        } else if (md_type == "banner" && md_order_banner == "") {
            alert('배너 출력옵션을 선택해주세요.');
            $('#md_order_banner').focus();
            return false;
        } else if (md_type == "item" && md_cnt < 1 || md_type == "item_tab" && md_cnt < 1) {
            alert('상품 출력개수를 입력해주세요.');
            $('#md_cnt_shop').focus();
            return false;
        } else if (md_type == "item" && md_col < 1 || md_type == "item" && md_row < 1 || md_type == "item" && md_col_mo < 1 || md_type == "item" && md_row_mo < 1) {
            alert('상품 출력(열X행) 옵션을 설정해주세요.');
            return false;
        } else if (md_type == "item_tab" && md_col < 1 || md_type == "item_tab" && md_row < 1 || md_type == "item_tab" && md_col_mo < 1 || md_type == "item_tab" && md_row_mo < 1) {
            alert('상품 출력(열X행) 옵션을 설정해주세요.');
            return false;
        } else if (md_type == "item" && md_skin == "") {
            alert('출력 스킨을 선택해주세요.');
            $('#md_skin_shop').focus();
            return false;
        } else if (md_type == "item_tab" && md_item_tab_skin == "") {
            alert('출력 스킨을 선택해주세요.');
            $('#md_item_tab_skin').focus();
            return false;
        } else {


            <?php if($is_admin) { ?>
            <?php } else { ?>
            alert('편집 권한이 없습니다.');
            return false;
            <?php } ?>

            // Ajax 요청 실행
            $.ajax({
                url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_set.php', // Ajax 요청을 보낼 엔드포인트 URL
                method: 'POST',
                dataType: 'json',
                data: {
                    <?php if(defined('_SHOP_')) { // 영카트?> "is_shop": "1",
                    <?php } else { ?> "is_shop": "0",
                    <?php } ?> "md_id": md_id,
                    "md_title": md_title,
                    "md_title_color": md_title_color,
                    "md_title_size": md_title_size,
                    "md_title_font": md_title_font,
                    "md_title_hide": md_title_hide,
                    "md_layout": md_layout,
                    "md_skin": md_skin,
                    "md_tab_list": md_tab_list,
                    "md_tab_skin": md_tab_skin,
                    "md_item_tab_list": md_item_tab_list,
                    "md_item_tab_skin": md_item_tab_skin,
                    "md_type": md_type,
                    "md_bo_table": md_bo_table,
                    "md_notice": md_notice,
                    "md_wide_is": md_wide_is,
                    "md_arrow_type": md_arrow_type,
                    "md_sca": md_sca,
                    "md_widget": md_widget,
                    "md_banner": md_banner,
                    "md_banner_id": md_banner_id,
                    "md_banner_bg": md_banner_bg,
                    "md_banner_skin": md_banner_skin,
                    "md_poll": md_poll,
                    "md_poll_id": md_poll_id,
                    "md_theme": md_theme,
                    "md_sec_key": md_sec_key,
                    "md_sec_uid": md_sec_uid,
                    "md_layout_name": layout_name,
                    "md_cnt": md_cnt,
                    "md_col": md_col,
                    "md_row": md_row,
                    "md_col_mo": md_col_mo,
                    "md_row_mo": md_row_mo,
                    "md_width": md_width,
                    "md_height": md_height,
                    "md_size": md_size,
                    "md_show": md_show,
                    "md_level": md_level,
                    "md_level_is": md_level_is,
                    "md_subject_is": md_subject_is,
                    "md_thumb_is": md_thumb_is,
                    "md_nick_is": md_nick_is,
                    "md_date_is": md_date_is,
                    "md_comment_is": md_comment_is,
                    "md_content_is": md_content_is,
                    "md_icon_is": md_icon_is,
                    "md_ca_is": md_ca_is,
                    "md_gap": md_gap,
                    "md_gap_mo": md_gap_mo,
                    "md_swiper_is": md_swiper_is,
                    "md_auto_is": md_auto_is,
                    "md_auto_time": md_auto_time,
                    "md_border": md_border,
                    "md_border_width": md_border_width,
                    "md_border_color": md_border_color,
                    "md_box_shadow": md_box_shadow,
                    "md_box_shadow_w": md_box_shadow_w,
                    "md_box_shadow_c": md_box_shadow_c,
                    "md_radius": md_radius,
                    "md_module": md_module,
                    "md_padding": md_padding,
                    "md_padding_lr_pc": md_padding_lr_pc,
                    "md_padding_lr_mo": md_padding_lr_mo,
                    "md_padding_tb_pc": md_padding_tb_pc,
                    "md_padding_tb_mo": md_padding_tb_mo,
                    "md_margin_top_pc": md_margin_top_pc,
                    "md_margin_top_mo": md_margin_top_mo,
                    "md_margin_btm_pc": md_margin_btm_pc,
                    "md_margin_btm_mo": md_margin_btm_mo,
                    "md_order": md_order,
                    "md_order_latest": md_order_latest,
                    "md_order_banner": md_order_banner,
                    "md_soldout_hidden": md_soldout_hidden,
                    "md_soldout_asc": md_soldout_asc,
                    "md_cb_batch": md_cb_batch,
                    "md_border_batch": md_border_batch,
                    "md_shadow_batch": md_shadow_batch,
                    "md_margin_batch": md_margin_batch,
                    "md_padding_batch": md_padding_batch,
                    // 여분필드가 필요한 경우 사용하세요. input 은 상황에 맞게 변경하세요.
                    //"md_1": md_1,
                    //"md_2": md_2,
                    //"md_3": md_3,
                    //"md_4": md_4,
                    //"md_5": md_5,
                    //"md_6": md_6,
                    //"md_7": md_7,
                    //"md_8": md_8,
                    //"md_9": md_9,
                    //"md_10": md_10,
                },


                success: function(data) {
                    if (data.status == 'ok') {
                        console.log('모듈저장:' + data.md_title);
                        //alert(data.md_title + ' 모듈이 저장 되었습니다.');
                        location.reload();

                    } else {
                        console.log('변경실패');
                    }
                },
                error: function(err) {
                    alert('문제가 발생 했습니다. 다시 시도해주세요.');
                }

            });

        }
    }


    // Ajax 실행 함수 정의 (모듈삭제)
    function executeAjax_module_del() {


        var md_id = $('input[name="md_id"]').val();
        var md_layout = $('input[name="md_layout"]').val();
        var md_theme = $('input[name="md_theme"]').val();
        <?php if(defined('_SHOP_')) { // 영카트?>
        var layout_name = '<?php echo $rb_core['layout_shop'] ?>';
        <?php } else { ?>
        var layout_name = '<?php echo $rb_core['layout'] ?>';
        <?php } ?>
        var del = 'true';

        if (md_id == "") {
            alert('모듈 ID정보가 없습니다. 다시 시도해주세요.');
            return false;
        } else {

            <?php if($is_admin) { ?>
            <?php } else { ?>
            alert('편집 권한이 없습니다.');
            return false;
            <?php } ?>


            // Ajax 요청 실행
            $.ajax({
                url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_set.php', // Ajax 요청을 보낼 엔드포인트 URL
                method: 'POST',
                dataType: 'json',
                data: {
                    "md_id": md_id,
                    "md_layout": md_layout,
                    "md_theme": md_theme,
                    "md_layout_name": layout_name,
                    "del": del,
                    <?php if(defined('_SHOP_')) { // 영카트?> "is_shop": "1",
                    <?php } else { ?> "is_shop": "0",
                    <?php } ?>
                },
                success: function(data) {
                    if (data.status == 'ok') {
                        location.reload();
                    } else {
                        console.log('변경실패');
                    }
                },
                error: function(err) {
                    alert('문제가 발생 했습니다. 다시 시도해주세요.');
                }
            });

        }
    }


    const RB_FOLDER_RE_CREATE = /^(?!\.)(?!.*\.\.)[A-Za-z0-9_-]+$/; // 생성: 점 불가
    const RB_FOLDER_RE_ANY = /^(?!\.)(?!.*\.\.)[A-Za-z0-9_.-]+$/; // 편집/읽기: 점 허용


    // 엔터를 <br>로만 강제
    $('#rb-css-editor').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.execCommand('insertHTML', false, '<br>\n');
        }
    });

    // 붙여넣기: 항상 텍스트만, 줄바꿈은 <br>로
    $('#rb-css-editor').on('paste', function(e) {
        e.preventDefault();

        // 1) 클립보드에서 순수 텍스트만 꺼내기
        var text = '';
        var clipboardData = (e.originalEvent && e.originalEvent.clipboardData) || window.clipboardData;
        if (clipboardData) {
            text = clipboardData.getData('text/plain') || '';
        }

        // 2) 개행 정규화 → \n
        text = String(text).replace(/\r\n?/g, '\n');

        // 3) HTML 이스케이프 (혹시라도 <, > 등 들어오면 태그로 안 보이게)
        var safe = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');

        // 4) \n → <br> 로 변환해서 현재 커서 위치에 삽입
        var html = safe.replace(/\n/g, '<br>');

        // execCommand는 여전히 contenteditable에서 잘 동작 (레인지 API로 바꿔도 OK)
        document.execCommand('insertHTML', false, html);
    });

    // 혹시 드래그&드롭으로 HTML 던져넣는 경우도 텍스트만
    $('#rb-css-editor').on('drop', function(e) {
        e.preventDefault();
        var dt = e.originalEvent && e.originalEvent.dataTransfer;
        var text = (dt && (dt.getData('text/plain') || dt.getData('Text'))) || '';
        text = String(text).replace(/\r\n?/g, '\n');
        var safe = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
        var html = safe.replace(/\n/g, '<br>');
        document.execCommand('insertHTML', false, html);
    });

    $(document).on('keydown', '#rb-css-editor[contenteditable="true"]', function(e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            document.execCommand('insertText', false, '    ');
        }
    });


    function escClass(c) {
        if (window.CSS && CSS.escape) return '.' + CSS.escape(c);
        return '.' + String(c).replace(/[^a-zA-Z0-9_-]/g, '\\$&');
    }

    function escId(id) {
        if (window.CSS && CSS.escape) return '#' + CSS.escape(id);
        return '#' + String(id).replace(/[^a-zA-Z0-9_-]/g, '\\$&');
    }

    function setEditorText($el, text) {
        var node = $el.get(0);
        if (!node) return;
        if ((node.tagName || '').toLowerCase() === 'textarea') $el.val(text);
        else node.textContent = text;
    }





    // 역슬래시 따옴표 정리 (혹시라도 섞여 들어왔을 때 보정)
    function normalizeQuotes(str) {
        return String(str).replace(/\\"/g, '"').replace(/\\'/g, "'");
    }

    // 저장된 CSS를 먼저 불러오되, 없으면 fallbackFn 실행
    function tryLoadExistingCSS(opts, $editor, fallbackFn) {
        var endpoint = g5_url + '/rb/rb.config/ajax.custom_css_load.php';
        var expectedUrl = buildCssFileUrl(opts);

        $.get(endpoint, {
            sec_id: opts.sec_id || '',
            sec_layout: opts.sec_layout || '',
            md_id: opts.md_id || '',
            md_layout: opts.md_layout || '',
            <?php if (defined('_SHOP_')) { ?>is_shop: '1'
            <?php } else { ?>is_shop: '0'
            <?php } ?>
        }).done(function(res) {
            var data;
            try {
                data = (typeof res === 'string') ? JSON.parse(res) : res;
            } catch (e) {
                data = null;
            }

            if (data && data.status === 'ok' && data.css) {
                setEditorFromCss(normalizeQuotes(data.css)); // 에디터 채움
                fileInfoShow(expectedUrl); // 파일 라벨 표시
            } else {
                // 파일 없음 → 템플릿 생성 + 라벨 제거
                fileInfoClear(); // 라벨 제거
                fallbackFn();
            }
        }).fail(function() {
            // 에러 → 템플릿 생성 + 라벨 제거
            fileInfoClear(); // 라벨 제거
            fallbackFn();
        });
    }

    function isSwiperDynamic(el) {
        var cls = (el.className || '').toString();
        var id = (el.id || '').toString();
        var tokens = cls.split(/\s+/).filter(Boolean).concat(id ? [id] : []);

        var deny = new Set([
            'swiper', 'swiper-container', 'swiper-container-initialized',
            'swiper-wrapper', 'rb-swiper-wrapper', 'rb_swiper_inner',
            'swiper-slide', 'rb-swiper-slide',
            'swiper-button-prev', 'swiper-button-next',
            'rb-swiper-prev', 'rb-swiper-next',
            'swiper-pagination', 'swiper-scrollbar', 'swiper-notification',
            'rb_swiper'
        ]);
        return tokens.some(function(t) {
            t = String(t).toLowerCase();
            if (deny.has(t)) return true;
            return (
                /^rb[-_]?swiper/i.test(t) ||
                /^swiper(-(container|wrapper|slide|button|pagination|scrollbar))/i.test(t)
            );
        });
    }

    // 마지막 클래스만 사용해서 길이 줄이기
    function buildOwnSelector(el) {
        var tag = (el.tagName || '').toLowerCase();
        if (!tag) return '';

        if (el.id) return tag + escId(el.id);

        var cls = (el.className && typeof el.className === 'string') ? el.className.trim() : '';
        if (!cls) return tag;

        var classes = cls.split(/\s+/).filter(Boolean);
        if (classes.length) {
            return tag + escClass(classes[classes.length - 1]); // 마지막 클래스만
        }
        return tag;
    }

    function buildParentSelector(el) {
        var p = el.parentElement;
        if (!p) return '';
        var tag = (p.tagName || '').toLowerCase();
        if (!tag) return '';

        if (p.id) return tag + escId(p.id);

        var cls = (p.className && typeof p.className === 'string') ? p.className.trim() : '';
        if (!cls) return tag;

        var classes = cls.split(/\s+/).filter(Boolean);
        if (classes.length) {
            return tag + escClass(classes[classes.length - 1]); // 마지막 클래스만
        }
        return tag;
    }

    function ensureFileInfo() {
        var $fi = $('#rb-css-fileinfo');
        if (!$fi.length) $fi = $('<div id="rb-css-fileinfo"></div>').appendTo('.rb-sh-side-css');
        return $fi;
    }

    function showWidgetPath(folder) {
        ensureFileInfo().html(
            '파일위치 : /rb/rb.widget/' + folder + '/widget.php'
        );
    }

    function clearWidgetPath() {
        ensureFileInfo().empty();
    }


    // 전역 컨텍스트
    window.rbCssCtx = {
        kind: null,
        layout: '',
        id: '',
        is_shop: '0'
    };

    // 공통: 컨텍스트 세팅
    function setRbCssCtx(kind, layout, id, isShop) {
        window.rbCssCtx = {
            kind: String(kind || ''),
            layout: String(layout || ''),
            id: String(id || ''),
            is_shop: String(isShop != null ? isShop : '0')
        };
    }


    // ============================= 섹션 =============================
    function edit_css_sec_open(arg1, arg2) {

        rbRestoreCssSaveBtn(); // 복구
        rbRestoreTopTit(); // 복구

        var $reset = $('#css_reset_btn');
        if ($reset.attr('data-hidden-by') === 'widget') {
            $reset.removeAttr('data-hidden-by').show();
        }

        $('.rb-sh-side-css')
            .css('transition', 'all 600ms cubic-bezier(0.86,0,0.07,1)')
            .addClass('open');

        var sec_layout, sec_id;

        // 버튼 element로 받은 경우
        if (arg1 && arg1.nodeType === 1) {
            sec_layout = $(arg1).data('layout');
            sec_id = $(arg1).data('id');
        } else {
            // 직접 값으로 받은 경우 (edit_css_sec_open('L1','S123'))
            sec_layout = arg1 || $('input[name="sec_layout"]').val();
            sec_id = arg2 || $('input[name="sec_id"]').val();
        }

        setRbCssCtx('sec', sec_layout, sec_id, isShop);

        // is_shop 판별 (엘리먼트에 data-shop 있으면 우선, 없으면 PHP 상수로 주입)
        var isShop = (arg1 && arg1.nodeType === 1 && $(arg1).attr('data-shop') != null) ?
            String($(arg1).attr('data-shop')) :
            (<?php if (defined('_SHOP_')) { ?> '1'
                <?php } else { ?> '0'
                <?php } ?>);

        // 타깃 요소에 data-shop 보강(누락 대비)
        $('.rb_section_box[data-layout="' + sec_layout + '"][data-id="' + sec_id + '"]').each(function() {
            if (!this.hasAttribute('data-shop')) this.setAttribute('data-shop', isShop);
        });

        // data-shop 포함한 최종 루트 셀렉터
        var rootSel = '.rb_section_box' +
            '[data-layout="' + sec_layout + '"]' +
            '[data-id="' + sec_id + '"]' +
            '[data-shop="' + isShop + '"]';

        var $rootScope = $(rootSel);
        var $editor = $('#rb-css-editor, #rb-css-edit-wrap').first();

        if (!$rootScope.length) {
            setEditorText($editor, '섹션을 찾을 수 없습니다: ' + rootSel);
            return;
        }

        // 불러오기에도 is_shop 같이 전송 (파일명 `_shop` 규칙과 일치)
        tryLoadExistingCSS({
            sec_layout: sec_layout,
            sec_id: sec_id,
            is_shop: isShop
        }, $editor, function templateBuild() {
            var seen = new Set();

            $rootScope.find('*')
                .not('.add_module_wrap, .add_module_wrap *')
                .not('.add_section_wrap, .add_section_wrap *')
                .not('br, script, style, noscript, link, meta, title, head')
                .each(function() {
                    if (isSwiperDynamic(this)) return;

                    var own = buildOwnSelector(this);
                    if (!own) return;

                    var parentSel = buildParentSelector(this);
                    var line = parentSel ?
                        (rootSel + ' ' + parentSel + ' > ' + own + ' {}') :
                        (rootSel + ' ' + own + ' {}');

                    if (!seen.has(line)) seen.add(line);
                });

            var lines = Array.from(seen).sort();
            var header = '';
            setEditorText(
                $editor,
                lines.length ? header + lines.join('\n') + '\n' :
                header + '/* 템플릿 생성: 요소 없음 */\n'
            );

            fileInfoClear(); // 파일 없으니 라벨 제거
        });
    }

    // ============================= 모듈 =============================
    function edit_css_mod_open(arg1, arg2) {

        lib_close();
        rbRestoreCssSaveBtn(); // 복구
        rbRestoreTopTit(); // 복구

        var $reset = $('#css_reset_btn');
        if ($reset.attr('data-hidden-by') === 'widget') {
            $reset.removeAttr('data-hidden-by').show();
        }

        $('.rb-sh-side-css').css('transition', 'all 600ms cubic-bezier(0.86,0,0.07,1)').addClass('open');

        var md_layout, md_id;

        if (arg1 && arg1.nodeType === 1) {
            md_layout = $(arg1).data('layout');
            md_id = $(arg1).data('id');
        } else {
            md_layout = arg1 || $('input[name="md_layout"]').val();
            md_id = arg2 || $('input[name="md_id"]').val();
        }

        setRbCssCtx('mod', md_layout, md_id, isShop);

        var isShop = (arg1 && arg1.nodeType === 1 && $(arg1).attr('data-shop') != null) ?
            String($(arg1).attr('data-shop')) :
            (<?php if (defined('_SHOP_')) { ?> '1'
                <?php } else { ?> '0'
                <?php } ?>);

        $('.rb_layout_box[data-layout="' + md_layout + '"][data-id="' + md_id + '"]').each(function() {
            if (!this.hasAttribute('data-shop')) this.setAttribute('data-shop', isShop);
        });

        var rootSel = '.rb_layout_box' +
            '[data-layout="' + md_layout + '"]' +
            '[data-id="' + md_id + '"]' +
            '[data-shop="' + isShop + '"]' +
            ' .content_box';
        var $rootScope = $(rootSel);
        var $editor = $('#rb-css-editor, #rb-css-edit-wrap').first();

        if (!$rootScope.length) {
            setEditorText($editor, '모듈을 찾을 수 없습니다: ' + rootSel);
            return;
        }

        tryLoadExistingCSS({
            md_layout,
            md_id,
            is_shop: isShop
        }, $editor, function templateBuild() {
            var seen = new Set();

            $rootScope.find('*')
                .not('.add_module_wrap, .add_module_wrap *')
                .not('.add_section_wrap, .add_section_wrap *')
                .not('br, script, style, noscript, link, meta, title, head')
                .each(function() {
                    if (isSwiperDynamic(this)) return;

                    var own = buildOwnSelector(this);
                    if (!own) return;

                    var parentSel = buildParentSelector(this);
                    var line = parentSel ?
                        (rootSel + ' ' + parentSel + ' > ' + own + ' {}') :
                        (rootSel + ' ' + own + ' {}');

                    if (!seen.has(line)) seen.add(line);
                });

            var lines = Array.from(seen).sort();
            var header = '';
            setEditorText($editor, lines.length ? header + lines.join('\n') + '\n' :
                header + '/* 템플릿 생성: 요소 없음 */\n');
        });
    }

    function openLibPanel() {
        edit_css_close();
        var $panel = $('.rb-sh-side-lib');
        $panel.css('transition', 'all 600ms cubic-bezier(0.86,0,0.07,1)').addClass('open');
        $('#rbLibTypeFilter').val('');
        if (typeof rb_lib_list_reload === 'function') rb_lib_list_reload();
        return false; // 버튼이 폼 안에 있어도 submit 방지
    }

    function rbNormalizeSerialized(val) {
        if (typeof val !== 'string') return val;

        // 케이스1: \&quot;  -> "
        var out = val.replace(/\\&quot;/g, '"');

        // 케이스2: &quot;   -> "
        out = out.replace(/&quot;/g, '"');

        // 케이스3: \"     -> "
        out = out.replace(/\\"/g, '"');

        // 불필요한 백슬래시가 남는 케이스 최소화 (예: \\")
        out = out.replace(/\\\\/g, '\\');

        // 값이 JSON 배열/객체 문자열이면 파싱했다가 다시 원본형식으로 되돌림
        // (input hidden에는 사람이 읽기 쉬운 ["a","b"] 형태로 넣고 싶을 때)
        if (/^\s*\[.*\]\s*$/.test(out) || /^\s*\{.*\}\s*$/.test(out)) {
            try {
                var parsed = JSON.parse(out);
                // 다시 사람이 보는 문자열로   ex) ["gallery||일반","..."]
                out = JSON.stringify(parsed);
            } catch (e) {
                // 파싱 실패 시 out 그대로 사용
            }
        }
        return out;
    }


    function norm(s) {
        return String(s || '').trim().toLowerCase();
    }

    $(document).on('change', '#rbLibTypeFilter', function() {
        renderRbLibListFiltered();
    });

    function renderRbLibListFiltered() {
        var $wrap = $('.rb-lib-st-list');
        if (!$wrap.length) return;

        var sel = norm($('#rbLibTypeFilter').val()); // '' = 전체
        $wrap.empty();

        (window._rb_preset_rows || []).forEach(function(row) {
            var t = norm(row.md_type); // DB의 md_type 값 그대로
            if (sel && sel !== t) return; // 선택값과 다르면 스킵 (정확 일치)

            var dateTxt = row.created_at ? row.created_at.replace(/-/g, '.').slice(0, 16) : '';
            var moTxt = row.is_mobile_only == '1' ? 'Mobile전용' : '';
            var wTxt = row.width_text || '';

            var $ul = $('<ul>').attr('data-lib-id', row.lib_id).addClass('rb-lib-item');
            $ul.append(
                '<li class="rb-lib-st-list-tit">' +
                '<span class="font-R cut">' + (row.title || '(제목없음)') + '</span>' +
                '<button type="button" class="lib_del_btn" style="float:right;font-size:12px;padding:2px 6px;">삭제</button>' +
                '</li>'
            );

            var optHtml = [];
            if (row.md_type) optHtml.push('<span class="opt_names">' + row.md_type + '</span>'); // ← 그대로 노출
            if (wTxt) optHtml.push('<span>' + wTxt + '</span>');
            if (moTxt) optHtml.push('<span>' + moTxt + '</span>');
            $ul.append('<li class="rb-lib-st-list-opt">' + optHtml.join(' ') + '</li>');
            $ul.append('<li class="rb-lib-st-list-date">' + dateTxt + '</li>');

            $ul.on('click', function(e) {
                if ($(e.target).closest('.lib_del_btn').length) return;
                rb_lib_apply($(this).data('lib-id'));
            });
            $ul.find('.lib_del_btn').on('click', function(e) {
                e.stopPropagation();
                var lib_id = $(this).closest('.rb-lib-item').data('lib-id');
                rb_lib_delete(lib_id);
            });

            $wrap.append($ul);
        });
    }



    // 최근에 받아온 rows 캐시
    window._rb_preset_rows = [];



    function renderRbLibListFiltered() {
        var $wrap = $('.rb-lib-st-list');
        if (!$wrap.length) return;

        var sel = ($('.rb-lib-st-top .select_tiny').val() || '').trim();
        $wrap.empty();

        (window._rb_preset_rows || []).forEach(function(row) {
            if (!rbMatchesFilter(sel, row.md_type)) return; // 여기만 바꿈

            var dateTxt = row.created_at ? row.created_at.replace(/-/g, '.').slice(0, 16) : '';

            const v = String(row?.md_show ?? '').trim().toLowerCase();
            const moTxt = (v === '') ? '공용' : (v === 'mobile') ? 'Mobile' : (v === 'pc') ? 'PC' : '공용';

            var wTxt = row.width_text || '';

            var $ul = $('<ul>').attr('data-lib-id', row.lib_id).addClass('rb-lib-item');

            $ul.append(
                '<li class="rb-lib-st-list-tit">' +
                '<span class="font-R cut">' + (row.title || '(제목없음)') + '</span>' +
                '<button type="button" class="lib_del_btn" style="float:right;font-size:12px;padding:2px 6px;">삭제</button>' +
                '</li>'
            );

            var optHtml = [];
            if (row.md_type) optHtml.push('<span class="opt_names">' + row.md_type + '</span>');
            if (wTxt) optHtml.push('<span>' + wTxt + '</span>');
            if (moTxt) optHtml.push('<span>' + moTxt + '</span>');
            $ul.append('<li class="rb-lib-st-list-opt">' + optHtml.join(' ') + '</li>');
            $ul.append('<li class="rb-lib-st-list-date">' + dateTxt + '</li>');

            $ul.on('click', function(e) {
                if ($(e.target).closest('.lib_del_btn').length) return;
                rb_lib_apply($(this).data('lib-id'));
            });
            $ul.find('.lib_del_btn').on('click', function(e) {
                e.stopPropagation();
                var lib_id = $(this).closest('.rb-lib-item').data('lib-id');
                rb_lib_delete(lib_id);
            });

            $wrap.append($ul);
        });
    }


    function saveAjax() {
        var data = {};
        // meta
        data.csrf = window.RB_WIDGET_CSRF || '';
        <?php if (defined('_SHOP_')) { ?>
        data.is_shop = '1';
        <?php } else { ?>
        data.is_shop = '0';
        <?php } ?>
        data.md_theme = $('input[name="md_theme"]').val() || '';
        data.md_layout = $('input[name="md_layout"]').val() || '';
        data.md_size = $('input[name="md_size"]:checked').val() || (data.md_size || '%');
        data.md_width = $('input[name="md_width"]').val() || (data.md_width || '100');
        data.md_height = $('input[name="md_height"]').val() || (data.md_height || 'auto');

        var $title = $('input[name="md_title"]');
        var $type = $('select[name="md_type"]');
        var mdTitle = ($title.val() || '').trim();
        var mdType = ($type.val() || '').trim();

        if (!mdTitle) {
            alert('모듈 타이틀을 입력해주세요.');
            $title.focus();
            return; // 전송 중단
        }
        if (!mdType) {
            alert('출력 타입을 선택해주세요.');
            $type.focus();
            return; // 전송 중단
        }

        // collect md_*
        $(document).find('input[name^="md_"], select[name^="md_"], textarea[name^="md_"]').each(function() {
            var t = (this.type || this.tagName).toLowerCase();
            if (t === 'file') return;
            var name = this.name;
            var key = name.replace(/\[\]$/, '');

            // 제외 목록
            if (key === 'md_id' || key === 'md_sec_key' || key === 'md_sec_uid' || key === 'md_layout') return;

            if (this.type === 'checkbox') {
                var $same = $(document).find('[name="' + name + '"]');
                if ($same.length > 1) {
                    var arr = [];
                    $same.each(function() {
                        if ($(this).is(':checked')) arr.push($(this).val());
                    });
                    data[key] = arr;
                    if (arr.length && arr.every(v => v === '1')) data[key] = '1';
                } else {
                    data[key] = $(this).is(':checked') ? '1' : '0';
                }
                return;
            }
            if (this.type === 'radio') {
                if ($(this).is(':checked')) data[key] = $(this).val();
                return;
            }
            if (this.tagName.toLowerCase() === 'select' && $(this).prop('multiple')) {
                data[key] = $(this).val() || [];
                return;
            }
            data[key] = $(this).val();
        });

        // 안전 보강(혹시라도 남아있으면 제거)
        delete data.md_id;
        delete data.md_sec_key;
        delete data.md_sec_uid;
        // md_layout는 프리셋 기준 필터로도 쓰이므로 제거하지 않음

        // is_shop, csrf, md_theme, md_layout 보강
        var extra = {
            action: 'save',
            csrf: (window.RB_WIDGET_CSRF || ''),
            <?php if (defined('_SHOP_')) { ?>
            is_shop: '1',
            <?php } else { ?>
            is_shop: '0',
            <?php } ?>
            md_theme: $('input[name="md_theme"]').val() || ''
        };

        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_lib.php',
            type: 'POST',
            dataType: 'json',
            data: $.extend({}, data, extra)
        }).done(function(res) {
            if (res && res.status === 'ok') {
                $('.rb-sh-side-lib').css('transition', 'all 600ms cubic-bezier(0.86,0,0.07,1)').addClass('open');
                if (typeof rb_lib_list_reload === 'function') rb_lib_list_reload();
                alert('설정을 라이브러리에 저장했습니다.');
            } else {
                alert((res && res.msg) ? res.msg : '저장 실패');
            }
        }).fail(function(xhr) {
            alert('서버 오류: ' + xhr.status);
        });
    }

    function lib_close() {
        $('.rb-sh-side-lib').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.rb-sh-side-lib').removeClass('open');
    }


    //닫기
    function edit_css_close() {
        $('.rb-sh-side-css').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.rb-sh-side-css').removeClass('open');
    }

    function edit_css_close_none() {
        $('.rb-sh-side-css').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.rb-sh-side-css').removeClass('open');
    }

    // HTML 특수문자 이스케이프
    function escHTML(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
    }



    function setEditorFromCss(cssText) {
        cssText = String(cssText).replace(/\r\n?/g, '\n');
        var html = escHTML(cssText).replace(/\n/g, '<br>');
        $('#rb-css-editor').html(html);
    }

    // (B) 에디터(contenteditable)의 내용을 "순수 CSS 텍스트"로 회수 (줄바꿈 보존)
    function getEditorCss() {
        var $ed = $('#rb-css-editor');
        var html = $ed.html() || '';

        // 블록 경계/BR -> \n
        html = html
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/<\/(p|div)>\s*<(p|div)[^>]*>/gi, '\n') // </div><div>
            .replace(/<\/(p|div)>/gi, '\n') // 끝 블록 -> \n
            .replace(/<(p|div)[^>]*>/gi, ''); // 여는 블록 제거

        // 모든 태그 제거
        html = html.replace(/<[^>]+>/g, '');

        // HTML 엔티티 디코드
        var ta = document.createElement('textarea');
        ta.innerHTML = html;
        var css = ta.value;

        // 개행 정규화 + 마지막 개행 보장
        css = css.replace(/\r\n?/g, '\n').replace(/\s+$/, '') + '\n';
        return css;
    }

    function fileInfoShow(url) {
        var $fi = ensureFileInfo().show();
        if (!url) {
            $fi.text('저장된 파일이 없습니다.');
            return;
        }
        var path = String(url).replace(/^https?:\/\/[^/]+/i, '');
        $fi.text('파일위치 : ' + path);
    }

    function fileInfoClear() {
        ensureFileInfo().show().text('저장된 파일이 없습니다.');
    }

    // 페이지 진입 시 혹시 정적으로 박혀 있던거 있으면 제거
    $(function() {
        fileInfoClear();
    });

    function buildCssFileUrl(opts) {
        var base = g5_url + '/data/rb_custom_css/';

        function slug(s) {
            return String(s).replace(/[^A-Za-z0-9_-]/g, '-');
        }

        var isShop =
            (opts && typeof opts.is_shop !== 'undefined') ? String(opts.is_shop) :
            (window.rbCssCtx && window.rbCssCtx.is_shop) ? String(window.rbCssCtx.is_shop) :
            '0';
        var suf = (isShop === '1') ? '_shop' : '';

        if (opts && opts.md_layout && opts.md_id)
            return base + 'mod' + suf + '_' + slug(opts.md_layout) + '_' + slug(opts.md_id) + '.css';
        if (opts && opts.sec_layout && opts.sec_id)
            return base + 'sec' + suf + '_' + slug(opts.sec_layout) + '_' + slug(opts.sec_id) + '.css';

        return '';
    }

    function loadSavedCssToEditor(fileUrl) {
        $.get(fileUrl + '?v=' + Date.now())
            .done(function(text) {
                var data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    data = null;
                }

                if (data && data.status === 'none') {
                    fileInfoClear();
                    setEditorFromCss('');
                    return;
                }
                // 파일 있음
                fileInfoShow(fileUrl);
                setEditorFromCss(text);
            })
            .fail(function() {
                fileInfoClear();
            });
    }

    // 저장 클릭
    $('#css_save_btn').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const cssCode = getEditorCss();
        const ctx = window.rbCssCtx || {};

        // 컨텍스트 우선, 없으면 기존 인풋 폴백
        const sec_id = (ctx.kind === 'sec') ? ctx.id : ($('input[name="sec_id"]').val() || '');
        const sec_layout = (ctx.kind === 'sec') ? ctx.layout : ($('input[name="sec_layout"]').val() || '');
        const md_id = (ctx.kind === 'mod') ? ctx.id : ($('input[name="md_id"]').val() || '');
        const md_layout = (ctx.kind === 'mod') ? ctx.layout : ($('input[name="md_layout"]').val() || '');

        const endpoint = g5_url + '/rb/rb.config/ajax.custom_css_save.php';

        $.post(endpoint, {
                css_code: cssCode,
                sec_id,
                sec_layout,
                md_id,
                md_layout,
                csrf: window.RB_WIDGET_CSRF,
                <?php if (defined('_SHOP_')) { ?>is_shop: '1'
                <?php } else { ?>is_shop: '0'
                <?php } ?>
            })
            .done(function(res) {
                let data = res;
                if (typeof res === 'string') {
                    try {
                        data = JSON.parse(res);
                    } catch (_) {}
                }

                if (data && data.status === 'ok') {
                    if (data.file_url && data.link_id) {
                        const id = data.link_id;
                        const href = data.file_url + '?v=' + Date.now();
                        const $lnk = $('#' + id);
                        if ($lnk.length) $lnk.attr('href', href);
                        else $('head').append('<link id="' + id + '" rel="stylesheet" href="' + href + '">');

                        // 저장 직후 에디터에 최신 CSS 반영
                        loadSavedCssToEditor(data.file_url);
                    }
                    alert('커스텀 CSS가 저장 및 반영 되었습니다');
                } else {
                    alert('저장 실패: ' + (data && data.message ? data.message : '응답 오류'));
                }
            })
            .fail(function(xhr) {
                alert('서버 오류: ' + xhr.status);
            });

        return false;
    });


    $('#css_reset_btn').on('click', function() {
        rb_confirm("생성된 CSS파일이 있는경우 삭제되며 초기 내용으로 원복됩니다. 계속 하시겠습니까? ")
            .then(function(confirmed) {
                if (!confirmed) return;

                const ctx = window.rbCssCtx || {};

                const sec_id = (ctx.kind === 'sec') ? ctx.id : ($('input[name="sec_id"]').val() || '');
                const sec_layout = (ctx.kind === 'sec') ? ctx.layout : ($('input[name="sec_layout"]').val() || '');
                const md_id = (ctx.kind === 'mod') ? ctx.id : ($('input[name="md_id"]').val() || '');
                const md_layout = (ctx.kind === 'mod') ? ctx.layout : ($('input[name="md_layout"]').val() || '');

                $.post(g5_url + '/rb/rb.config/ajax.custom_css_delete.php', {
                    sec_id,
                    sec_layout,
                    md_id,
                    md_layout,
                    <?php if (defined('_SHOP_')) { ?>is_shop: '1'
                    <?php } else { ?>is_shop: '0'
                    <?php } ?>
                }).done(function(res) {
                    let data = res;
                    if (typeof res === 'string') {
                        try {
                            data = JSON.parse(res);
                        } catch (_) {}
                    }

                    if (data && data.status === 'ok') {
                        fileInfoClear(); // 라벨 제거

                        if (data.existed === false) {
                            alert('생성된 CSS파일이 없습니다.');
                            return;
                        }

                        alert('CSS 파일이 삭제되고 초기화 되었습니다.');

                        // 컨텍스트 기준으로 다시 열기 (버튼 없이도 값 전달 가능)
                        if (ctx.kind === 'sec' && sec_id && sec_layout) {
                            edit_css_sec_open(sec_layout, sec_id);
                        } else if (ctx.kind === 'mod' && md_id && md_layout) {
                            edit_css_mod_open(md_layout, md_id);
                        }
                    } else {
                        alert('초기화 실패: ' + (data && data.message ? data.message : '응답 오류'));
                    }
                }).fail(function(xhr) {
                    alert('서버 오류: ' + xhr.status);
                });
            });
    });


    function initCssSidebarResizer() {
        var $panel = $('.rb-sh-side-css');
        if (!$panel.length) return;

        // 핸들 없으면 생성 (좌측 가장자리)
        if (!$panel.children('.rb-css-resizer').length) {
            $('<div class="rb-css-resizer" aria-hidden="true"></div>').prependTo($panel);
        }

        // 최소/최대 폭
        var MIN_W = 450; // px
        var MAX_W = 1280; // px

        // 핸들/패널 스타일 주입
        $panel.css({
            position: 'fixed'
        }); // 보통 right:0 로 쓰고 있을 것임(기존 CSS 유지)
        $panel.find('.rb-css-resizer').css({
            position: 'absolute',
            left: 0,
            top: 0,
            width: '4px',
            height: '100%',
            cursor: 'col-resize',
            'z-index': '998',
            'background': '#3b3e41'
        });

        var dragging = false;
        var startX = 0;
        var startW = 0;

        function onMouseMove(e) {
            if (!dragging) return;
            // 좌측 가장자리를 끌기 때문에, 마우스를 왼쪽으로 이동하면 폭이 증가
            var delta = startX - e.pageX;
            var newW = Math.max(MIN_W, Math.min(MAX_W, startW + delta));
            // 드래그 중에는 transition 비활성화 → 버벅임 방지
            $panel.css({
                transition: 'none',
                width: newW + 'px'
            });
        }

        function onMouseUp() {
            if (!dragging) return;
            dragging = false;
            $(document).off('mousemove', onMouseMove).off('mouseup', onMouseUp);
            $('body').css('user-select', '');
            // 드래그 끝 → 원래 transition 복구 (필요 시)
            $panel.css('transition', 'all 600ms cubic-bezier(0.86,0,0.07,1)');
        }

        $panel.on('mousedown', '.rb-css-resizer', function(e) {
            e.preventDefault();
            dragging = true;
            startX = e.pageX;
            startW = $panel.outerWidth(); // 현재 폭 기준
            $('body').css('user-select', 'none');
            // 드래그 중엔 트랜지션 해제
            $panel.css('transition', 'none');
            $(document).on('mousemove', onMouseMove).on('mouseup', onMouseUp);
        });
    }



    // 저장 버튼 원본을 보관/복구하기 위한 변수
    var __rb_savedCssBtn = null;

    function rbSwitchToWidgetSaveBtn() {
        var $old = $('#css_save_btn');
        if (!$old.length) return $('<button type="button" id="widget_save_btn" class="main_rb_bg">생성</button>').appendTo('.rb-sh-side-css-top-btn');
        __rb_savedCssBtn = $old.clone(true, true);
        var $new = $('<button type="button" id="widget_save_btn" class="main_rb_bg">생성</button>');
        $old.replaceWith($new);
        return $new;
    }

    function rbRestoreCssSaveBtn() {
        var $cur = $('#widget_save_btn');
        if ($cur.length && __rb_savedCssBtn) $cur.replaceWith(__rb_savedCssBtn);
        __rb_savedCssBtn = null;
    }

    function rbRestoreTopTit() {
        var $tit = $('.rb-sh-side-css-top-tit');
        var orig = $tit.data('orig-html');
        if (orig != null) {
            $tit.html(orig);
            $tit.removeData('orig-html');
        }
    }


    function rbGetEditorPlain() {
        var $ed = $('#rb-css-editor');
        if (!$ed.length) return '';
        var html = ($ed.html() || '')
            .replace(/\r\n?/g, '\n')
            .replace(/<br\s*\/?>/gi, '\n')
            .replace(/<\/(div|p|li|h[1-6])>/gi, '\n')
            .replace(/<[^>]+>/g, '')
            .replace(/&nbsp;/g, ' ');
        var ta = document.createElement('textarea');
        ta.innerHTML = html;
        return ta.value.replace(/\u00a0/g, ' ');
    }

    function rbSetEditorPlain(text) {
        $('#rb-css-editor').text(String(text || ''));
    }


    function rbEditorIsEmpty() {
        const el = document.getElementById('rb-css-editor');
        if (!el) return true;
        // 공백/개행/<br>만 있는 경우도 비어있는 것으로 간주
        const html = el.innerHTML.replace(/<br\s*\/?>/gi, '').replace(/\s+/g, '');
        return html.length === 0;
    }

    function rbSetEditorPlaceholder(text) {
        const $ed = $('#rb-css-editor');
        if (!$ed.length) return;
        $ed.attr('data-ph', text || '');
        if (rbEditorIsEmpty()) $ed.empty(); // :empty 상태로 만들어 placeholder가 보이게
    }

    function rbClearEditorPlaceholder() {
        $('#rb-css-editor').removeAttr('data-ph');
    }

    (function bindEditorPhEvents() {
        const $ed = $('#rb-css-editor');
        if (!$ed.length) return;
        $ed.off('.ph') // 중복바인딩 방지
            .on('input.ph keyup.ph paste.ph', function() {
                // 비어있으면 :empty가 되도록 불필요한 <br> 제거
                if (rbEditorIsEmpty()) $(this).empty();
            })
            .on('blur.ph', function() {
                if (rbEditorIsEmpty()) $(this).empty(); // 블러 시 다시 비면 플레이스홀더 보이게
            });
    })();


    function add_widget_mod_open(btn, selectedValue) {

        rbRestoreCssSaveBtn(); // 복구
        rbRestoreTopTit(); // 복구

        var $reset = $('#css_reset_btn');
        if ($reset.is(':visible')) $reset.attr('data-hidden-by', 'widget');
        $reset.hide();

        var $panel = $('.rb-sh-side-css');
        $panel.css('transition', 'all 600ms cubic-bezier(0.86,0,0.07,1)').addClass('open');

        // 선택값 파싱: "rb.widget/폴더명" → folder
        var folderMatched = null;
        if (selectedValue && typeof selectedValue === 'string') {
            var m = selectedValue.match(/^rb\.widget\/([^\/]+)$/);
            folderMatched = m ? m[1] : null;
        }
        var isEdit = !!folderMatched;

        // Top 타이틀 영역 교체(ul 안에 li로)
        var $tit = $panel.find('.rb-sh-side-css-top-tit');
        if (!$tit.length) {
            $tit = $('<ul class="rb-sh-side-css-top-tit"></ul>').prependTo($panel.find('.rb-sh-side-css-top-wrap'));
        }
        if (!$tit.data('orig-html')) $tit.data('orig-html', $tit.html());

        if (!$('#rb-widget-ui').length) {
            var ui =
                '<li id="rb-widget-ui">' +
                '  <div class="rb-widget-row">' +
                '    <input type="text" id="rb-widget-folder" placeholder="폴더명 (영문, 숫자, -, _)" />' +
                '  </div>' +
                '</li>';
            $tit.html(ui);
        }

        // 폴더 인풋 상태 설정
        var $folder = $('#rb-widget-folder');
        if (isEdit) {
            rbClearEditorPlaceholder();
            $folder.val(folderMatched).prop({
                    readonly: true,
                    disabled: true
                })
                .css({
                    opacity: '0.4',
                    cursor: 'not-allowed'
                });
            showWidgetPath(folderMatched);
        } else {
            rbSetEditorPlain('');
            rbSetEditorPlaceholder(
                "생성하실 위젯의 폴더명을 먼저 입력하신 후\n" +
                "여기에 코드를 입력하세요."
            );
            $folder.val('').prop({
                    readonly: false,
                    disabled: false
                })
                .css({
                    opacity: '1',
                    cursor: 'text'
                });
            clearWidgetPath();
        }


        // 생성모드에서만 블러 체크 (점 허용 안 함)
        $('#rb-widget-folder').off('blur.widget');
        if (!isEdit) {
            $('#rb-widget-folder').on('blur.widget', function() {
                var $inp = $(this);
                var folder = ($inp.val() || '').trim();

                if (!folder) {
                    clearWidgetPath();
                    return;
                }
                if (!RB_FOLDER_RE_CREATE.test(folder)) { // ⬅️ 생성 규칙 적용
                    alert('폴더명은 영문, 숫자, 하이픈(-), 언더스코어(_)만 허용됩니다.');
                    $inp.val('').focus();
                    clearWidgetPath();
                    return;
                }

                $.getJSON(g5_url + '/rb/rb.config/ajax.widget_check.php', {
                        folder
                    })
                    .done(function(res) {
                        if (res && res.ok && res.exists) {
                            alert('이미 같은 폴더가 존재합니다: ' + folder);
                            $inp.val('').focus();
                            clearWidgetPath();
                        } else {
                            showWidgetPath(folder);
                        }
                    });
            });
        }

        // 버튼 교체 및 라벨
        var $btn = rbSwitchToWidgetSaveBtn();
        $btn.text(isEdit ? '저장' : '생성');

        // 에디터 내용: 편집모드면 서버에서 로드, 생성모드는 비움
        if (isEdit) {
            $.ajax({
                url: g5_url + '/rb/rb.config/ajax.widget_load.php',
                type: 'GET',
                dataType: 'json',
                cache: false,
                data: {
                    folder: folderMatched,
                    csrf: window.RB_WIDGET_CSRF,
                    <?php if (defined('_SHOP_')) { ?> is_shop: '1'
                    <?php } else { ?> is_shop: '0'
                    <?php } ?>
                }
            }).done(function(res) {
                if (res && res.ok) {
                    rbSetEditorPlain(res.code || '');
                } else {
                    rbSetEditorPlain('');
                    alert('위젯 파일을 불러오지 못했습니다.');
                }
            }).fail(function() {
                rbSetEditorPlain('');
                alert('불러오기 오류');
            });
        } else {
            rbSetEditorPlain('');
        }

        // 생성/저장 클릭
        $btn.off('click.widget').on('click.widget', function(e) {
            e.preventDefault();

            // 현재 인풋이 disabled면 편집모드로 본다
            var $folderInp = $('#rb-widget-folder');
            var nowEdit = $folderInp.is(':disabled');

            var folder = isEdit ? folderMatched : (($('#rb-widget-folder').val() || '').trim());
            if (!folder) {
                alert('폴더명을 입력하세요.');
                return;
            }

            if (!isEdit && !RB_FOLDER_RE_CREATE.test(folder)) {
                alert('폴더명은 영문, 숫자, 하이픈(-), 언더스코어(_)만 허용됩니다.');
                return;
            }

            var code = rbGetEditorPlain();
            if (!code) {
                alert('코드가 비었습니다.');
                return;
            }

            $.ajax({
                url: g5_url + '/rb/rb.config/ajax.widget_save.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    folder: folder,
                    overwrite: isEdit ? '1' : '0', // 편집=항상 덮어쓰기, 생성=신규만
                    code: code,
                    csrf: window.RB_WIDGET_CSRF,
                    <?php if (defined('_SHOP_')) { ?> is_shop: '1'
                    <?php } else { ?> is_shop: '0'
                    <?php } ?>
                }
            }).done(function(res) {
                if (res && res.ok) {
                    alert((nowEdit ? '저장' : '생성') + '되었습니다.\n' + (res.path || ''));

                    // 생성 직후 → 곧바로 편집모드로 전환
                    if (!nowEdit) {
                        // 셀렉트 갱신 및 선택
                        refreshWidgetSelect('rb.widget/' + folder);

                        // 폴더 인풋 잠금 + 버튼 텍스트 변경
                        $folderInp.prop({
                                readonly: true,
                                disabled: true
                            })
                            .css({
                                background: '#f3f3f3',
                                cursor: 'not-allowed',
                                color: '#666'
                            });
                        $btn.text('저장');
                        showWidgetPath(folder);
                    }
                } else {
                    alert('실패: ' + (res && res.msg ? res.msg : 'unknown'));
                }
            }).fail(function(xhr) {
                alert('저장 중 오류가 발생했습니다.');
                console.error(xhr && xhr.responseText);
            });
        });
    }

    function refreshWidgetSelect(selectedValue) {
        var $sels = $('select[name="md_widget"]');
        if (!$sels.length) return;

        $.ajax({
            url: g5_url + '/rb/rb.config/ajax.widget_list.php',
            type: 'GET',
            dataType: 'html',
            cache: false,
            data: {
                md_widget: selectedValue || '',
                _t: Date.now() // 캐시 방지
            }
        }).done(function(html) {
            $sels.each(function() {
                var $sel = $(this);
                // 맨 앞 placeholder 보관
                var firstOpt = $sel.find('option').first();
                var placeholder = firstOpt.length ? firstOpt.prop('outerHTML') :
                    '<option value="">출력할 위젯을 선택하세요.</option>';

                // 옵션 교체 (placeholder + 서버에서 내려준 옵션)
                $sel.html(placeholder + html);

                // 선택값 강제 지정(선택값이 있으면)
                if (selectedValue) {
                    $sel.val(selectedValue);
                }

                // 의존 UI 갱신 필요 시
                $sel.trigger('change');
            });
        }).fail(function(xhr) {
            console.error('refreshWidgetSelect failed', xhr && xhr.responseText);
        });
    }


    // 문서 로드 시 리사이저 초기화
    $(function() {
        initCssSidebarResizer();
    });
</script>
<script>
    function drawTabsFromHidden() {
        var $inp = $('#md_tab_list');
        if (!$inp.length) return;

        var raw = String($inp.val() || '').trim()
            .replace(/\\&quot;/g, '"')
            .replace(/&quot;/g, '"');

        if (!raw) {
            $('#tab_selects').empty();
            return;
        }

        var s = String(raw).trim().replace(/\\&quot;/g, '"').replace(/&quot;/g, '"');
        if (!(s.startsWith('[') && s.endsWith(']'))) return;

        var list;
        try {
            list = JSON.parse(s);
        } catch (e) {
            console.warn('md_tab_list JSON 파싱 실패:', e, raw);
            return;
        }

        var $wrap = $('#tab_selects').empty();
        list.forEach(function(item) {
            var parts = String(item).split('||');
            var bo = parts[0];
            var ca = parts[1] || '';
            var $opt = $('select[name="md_bo_table_tab"] option[value="' + bo + '"]');
            var boText = $opt.length ? $opt.text().trim() : bo;
            var caText = ca ? ca : '전체';
            $wrap.append(
                '<span class="tag" data-key="' + item + '">' +
                boText + ' / ' + caText +
                '<button type="button" class="tag-remove" title="삭제">×</button></span>'
            );
        });

        // 불러온 리스트를 기존 로직이 쓰는 selectedData에 반영 (핵심)
        if (typeof selectedData === 'undefined') window.selectedData = [];
        selectedData = list.slice();
    }


    window.itemSelectedData = window.itemSelectedData || [];

    // 기존 addItemTag 그대로 사용
    function addItemTag(value, text) {
        text = text || $('#md_sca_shop option').filter(function() {
            return String($(this).val()).trim() === String(value).trim();
        }).first().text().trim() || String(value);

        const tagHtml = `
    <span class="item-tag" data-key="${value}">
      ${text}
      <button type="button" class="item-tag-remove" title="삭제">×</button>
    </span>`;
        $('#item_tab_selects').append(tagHtml);
    }

    function drawItemTabsFromHidden() {
        var $inp = $('#md_item_tab_list');
        if (!$inp.length) return;

        var raw = String($inp.val() || '').trim()
            .replace(/\\&quot;/g, '"')
            .replace(/&quot;/g, '"');
        var $wrap = $('#item_tab_selects').empty();

        if (!raw) {
            itemSelectedData = [];
            return; // hidden은 여기서 건드리지 않음
        }

        var s = String(raw).trim().replace(/\\&quot;/g, '"').replace(/&quot;/g, '"');
        if (!(s.startsWith('[') && s.endsWith(']'))) return;

        var list;
        try {
            list = JSON.parse(s); // ex) [1020,1010,"1030"]
            if (!Array.isArray(list)) throw new Error('not array');
        } catch (e) {
            console.warn('md_item_tab_list JSON 파싱 실패:', e, raw);
            return;
        }

        // 상태 재구성 + 태그는 addItemTag로 (항상 분류명 표기)
        itemSelectedData = [];
        list.forEach(function(v) {
            var key = String(v).trim();
            if (!key) return;
            itemSelectedData.push(key);

            // 분류명 확보 후 넘김 (옵션 없으면 addItemTag가 value로 임시표기)
            var label = $('#md_sca_shop option').filter(function() {
                return String($(this).val()).trim() === key;
            }).first().text().trim();

            addItemTag(key, label);
        });

        // select는 마지막 값으로
        $('#md_sca_shop').val(itemSelectedData[itemSelectedData.length - 1] || '');
        // hidden 갱신은 기존 updateItemHiddenField() 흐름에 맡기기
    }


    function rb_syncSlidersFromHidden() {
        // 공통 헬퍼: 값 파싱 + 슬라이더/핸들 동기화
        function syncIntSlider(inputSel, sliderSel) {
            var v = parseInt($(inputSel).val() || '0', 10);
            if (isNaN(v)) v = 0;

            var $slider = $(sliderSel);
            if ($slider.data('ui-slider')) {
                $slider.slider('value', v);
                $slider.find('.ui-slider-handle').text(v);
            }
        }

        // radius, padding 단일 키만 사용
        syncIntSlider('#md_radius', '#md_radius_range');
        syncIntSlider('#md_padding', '#md_padding_range');
        syncIntSlider('#md_border_width', '#md_border_width_range');
    }


    if (typeof rb_lib_list_reload !== 'function') {
        function rb_lib_list_reload() {
            var md_theme = $('input[name="md_theme"]').val() || '';

            $.ajax({
                url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_lib.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    action: 'list',
                    csrf: window.RB_WIDGET_CSRF,
                    <?php if (defined('_SHOP_')) { ?>
                    is_shop: '1',
                    <?php } else { ?>
                    is_shop: '0',
                    <?php } ?>
                    md_theme: md_theme
                    // md_layout는 절대 보내지 않음
                }
            }).done(function(res) {
                if (!res || res.status !== 'ok') return;
                var $wrap = $('.rb-lib-st-list');
                if (!$wrap.length) return;
                $wrap.empty();
                var sel = ($('#rbLibTypeFilter').val() || '').toLowerCase(); // ''=전체
                res.rows.forEach(function(row) {
                    if (sel && String(row.md_type || '').toLowerCase() !== sel) return; // ← 필터
                    var dateTxt = row.created_at ? row.created_at.replace(/-/g, '.').slice(0, 16) : '';

                    const v = String(row?.md_show ?? '').trim().toLowerCase();
                    const moTxt = (v === '') ? '공용' : (v === 'mobile') ? 'Mobile' : (v === 'pc') ? 'PC' : '공용';

                    var wTxt = row.width_text || '';
                    var $ul = $('<ul>').attr('data-lib-id', row.lib_id).addClass('rb-lib-item');
                    $ul.append('<li class="rb-lib-st-list-tit"><span class="font-R cut">' + (row.title || '(제목없음)') + '</span><button type="button" class="lib_del_btn" style="float:right;font-size:12px;padding:2px 6px;"><svg width="10" height="10" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.37629 8.76571L13.0333 14.4227C13.2219 14.6049 13.4745 14.7057 13.7367 14.7034C13.9989 14.7011 14.2497 14.5959 14.4351 14.4105C14.6205 14.2251 14.7257 13.9743 14.728 13.7121C14.7302 13.4499 14.6294 13.1973 14.4473 13.0087L8.79029 7.35171L14.4473 1.69471C14.6294 1.50611 14.7302 1.25351 14.728 0.991311C14.7257 0.729114 14.6205 0.478302 14.4351 0.292894C14.2497 0.107485 13.9989 0.00231622 13.7367 3.78026e-05C13.4745 -0.00224062 13.2219 0.0985537 13.0333 0.280712L7.37629 5.93771L1.71929 0.280712C1.52984 0.103057 1.2787 0.0060773 1.01902 0.0102941C0.759336 0.0145109 0.51148 0.119593 0.327898 0.303306C0.144315 0.487018 0.0394078 0.734948 0.0353747 0.994633C0.0313417 1.25432 0.128499 1.50539 0.306288 1.69471L5.96229 7.35171L0.305288 13.0087C0.209778 13.101 0.133596 13.2113 0.0811869 13.3333C0.0287779 13.4553 0.00119157 13.5865 3.7757e-05 13.7193C-0.00111606 13.8521 0.0241854 13.9838 0.0744663 14.1067C0.124747 14.2296 0.199 14.3412 0.292893 14.4351C0.386786 14.529 0.498438 14.6033 0.621334 14.6535C0.74423 14.7038 0.87591 14.7291 1.00869 14.728C1.14147 14.7268 1.27269 14.6992 1.39469 14.6468C1.5167 14.5944 1.62704 14.5182 1.71929 14.4227L7.37629 8.76571Z" fill="#ffffff"/></svg></button></li>');
                    var optHtml = [];
                    if (row.md_type) optHtml.push('<span class="opt_names">' + row.md_type + '</span>');
                    if (wTxt) optHtml.push('<span>' + wTxt + '</span>');
                    if (moTxt) optHtml.push('<span>' + moTxt + '</span>');
                    $ul.append('<li class="rb-lib-st-list-opt">' + optHtml.join(' ') + '</li>');
                    $ul.append('<li class="rb-lib-st-list-date">' + dateTxt + '</li>');
                    $ul.on('click', function(e) {
                        if ($(e.target).closest('.lib_del_btn').length) return;
                        rb_lib_apply($(this).data('lib-id'));
                    });
                    $ul.find('.lib_del_btn').on('click', function(e) {
                        e.stopPropagation();
                        var lib_id = $(this).closest('.rb-lib-item').data('lib-id');
                        rb_lib_delete(lib_id);
                    });
                    $wrap.append($ul);
                });
            });
        }
    }

    $(document).on('change', '#rbLibTypeFilter', function() {
        rb_lib_list_reload(); // 기존 기능 그대로 유지, 필터만 적용됨
    });

    if (typeof window.RB_IS_SHOP === 'undefined') {
        window.RB_IS_SHOP = <?php if (defined('_SHOP_')) { ?> 1 <?php } else { ?> 0 <?php } ?>;
    }




    (function rbRefreshTabsAfterApply() {
        function decodeEntities(s) {
            if (s == null) return '';
            var t = String(s).trim();
            return t.replace(/\\&quot;/g, '"').replace(/&quot;/g, '"');
        }

        function fire($el) {
            try {
                $el[0].dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            } catch (e) {}
            try {
                $el[0].dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            } catch (e) {}
            $el.trigger('input').trigger('change');
        }
        // 히든 두 개(공용/영카트 전용) 값 정규화 + 이벤트 발생
        var $md = $('#md_tab_list');
        var $itm = $('#md_item_tab_list'); // 없는 화면(일반)일 수 있음

        if ($md.length) {
            $md.val(decodeEntities($md.val() || ''));
            fire($md);
        }
        if ($itm.length) {
            $itm.val(decodeEntities($itm.val() || ''));
            fire($itm);
        }

        // DOM이 ajax로 교체된 직후 타이밍 보정: rAF → setTimeout(0)
        requestAnimationFrame(function() {
            setTimeout(function() {
                try {
                    if (typeof drawTabsFromHidden === 'function') drawTabsFromHidden();
                } catch (e) {}
                try {
                    if (typeof drawItemTabsFromHidden === 'function') drawItemTabsFromHidden();
                } catch (e) {}
            }, 0);
        });
    })();


    if (typeof rb_lib_apply !== 'function') {
        function rb_lib_apply(lib_id) {

            $.ajax({
                url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_lib.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    action: 'get',
                    csrf: window.RB_WIDGET_CSRF,
                    <?php if (defined('_SHOP_')) { ?>
                    is_shop: '1',
                    <?php } else { ?>
                    is_shop: '0',
                    <?php } ?>
                    lib_id: lib_id
                }
            }).done(function(res) {
                if (!res || res.status !== 'ok' || !res.payload) {
                    alert('불러오기에 실패했습니다.');
                    return;
                }


                // 적용 전 확인
                var msg = '분류, 스킨파일, 게시판 등이 삭제되어 저장된 값에 맞는 셀렉트 항목이 없는 경우 직접 설정해주셔야 합니다. 설정을 적용 하시겠습니까?';
                var confirmPromise = (typeof rb_confirm === 'function') ?
                    rb_confirm(msg) :
                    Promise.resolve(window.confirm(msg));

                confirmPromise.then(function(confirmed) {
                    if (!confirmed) {
                        // alert('적용을 취소했습니다.');
                        return;
                    }



                    // --- 변경 후 ---
                    var payload = res.payload || {};

                    // 서버 기준 Shop 여부(문자열 '1'|'0'로 고정)
                    var RB_IS_SHOP = <?php echo defined('_SHOP_') ? "'1'" : "'0'"; ?>;

                    /**
                     * 주입 타겟 찾기 (Shop이면 *_shop 우선)
                     * - 공용/Shop 쌍둥이, 배열형, id/name 모두 커버
                     */
                    function findTargets(key) {
                        var sels = [];
                        if (RB_IS_SHOP === '1') {
                            sels.push('#' + key + '_shop', '[name="' + key + '_shop"]', '[name="' + key + '_shop[]"]');
                        }
                        sels.push('#' + key, '[name="' + key + '"]', '[name="' + key + '[]"]');
                        // 공용을 __common 으로 밀어낸 경우 제외
                        var $els = $();
                        sels.forEach(function(sel) {
                            $els = $els.add($(sel).not('[name$="__common"]'));
                        });
                        return $els;
                    }

                    /** 체크박스/라디오 값 보조 */
                    function toArray(v) {
                        if (Array.isArray(v)) return v.map(String);
                        if (v == null) return [];
                        var s = String(v).trim();
                        if (!s) return [];
                        return s.split(',').map(function(x) {
                            return x.trim();
                        }).filter(Boolean);
                    }

                    /** 값 주입기: 타입별로 강제 주입 + 이벤트 통지 */
                    function forceApply(key, val) {
                        var $targets = findTargets(key);
                        if (!$targets.length) return false;

                        // 라디오 그룹: name 기준으로 묶어서 처리
                        if ($targets.first().attr('type') && $targets.first().attr('type').toLowerCase() === 'radio') {
                            var name = $targets.first().attr('name') || (RB_IS_SHOP === '1' ? key + '_shop' : key);
                            var $grp = $('input[type="radio"][name="' + name + '"]');
                            $grp.prop('checked', false);
                            $grp.filter('[value="' + String(val) + '"]').prop('checked', true);
                            $grp.first().trigger('change');
                            return true;
                        }

                        // 체크박스: name 기준으로 묶어서 처리(단일/다중 모두 커버)
                        if ($targets.first().attr('type') && $targets.first().attr('type').toLowerCase() === 'checkbox') {
                            var name = $targets.first().attr('name') || (RB_IS_SHOP === '1' ? key + '_shop' : key);
                            var $grp = $('input[type="checkbox"][name="' + name + '"]');
                            var arr = toArray(val);
                            $grp.prop('checked', false);
                            if (arr.length) {
                                arr.forEach(function(v) {
                                    $grp.filter('[value="' + v + '"]').prop('checked', true);
                                });
                                // 단일 체크박스(값이 '1' 등)도 커버
                                if (!$grp.filter(':checked').length && (val === 1 || val === '1' || val === true)) {
                                    $grp.first().prop('checked', true);
                                }
                            }
                            $grp.first().trigger('change');
                            return true;
                        }

                        // select[multiple]
                        if ($targets.is('select[multiple]')) {
                            var arr = toArray(val);
                            $targets.each(function() {
                                $(this).val(arr).trigger('change');
                            });
                            return true;
                        }

                        if (key === 'md_tab_list' || key === 'md_item_tab_list') {
                            var formatted;

                            try {
                                if (Array.isArray(val)) {
                                    // ex) [101, 102] → '["101","102"]'
                                    formatted = JSON.stringify(val.map(function(x) {
                                        return String(x).trim();
                                    }));
                                } else if (val == null || String(val).trim() === '') {
                                    formatted = '[]';
                                } else {
                                    var s = String(val).trim()
                                        .replace(/\\&quot;/g, '"')
                                        .replace(/&quot;/g, '"');
                                    if (s[0] === '[' && s.slice(-1) === ']') {
                                        // 이미 JSON 배열 형식이면 그대로 사용
                                        formatted = s;
                                    } else if (s.indexOf(',') > -1) {
                                        // "101, 102" → ["101","102"]
                                        formatted = JSON.stringify(s.split(',')
                                            .map(function(x) {
                                                return String(x).trim();
                                            })
                                            .filter(Boolean));
                                    } else {
                                        // "101" 단일 → ["101"]
                                        formatted = JSON.stringify([s]);
                                    }
                                }
                            } catch (e) {
                                formatted = '[]';
                            }

                            formatted = String(formatted)
                                .replace(/\\"/g, '"')
                                .replace(/\\&quot;/g, '&quot;');

                            $targets.each(function() {
                                $(this).val(formatted);
                                try {
                                    $(this).trigger('input').trigger('change');
                                } catch (e) {}
                            });
                            return true;
                        }

                        // 일반 select / input / textarea
                        $targets.each(function() {
                            $(this).val(String(val));
                            try {
                                $(this).trigger('input').trigger('change');
                            } catch (e) {}
                        });

                        // Coloris 미리보기 동기화 (대표 예: md_title_color 등)
                        if (/color/i.test(String(key))) {
                            $targets.each(function() {
                                var field = this.closest('.clr-field,.color_set_wrap');
                                if (field && field.style) field.style.setProperty('--clr-color', String(val));
                            });
                            if (window.Coloris) {
                                try {
                                    Coloris({
                                        el: '.coloris'
                                    });
                                } catch (e) {}
                            }
                        }

                        return true;
                    }

                    // 1) 원래 로직 있으면 먼저 실행(선택)
                    //    주석 처리되어 있던 기존 함수가 정상 동작하는 경우를 위해 유지
                    try {
                        if (typeof populateModuleForm === 'function') populateModuleForm(payload);
                    } catch (e) {}

                    window.__rb_last_applied_keys = window.__rb_last_applied_keys || [];

                    function rbClearTargetsForKey(key) {
                        // key와 짝꿍 키( *_shop ↔ 기본 ) 모두 클리어 시도
                        var keys = [key];
                        if (/_shop$/.test(key)) keys.push(key.replace(/_shop$/, ''));
                        else keys.push(key + '_shop');

                        keys.forEach(function(k) {
                            var $targets = findTargets(k);
                            if (!$targets.length) return;

                            var $first = $targets.first();
                            var type = ($first.attr('type') || '').toLowerCase();

                            // 라디오/체크박스는 그룹 전체 해제
                            if (type === 'radio') {
                                var name = $first.attr('name');
                                if (name) $('input[type="radio"][name="' + name + '"]').prop('checked', false).first().trigger('change');
                                return;
                            }
                            if (type === 'checkbox') {
                                var name = $first.attr('name');
                                if (name) $('input[type="checkbox"][name="' + name + '"]').prop('checked', false).first().trigger('change');
                                return;
                            }

                            // 멀티셀렉트는 빈 배열
                            if ($targets.is('select[multiple]')) {
                                $targets.each(function() {
                                    $(this).val([]).trigger('change');
                                });
                                return;
                            }

                            // 탭 히든은 명시적으로 빈 배열 문자열로
                            if (k === 'md_tab_list' || k === 'md_item_tab_list') {
                                $targets.each(function() {
                                    $(this).val('[]').trigger('input').trigger('change');
                                });
                                return;
                            }

                            // 일반 input/select/textarea는 공란
                            $targets.each(function() {
                                $(this).val('').trigger('input').trigger('change');
                            });

                            // Coloris 같은 색상 프리뷰 동기화
                            if (/color/i.test(String(k))) {
                                $targets.each(function() {
                                    var field = this.closest('.clr-field,.color_set_wrap');
                                    if (field && field.style) field.style.setProperty('--clr-color', '');
                                });
                            }
                        });
                    }

                    // 이번 payload에 있는(적용 대상) 키 모음
                    var _newKeys = new Set(Object.keys(payload || {}));

                    // 이전에 적용했던 키 중에서, 이번에는 없는 키들만 선제 클리어
                    window.__rb_last_applied_keys.forEach(function(prevKey) {
                        // prevKey 자체가 없고, 그 짝꿍키도 없으면 클리어
                        var hasNow =
                            _newKeys.has(prevKey) ||
                            (_newKeys.has(prevKey.replace(/_shop$/, ''))) ||
                            (_newKeys.has(prevKey + '_shop'));
                        if (!hasNow) rbClearTargetsForKey(prevKey);
                    });

                    // 2) 강제 주입 (모든 md_* 키를 실제 필드에 꽂음)
                    var applied = 0,
                        missed = [];

                    var appliedKeys = [];

                    Object.keys(payload).forEach(function(key) {
                        // 대응 관계: *_shop ↔ 기본키 둘 다 시도
                        var ok = forceApply(key, payload[key]);
                        if (!ok && /_shop$/.test(key)) {
                            var base = key.replace(/_shop$/, '');
                            ok = forceApply(base, payload[key]);
                        } else if (!ok) {
                            ok = forceApply(key + '_shop', payload[key]);
                        }
                        if (ok) appliedKeys.push(key);
                        if (ok) applied++;
                        else missed.push(key);
                    });

                    window.__rb_last_applied_keys = appliedKeys.slice();

                    // 3) 이후 부가 렌더/동기화
                    (function rbDeferredTagRender() {
                        function safeDraw(attempt) {
                            attempt = attempt || 0;

                            // 컨테이너가 아직 없으면 조금 뒤에 다시 시도 (최대 10회 ≈ 500ms)
                            var hasWrap = ($('#tab_selects').length || $('#item_tab_selects').length);
                            if (!hasWrap && attempt < 10) {
                                return setTimeout(function() {
                                    safeDraw(attempt + 1);
                                }, 50);
                            }

                            // 히든 값이 &quot;로 들어온 경우를 대비해 한 번 더 이벤트 깨우기
                            ['#md_tab_list', '#md_item_tab_list'].forEach(function(sel) {
                                var $el = $(sel);
                                if (!$el.length) return;
                                try {
                                    $el[0].dispatchEvent(new Event('input', {
                                        bubbles: true
                                    }));
                                } catch (e) {}
                                try {
                                    $el[0].dispatchEvent(new Event('change', {
                                        bubbles: true
                                    }));
                                } catch (e) {}
                                $el.trigger('input').trigger('change');
                            });

                            try {
                                if (typeof drawTabsFromHidden === 'function') drawTabsFromHidden();
                            } catch (e) {}
                            try {
                                if (typeof drawItemTabsFromHidden === 'function') drawItemTabsFromHidden();
                            } catch (e) {}
                        }

                        // DOM 페인트가 끝난 다음 호출
                        requestAnimationFrame(function() {
                            setTimeout(function() {
                                safeDraw(0);
                            }, 0);
                        });
                    })();

                    try {
                        if (typeof rb_syncSlidersFromHidden === 'function') rb_syncSlidersFromHidden();
                    } catch (e) {}

                    // 4) 디버그 로그(개발자도구 콘솔에서 확인)
                    console.log('[rb] applied fields:', applied, 'missed:', missed);


                    if (typeof window.rb_after_form_populate === 'function') {
                        try {
                            window.rb_after_form_populate(res.payload);
                        } catch (e) {}
                    }
                    if (typeof window.refresh_preview === 'function') {
                        try {
                            window.refresh_preview();
                        } catch (e) {}
                    }
                    if (typeof window.change_layout_visibility === 'function') {
                        try {
                            window.change_layout_visibility();
                        } catch (e) {}
                    }


                    // 값 주입 + Coloris 프리뷰 동기화 (간소화 버전)
                    (function applyMdTitleColor(payload) {
                        // 1) 값 추출 + 간단 정규화 (#RGB/#RRGGBB/#RRGGBBAA, rgb/rgba, 샵 없음 허용)
                        function toHex(x) {
                            if (!x) return '';
                            x = String(x).trim();
                            var m = x.match(/^rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})(?:\s*,\s*(\d*\.?\d+))?\s*\)$/i);
                            if (m) {
                                var to2 = n => n.toString(16).padStart(2, '0').toUpperCase();
                                var r = Math.max(0, Math.min(255, parseInt(m[1], 10)));
                                var g = Math.max(0, Math.min(255, parseInt(m[2], 10)));
                                var b = Math.max(0, Math.min(255, parseInt(m[3], 10)));
                                var a = m[4] != null ? Math.max(0, Math.min(1, parseFloat(m[4]))) : 1;
                                return '#' + to2(r) + to2(g) + to2(b) + (a < 1 ? to2(Math.round(a * 255)) : '');
                            }
                            if (/^[0-9a-f]{3,8}$/i.test(x)) x = '#' + x;
                            return /^#(?:[0-9a-f]{3}|[0-9a-f]{6}|[0-9a-f]{8})$/i.test(x) ? x : '';
                        }

                        var colorVal = toHex(payload?.md_title_color) || '#25282B';
                        var el = document.querySelector('input[name="md_title_color"]');
                        if (!el) return;

                        // 2) 값/속성 세팅 + 이벤트 통지
                        el.value = colorVal;
                        el.setAttribute('value', colorVal);
                        try {
                            el.dispatchEvent(new Event('input', {
                                bubbles: true
                            }));
                        } catch (e) {}
                        try {
                            el.dispatchEvent(new Event('change', {
                                bubbles: true
                            }));
                        } catch (e) {}
                        if (window.jQuery) {
                            try {
                                jQuery(el).trigger('input').trigger('change');
                            } catch (e) {}
                        }

                        // 3) Coloris 프리뷰 배경(CSS 변수)도 동기화
                        var field = el.closest('.clr-field,.color_set_wrap');
                        if (field && field.style) field.style.setProperty('--clr-color', colorVal);

                        // 4) 인스턴스 재스캔(중복 호출해도 안전)
                        if (window.Coloris) {
                            try {
                                Coloris({
                                    el: '.coloris'
                                });
                            } catch (e) {}
                        }
                    })(res.payload);
                    // 끝


                    alert('설정이 적용 되었습니다.');

                }).catch(function(err) {
                    // rb_confirm가 Promise 거부하거나 예외일 때 안전 탈출
                    //console.warn('rb_confirm error:', err);
                });

                try {
                    if (typeof drawTabsFromHidden === 'function') drawTabsFromHidden();
                } catch (e) {}
                try {
                    if (typeof drawItemTabsFromHidden === 'function') drawItemTabsFromHidden();
                } catch (e) {}

            }).fail(function(xhr) {
                alert('서버 오류: ' + xhr.status);
            });
        }
    }

    if (typeof rb_lib_delete !== 'function') {
        function rb_lib_delete(lib_id) {
            // rb_confirm가 Promise를 반환하면 사용, 없으면 window.confirm로 대체
            var confirmPromise = (typeof rb_confirm === 'function') ?
                rb_confirm('선택하신 설정을 삭제할까요?') :
                Promise.resolve(window.confirm('선택하신 설정을 삭제할까요?'));

            confirmPromise.then(function(confirmed) {
                if (!confirmed) return; // 취소 시 종료

                $.ajax({
                    url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_lib.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'delete',
                        csrf: (window.RB_WIDGET_CSRF || ''),
                        <?php if (defined('_SHOP_')) { ?>
                        is_shop: '1',
                        <?php } else { ?>
                        is_shop: '0',
                        <?php } ?>
                        lib_id: lib_id
                    }
                }).done(function(res) {
                    if (res && res.status === 'ok') {
                        if (typeof rb_lib_list_reload === 'function') rb_lib_list_reload();
                    } else {
                        alert((res && res.msg) ? res.msg : '삭제 실패');
                    }
                }).fail(function(xhr) {
                    alert('서버 오류: ' + xhr.status);
                });
            });
        }
    }


    if (typeof populateModuleForm !== 'function') {
        function populateModuleForm(p) {
            var $root = $(document);
            var IN_SHOP = (window.RB_IS_SHOP == 1);

            // ── helpers ─────────────────────────────────────────────
            function toS(v) {
                return (v === null || v === undefined) ? '' : String(v);
            }

            function isOn(v) {
                return v === 1 || v === '1' || v === true || v === 'Y' || v === 'y' || v === 'on';
            }

            function toArr(v) {
                if (Array.isArray(v)) return v.map(toS);
                var s = toS(v).trim();
                if (!s) return [];
                if (s[0] === '[' && s.slice(-1) === ']') {
                    try {
                        var d = JSON.parse(s);
                        if (Array.isArray(d)) return d.map(toS);
                    } catch (e) {}
                }
                if (s.indexOf(',') > -1) return s.split(',').map(function(x) {
                    return x.trim();
                }).filter(Boolean).map(toS);
                return [s];
            }
            // 같은 name이 일반/SHOP 두 벌일 때 현재 모드의 요소만 선택
            function pickByMode(name) {
                var $all = $(document).find('[name="' + name + '"], [name="' + name + '[]"]');
                if (!$all.length) return $all;

                var isShop = (window.RB_IS_SHOP == 1);

                if (isShop) {
                    // 1순위: id가 정확히 name_shop 인 요소
                    var $idShop = $('#' + name + '_shop');
                    if ($idShop.length) return $idShop;

                    // 2순위: 같은 name 중에서 shop 영역 우선
                    /*
                    var $inShopScope = $all.filter(function(){
                      var $el = $(this);
                      return $el.is('[data-shop="1"]') ||
                             ($el.attr('id')||'').endsWith('_shop') ||
                             $el.closest('[data-scope="shop"], .shop-panel, #shop-pane').length > 0;
                    });
                    */
                    if ($inShopScope.length) return $inShopScope;

                    // 3순위: 폴백으로 같은 name 전체
                    return $all;
                } else {
                    // 일반 모드
                    // 1순위: id가 정확히 name 인 요소 (id가 *_shop 인 것은 제외)
                    var $id = $('#' + name);
                    if ($id.length && !$id.is('#' + name + '_shop')) return $id;

                    // 2순위: 같은 name 중 *_shop 가 아닌 것 우선
                    var $notShop = $all.filter(function() {
                        var id = this.id || '';
                        var inShopScope = $(this).closest('[data-scope="shop"], .shop-panel, #shop-pane').length > 0;
                        return !id.endsWith('_shop') && !inShopScope && !$(this).is('[data-shop="1"]');
                    });
                    if ($notShop.length) return $notShop;

                    // 3순위: 폴백
                    return $all;
                }
            }

            // 슬라이더 동기화: hidden.co_range_send ↔ #<base>_range
            function syncSlider($inputs, val) {
                var v = Number(val);
                if (!isFinite(v)) v = parseFloat(val);
                if (!isFinite(v)) v = 0;

                $inputs.filter('input.co_range_send').each(function() {
                    var id = this.id || '';
                    var base = id.replace(/_shop$/, ''); // md_radius_shop -> md_radius
                    var $slider = $('#' + base + '_range'); // -> #md_radius_range
                    if (!$slider.length) return;

                    // 실제 적용 함수 (jQuery UI 있으면 API로, 아니면 수동 보정)
                    function applyOnce() {
                        if ($slider.hasClass('ui-slider') && typeof $slider.slider === 'function') {
                            try {
                                $slider.slider('value', v);
                            } catch (e) {}
                        } else {
                            // 폴백: 바/핸들 위치 수동 보정 (min=0, max=30 가정 — 마크업 동일 패턴)
                            var min = 0,
                                max = 30;
                            var pct = Math.max(0, Math.min(100, ((v - min) / (max - min)) * 100));
                            $slider.find('.ui-slider-range-min').css('width', pct + '%');
                            $slider.find('.ui-slider-handle').css('left', pct + '%');
                        }
                        // 핸들 텍스트 갱신(네 마크업이 숫자를 핸들에 직접 출력)
                        $slider.find('.ui-slider-handle').text(String(v));
                    }

                    // 즉시 → 0ms → 150ms 3번 보강 (지연 렌더/토글 후에도 반영되게)
                    applyOnce();
                    setTimeout(applyOnce, 0);
                    setTimeout(applyOnce, 150);
                });
            }
            // ────────────────────────────────────────────────────────

            Object.keys(p || {}).forEach(function(key) {
                var val = p[key];

                // 태그 출력 로직을 건드리지 않기 위해:
                //    md_item_tab_list / md_tab_list는 hidden 값만 정확히 채우고 종료
                if (key === 'md_item_tab_list' || key === 'md_tab_list') {
                    var str = (typeof rbNormalizeSerialized === 'function') ?
                        rbNormalizeSerialized(val) :
                        (Array.isArray(val) ? JSON.stringify(val) : String(val || ''));
                    $('#' + key).val(str).trigger('input').trigger('change');
                    return;
                }

                // 이 아래는 전부 모드별로 해당 name만 주입 (일반/SHOP 동명이름 보호)
                var $byName = pickByMode(key);
                if (!$byName.length) return;

                // 배열/멀티값: 체크박스 그룹, 멀티 셀렉트만 처리 (hidden/text는 그대로 — 태그 영향 X)
                if (Array.isArray(val) || (typeof val === 'string' && (val.trim().startsWith('[') || val.indexOf(',') > -1))) {
                    // 체크박스 그룹
                    var $chk = $byName.filter('[type="checkbox"]');
                    if ($chk.length) {
                        var set = new Set(toArr(val));
                        $chk.prop('checked', false).each(function() {
                            if (set.has(toS($(this).val()))) $(this).prop('checked', true);
                        }).trigger('change');
                    }
                    // 멀티 셀렉트
                    $byName.filter('select[multiple]').each(function() {
                        $(this).val(toArr(val)).trigger('change');
                    });
                    return;
                }

                // 라디오
                var $radios = $byName.filter('[type="radio"]');
                if ($radios.length > 0) {
                    var s = toS(val);
                    $radios.prop('checked', false);
                    $radios.filter('[value="' + s + '"]').prop('checked', true).trigger('change');
                    return;
                }

                // 단일 체크박스(모드별 한 개)
                var $checkbox = $byName.filter('[type="checkbox"]');
                if ($checkbox.length === 1) {
                    $checkbox.prop('checked', !!isOn(val)).trigger('change');
                    return;
                }

                // 단일 셀렉트
                var $sel = $byName.filter('select').not('[multiple]');
                if ($sel.length) {
                    $sel.val(toS(val)).trigger('change');
                    return;
                }

                // 인풋/히든/텍스트/컬러 등 (슬라이더 쌍이면 함께 동기화)
                var norm = (typeof rbNormalizeSerialized === 'function') ? rbNormalizeSerialized(val) : toS(val);
                $byName.not('[type="checkbox"]').not('[type="radio"]').not('select')
                    .val(norm).trigger('input').trigger('change');

                // ← 여기만 동작 추가됨 (슬라이더 반영)
                syncSlider($byName, norm);
            });
        }
    }
</script>


<script>
    $(document).on('click', '.rb-resize-s-reset', function(e) {
        e.preventDefault();

        // 이 버튼이 속한 모듈 카드/랩퍼 찾기
        const $card = $(this).closest('.rb_layout_box');
        const $wrap = $card.find('.rb-module-wrap').first();

        // UI 리셋: 높이 auto로
        $wrap.css('height', 'auto');

        // 서버 저장: md_height = 'auto'
        if (typeof rbSaveModuleHeight === 'function') {
            rbSaveModuleHeight($wrap, 'auto');
        }
    });


    function rbSaveModuleHeight($box, finalOuterPx) {
        var $card = $box.closest('.rb_layout_box');
        var md_id = $card.data('id') ?? $card.attr('data-id');
        var layout = $card.data('layout') ?? $card.attr('data-layout');

        <?php if (defined('_SHOP_')) { ?>
        var is_shop = '1';
        <?php } else { ?>
        var is_shop = '0';
        <?php } ?>

        if (!md_id) {
            console.warn('[rbSaveModuleHeight] md_id 없음');
            return;
        }

        $.ajax({
            url: '<?php echo G5_URL ?>/rb/rb.config/ajax.module_set.php',
            type: 'POST',
            data: {
                md_id: md_id,
                md_layout: (layout || ''),
                md_height: String(finalOuterPx),
                is_shop: is_shop,
                is_height: '1',
            },
            dataType: 'json'
        }).done(function(res) {
            // console.log('saved', res);
        }).fail(function(xhr) {
            console.warn('height save failed', xhr?.responseText || xhr);
        });
    }

    (function($) {
        function clamp(v, min, max) {
            return Math.max(min, Math.min(max, v));
        }

        // UL 기본 마진 제거 + 마진붕괴 방지(그대로 유지)
        (function injectOnce() {
            if (document.getElementById('rb-resizer-fix-style')) return;
            var st = document.createElement('style');
            st.id = 'rb-resizer-fix-style';
            st.textContent = ``;
            document.head.appendChild(st);
        })();

        function zoneContentTop($zone) {
            var r = $zone[0].getBoundingClientRect();
            var cs = getComputedStyle($zone[0]);
            return r.top + (parseFloat(cs.paddingTop) || 0) + (parseFloat(cs.borderTopWidth) || 0);
        }

        function ensureHandlesAndGuides(ctx) {
            var $ctx = ctx ? $(ctx) : $(document);
            $ctx.find('.content_box_set').each(function() {
                var $b = $(this);
                if (!$b.data('rbResizeReady')) {
                    if (!$b.children('.rb-resize-s').length) {
                        $b.append('<div class="rb-resize-s" aria-label="resize bottom"></div>');
                    }
                    $b.data('rbResizeReady', true);
                }
            });
            $ctx.find('.ui-sortable').each(function() {
                var $zone = $(this);
                if ($zone.css('position') === 'static') $zone.css('position', 'relative');
                if (!$zone.children('.rb-guide-y').length) {
                    $('<div class="rb-guide-y"></div>').appendTo($zone);
                }
            });
        }
        ensureHandlesAndGuides();

        var mo = new MutationObserver(function(muts) {
            for (var m of muts) {
                for (var n of m.addedNodes) {
                    if (!(n instanceof HTMLElement)) continue;
                    if (n.matches?.('.content_box_set, .ui-sortable, .ui-sortable-handle') ||
                        n.querySelector?.('.content_box_set, .ui-sortable, .ui-sortable-handle')) {
                        ensureHandlesAndGuides(n);
                    }
                }
            }
        });
        mo.observe(document.body, {
            childList: true,
            subtree: true
        });
        window.rbResizerRefresh = ensureHandlesAndGuides;

        // ── 리사이즈 드래그 로직 ─────────────────────────────
        var SNAP = 10,
            MIN_H = 60,
            MAX_H = 4000;
        var dragging = false,
            startY = 0,
            startOuterH = 0;
        var $box = null,
            $wrap = null,
            $zone = null,
            $guide = null,
            $sortable = null;
        var containerTop = 0,
            boxTop = 0,
            snapTargets = [];
        var prevBoxSizing = '';

        // 스냅 타겟은 형제들의 "wrap(.rb-module-wrap) 바닥" 기준
        function collectSnapTargets($zone, $excludeBox) {
            var list = [],
                zTop = containerTop;
            $zone.find('.ui-sortable-handle .content_box_set').each(function() {
                if (this === $excludeBox[0]) return;
                var $w = $(this).children('.rb-module-wrap').first();
                var r = ($w[0] || this).getBoundingClientRect(); // 없으면 box로 폴백
                list.push((r.top + r.height) - zTop);
            });
            return list.sort(function(a, b) {
                return a - b;
            });
        }

        $(document).on('mousedown.rbResize', '.content_box_set .rb-resize-s', function(e) {
            e.preventDefault();
            e.stopPropagation();

            $box = $(this).closest('.content_box_set');
            $wrap = $box.children('.rb-module-wrap').first(); // 대상 wrap
            if (!$wrap.length) $wrap = $box; // 안전 폴백

            $zone = $box.closest('.ui-sortable');
            if (!$zone.length) $zone = $box.parent();
            $guide = $zone.children('.rb-guide-y');

            // jQuery UI sortable 일시 비활성
            $sortable = $zone.data('ui-sortable') ? $zone : null;
            if ($sortable) $sortable.sortable('option', 'disabled', true);

            var wr = $wrap[0].getBoundingClientRect();

            containerTop = zoneContentTop($zone);
            boxTop = wr.top - containerTop;

            startY = e.pageY;
            startOuterH = Math.round(wr.height); // wrap의 겉높이 기준

            // 드래그 중엔 wrap을 border-box 로 강제 → 겉높이=height
            prevBoxSizing = $wrap.css('box-sizing');
            $wrap.css('box-sizing', 'border-box');

            snapTargets = collectSnapTargets($zone, $box);

            dragging = true;
            $('body').addClass('rb-no-select');
        });

        var scheduled = false,
            lastMove = null;

        function tick() {
            scheduled = false;
            if (!dragging || !lastMove) return;

            var e = lastMove;
            var dy = e.pageY - startY;

            // 매 프레임 wrap 위치 실측
            var wr = $wrap[0].getBoundingClientRect();
            boxTop = wr.top - containerTop;

            var hOuter = clamp(startOuterH + dy, MIN_H, MAX_H);

            var curBottom = boxTop + hOuter;
            var snapped = null;
            for (var i = 0; i < snapTargets.length; i++) {
                var t = snapTargets[i];
                if (Math.abs(t - curBottom) <= SNAP) {
                    snapped = t;
                    break;
                }
            }
            if (snapped != null) {
                $guide.css({
                    top: snapped + 'px'
                }).show();
                hOuter = clamp(Math.round(snapped - boxTop), MIN_H, MAX_H);
            } else {
                $guide && $guide.hide();
            }

            // wrap에만 높이 적용
            $wrap.css('height', hOuter + 'px');
        }

        $(document).on('mousemove.rbResize', function(e) {
            if (!dragging) return;
            e.preventDefault();
            e.stopPropagation();
            lastMove = e;
            if (!scheduled) {
                scheduled = true;
                requestAnimationFrame(tick);
            }
        });

        $(document).on('mouseup.rbResize', function() {
            if (!dragging) return;

            if ($sortable) $sortable.sortable('option', 'disabled', false);
            $guide && $guide.hide();

            if ($box && $wrap) {
                // 저장도 wrap의 겉높이로
                var finalOuter = Math.round($wrap[0].getBoundingClientRect().height);
                rbSaveModuleHeight($box, finalOuter);
                // box-sizing 원복
                if (prevBoxSizing) $wrap.css('box-sizing', prevBoxSizing);
            }

            dragging = false;
            $box = $wrap = $zone = $guide = $sortable = null;
            scheduled = false;
            lastMove = null;
            $('body').removeClass('rb-no-select');
        });

    })(jQuery);
</script>
