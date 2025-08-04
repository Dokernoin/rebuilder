<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.config/style.css?ver='.G5_TIME_YMDHIS.'">', 0);
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.config/coloris/coloris.css?ver='.G5_TIME_YMDHIS.'">', 0);
add_javascript('<script src="'.G5_URL.'/rb/rb.config/coloris/coloris.js"></script>', 0);
?>

<div class="sh-side-options-container" style="margin-top:100px">
    <a href="javascript:void(0);" class="sh-side-options-item sh-accent-color" id="saveOrderButton" title="모듈정렬 저장">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_check.svg"></div>
    </a>

    <a href="<?php echo G5_ADMIN_URL  ?>" target="_blank" class="sh-side-options-item sh-accent-color" title="관리자모드">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_setting.svg"></div>
    </a>
    <a class="sh-side-options-item sh-accent-color mobule_set_btn" title="모듈설정" onclick="toggleSideOptions();">
        <div class="sh-side-options-item-container"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_mod.svg"></div>
    </a>

    <a class="sh-side-options-item sh-accent-color setting_set_btn" title="환경설정" onclick="toggleSideOptions_open_set();">
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
                    <h6 class="font-R rb_config_sub_txt">레이아웃 및 웹폰트는 새로고침 후 확인해주세요.<br>이외 모든 설정은 변경즉시 적용 됩니다.<br>서브영역 설정의 경우 서브페이지로 이동해주세요.</h6>
                    <ul class="rb_config_sec">
                        <h6 class="font-B">강조컬러 설정 (공용)</h6>
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
                            <style>
                                .co_header_ex {
                                    float: left;
                                    width: 70%;
                                }

                                .co_header_ex_dd {
                                    border: 1px solid #fff;
                                    margin-top: 15px;
                                }

                                .co_header_chk {
                                    float: left;
                                    width: 30%;
                                    padding-left: 15px;
                                    line-height: 40px;
                                }

                                .co_header_ex dd {
                                    border-radius: 10px;
                                    width: 100%;
                                    padding: 12px 20px 12px 20px;
                                    margin-bottom: 5px;
                                }

                                .co_header_ex dd span {
                                    float: left;
                                    margin-top: 3px;
                                }

                                .co_header_ex dd i {
                                    float: right;
                                    margin-top: 2px;
                                }
                            </style>

                            <ul>

                                <div class="color_set_wrap square" style="position: relative;">
                                    <input type="text" class="coloris coloris2 mod_co_header" name="co_header" value="<?php echo !empty($rb_config['co_header']) ? $rb_config['co_header'] : ''; ?>">
                                </div>

                                <li class="co_header_ex">
                                    <dd class="co_header_ex_dd">
                                        <span class="font-B">Aa 가 123</span>
                                        <i>
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#25282B" />
                                            </svg>
                                        </i>
                                        <div class="cb"></div>
                                    </dd>
                                </li>
                                <li class="co_header_chk"></li>
                                <div class="cb"></div>
                            </ul>

                        </div>
                    </ul>

                    <ul class="rb_config_sec">
                        <h6 class="font-B">모듈간격 설정 (공용)</h6>
                        <h6 class="font-R rb_config_sub_txt">모듈간 간격을 설정할 수 있습니다.<br>내부 여백은 각 모듈 설정에서 개별 적용이 가능합니다.</h6>
                        <div class="config_wrap">

                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">간격 (PC)</span><br>
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

                                            executeAjax();

                                            // 기존 클래스 제거 후 새로운 클래스 추가
                                            $('.contents_wrap section.index').removeClass(function(index, className) {
                                                return (className.match(/co_gap_pc_\d+/g) || []).join(' ');
                                            }).addClass('co_gap_pc_' + ui.value);

                                            $('.contents_wrap section.sub').removeClass(function(index, className) {
                                                return (className.match(/co_gap_pc_\d+/g) || []).join(' ');
                                            }).addClass('co_gap_pc_' + ui.value);

                                            $('.add_module_wrap').removeClass(function(index, className) {
                                                return (className.match(/adm_co_gap_pc_\d+/g) || []).join(' ');
                                            }).addClass('adm_co_gap_pc_' + ui.value);

                                        }
                                    });

                                    $("#co_gap_pc_range .ui-slider-handle").html("<?php echo !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '0'; ?>");
                                    $("#co_gap_pc").val("<?php echo !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '0'; ?>"); // 초기값 설정
                                </script>
                                <div class="cb"></div>
                            </ul>

                            <input type="hidden" id="co_inner_padding_pc" class="" name="co_inner_padding_pc" value="">

                            <!-- 임시제거
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">내부 여백 (PC)</span><br>
                                    0~30px
                                </li>
                                <li class="rows_inp_r mt-15">
                                    <div id="co_inner_padding_pc_range" class="rb_range_item"></div>
                                    <input type="hidden" id="co_inner_padding_pc" class="co_range_send" name="co_inner_padding_pc" value="<?php echo !empty($rb_core['inner_padding_pc']) ? $rb_core['inner_padding_pc'] : '0'; ?>">
                                </li>
                                
                                <script type="text/javascript">

                                $("#co_inner_padding_pc_range").slider({
                                  range: "min",
                                  min: 0,
                                  max: 30,
                                  value: <?php echo !empty($rb_core['inner_padding_pc']) ? $rb_core['inner_padding_pc'] : '0'; ?>,
                                  step: 5,
                                  slide: function(e, ui) {
                                    $("#co_inner_padding_pc_range .ui-slider-handle").html(ui.value);
                                    $("#co_inner_padding_pc").val(ui.value); // hidden input에 값 업데이트
                                    executeAjax();
                                    
                                    // 기존 클래스 제거 후 새로운 클래스 추가
                                    $('.contents_wrap section.index').removeClass(function(index, className) {
                                        return (className.match(/co_inner_padding_pc_\d+/g) || []).join(' ');
                                    }).addClass('co_inner_padding_pc_' + ui.value);
                                    
                                  }
                                });

                                $("#co_inner_padding_pc_range .ui-slider-handle").html("<?php echo !empty($rb_core['inner_padding_pc']) ? $rb_core['inner_padding_pc'] : '0'; ?>");
                                $("#co_inner_padding_pc").val("<?php echo !empty($rb_core['inner_padding_pc']) ? $rb_core['inner_padding_pc'] : '0'; ?>"); // 초기값 설정

                                </script>
                                <div class="cb"></div>
                            </ul>
                            -->


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

                            <ul class="rows_inp_lr mt-5">
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

                            <ul class="rows_inp_lr mt-10">
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

                                            executeAjax();

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


                            <ul class="rows_inp_lr mt-10">
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
                                        max: 30,
                                        value: <?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>,
                                        step: 5,
                                        slide: function(e, ui) {
                                            $("#co_sidemenu_padding_shop_range .ui-slider-handle").html(ui.value);
                                            $("#co_sidemenu_padding_shop").val(ui.value); // hidden input에 값 업데이트

                                            executeAjax();

                                            var co_sidemenu_shop = $('input[name="co_sidemenu_shop"]:checked').val();

                                            if(co_sidemenu_shop == 'left') {
                                                $('#rb_sidemenu_shop').css('padding-right', ui.value);
                                            } else if(co_sidemenu_shop == 'right') {
                                                $('#rb_sidemenu_shop').css('padding-left', ui.value);
                                            }


                                        }
                                    });

                                    $("#co_sidemenu_padding_shop_range .ui-slider-handle").html("<?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>");
                                    $("#co_sidemenu_padding_shop").val("<?php echo !empty($rb_core['sidemenu_padding_shop']) ? $rb_core['sidemenu_padding_shop'] : '0'; ?>"); // 초기값 설정
                                </script>
                                <div class="cb"></div>
                            </ul>


                        </div>

                    </ul>

                    <ul class="rb_config_sec" <?php if(defined('_SHOP_')) { // 영카트?>style="display:none !important;" <?php } else { ?>style="display:block !important;" <?php } ?>>

                        <h6 class="font-B">서브 사이드 영역 설정</h6>
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

                            <ul class="rows_inp_lr mt-5">
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

                            <ul class="rows_inp_lr mt-10">
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

                                            executeAjax();

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


                            <ul class="rows_inp_lr mt-10">
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
                                        max: 30,
                                        value: <?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>,
                                        step: 5,
                                        slide: function(e, ui) {
                                            $("#co_sidemenu_padding_range .ui-slider-handle").html(ui.value);
                                            $("#co_sidemenu_padding").val(ui.value); // hidden input에 값 업데이트

                                            executeAjax();

                                            var co_sidemenu = $('input[name="co_sidemenu"]:checked').val();

                                            if(co_sidemenu == 'left') {
                                                $('#rb_sidemenu').css('padding-right', ui.value);
                                            } else if(co_sidemenu == 'right') {
                                                $('#rb_sidemenu').css('padding-left', ui.value);
                                            }

                                        }
                                    });

                                    $("#co_sidemenu_padding_range .ui-slider-handle").html("<?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>");
                                    $("#co_sidemenu_padding").val("<?php echo !empty($rb_core['sidemenu_padding']) ? $rb_core['sidemenu_padding'] : '0'; ?>"); // 초기값 설정
                                </script>
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

                                    <input type="radio" name="v_use" id="v_use_0" class="magic-radio" value="0"
                                    <?php if (!isset($rb_v_info['v_use']) || intval($rb_v_info['v_use']) === 0) { ?>checked<?php } ?>>
                                    <label for="v_use_0">없음</label>

                                    <input type="radio" name="v_use" id="v_use_1" class="magic-radio" value="1"
                                    <?php if (isset($rb_v_info['v_use']) && intval($rb_v_info['v_use']) === 1) { ?>checked<?php } ?>>
                                    <label for="v_use_1">사용</label>

                                    <?php if(isset($cate_id) && $cate_id) { // 영카트?>
                                    <input type="radio" name="v_use" id="v_use_2" class="magic-radio" value="2"
                                    <?php if (isset($rb_v_info['v_use']) && intval($rb_v_info['v_use']) === 2) { ?>checked<?php } ?>>
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


                        $(document).ready(function () {
                            // 페이지 로드시 적용
                            toggleTopVisualBox();

                            // v_use 라디오 변경 시 AJAX + 표시제어
                            $(document).on('change', 'input[name="v_use"]', function () {
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
                                    success: function (data) {
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
                                    error: function (xhr, status, error) {
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
                                            step: 10,
                                            slide: function(e, ui) {
                                                $("#co_topvisual_height_range .ui-slider-handle").html(ui.value);
                                                $("#co_topvisual_height").val(ui.value); // hidden input에 값 업데이트

                                                executeAjax();

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

                                                executeAjax();

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

                                                executeAjax();

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
                            document.getElementById('clear_top_btn').addEventListener('click', function () {
                                if (confirm('현재 설정된 서브 상단영역을 모두 초기화 합니다.\n입력된 내용 및 설정값이 모두 삭제 됩니다.\n\n계속 하시겠습니까?')) {
                                    fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.clear_topvisual.php', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                        body: 'act=top_clear'
                                    })
                                    .then(res => res.text())
                                    .then(res => {
                                        if (res.trim() === 'ok') {
                                            alert('초기화 완료 되었습니다.');
                                            location.reload();
                                        } else {
                                            alert('초기화 실패: ' + res);
                                        }
                                    })
                                    .catch(err => {
                                        alert('에러 발생: ' + err);
                                    });
                                }
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

                    <?php if (defined("_INDEX_")) { ?>
                    <ul class="rb_config_sec">
                        <h6 class="font-B"><?php if(defined('_SHOP_')) { // 영카트?>마켓 <?php } ?>메인 상단여백 설정 (PC)</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            PC버전 상단의 여백을 제거할 수 있습니다.
                        </h6>
                        <div class="config_wrap">
                            <ul>
                                <?php if(defined('_SHOP_')) { // 영카트?>
                                <input type="checkbox" name="co_main_padding_top_shop" id="co_main_padding_top_shop" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_core['padding_top_shop']) && $rb_core['padding_top_shop'] == 1) { ?>checked<?php } ?>><label for="co_main_padding_top_shop">여백제거</label>
                                <input type="checkbox" style="display:none;" name="co_main_padding_top" id="co_main_padding_top" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_core['padding_top']) && $rb_core['padding_top'] == 1) { ?>checked<?php } ?>><label for="co_main_padding_top" style="display:none;">여백제거</label>
                                <?php } else { ?>
                                <input type="checkbox" name="co_main_padding_top" id="co_main_padding_top" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_core['padding_top']) && $rb_core['padding_top'] == 1) { ?>checked<?php } ?>><label for="co_main_padding_top">여백제거</label>
                                <input type="checkbox" style="display:none;" name="co_main_padding_top_shop" id="co_main_padding_top_shop" class="magic-checkbox mod_send" value="1" <?php if(isset($rb_core['padding_top_shop']) && $rb_core['padding_top_shop'] == 1) { ?>checked<?php } ?>><label for="co_main_padding_top_shop" style="display:none;">여백제거</label>
                                <?php } ?>

                            </ul>
                        </div>
                    </ul>
                    <?php } else { ?>
                        <input type="hidden" name="co_main_padding_top_shop" id="co_main_padding_top_shop" value="<?php echo !empty($rb_core['padding_top_shop']) ? $rb_core['padding_top_shop'] : ''; ?>">
                        <input type="hidden" name="co_main_padding_top" id="co_main_padding_top" value="<?php echo !empty($rb_core['padding_top']) ? $rb_core['padding_top'] : ''; ?>">
                    <?php } ?>



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
                        <button type="button" class="main_rb_bg" id="clear_cache_btn" class="btn">캐시 삭제</button>
                        <script>
                        document.getElementById('clear_cache_btn').addEventListener('click', function () {
                            if (confirm('/data/cache/ 폴더의 모든 캐시파일이 제거되며,\n비로그인 접속시 메인 레이아웃 캐시가 재생성 됩니다.\n\n계속하시겠습니까?')) {
                                fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.clear_cache.php', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                    body: 'act=clear'
                                })
                                .then(res => res.text())
                                .then(res => {
                                    if (res.trim() === 'ok') {
                                        alert('캐시 파일이 모두 삭제되었습니다.');
                                        location.reload();
                                    } else {
                                        alert('삭제 실패: ' + res);
                                    }
                                })
                                .catch(err => {
                                    alert('에러 발생: ' + err);
                                });
                            }
                        });
                        </script>
                        <div class="cb"></div>
                        <button type="button" class="rb_config_reload mt-5 font-B" onclick="javascript:location.reload();">새로고침</button>
                        <button type="button" class="rb_config_close mt-5 font-B" onclick="toggleSideOptions_close()">닫기</button>
                        <div class="cb"></div>
                    </ul>





                </div>


            </div>
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
    $(document).ready(function() {
        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').hide();
        $("#saveOrderButton").hide();
    });


    //모듈설정 토글
    function toggleSideOptions() {

        // PHP에서 관리자만 스타일 삽입!
        <?php if($is_admin) { ?>
        // 토글 ON(열기)할 때만 스타일 삽입
        if (!$('.content_box').hasClass('content_box_set')) {
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
        }
        <?php } ?>

        //클래스로 확인한다.
        if ($('.content_box').hasClass('content_box_set')) {
            toggleSideOptions_close_mod();
        } else {
            toggleSideOptions_open_mod();
        }
    }

    // 모듈설정 오픈
    function toggleSideOptions_open_mod() {

        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').show();

        // 모듈설정 활성
        $('.content_box').addClass('content_box_set');
        $('.rb_layout_box').addClass('bg_fff');
        $('.mobule_set_btn').addClass('open');
        $('.setting_set_btn').removeClass('open');
        $('.add_module_wrap').show(); //2.1.4 추가

        // 모듈이동
        $(function() {
            $(".flex_box").each(function() {
                var $flexBox = $(this);
                var originalWidth, originalHeight;

                $flexBox.sortable({
                    placeholder: "placeholders_box", // 드랍될 위치를 표시할 클래스 이름
                    tolerance: "pointer", // pointer를 기준으로 tolerance 설정
                    helper: "clone", // helper를 clone으로 설정
                    items: "> .rb_layout_box", // .content_box만 드래그 가능

                    start: function(event, ui) {
                        // 드래그 시작할 때 원래 크기 저장 (padding과 border 포함)
                        originalWidth = ui.item.outerWidth();
                        originalHeight = ui.item.outerHeight();
                        ui.helper.addClass("dragging");
                        ui.helper.css({
                            width: originalWidth - 0.5,
                            height: originalHeight - 0.5
                        });


                        var paddingLeft = parseInt(ui.helper.css('padding-left'), 10);
                        var paddingRight = parseInt(ui.helper.css('padding-right'), 10);
                        var paddingTop = parseInt(ui.helper.css('padding-top'), 10);
                        var paddingBottom = parseInt(ui.helper.css('padding-bottom'), 10);

                        $(".placeholders_box").css({
                            width: originalWidth - paddingLeft - paddingRight,
                            height: originalHeight - paddingTop - paddingBottom,
                            margin: paddingLeft
                        });
                    },
                    stop: function(event, ui) {
                        // 드래그 멈출 때 원래 크기로 복원하고 그림자 제거
                        ui.item.removeClass("dragging");
                        ui.item.css({
                            width: originalWidth - 0.5,
                            height: originalHeight - 0.5
                        });

                        // .add_module_wrap 아래로 이동했는지 확인
                        var addModuleWrapIndex = $flexBox.children(".add_module_wrap").index();
                        var itemIndex = ui.item.index();

                        if (itemIndex > addModuleWrapIndex) {
                            // .add_module_wrap 아래로 이동한 경우 원래 위치로 되돌리기
                            $flexBox.sortable("cancel");
                        }

                        // data-order-id 업데이트
                        $flexBox.find(".rb_layout_box").each(function(index) {
                            $(this).attr("data-order-id", index + 1);
                        });

                        $("#saveOrderButton").show();
                    },
                    update: function(event, ui) {
                        // .add_module_wrap 아래로 이동했는지 확인
                        var addModuleWrapIndex = $flexBox.children(".add_module_wrap").index();
                        var itemIndex = ui.item.index();

                        if (itemIndex > addModuleWrapIndex) {
                            // .add_module_wrap 아래로 이동한 경우 원래 위치로 되돌리기
                            $flexBox.sortable("cancel");
                        }

                        // data-order-id 업데이트
                        $flexBox.find(".rb_layout_box").each(function(index) {
                            $(this).attr("data-order-id", index + 1);
                        });

                        // 변경된 순서를 배열로 저장
                        var order = $flexBox.sortable('toArray', {
                            attribute: 'data-id'
                        });
                        console.log(order);

                        // order 값을 전역 변수로 저장
                        window.currentOrder = order;
                    }
                }).disableSelection();
            });

            // 저장 버튼 클릭 이벤트 핸들러
            $("#saveOrderButton").on("click", function() {
                <?php if($is_admin) { ?>
                <?php } else { ?>
                alert('편집 권한이 없습니다.');
                return false;
                <?php } ?>

                if (window.currentOrder) {
                    saveOrder(window.currentOrder); // 순서를 저장하는 함수 호출
                } else {
                    console.log("순서저장에 문제가 있습니다.");
                }
            });

            // content_box를 클릭할 때 원래 크기 저장

            $(".rb_layout_box").on("mousedown", function(event) {
                $(".rb_layout_box").removeClass("dragging");
                var $this = $(this);
                originalWidth = $this.outerWidth();
                originalHeight = $this.outerHeight();
                $this.css({
                    width: originalWidth,
                    height: originalHeight
                });

                $this.addClass("clicked");
            });


            // 마우스를 놓을 때 크기 초기화
            $(".rb_layout_box").on("mouseup", function(event) {
                var $this = $(this);
                originalWidth = $this.outerWidth();
                originalHeight = $this.outerHeight();
                $this.css({
                    width: originalWidth,
                    height: originalHeight
                });
            });

            // 순서를 저장하는 함수
            function saveOrder() {
                var orderData = [];
                $(".flex_box .rb_layout_box").each(function(index) {
                    orderData.push({
                        id: $(this).data('id'),
                        order_id: index + 1
                    });
                });

                $.ajax({
                    url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                    method: 'POST',

                    data: {
                        order: orderData,
                        mod_type: "mod_order",
                        <?php if (defined('_SHOP_')) { ?>
                        is_shop: "1"
                        <?php } else { ?>
                        is_shop: "0"
                        <?php } ?>
                    },

                    success: function(response) {
                        console.log('Order saved:', response);
                        $("#saveOrderButton").hide();
                        alert('모듈의 순서를 변경하였습니다.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving order:', error);
                    }
                });
            }
        });

    }


    // 모듈설정 닫기
    function toggleSideOptions_close_mod() {
        $('.rb_config_mod1').hide();
        $('.rb_config_mod2').hide();

        // 모듈설정 비활성
        $(".flex_box").sortable("destroy");
        $('.content_box').removeClass('handles');
        $('.mobule_set_btn').removeClass('open');
        $('.setting_set_btn').removeClass('open');
        $('.add_module_wrap').hide(); //2.1.4 추가

        toggleSideOptions_close();
    }



    //환경설정 오픈
    function toggleSideOptions_open_set() {
        toggleSideOptions_open()

        $('.rb_config_mod1').show();
        $('.rb_config_mod2').hide();

        //환경설정 활성
        $('.setting_set_btn').addClass('open');
        $('.mobule_set_btn').removeClass('open');
        $('.content_box').removeClass('content_box_set');
        $('.rb_layout_box').removeClass('bg_fff');
        $('.add_module_wrap').hide(); //2.1.4 추가
    }

    //환경설정 열기
    function toggleSideOptions_open() {
        $('.sh-side-options').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.sh-side-options').addClass('open');
    }

    //환경설정 닫기
    function toggleSideOptions_close() {
        $('.sh-side-options').css('transition', 'all 600ms cubic-bezier(0.86, 0, 0.07, 1)');
        $('.sh-side-options').removeClass('open');

        $('.setting_set_btn').removeClass('open');
        $('.mobule_set_btn').removeClass('open');
        $('.content_box').removeClass('content_box_set');
        $('.rb_layout_box').removeClass('bg_fff');
        $('.add_module_wrap').hide(); //2.1.4 추가

    }


    //모듈설정
    function set_module_send(element) {

        // 부모 요소의 값을 가져옴
        var set_layout = $(element).closest('.flex_box').data('layout');
        var set_title = $(element).closest('.rb_layout_box').data('title');
        var set_id = $(element).closest('.rb_layout_box').data('id');
        var theme_name = '<?php echo $rb_core['theme']; ?>';
        var mod_type = '2';


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

        // input 요소에 가져온 값을 설정
        //$('input[name="aaa"]').val(title + ' - ' + id);
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



    //설정패널
    $(document).ready(function() {

        // 이벤트 핸들러 추가
        $('.mod_co_color').on('change', function() {
            executeAjax();
        });

        $('.mod_co_header').on('change', function() {
            executeAjax();
        });

        $('.mod_send').change(function() {
            executeAjax();
        });

    });

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
    function executeAjax() {

        var co_color = $('input[name="co_color"]').val();
        var co_header = $('input[name="co_header"]').val();
        var co_font = $('select[name="co_font"]').val();
        var co_gap_pc = $('input[name="co_gap_pc"]').val();
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

        <?php if (defined("_INDEX_")) { ?>
        var co_main_padding_top = $('input[name="co_main_padding_top"]:checked').val();
        var co_main_padding_top_shop = $('input[name="co_main_padding_top_shop"]:checked').val();
        <?php } else { ?>
        var co_main_padding_top = $('input[name="co_main_padding_top"]').val();
        var co_main_padding_top_shop = $('input[name="co_main_padding_top_shop"]').val();
        <?php } ?>

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
                "co_font": co_font,
                "co_gap_pc": co_gap_pc,
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
                "co_main_padding_top": co_main_padding_top,
                "co_main_padding_top_shop": co_main_padding_top_shop,

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

                    if(data.co_sidemenu_hide == 1) {
                        $('#rb_sidemenu').addClass('pc');
                    } else {
                        $('#rb_sidemenu').removeClass('pc');
                    }

                    if(data.co_sidemenu_hide_shop == 1) {
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


                } else {
                    console.log('변경실패');
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
                    $('.main_wording').css('font-size', data.co_topvisual_m_size+'px');
                    $('.main_wording').css('font-family', data.co_topvisual_m_font);
                    $('.main_wording').css('text-align', data.co_topvisual_m_align);

                    $('.sub_wording').css('color', data.co_topvisual_s_color);
                    $('.sub_wording').css('font-size', data.co_topvisual_s_size+'px');
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
        <?php } ?>


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
        var md_border = $('input[name="md_border_shop"]:checked').val();
        var md_radius = $('#md_radius_shop').val();
        var md_padding = $('#md_padding_shop').val();
        var md_margin_top_pc = $('#md_margin_top_pc_shop').val();
        var md_margin_top_mo = $('#md_margin_top_mo_shop').val();
        var md_margin_btm_pc = $('#md_margin_btm_pc_shop').val();
        var md_margin_btm_mo = $('#md_margin_btm_mo_shop').val();
        var md_wide_is = $('input[name="md_wide_is_shop"]:checked').val();
        <?php } else { ?>
        var layout_name = '<?php echo $rb_core['layout'] ?>';
        var md_border = $('input[name="md_border"]:checked').val();
        var md_radius = $('#md_radius').val();
        var md_padding = $('#md_padding').val();
        var md_margin_top_pc = $('#md_margin_top_pc').val();
        var md_margin_top_mo = $('#md_margin_top_mo').val();
        var md_margin_btm_pc = $('#md_margin_btm_pc').val();
        var md_margin_btm_mo = $('#md_margin_btm_mo').val();
        var md_wide_is = $('input[name="md_wide_is"]:checked').val();
        <?php } ?>


        if (md_type == "item") {
            var md_cnt = $('#md_cnt_shop').val();
            var md_col = $('#md_col_shop').val();
            var md_row = $('#md_row_shop').val();
            var md_col_mo = $('#md_col_mo_shop').val();
            var md_row_mo = $('#md_row_mo_shop').val();
        } else {
            var md_cnt = $('#md_cnt').val();
            var md_col = $('#md_col').val();
            var md_row = $('#md_row').val();
            var md_col_mo = $('#md_col_mo').val();
            var md_row_mo = $('#md_row_mo').val();
        }

        var md_width = $('input[name="md_width"]').val();
        var md_height = $('input[name="md_height"]').val();
        var md_size = $('input[name="md_size"]:checked').val();
        var md_show = $('input[name="md_show"]:checked').val();

        if (md_type == "item") {
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

        var md_tab_list = $('input[name="md_tab_list"]').val();
        var md_tab_skin = $('select[name="md_tab_skin"]').val();

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
            alert('게시물 출력갯수를 입력해주세요.');
            $('#md_cnt').focus();
            return false;
        } else if (md_type == "latest" && md_col < 1 || md_type == "latest" && md_row < 1 || md_type == "latest" && md_col_mo < 1 || md_type == "latest" && md_row_mo < 1) {
            alert('게시물 출력(열X행) 옵션을 설정해주세요.');
            return false;
        } else if (md_type == "tab" && md_tab_list == "" || md_type == "tab" && md_tab_list == "[]") {
            alert('탭으로 출력할 게시판 또는 카테고리를 선택해주세요.');
            $('select[name="md_bo_table_tab"]').focus();
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
        } else if (md_type == "item" && md_module == "") {
            alert('상품 타입을 선택해주세요.');
            $('#md_module_shop').focus();
            return false;
        } else if (md_type == "item" && md_order == "") {
            alert('상품 출력옵션을 선택해주세요.');
            $('#md_order_shop').focus();
            return false;
        } else if (md_type == "latest" && md_order_latest == "" || md_type == "tab" && md_order_latest == "") {
            alert('게시물 출력옵션을 선택해주세요.');
            $('#md_order_latest').focus();
            return false;
        } else if (md_type == "item" && md_cnt < 1) {
            alert('상품 출력갯수를 입력해주세요.');
            $('#md_cnt_shop').focus();
            return false;
        } else if (md_type == "item" && md_col < 1 || md_type == "item" && md_row < 1 || md_type == "item" && md_col_mo < 1 || md_type == "item" && md_row_mo < 1) {
            alert('상품 출력(열X행) 옵션을 설정해주세요.');
            return false;
        } else if (md_type == "item" && md_skin == "") {
            alert('출력 스킨을 선택해주세요.');
            $('#md_skin_shop').focus();
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
                    <?php if(defined('_SHOP_')) { // 영카트?>
                        "is_shop": "1",
                    <?php } else { ?>
                        "is_shop": "0",
                    <?php } ?>
                    "md_id": md_id,
                    "md_title": md_title,
                    "md_title_color": md_title_color,
                    "md_title_size": md_title_size,
                    "md_title_font": md_title_font,
                    "md_title_hide": md_title_hide,
                    "md_layout": md_layout,
                    "md_skin": md_skin,
                    "md_tab_list": md_tab_list,
                    "md_tab_skin": md_tab_skin,
                    "md_type": md_type,
                    "md_bo_table": md_bo_table,
                    "md_notice": md_notice,
                    "md_wide_is": md_wide_is,
                    "md_sca": md_sca,
                    "md_widget": md_widget,
                    "md_banner": md_banner,
                    "md_banner_id": md_banner_id,
                    "md_banner_bg": md_banner_bg,
                    "md_banner_skin": md_banner_skin,
                    "md_poll": md_poll,
                    "md_poll_id": md_poll_id,
                    "md_theme": md_theme,
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
                    "md_radius": md_radius,
                    "md_module": md_module,
                    "md_padding": md_padding,
                    "md_margin_top_pc": md_margin_top_pc,
                    "md_margin_top_mo": md_margin_top_mo,
                    "md_margin_btm_pc": md_margin_btm_pc,
                    "md_margin_btm_mo": md_margin_btm_mo,
                    "md_order": md_order,
                    "md_order_latest": md_order_latest,
                    "md_soldout_hidden": md_soldout_hidden,
                    "md_soldout_asc": md_soldout_asc,
                },


                success: function(data) {
                    if (data.status == 'ok') {
                        console.log('모듈저장:' + data.md_title);
                        alert(data.md_title + ' 모듈이 저장 되었습니다.');
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
</script>
