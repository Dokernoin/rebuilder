<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

$mod_type = !empty($_POST['mod_type']) ? $_POST['mod_type'] : '';
$is_shop = !empty($_POST['is_shop']) ? $_POST['is_shop'] : '';

if(isset($is_shop) && $is_shop == 1) {
    $rb_module_tables = "rb_module_shop";
} else { 
    $rb_module_tables = "rb_module";
}

if($mod_type == 1) { //환경설정
    $co_color = !empty($_POST['co_color']) ? $_POST['co_color'] : 'AA20FF';
    $co_header = !empty($_POST['co_header']) ? $_POST['co_header'] : '0';
   
    $co_layout = !empty($_POST['co_layout']) ? $_POST['co_layout'] : 'basic';
    $co_layout_hd = !empty($_POST['co_layout_hd']) ? $_POST['co_layout_hd'] : 'basic';
    $co_layout_ft = !empty($_POST['co_layout_ft']) ? $_POST['co_layout_ft'] : 'basic';
    
    $co_layout_shopp = !empty($_POST['co_layout_shop']) ? $_POST['co_layout_shop'] : 'basic';
    $co_layout_hd_shop = !empty($_POST['co_layout_hd_shop']) ? $_POST['co_layout_hd_shop'] : 'basic_row';
    $co_layout_ft_shop = !empty($_POST['co_layout_ft_shop']) ? $_POST['co_layout_ft_shop'] : 'basic';
    
    $co_font = !empty($_POST['co_font']) ? $_POST['co_font'] : 'Pretendard';
    $co_sub_width = !empty($_POST['co_sub_width']) ? $_POST['co_sub_width'] : '1024';
    $co_main_width = !empty($_POST['co_main_width']) ? $_POST['co_main_width'] : '1400';
    $co_tb_width = !empty($_POST['co_tb_width']) ? $_POST['co_tb_width'] : '1400';
    $co_main_padding_top = !empty($_POST['co_main_padding_top']) ? $_POST['co_main_padding_top'] : '0';
    $co_main_padding_top_shop = !empty($_POST['co_main_padding_top_shop']) ? $_POST['co_main_padding_top_shop'] : '0';
    
    $co_menu_shop = !empty($_POST['co_menu_shop']) ? $_POST['co_menu_shop'] : '0';

    $co_gap_pc = !empty($_POST['co_gap_pc']) ? $_POST['co_gap_pc'] : '0';
    $co_inner_padding_pc = !empty($_POST['co_inner_padding_pc']) ? $_POST['co_inner_padding_pc'] : '0';

    $co_side_skin = !empty($_POST['co_side_skin']) ? $_POST['co_side_skin'] : '';
    $co_side_skin_shop = !empty($_POST['co_side_skin_shop']) ? $_POST['co_side_skin_shop'] : '';
    $co_sidemenu = !empty($_POST['co_sidemenu']) ? $_POST['co_sidemenu'] : '';
    $co_sidemenu_shop = !empty($_POST['co_sidemenu_shop']) ? $_POST['co_sidemenu_shop'] : '';
    $co_sidemenu_width = !empty($_POST['co_sidemenu_width']) ? $_POST['co_sidemenu_width'] : '200';
    $co_sidemenu_width_shop = !empty($_POST['co_sidemenu_width_shop']) ? $_POST['co_sidemenu_width_shop'] : '200';
    $co_sidemenu_padding = !empty($_POST['co_sidemenu_padding']) ? $_POST['co_sidemenu_padding'] : '0';
    $co_sidemenu_padding_shop = !empty($_POST['co_sidemenu_padding_shop']) ? $_POST['co_sidemenu_padding_shop'] : '0';
    $co_sidemenu_hide = !empty($_POST['co_sidemenu_hide']) ? $_POST['co_sidemenu_hide'] : '0';
    $co_sidemenu_hide_shop = !empty($_POST['co_sidemenu_hide_shop']) ? $_POST['co_sidemenu_hide_shop'] : '0';
}

if($mod_type == 2) { //모듈설정
    $set_title = !empty($_POST['set_title']) ? $_POST['set_title'] : '';
    $set_layout = !empty($_POST['set_layout']) ? $_POST['set_layout'] : '';
    $set_id = !empty($_POST['set_id']) ? $_POST['set_id'] : '';
    $set_type = !empty($_POST['set_type']) ? $_POST['set_type'] : '';
    $theme_name = !empty($_POST['theme_name']) ? $_POST['theme_name'] : '';
}

if($mod_type == "del") { //모듈삭제
    $set_layout = !empty($_POST['set_layout']) ? $_POST['set_layout'] : '';
    $set_id = !empty($_POST['set_id']) ? $_POST['set_id'] : '';
    $theme_name = !empty($_POST['theme_name']) ? $_POST['theme_name'] : '';
}

?>

   
    <?php if(isset($mod_type) && $mod_type == 1) { ?>
        <?php
    
            if($is_admin) {
            $sql = " update rb_config set co_layout = '{$co_layout}', co_layout_hd = '{$co_layout_hd}', co_layout_ft = '{$co_layout_ft}', co_layout_shop = '{$co_layout_shop}', co_layout_hd_shop = '{$co_layout_hd_shop}', co_layout_ft_shop = '{$co_layout_ft_shop}', co_color = '{$co_color}', co_header = '{$co_header}', co_font = '{$co_font}', co_gap_pc = '{$co_gap_pc}', co_inner_padding_pc = '{$co_inner_padding_pc}', co_sub_width = '{$co_sub_width}', co_main_width = '{$co_main_width}', co_tb_width = '{$co_tb_width}', co_main_padding_top = '{$co_main_padding_top}', co_main_padding_top_shop = '{$co_main_padding_top_shop}', co_menu_shop = '{$co_menu_shop}', co_sidemenu_padding = '{$co_sidemenu_padding}', co_sidemenu_padding_shop = '{$co_sidemenu_padding_shop}', co_sidemenu_hide = '{$co_sidemenu_hide}', co_sidemenu_hide_shop = '{$co_sidemenu_hide_shop}', co_side_skin = '{$co_side_skin}', co_side_skin_shop = '{$co_side_skin_shop}', co_sidemenu = '{$co_sidemenu}', co_sidemenu_shop = '{$co_sidemenu_shop}', co_sidemenu_width = '{$co_sidemenu_width}', co_sidemenu_width_shop = '{$co_sidemenu_width_shop}', co_datetime = '".G5_TIME_YMDHIS."', co_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            sql_query($sql);
            }

            $data = array(
                'co_color' => $co_color,
                'co_header' => $co_header,
                'co_layout' => $co_layout,
                'co_layout_hd' => $co_layout_hd,
                'co_layout_ft' => $co_layout_ft,
                'co_layout_shop' => $co_layout_shop,
                'co_layout_hd_shop' => $co_layout_hd_shop,
                'co_layout_ft_shop' => $co_layout_ft_shop,
                'co_font' => $co_font,
                'co_gap_pc' => $co_gap_pc,
                'co_inner_padding_pc' => $co_inner_padding_pc,
                'co_sub_width' => $co_sub_width,
                'co_main_width' => $co_main_width,
                'co_tb_width' => $co_tb_width,
                'co_main_padding_top' => $co_main_padding_top,
                'co_main_padding_top_shop' => $co_main_padding_top_shop,
                'co_menu_shop' => $co_menu_shop,
                'co_side_skin' => $co_side_skin,
                'co_side_skin_shop' => $co_side_skin_shop,
                'co_sidemenu' => $co_sidemenu,
                'co_sidemenu_shop' => $co_sidemenu_shop,
                'co_sidemenu_width' => $co_sidemenu_width,
                'co_sidemenu_width_shop ' => $co_sidemenu_width_shop,
                'co_sidemenu_padding' => $co_sidemenu_padding,
                'co_sidemenu_padding_shop ' => $co_sidemenu_padding_shop,
                'co_sidemenu_hide' => $co_sidemenu_hide,
                'co_sidemenu_hide_shop' => $co_sidemenu_hide_shop,
                'status' => 'ok',
            );
            echo json_encode($data);
        ?>
    <?php } ?>
    
    <?php if(isset($mod_type) && $mod_type == 2) { ?>
    <h2 class="font-B"><?php if($set_title) { ?><span><?php echo $set_title ?></span> 모듈설정<?php } else { ?>모듈추가<?php } ?></h2>
        
    <h6 class="font-R rb_config_sub_txt">
    공식 배포되는 스킨 외에 커스텀 된 스킨의 경우<br>
    갯수, 간격, 스와이프, 출력항목 등이 작동하지 않을 수 있습니다.
    </h6>

        <?php if($set_layout == "") { ?>

        <div class="rb_config_sec">
           <div class="no_data">
            변경할 모듈을 선택해주세요.
            </div>
        </div>

        <?php } else { ?>
        
            <?php if($set_layout && $set_id && $theme_name) { ?>
            
                <?php

                $rb_module = sql_fetch(" select * from {$rb_module_tables} where md_theme = '{$theme_name}' and md_id = '{$set_id}' and md_layout = '{$set_layout}' ");
                $rb_module_is = sql_fetch(" select COUNT(*) as cnt from {$rb_module_tables} where md_theme = '{$theme_name}' and md_id = '{$set_id}' and md_layout = '{$set_layout}' ");
    
                $md_id = !empty($rb_module['md_id']) ? $rb_module['md_id'] : '';
                $md_theme = !empty($rb_module['md_theme']) ? $rb_module['md_theme'] : '';
                $md_type = !empty($rb_module['md_type']) ? $rb_module['md_type'] : '';
                $md_show = !empty($rb_module['md_show']) ? $rb_module['md_show'] : '';
                $md_size = !empty($rb_module['md_size']) ? $rb_module['md_size'] : '%';
                $md_title = !empty($rb_module['md_title']) ? $rb_module['md_title'] : '';
                $md_title_color = !empty($rb_module['md_title_color']) ? $rb_module['md_title_color'] : '#25282b';
                $md_title_size = !empty($rb_module['md_title_size']) ? $rb_module['md_title_size'] : '20';
                $md_title_font = !empty($rb_module['md_title_font']) ? $rb_module['md_title_font'] : 'font-B';
                $md_title_hide = !empty($rb_module['md_title_hide']) ? $rb_module['md_title_hide'] : '0';
                $md_skin = !empty($rb_module['md_skin']) ? $rb_module['md_skin'] : '';
                $md_tab_skin = !empty($rb_module['md_tab_skin']) ? $rb_module['md_tab_skin'] : '';
                $md_tab_list = !empty($rb_module['md_tab_list']) ? $rb_module['md_tab_list'] : '';
                $md_bo_table = !empty($rb_module['md_bo_table']) ? $rb_module['md_bo_table'] : '';
                $md_sca = !empty($rb_module['md_sca']) ? $rb_module['md_sca'] : '';
                $md_widget = !empty($rb_module['md_widget']) ? $rb_module['md_widget'] : '';
                $md_banner = !empty($rb_module['md_banner']) ? $rb_module['md_banner'] : '';
                $md_banner_id = !empty($rb_module['md_banner_id']) ? $rb_module['md_banner_id'] : '';
                $md_banner_bg = !empty($rb_module['md_banner_bg']) ? $rb_module['md_banner_bg'] : '';
                $md_banner_skin = !empty($rb_module['md_banner_skin']) ? $rb_module['md_banner_skin'] : '';
                $md_poll = !empty($rb_module['md_poll']) ? $rb_module['md_poll'] : '';
                $md_poll_id = !empty($rb_module['md_poll_id']) ? $rb_module['md_poll_id'] : '';
                $md_cnt = !empty($rb_module['md_cnt']) ? $rb_module['md_cnt'] : '';
                $md_col = !empty($rb_module['md_col']) ? $rb_module['md_col'] : '';
                $md_row = !empty($rb_module['md_row']) ? $rb_module['md_row'] : '';
                $md_col_mo = !empty($rb_module['md_col_mo']) ? $rb_module['md_col_mo'] : '';
                $md_row_mo = !empty($rb_module['md_row_mo']) ? $rb_module['md_row_mo'] : '';
                $md_width = !empty($rb_module['md_width']) ? $rb_module['md_width'] : '';
                $md_height = !empty($rb_module['md_height']) ? $rb_module['md_height'] : '';
                $md_subject_is = !empty($rb_module['md_subject_is']) ? $rb_module['md_subject_is'] : '';
                $md_thumb_is = !empty($rb_module['md_thumb_is']) ? $rb_module['md_thumb_is'] : '';
                $md_nick_is = !empty($rb_module['md_nick_is']) ? $rb_module['md_nick_is'] : '';
                $md_date_is = !empty($rb_module['md_date_is']) ? $rb_module['md_date_is'] : '';
                $md_content_is = !empty($rb_module['md_content_is']) ? $rb_module['md_content_is'] : '';
                $md_icon_is = !empty($rb_module['md_icon_is']) ? $rb_module['md_icon_is'] : '';
                $md_comment_is = !empty($rb_module['md_comment_is']) ? $rb_module['md_comment_is'] : '';
                $md_ca_is = !empty($rb_module['md_ca_is']) ? $rb_module['md_ca_is'] : '';
                $md_gap = !empty($rb_module['md_gap']) ? $rb_module['md_gap'] : '';
                $md_gap_mo = !empty($rb_module['md_gap_mo']) ? $rb_module['md_gap_mo'] : '';
                $md_swiper_is = !empty($rb_module['md_swiper_is']) ? $rb_module['md_swiper_is'] : '';
                $md_auto_is = !empty($rb_module['md_auto_is']) ? $rb_module['md_auto_is'] : '';
                $md_auto_time = !empty($rb_module['md_auto_time']) ? $rb_module['md_auto_time'] : '';
                $md_order = !empty($rb_module['md_order']) ? $rb_module['md_order'] : '';
                $md_order_latest = !empty($rb_module['md_order_latest']) ? $rb_module['md_order_latest'] : '';
                $md_border = !empty($rb_module['md_border']) ? $rb_module['md_border'] : '';
                $md_module = !empty($rb_module['md_module']) ? $rb_module['md_module'] : '';
                $md_soldout_hidden = !empty($rb_module['md_soldout_hidden']) ? $rb_module['md_soldout_hidden'] : '';
                $md_soldout_asc = !empty($rb_module['md_soldout_asc']) ? $rb_module['md_soldout_asc'] : '';
                $md_notice = !empty($rb_module['md_notice']) ? $rb_module['md_notice'] : '0';
                $md_radius = empty($rb_module['md_radius']) ? '0' : $rb_module['md_radius'];
                $md_padding = empty($rb_module['md_padding']) ? '0' : $rb_module['md_padding'];
                $md_margin_top_pc = empty($rb_module['md_margin_top_pc']) ? '' : $rb_module['md_margin_top_pc'];
                $md_margin_top_mo = empty($rb_module['md_margin_top_mo']) ? '' : $rb_module['md_margin_top_mo'];
                $md_margin_btm_pc = empty($rb_module['md_margin_btm_pc']) ? '' : $rb_module['md_margin_btm_pc'];
                $md_margin_btm_mo = empty($rb_module['md_margin_btm_mo']) ? '' : $rb_module['md_margin_btm_mo'];
    
                ?>
            
            <?php } else { ?>
               
               
                
            <?php } ?>


            <ul class="rb_config_sec">
                <h6 class="font-B">모듈 타이틀 설정</h6>
                <h6 class="font-R rb_config_sub_txt">모듈 타이틀의 워딩 및 스타일을 설정할 수 있습니다.<br>배너, 투표의 경우는 적용되지 않습니다.</h6>
                <div class="config_wrap">
                    <ul>
                        <input type="text" name="md_title" class="input w100" value="<?php echo !empty($md_title) ? $md_title : ''; ?>" placeholder="타이틀을 입력하세요." autocomplete="off">
                        <input type="hidden" name="md_layout" value="<?php echo !empty($set_layout) ? $set_layout : ''; ?>">
                        <input type="hidden" name="md_theme" value="<?php echo !empty($theme_name) ? $theme_name : ''; ?>">
                        <input type="hidden" name="md_id" value="<?php echo !empty($md_id) ? $md_id : ''; ?>">

                        <?php
                            // md_layout 컬럼의 타입을 255로 변경
                            $sql = "SHOW COLUMNS FROM rb_module LIKE 'md_layout'";
                            $row = sql_fetch($sql);

                            if ($row && stripos($row['Type'], 'varchar(255)') === false) {
                                $alter_sql = "ALTER TABLE rb_module MODIFY COLUMN md_layout VARCHAR(255) NOT NULL";
                                sql_query($alter_sql);

                            }

                            // md_layout 컬럼의 타입을 255로 변경
                            $sql = "SHOW COLUMNS FROM rb_module_shop LIKE 'md_layout'";
                            $row = sql_fetch($sql);

                            if ($row && stripos($row['Type'], 'varchar(255)') === false) {
                                $alter_sql = "ALTER TABLE rb_module_shop MODIFY COLUMN md_layout VARCHAR(255) NOT NULL";
                                sql_query($alter_sql);

                            }
                        ?>
                    </ul>

                    <ul class="config_wrap_flex">

                                <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                                    <input type="text" class="coloris mod_md_title_color" name="md_title_color" value="<?php echo !empty($md_title_color) ? $md_title_color : '#25282B'; ?>" style="width:25px !important;">
                                </div>컬러

                                <script type="text/javascript">
                                Coloris({el:'.coloris'});
                                Coloris.setInstance('.coloris', {
                                    parent: '.sh-side-demos-container',			// 상위 container
                                    formatToggle: false,	// Hex, RGB, HSL 토글버튼 활성
                                    format: 'hex',			// 색상 포맷지정
                                    margin: 0,				// margin
                                    swatchesOnly: false,	// 색상 견본만 표시여부
                                    alpha: true,			// 알파(투명) 활성여부
                                    theme: 'polaroid',		// default, large, polaroid, pill
                                    themeMode: 'Light',		// dark, Light
                                    focusInput: true,		// 색상코드 Input에 포커스 여부
                                    selectInput: true,		// 선택기가 열릴때 색상값을 select 여부
                                    autoClose: true,		// 자동닫기 - 확인 안됨
                                    inline: false,			// color picker를 인라인 위젯으로 사용시 true
                                    defaultColor: '#25282B',	// 기본 색상인 인라인 mode
                                    // Clear Button 설정
                                    clearButton: true,
                                    //clearLabel: '초기화',
                                    // Close Button 설정
                                    closeButton: true,	// true, false
                                    closeLabel: '닫기',	// 닫기버튼 텍스트
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

                                <input type="number" class="tiny_input" name="md_title_size" value="<?php echo !empty($md_title_size) ? $md_title_size : '20'; ?>"> px

                                <select class="select select_tiny" name="md_title_font" id="md_title_font">
                                    <option value="">스타일</option>
                                    <option value="font-R" <?php if (isset($md_title_font) && $md_title_font == "font-R") { ?>selected<?php } ?>>Regular</option>
                                    <option value="font-B" <?php if (isset($md_title_font) && $md_title_font == "font-B") { ?>selected<?php } ?>>Bold</option>
                                    <option value="font-H" <?php if (isset($md_title_font) && $md_title_font == "font-H") { ?>selected<?php } ?>>Heavy</option>
                                </select>

                                <div style="margin-left:auto;">
                                <input type="checkbox" name="md_title_hide" id="md_title_hide" class="magic-checkbox" value="1" <?php if (isset($md_title_hide) && $md_title_hide == "1") { ?>checked<?php } ?>><label for="md_title_hide">숨김</label>
                                </div>

                    </ul>

                </div>
                
            </ul>
            


            <ul class="rb_config_sec">
                <h6 class="font-B">출력 설정</h6>
                <div class="config_wrap">

                    <ul>
                        <input type="radio" name="md_show" id="md_show_1" class="magic-radio" value="" <?php if (isset($md_show) && $md_show == "" || empty($md_show)) { ?>checked<?php } ?>><label for="md_show_1">공용</label>
                        <input type="radio" name="md_show" id="md_show_2" class="magic-radio" value="pc" <?php if (isset($md_show) && $md_show == "pc") { ?>checked<?php } ?>><label for="md_show_2">PC 전용</label>
                        <input type="radio" name="md_show" id="md_show_3" class="magic-radio" value="mobile" <?php if (isset($md_show) && $md_show == "mobile") { ?>checked<?php } ?>><label for="md_show_3">Mobile 전용</label>
                    </ul>


                    <ul class="mt-10">
                        <select class="select w100" name="md_type" id="md_type">
                            <option value="">출력 타입을 선택하세요.</option>
                            <option value="latest" <?php if (isset($md_type) && $md_type == "latest") { ?>selected<?php } ?>>최신글</option>
                            <option value="tab" <?php if (isset($md_type) && $md_type == "tab") { ?>selected<?php } ?>>최신글 탭</option>
                            <option value="widget" <?php if (isset($md_type) && $md_type == "widget") { ?>selected<?php } ?>>위젯</option>
                            <option value="banner" <?php if (isset($md_type) && $md_type == "banner") { ?>selected<?php } ?>>배너</option>
                            <option value="poll" <?php if (isset($md_type) && $md_type == "poll") { ?>selected<?php } ?>>투표</option>
                            <?php if($is_shop == 1) { // 영카트?>
                            <option value="item" <?php if (isset($md_type) && $md_type == "item") { ?>selected<?php } ?>>상품</option>
                            <?php } ?>
                        </select>
                    </ul>
                     
                     
                    <ul class="mt-5 selected_poll selected_select">
                        <select class="select w100" name="md_poll">
                            <option value="">출력 스킨을 선택하세요.</option>
                            <?php echo rb_skin_select('poll', $md_poll); ?>
                        </select>
                    </ul>
                     
                    <ul class="mt-5 selected_poll selected_select">
                        <select class="select w100" name="md_poll_id">
                            <option value="">출력할 투표를 선택하세요.</option>
                            <?php echo rb_poll_list($md_poll_id); ?>
                        </select>
                    </ul>
                    
                    
                     
                     
                      

                    <ul class="mt-5 selected_widget selected_select">
                        <select class="select w100" name="md_widget">
                            <option value="">출력할 위젯을 선택하세요.</option>
                            <?php echo rb_widget_select('rb.widget', $md_widget); ?>
                        </select>
                        
                        <h6 class="font-R rb_config_sub_txt">
                            신규 위젯 추가는 빌더가이드를 참고해주세요.<br>
                            해당 파일의 경로를 참고하셔서 코드를 직접 수정해주세요.
                        </h6>
                        
                    </ul>
                    

                    
                    <ul class="mt-5 selected_banner selected_select">
                        <select class="select w100" name="md_banner" id="md_banner">
                            <option value="">출력할 배너그룹을 선택하세요.</option>
                            <?php echo rb_banner_list($md_banner); ?>
                        </select>
                    </ul>
                    
                    <ul class="mt-5 selected_banner2">
                        <select class="select w100" name="md_banner_id">
                            <option value="">출력할 배너를 선택하세요.</option>
                            <?php echo rb_banner_id_list($md_banner_id); ?>
                        </select>
                    </ul>
                    
                    <ul class="mt-5 selected_banner selected_select">
                        <select class="select w100" name="md_banner_skin">
                            <option value="">출력 스킨을 선택하세요.</option>
                            <?php echo rb_banner_skin_select('rb.mod/banner/skin', $md_banner_skin); ?>
                        </select>
                        
                        <h6 class="font-R rb_config_sub_txt">
                            배너를 먼저 등록해 주세요.<br>
                            개별출력의 경우 출력할 배너를 선택해주세요.
                        </h6>
                    </ul>
                    
                    
                    <!-- 탭 { -->

                    <ul class="mt-5 selected_tab selected_select" id="tab_send">
                        <select class="select w100" name="md_bo_table_tab">
                            <option value="">연결할 게시판을 선택하세요.</option>
                            <?php echo rb_board_list($md_bo_table); ?>
                        </select>
                    </ul>

                    <div id="tab_cates">
                        <ul class="mt-5 selected_tab selected_select">
                            <select class="select w100" name="md_sca_tab" id="tab_sca">
                                <option value="">카테고리를 선택하세요.</option>
                                <?php echo rb_sca_list($md_bo_table, $md_sca); ?>
                                <option value="">전체</option>
                            </select>
                        </ul>
                    </div>

                    <div id="tab_selects" class="selected_tags mt-3"></div>
                    <input type="hidden" name="md_tab_list" id="md_tab_list" value='<?php echo htmlspecialchars($md_tab_list, ENT_QUOTES); ?>'>

                    <script>
                    $(document).ready(function () {
                        let selectedData = [];

                        // 복원: 저장된 md_tab_list 값을 읽어서 태그로 출력
                        const savedList = $('#md_tab_list').val();
                        if (savedList && savedList.startsWith('[')) {
                            try {
                                const parsed = JSON.parse(savedList);
                                if (Array.isArray(parsed)) {
                                    parsed.forEach(item => {
                                        if (!selectedData.includes(item)) {
                                            selectedData.push(item);

                                            const parts = item.split('||');
                                            const bo_table = parts[0];
                                            const ca_name = parts.length > 1 ? parts[1] : '';

                                            // fallback 처리
                                            let bo_text = bo_table;
                                            const $boOption = $(`select[name="md_bo_table_tab"] option[value="${bo_table}"]`);
                                            if ($boOption.length > 0) {
                                                bo_text = $boOption.text().trim();
                                            }

                                            const ca_text = ca_name ? ca_name : '전체';
                                            const tagText = `${bo_text} / ${ca_text}`;

                                            const tagHtml = `
                                                <span class="tag" data-key="${item}">
                                                    ${tagText}
                                                    <button type="button" class="tag-remove" title="삭제">×</button>
                                                </span>
                                            `;
                                            $('#tab_selects').append(tagHtml);
                                        }
                                    });
                                    updateHiddenField();
                                }
                            } catch (e) {
                                console.error('태그 복원 실패:', e, savedList);
                            }
                        }

                        // 선택 시 태그 추가
                        $(document).off('change', 'select[name="md_sca_tab"]').on('change', 'select[name="md_sca_tab"]', function () {
                            const bo_table = $('select[name="md_bo_table_tab"]').val();
                            const bo_text = $('select[name="md_bo_table_tab"] option:selected').text().trim();
                            const ca_name = $(this).val();
                            const ca_text = $(this).find('option:selected').text().trim();

                            if (!bo_table) return;

                            const isAll = ca_name === '';
                            const uniqueKey = isAll ? bo_table : `${bo_table}||${ca_name}`;
                            const tagText = isAll ? `${bo_text} / 전체` : `${bo_text} / ${ca_text}`;

                            if (selectedData.includes(uniqueKey)) return;

                            selectedData.push(uniqueKey);

                            const tagHtml = `
                                <span class="tag" data-key="${uniqueKey}">
                                    ${tagText}
                                    <button type="button" class="tag-remove" title="삭제">×</button>
                                </span>
                            `;
                            $('#tab_selects').append(tagHtml);
                            updateHiddenField();
                        });

                        // 태그 삭제
                        $('#tab_selects').on('click', '.tag-remove', function () {
                            const $tag = $(this).closest('.tag');
                            const key = $tag.data('key');
                            selectedData = selectedData.filter(k => k !== key);
                            $tag.remove();
                            updateHiddenField();
                        });

                        // 드래그
                        $('#tab_selects').sortable({
                            items: '.tag',
                            update: function () {
                                // 순서 변경 시 selectedData도 재구성
                                selectedData = [];
                                $('#tab_selects .tag').each(function () {
                                    const key = $(this).data('key');
                                    selectedData.push(key);
                                });
                                updateHiddenField();
                            }
                        });

                        function updateHiddenField() {
                            $('#md_tab_list').val(JSON.stringify(selectedData));
                        }
                    });
                    </script>

                    <!-- } -->

                    <ul class="mt-5 selected_tab selected_select">
                        <select class="select w100" name="md_tab_skin" id="md_tab_skin">
                            <option value="">출력 스킨을 선택하세요.</option>
                            <?php echo rb_skin_select('latest_tabs', $md_tab_skin); ?>
                        </select>
                    </ul>


                    <ul class="mt-5 selected_latest selected_select" id="board_send">
                        <select class="select w100" name="md_bo_table">
                            <option value="">연결할 게시판을 선택하세요.</option>
                            <?php echo rb_board_list($md_bo_table); ?>
                        </select>
                    </ul>

                    <div id="res_cates">
                        <ul class="mt-5 selected_latest selected_select">
                            <select class="select w100" name="md_sca" id="md_sca">
                                <option value="">전체 카테고리</option>
                                <?php echo rb_sca_list($md_bo_table, $md_sca); ?>
                            </select>
                        </ul>
                    </div>

                    <ul class="mt-5 selected_latest selected_select">
                        <select class="select w100" name="md_skin" id="md_skin">
                            <option value="">출력 스킨을 선택하세요.</option>
                            <?php echo rb_skin_select('latest', $md_skin); ?>
                        </select>
                    </ul>

                    <?php 
                      if($is_shop == 1) {
                          // 분류리스트
                            $category_select = '';
                            $sql = " select * from {$g5['g5_shop_category_table']} ";
                            if ($is_admin != 'super')
                                $sql .= " where ca_mb_id = '{$member['mb_id']}' ";
                            $sql .= " order by ca_order, ca_id ";
                            $result = sql_query($sql);
                            for ($i=0; $row=sql_fetch_array($result); $i++)
                            {
                                $len = strlen($row['ca_id']) / 2 - 1;

                                $nbsp = "";
                                for ($i=0; $i<$len; $i++)
                                    $nbsp .= "&nbsp;&nbsp;&nbsp;";

                                $category_select .= "<option value=\"{$row['ca_id']}\">$nbsp{$row['ca_name']}</option>\n";
                            }
                    ?>
                    
                    
                    <ul class="mt-5 selected_item selected_select">
                        <select class="select w100" name="md_module" id="md_module_shop">
                            <option value="0" <?php if (isset($md_module) && $md_module == "0") { ?>selected<?php } ?>>전체상품</option>
                            <option value="1" <?php if (isset($md_module) && $md_module == "1") { ?>selected<?php } ?>>히트상품</option>
                            <option value="2" <?php if (isset($md_module) && $md_module == "2") { ?>selected<?php } ?>>추천상품</option>
                            <option value="3" <?php if (isset($md_module) && $md_module == "3") { ?>selected<?php } ?>>최신상품</option>
                            <option value="4" <?php if (isset($md_module) && $md_module == "4") { ?>selected<?php } ?>>인기상품</option>
                            <option value="5" <?php if (isset($md_module) && $md_module == "5") { ?>selected<?php } ?>>할인상품</option>
                        </select>
                    </ul>
                    
                    <ul class="mt-5 selected_item selected_select">
                        <select class="select w100" name="md_sca" id="md_sca_shop">
                            <option value="">전체 카테고리</option>
                            <?php echo conv_selected_option($category_select, $md_sca); ?>
                        </select>
                    </ul>
                    
                    <ul class="mt-5 selected_item selected_select">
                        <select class="select w100" name="md_order" id="md_order_shop">
                            <option value="">출력 옵션을 선택하세요.</option>
                            <option value="it_id desc" <?php if (isset($md_order) && $md_order == "it_id desc") { ?>selected<?php } ?>>기본순</option>
                            <option value="it_time desc" <?php if (isset($md_order) && $md_order == "it_time desc") { ?>selected<?php } ?>>최근등록순</option>
                            <option value="it_hit desc" <?php if (isset($md_order) && $md_order == "it_hit desc") { ?>selected<?php } ?>>조회수높은순</option>
                            <option value="it_stock_qty asc" <?php if (isset($md_order) && $md_order == "it_stock_qty asc") { ?>selected<?php } ?>>품절임박순</option>
                            <option value="it_price desc" <?php if (isset($md_order) && $md_order == "it_price desc") { ?>selected<?php } ?>>판매가높은순</option>
                            <option value="it_price asc" <?php if (isset($md_order) && $md_order == "it_price asc") { ?>selected<?php } ?>>판매가낮은순</option>
                            <option value="it_use_avg desc" <?php if (isset($md_order) && $md_order == "it_use_avg desc") { ?>selected<?php } ?>>평점높은순</option>
                            <option value="it_use_cnt desc" <?php if (isset($md_order) && $md_order == "it_use_cnt desc") { ?>selected<?php } ?>>리뷰많은순</option>
                            <option value="rand()" <?php if (isset($md_order) && $md_order == "rand()") { ?>selected<?php } ?>>랜덤</option>
                        </select>
                    </ul>
                    
                    



                    <ul class="mt-5 selected_item selected_select">
                        <select class="select w100" name="md_skin" id="md_skin_shop">
                            <?php echo rb_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $md_skin); ?>
                        </select>
                    </ul>

                    <div>
                        <ul class="mt-5 selected_item selected_select">
                            <input type="checkbox" name="md_soldout_asc" id="md_soldout_asc" value="1" <?php if (isset($md_soldout_asc) && $md_soldout_asc == "1") { ?>checked<?php } ?>><label for="md_soldout_asc">품절상품 후순위 정렬</label>
                            <input type="checkbox" name="md_soldout_hidden" id="md_soldout_hidden" value="1" <?php if (isset($md_soldout_hidden) && $md_soldout_hidden == "1") { ?>checked<?php } ?>><label for="md_soldout_hidden">품절상품 숨김</label>
                        </ul>
                    </div>

                    <?php } ?>

                    <div>
                        <ul class="mt-5 selected_latest_tab selected_select">
                            <select class="select w100" name="md_order_latest" id="md_order_latest">
                                <option value="">출력 옵션을 선택하세요.</option>
                                <option value="wr_num" <?php if (isset($md_order_latest) && $md_order_latest == "wr_num") { ?>selected<?php } ?>>기본순</option>
                                <option value="wr_hit desc" <?php if (isset($md_order_latest) && $md_order_latest == "wr_hit desc") { ?>selected<?php } ?>>조회 높은순</option>
                                <option value="wr_good desc" <?php if (isset($md_order_latest) && $md_order_latest == "wr_good desc") { ?>selected<?php } ?>>추천 많은순</option>
                                <option value="wr_comment desc" <?php if (isset($md_order_latest) && $md_order_latest == "wr_comment desc") { ?>selected<?php } ?>>댓글 많은순</option>
                                <option value="rand()" <?php if (isset($md_order_latest) && $md_order_latest == "rand()") { ?>selected<?php } ?>>랜덤</option>
                            </select>
                        </ul>
                    </div>

                    <script>
                        
                        $('#board_send').change(function() {
                            scaAjax();
                        });
                        
                        // 해당게시판의 카테고리를 얻는다
                        function scaAjax() {
                            
                            var md_bo_table = $('select[name="md_bo_table"]').val();
                            var mod_type = 'ca_name';
                            
                            $.ajax({
                                url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                                method: 'POST', // POST 방식으로 전송
                                dataType: 'html',
                                data: { 
                                    "md_bo_table":md_bo_table,
                                    "mod_type":mod_type,
                                },
                                success: function(response) {
                                    $("#res_cates").html(response); //성공
                                },
                                error: function(xhr, status, error) {
                                    console.error('처리에 문제가 있습니다. 잠시 후 이용해주세요.');
                                }
                
                            });
                        }
                        


                        $('#tab_send').change(function() {
                            tabscaAjax();
                        });

                        // 해당게시판의 카테고리를 얻는다
                        function tabscaAjax() {

                            var md_bo_table = $('select[name="md_bo_table_tab"]').val();
                            var mod_type = 'ca_name_tab';

                            $.ajax({
                                url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.res.php',
                                method: 'POST', // POST 방식으로 전송
                                dataType: 'html',
                                data: {
                                    "md_bo_table":md_bo_table,
                                    "mod_type":mod_type,
                                },
                                success: function(response) {
                                    $("#tab_cates").html(response); //성공
                                },
                                error: function(xhr, status, error) {
                                    console.error('처리에 문제가 있습니다. 잠시 후 이용해주세요.');
                                }

                            });
                        }




                        $(document).ready(function() {
                            
                            var md_type = $('select[name="md_type"]').val();
                            $('.selected_select').hide();
                            $('.selected_all').hide();
                            $('.selected_style').hide();
                            
                            if(md_type == "latest") {
                                $('.selected_latest').show();
                                $('.selected_all').show();
                                $('.selected_latest_tab').show();
                                $('.selected_style').show();
                            } else if(md_type == "tab") {
                                $('.selected_tab').show();
                                $('.selected_all').show();
                                 $('.selected_latest_tab').show();
                                $('.selected_style').show();
                            } else if(md_type == "widget") {
                                $('.selected_widget').show();
                                $('.selected_all').show();
                                $('.selected_style').show();
                            } else if(md_type == "banner") {
                                $('.selected_banner').show();
                                $('.selected_all').show();
                                $('.selected_style').show();
                            } else if(md_type == "poll") {
                                $('.selected_poll').show();
                                $('.selected_all').show();
                                $('.selected_style').show();
                            } else if(md_type == "item") {
                                $('.selected_item').show();
                                $('.selected_all').show();
                                $('.selected_style').show();
                            } else { 
                                $('.selected_select').hide();
                                $('.selected_all').hide();
                                $('.selected_style').hide();
                                $('.selected_latest_tab').hide();
                                $('.selected_tab').hide();
                            }

                            $('#md_type').change(function() {
                                var selectedValue = $(this).val();

                                
                                $('input[name="md_radius"]').val('0');
                                $('input[name="md_radius_shop"]').val('0');
                                $("#md_radius_shop").val('0');
                                $("#md_radius").val('0');
                                $("#md_radius_range .ui-slider-handle").html("0");
                                $("#md_radius_range .ui-slider-handle").css("left", "0");
                                $("#md_radius_range .ui-slider-range").css("width", "0");
                                
                                $('input[name="md_padding"]').val('0');
                                $('input[name="md_padding_shop"]').val('0');
                                $("#md_padding_shop").val('0');
                                $("#md_padding").val('0');
                                $("#md_padding_range .ui-slider-handle").html("0");
                                $("#md_padding_range .ui-slider-handle").css("left", "0");
                                $("#md_padding_range .ui-slider-range").css("width", "0");
                                
                                $('input[name="md_margin_top_pc"]').val('');
                                $('input[name="md_margin_top_mo"]').val('');
                                $('input[name="md_margin_top_pc_shop"]').val('');
                                $('input[name="md_margin_top_mo_shop"]').val('');

                                $('input[name="md_margin_btm_pc"]').val('');
                                $('input[name="md_margin_btm_mo"]').val('');
                                $('input[name="md_margin_btm_pc_shop"]').val('');
                                $('input[name="md_margin_btm_mo_shop"]').val('');

                                $("#md_tab_list").val('');
                                $('#tab_selects .tag').remove();


                                $('.selected_select').hide();
                                $('.selected_all').hide();
                                $('.selected_style').hide();
                                
                                if (selectedValue == "latest" || selectedValue == "tab") {
                                    $('.selected_latest_tab').show();
                                } else {
                                    $('.selected_latest_tab').hide();
                                }

                                $('.selected_style').show();
                                
                                if (selectedValue !== "none") {
                                    $('.selected_' + selectedValue).show();
                                    $('.selected_all').show();
                                }
                            });
                        });
                        
                        
                        $(document).ready(function() {
                            $('.selected_banner2').hide();
                            
                            var md_banner = $('select[name="md_banner"]').val();

                            if(md_banner == "개별출력") {
                                $('.selected_banner2').show();
                            } else { 
                                $('.selected_banner2').hide();
                            }

                            $('#md_banner').change(function() {
                                var selectedValue = $(this).val();
                                if (selectedValue == "개별출력") {
                                    $('.selected_banner2').show();
                                } else { 
                                    $('.selected_banner2').hide();
                                }
                            });
                            
                        });
                    </script>

                    <div>
                        <ul class="mt-5 selected_latest_tab selected_select">
                            <input type="checkbox" name="md_notice" id="md_notice" value="1" <?php if (isset($md_notice) && $md_notice == "1") { ?>checked<?php } ?>><label for="md_notice">공지 상단고정</label>
                        </ul>
                    </div>

                   
                    <?php if(isset($md_skin) && $md_skin && isset($md_type) && $md_type == "latest") { ?>

                        <ul class="skin_path_url mt-5">
                            <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                            <li class="skin_path_url_txt">
                            <?php echo str_replace('theme','/theme/'.$theme_name.'/skin/latest',$md_skin); ?>/
                            </li>
                            <div class="cb"></div>
                        </ul>

                    <?php } ?>
                    
                    <?php if(isset($md_tab_skin) && $md_tab_skin && isset($md_type) && $md_type == "tab") { ?>

                        <ul class="skin_path_url mt-5">
                            <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                            <li class="skin_path_url_txt">
                            <?php echo str_replace('theme','/theme/'.$theme_name.'/skin/latest_tab',$md_tab_skin); ?>/
                            </li>
                            <div class="cb"></div>
                        </ul>

                    <?php } ?>

                    <?php if(isset($md_widget) && $md_widget && isset($md_type) && $md_type == "widget") { ?>
                    <ul class="skin_path_url mt-5">
                        <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                        <li class="skin_path_url_txt">
                        <?php echo str_replace('rb.widget','/rb/rb.widget',$md_widget); ?>/
                        </li>
                        <div class="cb"></div>
                    </ul>
                    <?php } ?>
                    
                    <?php if(isset($md_poll) && $md_poll && isset($md_type) && $md_type == "poll") { ?>
                    <ul class="skin_path_url mt-5">
                        <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                        <li class="skin_path_url_txt">
                        <?php echo str_replace('theme','/theme/'.$theme_name.'/skin/poll',$md_poll); ?>/
                        </li>
                        <div class="cb"></div>
                    </ul>
                    <?php } ?>
                    
                    <?php if(isset($md_banner) && $md_banner && isset($md_type) && $md_type == "banner") { ?>
                    <ul class="skin_path_url mt-5">
                        <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
                        <li class="skin_path_url_txt">
                        <?php echo str_replace('rb.mod','/rb/rb.mod',$md_banner_skin); ?>/
                        </li>
                        <div class="cb"></div>
                    </ul>
                    <?php } ?>

                    
                    <ul class="rb_config_sec selected_banner selected_select">
                        <h6 class="font-B">백그라운드 컬러 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                        배너영역의 백그라운드 컬러를 설정할 수 있습니다. 
                        </h6>
                        <div class="config_wrap">
                            <ul class="flex_left">
                                <input type="text" name="md_banner_bg" class="input w50 h40 text-center" value="<?php echo !empty($md_banner_bg) ? $md_banner_bg : ''; ?>" placeholder="컬러코드(16진수)" autocomplete="off">
                                <span class="bn_bg_color_label" style="background-color:<?php echo $md_banner_bg?>"></span>
                                <span>예) #FFFFFF</span>
                            </ul>
                        </div>
                    </ul>
                    
                    <ul class="rb_config_sec selected_style selected_select">
                        <h6 class="font-B">모듈 스타일 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">모듈 박스의 스타일을 설정할 수 있습니다.</h6>
                        <div class="config_wrap">
                        
                           <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">테두리</span><br>
                                    border
                                </li>
                                <li class="rows_inp_r mt-5">
                                    <?php if($is_shop == 1) { // 영카트?>
                                    <input type="radio" name="md_border_shop" id="md_border_shop_1" class="magic-radio" value="" <?php if (isset($md_border) && $md_border == "" || empty($md_border)) { ?>checked<?php } ?>><label for="md_border_shop_1">없음</label>
                                    <input type="radio" name="md_border_shop" id="md_border_shop_2" class="magic-radio" value="solid" <?php if (isset($md_border) && $md_border == "solid") { ?>checked<?php } ?>><label for="md_border_shop_2">실선</label>　
                                    <input type="radio" name="md_border_shop" id="md_border_shop_3" class="magic-radio" value="dashed" <?php if (isset($md_border) && $md_border == "dashed") { ?>checked<?php } ?>><label for="md_border_shop_3">점선</label>
                                    <?php } else { ?>
                                    <input type="radio" name="md_border" id="md_border_1" class="magic-radio" value="" <?php if (isset($md_border) && $md_border == "" || empty($md_border)) { ?>checked<?php } ?>><label for="md_border_1">없음</label>
                                    <input type="radio" name="md_border" id="md_border_2" class="magic-radio" value="solid" <?php if (isset($md_border) && $md_border == "solid") { ?>checked<?php } ?>><label for="md_border_2">실선</label>　
                                    <input type="radio" name="md_border" id="md_border_3" class="magic-radio" value="dashed" <?php if (isset($md_border) && $md_border == "dashed") { ?>checked<?php } ?>><label for="md_border_3">점선</label>
                                    <?php } ?>
                                </li>

                                <div class="cb"></div>
                            </ul>



                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">상단 간격</span><br>
                                    margin-top
                                </li>
                                <li class="rows_inp_r mt-5">
                                    <?php if($is_shop == 1) { // 영카트?>
                                    <input type="number" id="md_margin_top_pc_shop" class="tiny_input w25 ml-0" name="md_margin_top_pc_shop" placeholder="PC" value="<?php echo !empty($md_margin_top_pc) ? $md_margin_top_pc : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="md_margin_top_mo_shop" class="tiny_input w25 ml-0" name="md_margin_top_mo_shop" placeholder="Mobile" value="<?php echo !empty($md_margin_top_mo) ? $md_margin_top_mo : ''; ?>"> <span class="font-12">px</span>
                                    <?php } else { ?>
                                    <input type="number" id="md_margin_top_pc" class="tiny_input w25 ml-0" name="md_margin_top_pc" placeholder="PC" value="<?php echo !empty($md_margin_top_pc) ? $md_margin_top_pc : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="md_margin_top_mo" class="tiny_input w25 ml-0" name="md_margin_top_mo" placeholder="Mobile" value="<?php echo !empty($md_margin_top_mo) ? $md_margin_top_mo : ''; ?>"> <span class="font-12">px</span>
                                    <?php } ?>
                                </li>

                                <div class="cb"></div>
                            </ul>


                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">하단 간격</span><br>
                                    margin-bottom
                                </li>
                                <li class="rows_inp_r mt-5">
                                    <?php if($is_shop == 1) { // 영카트?>
                                    <input type="number" id="md_margin_btm_pc_shop" class="tiny_input w25 ml-0" name="md_margin_btm_pc_shop" placeholder="PC" value="<?php echo !empty($md_margin_btm_pc) ? $md_margin_btm_pc : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="md_margin_btm_mo_shop" class="tiny_input w25 ml-0" name="md_margin_btm_mo_shop" placeholder="Mobile" value="<?php echo !empty($md_margin_btm_mo) ? $md_margin_btm_mo : ''; ?>"> <span class="font-12">px</span>
                                    <?php } else { ?>
                                    <input type="number" id="md_margin_btm_pc" class="tiny_input w25 ml-0" name="md_margin_btm_pc" placeholder="PC" value="<?php echo !empty($md_margin_btm_pc) ? $md_margin_btm_pc : ''; ?>"> <span class="font-12">px　</span>
                                    <input type="number" id="md_margin_btm_mo" class="tiny_input w25 ml-0" name="md_margin_btm_mo" placeholder="Mobile" value="<?php echo !empty($md_margin_btm_mo) ? $md_margin_btm_mo : ''; ?>"> <span class="font-12">px</span>
                                    <?php } ?>
                                </li>

                                <div class="cb"></div>
                            </ul>

                            
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">모서리 라운드</span><br>
                                    border-radius
                                </li>
                                <li class="rows_inp_r mt-15">
                                    <div id="md_radius_range" class="rb_range_item"></div>
                                    <?php if($is_shop == 1) { // 영카트?>
                                    <input type="hidden" id="md_radius_shop" class="co_range_send" name="md_radius_shop" value="<?php echo !empty($md_radius) ? $md_radius : '0'; ?>">
                                    <?php } else { ?>
                                    <input type="hidden" id="md_radius" class="co_range_send" name="md_radius" value="<?php echo !empty($md_radius) ? $md_radius : '0'; ?>">
                                    <?php } ?>
                                </li>
                                
                                <script type="text/javascript">

                                $("#md_radius_range").slider({
                                  range: "min",
                                  min: 0,
                                  max: 30,
                                  value: <?php echo !empty($md_radius) ? $md_radius : '0'; ?>,
                                  step: 5,
                                  slide: function(e, ui) {
                                    $("#md_radius_range .ui-slider-handle").html(ui.value);
                                    
                                    <?php if($is_shop == 1) { // 영카트?>
                                        $("#md_radius_shop").val(ui.value); // hidden input에 값 업데이트
                                    <?php } else { ?>
                                        $("#md_radius").val(ui.value); // hidden input에 값 업데이트
                                    <?php } ?>
                                    
                                  }
                                });

                                $("#md_radius_range .ui-slider-handle").html("<?php echo !empty($md_radius) ? $md_radius : '0'; ?>");
                                <?php if($is_shop == 1) { // 영카트?>
                                $("#md_radius_shop").val("<?php echo !empty($md_radius) ? $md_radius : '0'; ?>"); // 초기값 설정
                                <?php } else { ?>
                                $("#md_radius").val("<?php echo !empty($md_radius) ? $md_radius : '0'; ?>"); // 초기값 설정
                                <?php } ?>
                                </script>

                                <div class="cb"></div>
                            </ul>
                            
                            
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">내부 여백</span><br>
                                    padding
                                </li>
                                <li class="rows_inp_r mt-15">
                                    <div id="md_padding_range" class="rb_range_item"></div>
                                    <?php if($is_shop == 1) { // 영카트?>
                                    <input type="hidden" id="md_padding_shop" class="co_range_send" name="md_padding_shop" value="<?php echo !empty($md_padding) ? $md_padding : '0'; ?>">
                                    <?php } else { ?>
                                    <input type="hidden" id="md_padding" class="co_range_send" name="md_padding" value="<?php echo !empty($md_padding) ? $md_padding : '0'; ?>">
                                    <?php } ?>
                                </li>
                                
                                <script type="text/javascript">

                                $("#md_padding_range").slider({
                                  range: "min",
                                  min: 0,
                                  max: 30,
                                  value: <?php echo !empty($md_padding) ? $md_padding : '0'; ?>,
                                  step: 5,
                                  slide: function(e, ui) {
                                    $("#md_padding_range .ui-slider-handle").html(ui.value);
                                    
                                    <?php if($is_shop == 1) { // 영카트?>
                                        $("#md_padding_shop").val(ui.value); // hidden input에 값 업데이트
                                    <?php } else { ?>
                                        $("#md_padding").val(ui.value); // hidden input에 값 업데이트
                                    <?php } ?>
                                  }
                                });

                                $("#md_padding_range .ui-slider-handle").html("<?php echo !empty($md_padding) ? $md_padding : '0'; ?>");
                                <?php if($is_shop == 1) { // 영카트?>
                                $("#md_padding_shop").val("<?php echo !empty($md_padding) ? $md_padding : '0'; ?>"); // 초기값 설정
                                <?php } else { ?>
                                $("#md_padding").val("<?php echo !empty($md_padding) ? $md_padding : '0'; ?>"); // 초기값 설정
                                <?php } ?>

                                </script>
                                <div class="cb"></div>
                            </ul>


                        </div>
                    </ul>
                    
                    
                    
                    <?php
                        if($is_shop == 1) {
                    ?>

                    <ul class="rb_config_sec selected_item selected_select">
                        <h6 class="font-B">출력갯수 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            열(가로)X행(세로) 출력갯수를 설정할 수 있습니다.
                        </h6>
                        <div class="config_wrap">
                            <ul class="rows_inp_lr">
                                <li class="rows_inp_l">
                                    <input type="number" name="md_cnt" id="md_cnt_shop" class="input w60 h40 text-center" value="<?php echo !empty($md_cnt) ? $md_cnt : ''; ?>" placeholder="갯수" autocomplete="off" autocomplete="off">　<span>개</span>
                                </li>
                                <li class="rows_inp_r">
                                    <input type="number" name="md_col" id="md_col_shop" class="input w30 h40 text-center" value="<?php echo !empty($md_col) ? $md_col : ''; ?>" placeholder="열" autocomplete="off">　<span>X</span>
                                    <input type="number" name="md_row" id="md_row_shop" class="input w30 h40 text-center" value="<?php echo !empty($md_row) ? $md_row : ''; ?>" placeholder="행" autocomplete="off">
                                </li>
                                <div class="cb"></div>
                            </ul>
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">Mobile 버전</span><br>
                                    1024px 이하
                                </li>
                                <li class="rows_inp_r">
                                    <input type="number" name="md_col_mo" id="md_col_mo_shop" class="input w30 h40 text-center" value="<?php echo !empty($md_col_mo) ? $md_col_mo : ''; ?>" placeholder="열" autocomplete="off">　<span>X</span>
                                    <input type="number" name="md_row_mo" id="md_row_mo_shop" class="input w30 h40 text-center" value="<?php echo !empty($md_row_mo) ? $md_row_mo : ''; ?>" placeholder="행" autocomplete="off">
                                </li>
                                <div class="cb"></div>
                            </ul>
                        </div>
                    </ul>
                    
                    
                    <ul class="rb_config_sec selected_item selected_select">
                        <h6 class="font-B">간격 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            상품간의 간격(여백)을 설정할 수 있습니다.
                        </h6>
                        
                        <div class="config_wrap">
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">PC 버전</span><br>
                                    1024px 이상
                                </li>
                                <li class="rows_inp_r">
                                    <input type="number" name="md_gap" id="md_gap_shop" class="input w40 h40 text-center" value="<?php echo !empty($md_gap) ? $md_gap : ''; ?>" placeholder="간격(px)" autocomplete="off">　<span>px (PC)</span>
                                </li>
                                <div class="cb"></div>
                            </ul>
                            <ul class="rows_inp_lr mt-10">
                                <li class="rows_inp_l rows_inp_l_span">
                                    <span class="font-B">Mobile 버전</span><br>
                                    1024px 이하
                                </li>
                                <li class="rows_inp_r">
                                    <input type="number" name="md_gap_mo" id="md_gap_mo_shop" class="input w40 h40 text-center" value="<?php echo !empty($md_gap_mo) ? $md_gap_mo : ''; ?>" placeholder="간격(px)" autocomplete="off">　<span>px (Mobile)</span>
                                </li>
                                <div class="cb"></div>
                            </ul>

                        </div>
                    </ul>
                    
                    <ul class="rb_config_sec selected_item selected_select">
                        <h6 class="font-B">스와이프 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            행X열 보다 출력갯수가 많을 경우<br>
                            스와이프 및 자동롤링 처리 유무를 설정할 수 있습니다.
                        </h6>
                        <div class="config_wrap">
                            <input type="checkbox" name="md_swiper_is" class="md_swiper_is_shop" id="md_swiper_is_shop" class="magic-checkbox" value="1" <?php if (isset($md_swiper_is) && $md_swiper_is == 1) { ?>checked<?php } ?>><label for="md_swiper_is_shop">스와이프 사용</label>
                        </div>

                        <div class="config_wrap">
                            <input type="checkbox" name="md_auto_is" id="md_auto_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_auto_is) && $md_auto_is == 1) { ?>checked<?php } ?>><label for="md_auto_is_shop">자동롤링 사용</label>　
                            <input type="number" name="md_auto_time" id="md_auto_time_shop" class="input w30 h40 text-center" value="<?php echo !empty($md_auto_time) ? $md_auto_time : ''; ?>" placeholder="밀리초" autocomplete="off">　<span>3000=3초</span>
                        </div>


                    </ul>




                    
                    <ul class="rb_config_sec selected_item selected_select">
                        <h6 class="font-B">출력항목 설정</h6>
                        <h6 class="font-R rb_config_sub_txt">
                            선택하신 항목이 출력됩니다.
                        </h6>
                        <div class="config_wrap">
                            <ul>
                                <input type="checkbox" name="md_ca_is" id="md_ca_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_ca_is) && $md_ca_is == 1) { ?>checked<?php } ?>><label for="md_ca_is_shop">카테고리</label>　
                                <input type="checkbox" name="md_thumb_is" id="md_thumb_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_thumb_is) && $md_thumb_is == 1) { ?>checked<?php } ?>><label for="md_thumb_is_shop">상품이미지</label>　
                                <input type="checkbox" name="md_subject_is" id="md_subject_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_subject_is) && $md_subject_is == 1) { ?>checked<?php } ?>><label for="md_subject_is_shop">상품명</label><br>
                                <input type="checkbox" name="md_content_is" id="md_content_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_content_is) && $md_content_is == 1) { ?>checked<?php } ?>><label for="md_content_is_shop">상품설명</label>　
                                <input type="checkbox" name="md_date_is" id="md_date_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_date_is) && $md_date_is == 1) { ?>checked<?php } ?>><label for="md_date_is_shop">등록일</label>　
                                <input type="checkbox" name="md_comment_is" id="md_comment_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_comment_is) && $md_comment_is == 1) { ?>checked<?php } ?>><label for="md_comment_is_shop">찜갯수</label>　
                                <input type="checkbox" name="md_icon_is" id="md_icon_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_icon_is) && $md_icon_is == 1) { ?>checked<?php } ?>><label for="md_icon_is_shop">아이콘</label>
                            </ul>
                        </div>
                    </ul>
                    
                    
                    <?php } ?>
                    
                    
                    
                    
                    
                    
                    
                    
                </div>
            </ul>
            
            
            <ul class="rb_config_sec selected_latest_tab selected_select">
                <h6 class="font-B">출력갯수 설정</h6>
                <h6 class="font-R rb_config_sub_txt">
                    열(가로)X행(세로) 출력갯수를 설정할 수 있습니다.
                </h6>
                <div class="config_wrap">
                    <ul class="rows_inp_lr">
                        <li class="rows_inp_l">
                            <input type="number" name="md_cnt" id="md_cnt" class="input w60 h40 text-center" value="<?php echo !empty($md_cnt) ? $md_cnt : ''; ?>" placeholder="갯수" autocomplete="off" autocomplete="off">　<span>개</span>
                        </li>
                        <li class="rows_inp_r">
                            <input type="number" name="md_col" id="md_col" class="input w30 h40 text-center" value="<?php echo !empty($md_col) ? $md_col : ''; ?>" placeholder="열" autocomplete="off">　<span>X</span>
                            <input type="number" name="md_row" id="md_row" class="input w30 h40 text-center" value="<?php echo !empty($md_row) ? $md_row : ''; ?>" placeholder="행" autocomplete="off">
                        </li>
                        <div class="cb"></div>
                    </ul>
                    <ul class="rows_inp_lr mt-10">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">Mobile 버전</span><br>
                            1024px 이하
                        </li>
                        <li class="rows_inp_r">
                            <input type="number" name="md_col_mo" id="md_col_mo" class="input w30 h40 text-center" value="<?php echo !empty($md_col_mo) ? $md_col_mo : ''; ?>" placeholder="열" autocomplete="off">　<span>X</span>
                            <input type="number" name="md_row_mo" id="md_row_mo" class="input w30 h40 text-center" value="<?php echo !empty($md_row_mo) ? $md_row_mo : ''; ?>" placeholder="행" autocomplete="off">
                        </li>
                        <div class="cb"></div>
                    </ul>
                </div>
            </ul>
            
            <ul class="rb_config_sec selected_latest_tab selected_select">
                <h6 class="font-B">간격 설정</h6>
                <h6 class="font-R rb_config_sub_txt">
                    게시물간의 간격(여백)을 설정할 수 있습니다.
                </h6>
                <div class="config_wrap">
                    <ul class="rows_inp_lr mt-10">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">PC 버전</span><br>
                            1024px 이상
                        </li>
                        <li class="rows_inp_r">
                            <input type="number" name="md_gap" id="md_gap" class="input w40 h40 text-center" value="<?php echo $md_gap ?>" placeholder="간격(px)" autocomplete="off">　<span>px (PC)</span>
                        </li>
                        <div class="cb"></div>
                    </ul>
                    <ul class="rows_inp_lr mt-10">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">Mobile 버전</span><br>
                            1024px 이하
                        </li>
                        <li class="rows_inp_r">
                            <input type="number" name="md_gap_mo" id="md_gap_mo" class="input w40 h40 text-center" value="<?php echo $md_gap_mo ?>" placeholder="간격(px)" autocomplete="off">　<span>px (Mobile)</span>
                        </li>
                        <div class="cb"></div>
                    </ul>
                    
                </div>
            </ul>
            
            <ul class="rb_config_sec selected_latest_tab selected_select">
                <h6 class="font-B">스와이프 설정</h6>
                <h6 class="font-R rb_config_sub_txt">
                    행X열 보다 출력갯수가 많을 경우<br>
                    스와이프 및 자동롤링 처리 유무를 설정할 수 있습니다.
                </h6>
                <div class="config_wrap">
                    <div class="config_wrap">
                        <input type="checkbox" name="md_swiper_is" class="md_swiper_is" id="md_swiper_is" class="magic-checkbox" value="1" <?php if (isset($md_swiper_is) && $md_swiper_is == 1) { ?>checked<?php } ?>><label for="md_swiper_is">스와이프 사용</label>
                    </div>
                </div>

                <div class="config_wrap">
                    <input type="checkbox" name="md_auto_is" id="md_auto_is" class="magic-checkbox" value="1" <?php if(isset($md_auto_is) && $md_auto_is == 1) { ?>checked<?php } ?>><label for="md_auto_is">자동롤링 사용</label>　
                    <input type="number" name="md_auto_time" id="md_auto_time" class="input w30 h40 text-center" value="<?php echo !empty($md_auto_time) ? $md_auto_time : ''; ?>" placeholder="밀리초" autocomplete="off">　<span>3000=3초</span>
                </div>
            </ul>



            
            <ul class="rb_config_sec selected_all">
                <h6 class="font-B">사이즈 설정</h6>
                <h6 class="font-R rb_config_sub_txt">
                    모듈의 가로, 세로 사이즈를 설정할 수 있습니다.<br>
                    숫자로만 입력해주세요.
                </h6>
                <div class="config_wrap">

                    <ul class="rows_inp_lr mt-10">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">단위설정</span><br>
                            %, PX
                        </li>
                        <li class="rows_inp_r">
                            <input type="radio" name="md_size" id="md_size_1" class="magic-radio" value="%" <?php if (isset($md_size) && $md_size == "" || isset($md_size) && $md_size == "%" || empty($md_size)) { ?>checked<?php } ?>><label for="md_size_1">%</label>
                            <input type="radio" name="md_size" id="md_size_2" class="magic-radio" value="px" <?php if (isset($md_size) && $md_size == "px") { ?>checked<?php } ?>><label for="md_size_2">px</label>
                        </li>

                        <div class="cb"></div>
                    </ul>

                    <ul class="rows_inp_lr mt-10">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">가로사이즈</span><br>
                            %, PX
                        </li>
                        <li class="rows_inp_r">
                            <input type="number" name="md_width" class="input w40 h40 text-center" value="<?php echo !empty($md_width) ? $md_width : '100'; ?>" placeholder="숫자" autocomplete="off">　<span class="md_size_set">%</span>
                        </li>

                        <div class="cb"></div>
                    </ul>

                    <ul class="rows_inp_lr mt-10">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">세로사이즈</span><br>
                            %, PX
                        </li>
                        <li class="rows_inp_r">
                            <input type="text" name="md_height" class="input w40 h40 text-center" value="auto" placeholder="auto" readonly autocomplete="off">　<span class="md_size_set">%</span>
                        </li>

                        <div class="cb"></div>
                    </ul>

                    <script>
                    function updateUnitSpan() {
                        var unit = $("input[name='md_size']:checked").val();
                        $(".md_size_set").text(unit);
                    }

                    // 라디오 변경 시 적용
                    $(document).on('change', "input[name='md_size']", updateUnitSpan);

                    // 페이지 로드시 적용
                    $(document).ready(updateUnitSpan);
                    </script>



                </div>

            </ul>
            
            <ul class="rb_config_sec selected_latest_tab selected_select">
                <h6 class="font-B">출력항목 설정</h6>
                <h6 class="font-R rb_config_sub_txt">
                    선택하신 항목이 출력됩니다.
                </h6>
                <div class="config_wrap">
                    <ul>
                        <input type="checkbox" name="md_subject_is" id="md_subject_is" class="magic-checkbox" value="1" <?php if(isset($md_subject_is) && $md_subject_is == 1) { ?>checked<?php } ?>><label for="md_subject_is">제목</label>　
                        <input type="checkbox" name="md_thumb_is" id="md_thumb_is" class="magic-checkbox" value="1" <?php if(isset($md_thumb_is) && $md_thumb_is == 1) { ?>checked<?php } ?>><label for="md_thumb_is">썸네일</label>　
                        <input type="checkbox" name="md_nick_is" id="md_nick_is" class="magic-checkbox" value="1" <?php if(isset($md_nick_is) && $md_nick_is == 1) { ?>checked<?php } ?>><label for="md_nick_is">닉네임</label>　
                        <input type="checkbox" name="md_date_is" id="md_date_is" class="magic-checkbox" value="1" <?php if(isset($md_date_is) && $md_date_is == 1) { ?>checked<?php } ?>><label for="md_date_is">작성일</label>　
                        <input type="checkbox" name="md_ca_is" id="md_ca_is" class="magic-checkbox" value="1" <?php if(isset($md_ca_is) && $md_ca_is == 1) { ?>checked<?php } ?>><label for="md_ca_is">카테고리</label>　
                        <input type="checkbox" name="md_comment_is" id="md_comment_is" class="magic-checkbox" value="1" <?php if(isset($md_comment_is) && $md_comment_is == 1) { ?>checked<?php } ?>><label for="md_comment_is">댓글</label>　
                        <input type="checkbox" name="md_content_is" id="md_content_is" class="magic-checkbox" value="1" <?php if(isset($md_content_is) && $md_content_is == 1) { ?>checked<?php } ?>><label for="md_content_is">본문내용</label>　
                        <input type="checkbox" name="md_icon_is" id="md_icon_is" class="magic-checkbox" value="1" <?php if(isset($md_icon_is) && $md_icon_is == 1) { ?>checked<?php } ?>><label for="md_icon_is">아이콘</label>　
                    </ul>
                </div>
            </ul>
            
            
            <ul class="rb_config_sec">
                <button type="button" class="rb_config_save font-B" onclick="executeAjax_module()">저장하기</button>
                <button type="button" class="rb_config_close font-B" onclick="toggleSideOptions_close()">취소</button>
                <div class="cb"></div>
            </ul>
        
        <?php } ?>
        
    <?php } ?>
    
    
    <?php if(isset($mod_type) && $mod_type == "del") { ?>
    <h2 class="font-B"><span><?php echo !empty($set_title) ? $set_title : ''; ?></span> 모듈삭제</h2>
    <input type="hidden" name="md_layout" value="<?php echo !empty($set_layout) ? $set_layout : ''; ?>">
    <input type="hidden" name="md_theme" value="<?php echo !empty($theme_name) ? $theme_name : ''; ?>">
    <input type="hidden" name="md_id" value="<?php echo !empty($set_id) ? $set_id : ''; ?>">
                        
        <ul class="rb_config_sec">
           <div class="no_data">
            모듈을 삭제합니다.<br>
            삭제하신 모듈은 복구할 수 없습니다.
            </div>
        </ul>
        
        <ul class="rb_config_sec">
            <button type="button" class="rb_config_save font-B" onclick="executeAjax_module_del()">삭제하기</button>
            <button type="button" class="rb_config_close font-B" onclick="toggleSideOptions_close()">취소</button>
            <div class="cb"></div>
        </ul>
    <?php } ?>
    
    


