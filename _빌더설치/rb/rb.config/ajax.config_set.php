<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

$mod_type = !empty($_POST['mod_type']) ? $_POST['mod_type'] : '';
$is_shop = !empty($_POST['is_shop']) ? $_POST['is_shop'] : '';

if(isset($is_shop) && $is_shop == 1) {
    $rb_module_tables = "rb_module_shop";
    $rb_section_tables = "rb_section_shop";
} else { 
    $rb_module_tables = "rb_module";
    $rb_section_tables = "rb_section";
}

if($mod_type == 1) { //환경설정
    $co_color = !empty($_POST['co_color']) ? $_POST['co_color'] : 'AA20FF';
    $co_header = !empty($_POST['co_header']) ? $_POST['co_header'] : '0';

    $co_main_bg = !empty($_POST['co_main_bg']) ? $_POST['co_main_bg'] : '#FFFFFF';
    $co_sub_bg = !empty($_POST['co_sub_bg']) ? $_POST['co_sub_bg'] : '#FFFFFF';
    $co_gap_mo = !empty($_POST['co_gap_mo']) ? $_POST['co_gap_mo'] : '0';
   
    $co_layout = !empty($_POST['co_layout']) ? $_POST['co_layout'] : 'basic';
    $co_layout_hd = !empty($_POST['co_layout_hd']) ? $_POST['co_layout_hd'] : 'basic';
    $co_layout_ft = !empty($_POST['co_layout_ft']) ? $_POST['co_layout_ft'] : 'basic';
    
    $co_layout_shop = !empty($_POST['co_layout_shop']) ? $_POST['co_layout_shop'] : 'basic';
    $co_layout_hd_shop = !empty($_POST['co_layout_hd_shop']) ? $_POST['co_layout_hd_shop'] : 'basic_row';
    $co_layout_ft_shop = !empty($_POST['co_layout_ft_shop']) ? $_POST['co_layout_ft_shop'] : 'basic';
    
    $co_font = !empty($_POST['co_font']) ? $_POST['co_font'] : 'Pretendard';
    $co_sub_width = !empty($_POST['co_sub_width']) ? $_POST['co_sub_width'] : '1024';
    $co_main_width = !empty($_POST['co_main_width']) ? $_POST['co_main_width'] : '1400';
    $co_tb_width = !empty($_POST['co_tb_width']) ? $_POST['co_tb_width'] : '1400';

    $co_padding_top = isset($_POST['co_padding_top']) ? $_POST['co_padding_top'] : '';
    $co_padding_top_sub = isset($_POST['co_padding_top_sub']) ? $_POST['co_padding_top_sub'] : '';
    $co_padding_top_shop = isset($_POST['co_padding_top_shop']) ? $_POST['co_padding_top_shop'] : '';
    $co_padding_top_sub_shop = isset($_POST['co_padding_top_sub_shop']) ? $_POST['co_padding_top_sub_shop'] : '';

    $co_padding_btm = isset($_POST['co_padding_btm']) ? $_POST['co_padding_btm'] : '';
    $co_padding_btm_sub = isset($_POST['co_padding_btm_sub']) ? $_POST['co_padding_btm_sub'] : '';
    $co_padding_btm_shop = isset($_POST['co_padding_btm_shop']) ? $_POST['co_padding_btm_shop'] : '';
    $co_padding_btm_sub_shop = isset($_POST['co_padding_btm_sub_shop']) ? $_POST['co_padding_btm_sub_shop'] : '';
    
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

if($mod_type == 3) { //섹션설정
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

if($mod_type == "del_sec") { //섹션삭제
    $set_layout = !empty($_POST['set_layout']) ? $_POST['set_layout'] : '';
    $set_id = !empty($_POST['set_id']) ? $_POST['set_id'] : '';
    $theme_name = !empty($_POST['theme_name']) ? $_POST['theme_name'] : '';
}

?>


<?php if(isset($mod_type) && $mod_type == 1) { ?>
<?php
    
            if($is_admin) {
            $sql = " update rb_config set co_layout = '{$co_layout}', co_layout_hd = '{$co_layout_hd}', co_layout_ft = '{$co_layout_ft}', co_layout_shop = '{$co_layout_shop}', co_layout_hd_shop = '{$co_layout_hd_shop}', co_layout_ft_shop = '{$co_layout_ft_shop}', co_color = '{$co_color}', co_header = '{$co_header}', co_main_bg = '{$co_main_bg}', co_sub_bg = '{$co_sub_bg}', co_gap_mo = '{$co_gap_mo}', co_font = '{$co_font}', co_gap_pc = '{$co_gap_pc}', co_inner_padding_pc = '{$co_inner_padding_pc}', co_sub_width = '{$co_sub_width}', co_main_width = '{$co_main_width}', co_tb_width = '{$co_tb_width}', co_padding_top = '{$co_padding_top}', co_padding_top_sub = '{$co_padding_top_sub}', co_padding_top_shop = '{$co_padding_top_shop}', co_padding_top_sub_shop = '{$co_padding_top_sub_shop}', co_padding_btm = '{$co_padding_btm}', co_padding_btm_sub = '{$co_padding_btm_sub}', co_padding_btm_shop = '{$co_padding_btm_shop}', co_padding_btm_sub_shop = '{$co_padding_btm_sub_shop}', co_menu_shop = '{$co_menu_shop}', co_sidemenu_padding = '{$co_sidemenu_padding}', co_sidemenu_padding_shop = '{$co_sidemenu_padding_shop}', co_sidemenu_hide = '{$co_sidemenu_hide}', co_sidemenu_hide_shop = '{$co_sidemenu_hide_shop}', co_side_skin = '{$co_side_skin}', co_side_skin_shop = '{$co_side_skin_shop}', co_sidemenu = '{$co_sidemenu}', co_sidemenu_shop = '{$co_sidemenu_shop}', co_sidemenu_width = '{$co_sidemenu_width}', co_sidemenu_width_shop = '{$co_sidemenu_width_shop}', co_datetime = '".G5_TIME_YMDHIS."', co_ip = '{$_SERVER['REMOTE_ADDR']}' ";
            sql_query($sql);
            }

            $data = array(
                'co_color' => $co_color,
                'co_header' => $co_header,
                'co_main_bg' => $co_main_bg,
                'co_sub_bg' => $co_sub_bg,
                'co_gap_mo' => $co_gap_mo,
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
                'co_padding_top' => $co_padding_top,
                'co_padding_top_sub' => $co_padding_top_sub,
                'co_padding_top_shop' => $co_padding_top_shop,
                'co_padding_top_sub_shop' => $co_padding_top_sub_shop,
                'co_padding_btm' => $co_padding_btm,
                'co_padding_btm_sub' => $co_padding_btm_sub,
                'co_padding_btm_shop' => $co_padding_btm_shop,
                'co_padding_btm_sub_shop' => $co_padding_btm_sub_shop,
                'co_menu_shop' => $co_menu_shop,
                'co_side_skin' => $co_side_skin,
                'co_side_skin_shop' => $co_side_skin_shop,
                'co_sidemenu' => $co_sidemenu,
                'co_sidemenu_shop' => $co_sidemenu_shop,
                'co_sidemenu_width' => $co_sidemenu_width,
                'co_sidemenu_width_shop' => $co_sidemenu_width_shop,
                'co_sidemenu_padding' => $co_sidemenu_padding,
                'co_sidemenu_padding_shop' => $co_sidemenu_padding_shop,
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
    개수, 간격, 스와이프, 출력항목 등이 작동하지 않을 수 있습니다.
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
                $md_item_tab_list = !empty($rb_module['md_item_tab_list']) ? $rb_module['md_item_tab_list'] : '';
                $md_item_tab_skin = !empty($rb_module['md_item_tab_skin']) ? $rb_module['md_item_tab_skin'] : '';
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
                $md_order_banner = !empty($rb_module['md_order_banner']) ? $rb_module['md_order_banner'] : '';
                $md_border = !empty($rb_module['md_border']) ? $rb_module['md_border'] : '';
                $md_border_width = !empty($rb_module['md_border_width']) ? $rb_module['md_border_width'] : '';
                $md_border_color = !empty($rb_module['md_border_color']) ? $rb_module['md_border_color'] : '';
                $md_box_shadow = !empty($rb_module['md_box_shadow']) ? $rb_module['md_box_shadow'] : '';
                $md_box_shadow_w = !empty($rb_module['md_box_shadow_w']) ? $rb_module['md_box_shadow_w'] : '';
                $md_box_shadow_c = !empty($rb_module['md_box_shadow_c']) ? $rb_module['md_box_shadow_c'] : '';

                $md_level = !empty($rb_module['md_level']) ? $rb_module['md_level'] : '';
                $md_level_is = !empty($rb_module['md_level_is']) ? $rb_module['md_level_is'] : '';

                $md_module = !empty($rb_module['md_module']) ? $rb_module['md_module'] : '';
                $md_soldout_hidden = !empty($rb_module['md_soldout_hidden']) ? $rb_module['md_soldout_hidden'] : '';
                $md_soldout_asc = !empty($rb_module['md_soldout_asc']) ? $rb_module['md_soldout_asc'] : '';
                $md_notice = !empty($rb_module['md_notice']) ? $rb_module['md_notice'] : '0';
                $md_wide_is = !empty($rb_module['md_wide_is']) ? $rb_module['md_wide_is'] : '0';
                $md_arrow_type  = !empty($rb_module['md_arrow_type']) ? $rb_module['md_arrow_type'] : '0';
                $md_radius = empty($rb_module['md_radius']) ? '0' : $rb_module['md_radius'];
                $md_padding = empty($rb_module['md_padding']) ? '0' : $rb_module['md_padding'];

                $md_margin_top_pc = $rb_module['md_margin_top_pc'] ?? '';
                $md_margin_top_mo = $rb_module['md_margin_top_mo'] ?? '';
                $md_margin_btm_pc = $rb_module['md_margin_btm_pc'] ?? '';
                $md_margin_btm_mo = $rb_module['md_margin_btm_mo'] ?? '';

                $md_padding_lr_pc = $rb_module['md_padding_lr_pc'] ?? '';
                $md_padding_lr_mo = $rb_module['md_padding_lr_mo'] ?? '';
                $md_padding_tb_pc = $rb_module['md_padding_tb_pc'] ?? '';
                $md_padding_tb_mo = $rb_module['md_padding_tb_mo'] ?? '';


    
                ?>

<?php } else { ?>



<?php } ?>

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
        //theme: 'polaroid', // default, large, polaroid, pill
        themeMode: 'Light', // dark, Light
        focusInput: true, // 색상코드 Input에 포커스 여부
        selectInput: true, // 선택기가 열릴때 색상값을 select 여부
        autoClose: true, // 자동닫기 - 확인 안됨
        inline: false, // color picker를 인라인 위젯으로 사용시 true
        defaultColor: '#25282B', // 기본 색상인 인라인 mode
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

<ul class="rb_config_sec">
    <h6 class="font-B">모듈 타이틀 설정</h6>
    <h6 class="font-R rb_config_sub_txt">모듈 타이틀의 워딩 및 스타일을 설정할 수 있습니다.</h6>
    <div class="config_wrap">
        <ul>
            <input type="text" name="md_title" class="input w100" value="<?php echo !empty($md_title) ? $md_title : ''; ?>" placeholder="타이틀을 입력하세요." autocomplete="off">
            <input type="hidden" name="md_layout" value="<?php echo !empty($set_layout) ? $set_layout : ''; ?>">
            <input type="hidden" name="md_theme" value="<?php echo !empty($theme_name) ? $theme_name : ''; ?>">
            <input type="hidden" name="md_id" value="<?php echo !empty($md_id) ? $md_id : ''; ?>">

            <?php
            // set_module_send 에서 넘어온 값 받기
            $md_sec_key_in = $_POST['md_sec_key'] ?? '';
            $md_sec_uid_in = $_POST['md_sec_uid'] ?? '';
            ?>
            <input type="hidden" name="md_sec_key" value="<?php echo htmlspecialchars($md_sec_key_in, ENT_QUOTES); ?>">
            <input type="hidden" name="md_sec_uid" value="<?php echo htmlspecialchars($md_sec_uid_in, ENT_QUOTES); ?>">

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
            <?php echo rb_member_level_select('md_level', 1, $member['mb_level'], ($md_level ?? '')); ?>

            <select id="md_level_is" name="md_level_is" class="select select_tiny w30">
                <option value="" <?php if (isset($md_level_is) && $md_level_is == "") { ?>selected<?php } ?>>출력조건</option>
                <option value="1" <?php if (isset($md_level_is) && $md_level_is == "1") { ?>selected<?php } ?>>레벨만 출력</option>
                <option value="2" <?php if (isset($md_level_is) && $md_level_is == "2") { ?>selected<?php } ?>>레벨만 숨김</option>
                <option value="3" <?php if (isset($md_level_is) && $md_level_is == "3") { ?>selected<?php } ?>>레벨 이상만 출력</option>
                <option value="4" <?php if (isset($md_level_is) && $md_level_is == "4") { ?>selected<?php } ?>>레벨 이하만 출력</option>
                <option value="5" <?php if (isset($md_level_is) && $md_level_is == "5") { ?>selected<?php } ?>>레벨 이상만 숨김</option>
                <option value="6" <?php if (isset($md_level_is) && $md_level_is == "6") { ?>selected<?php } ?>>레벨 이하만 숨김</option>

            </select>
        </ul>


        <ul class="mt-10">
            <select class="select w100" name="md_type" id="md_type">
                <option value="">출력 타입을 선택하세요.</option>
                <option value="latest" <?php if (isset($md_type) && $md_type == "latest") { ?>selected<?php } ?>>최신글(단일)</option>
                <option value="tab" <?php if (isset($md_type) && $md_type == "tab") { ?>selected<?php } ?>>최신글(탭)</option>
                <option value="widget" <?php if (isset($md_type) && $md_type == "widget") { ?>selected<?php } ?>>위젯</option>
                <option value="banner" <?php if (isset($md_type) && $md_type == "banner") { ?>selected<?php } ?>>배너</option>
                <option value="poll" <?php if (isset($md_type) && $md_type == "poll") { ?>selected<?php } ?>>투표</option>
                <?php if($is_shop == 1) { // 영카트?>
                <option value="item" <?php if (isset($md_type) && $md_type == "item") { ?>selected<?php } ?>>상품</option>
                <option value="item_tab" <?php if (isset($md_type) && $md_type == "item_tab") { ?>selected<?php } ?>>상품(탭)</option>
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

            <button type="button" class="main_rb_bg font-B" id="widget_add_btn" onclick="add_widget_mod_open(this, document.querySelector('select[name=md_widget]').value)">위젯 라이브 커스텀</button>

            <h6 class="font-R rb_config_sub_txt">
                직접 추가하신 위젯을 선택/출력할 수 있어요.<br>
                [위젯 라이브커스텀] 으로 위젯을 하드코딩 하거나 위젯의 코드를<br>
                바로 편집할 수 있어요.
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
            <select class="select w100" name="md_order_banner">
                <option value="">출력 옵션을 선택하세요.</option>
                <option value="bn_order, bn_id desc" <?php if (isset($md_order_banner) && $md_order_banner == "bn_order, bn_id desc") { ?>selected<?php } ?>>기본순</option>
                <option value="rand()" <?php if (isset($md_order_banner) && $md_order_banner == "rand()") { ?>selected<?php } ?>>랜덤</option>
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
            $(document).ready(function() {
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
                $(document).off('change', 'select[name="md_sca_tab"]').on('change', 'select[name="md_sca_tab"]', function() {
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
                $('#tab_selects').on('click', '.tag-remove', function() {
                    const $tag = $(this).closest('.tag');
                    const key = String($tag.data('key') || '');

                    // 기존 로직 그대로
                    selectedData = selectedData.filter(k => String(k) !== key);
                    $tag.remove();

                    // DOM에 남아있는 태그를 기준으로 다시 한 번 보정 (불일치 방지용)
                    selectedData = $('#tab_selects .tag').map(function() {
                        return String($(this).data('key') || '');
                    }).get();

                    updateHiddenField();
                });

                // 드래그
                $('#tab_selects').sortable({
                    items: '.tag',
                    update: function() {
                        // 순서 변경 시 selectedData도 재구성
                        selectedData = [];
                        $('#tab_selects .tag').each(function() {
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
            <select class="select w100" name="md_sca" id="md_sca_shop">
                <option value="">전체 카테고리</option>
                <?php echo conv_selected_option($category_select, $md_sca); ?>
            </select>
        </ul>

        <div id="item_tab_selects" class="selected_tags selected_item_tab mt-3"></div>
        <input type="hidden" name="md_item_tab_list" id="md_item_tab_list" class="selected_item_tab" value='<?php echo htmlspecialchars($md_item_tab_list, ENT_QUOTES); ?>'>

        <script>
            $(function() {
                let itemSelectedData = [];

                // --- 초기 복원 ---
                const savedList = $('#md_item_tab_list').val();
                if (savedList && savedList.startsWith('[')) {
                    try {
                        const parsed = JSON.parse(savedList);
                        if (Array.isArray(parsed)) {
                            parsed.forEach((item, idx) => {
                                if (!itemSelectedData.includes(item)) {
                                    itemSelectedData.push(item);
                                    addItemTag(item);
                                }
                            });
                            // select는 마지막 값으로 설정
                            if (itemSelectedData.length)
                                $('#md_sca_shop').val(itemSelectedData[itemSelectedData.length - 1]);
                            updateItemHiddenField();
                        }
                    } catch (e) {
                        console.error('태그 복원 실패:', e, savedList);
                    }
                }

                // --- 선택 시 ---
                $('#md_sca_shop').on('change', function() {
                    const value = $(this).val();
                    const text = $(this).find('option:selected').text().trim();

                    if (!value) return;
                    if (itemSelectedData.includes(value)) return;

                    itemSelectedData.push(value);
                    addItemTag(value, text);
                    // 항상 select는 마지막 선택값을 유지
                    $('#md_sca_shop').val(value);
                    updateItemHiddenField();
                });

                // --- 태그 삭제 ---
                $('#item_tab_selects').off('click.rb.itemRemove').on('click.rb.itemRemove', '.item-tag-remove', function() {
                    const $tag = $(this).closest('.item-tag');
                    const key = String($tag.data('key'));

                    // 배열에서 해당 키만 제거 (문자/숫자 혼재 대비 toString)
                    itemSelectedData = (itemSelectedData || []).filter(k => String(k) !== key);

                    // DOM 제거
                    $tag.remove();

                    // ✅ 안전장치: DOM 기준으로 다시 한 번 재수집 (불일치 방지)
                    itemSelectedData = $('#item_tab_selects .item-tag').map(function() {
                        return String($(this).data('key') || '');
                    }).get();

                    // select는 마지막 값으로 설정 (남은게 있다면)
                    if (itemSelectedData.length) {
                        $('#md_sca_shop').val(itemSelectedData[itemSelectedData.length - 1]);
                    } else {
                        $('#md_sca_shop').val('');
                    }

                    // hidden 갱신
                    updateItemHiddenField();
                });

                // --- 드래그 정렬 ---
                $('#item_tab_selects').sortable({
                    items: '.item-tag',
                    update: function() {
                        let newOrder = [];
                        $('#item_tab_selects .item-tag').each(function() {
                            newOrder.push($(this).data('key'));
                        });
                        itemSelectedData = newOrder;
                        // select는 마지막 값으로 설정
                        if (itemSelectedData.length) {
                            $('#md_sca_shop').val(itemSelectedData[itemSelectedData.length - 1]);
                        } else {
                            $('#md_sca_shop').val('');
                        }
                        updateItemHiddenField();
                    }
                });

                // --- 태그 추가 함수 ---
                function addItemTag(value, text) {
                    text = text || $('#md_sca_shop option[value="' + value + '"]').text().trim() || value;
                    const tagHtml = `
                                <span class="item-tag" data-key="${value}">
                                    ${text}
                                    <button type="button" class="item-tag-remove" title="삭제">×</button>
                                </span>
                            `;
                    $('#item_tab_selects').append(tagHtml);
                }

                // --- hidden 값 업데이트 ---
                function updateItemHiddenField() {
                    // #md_type 값이 'item_tab'일 때만 값 입력
                    if ($('#md_type').val() === 'item_tab' && itemSelectedData.length >= 2) {
                        $('#md_item_tab_list').val(JSON.stringify(itemSelectedData));
                    } else {
                        $('#md_item_tab_list').val('');
                    }
                }
            });
        </script>

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



        <ul class="mt-5 selected_item_skin selected_select">
            <select class="select w100" name="md_skin" id="md_skin_shop">
                <?php echo rb_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $md_skin); ?>
            </select>
        </ul>

        <ul class="mt-5 selected_item_skin_tab selected_select">
            <select class="select w100" name="md_item_tab_skin" id="md_item_tab_skin">
                <?php echo rb_list_skin_options("^main.[0-9]+\.skin\.php", G5_SHOP_SKIN_PATH, $md_item_tab_skin); ?>
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
                        "md_bo_table": md_bo_table,
                        "mod_type": mod_type,
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
                        "md_bo_table": md_bo_table,
                        "mod_type": mod_type,
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

                $('.selected_latest_tab').hide();
                $('.selected_cnt').hide();
                $('.selected_tab').hide();
                $('.selected_item').hide();
                $('.selected_item_skin').hide();
                $('.selected_item_skin_tab').hide();
                $('.selected_item_tab').hide();
                $('.selected_banner').hide();
                $('.selected_poll').hide();
                $('.selected_widget').hide();
                $('.selected_latest').hide();

                if (md_type == "latest") {
                    $('.selected_latest').show();
                    $('.selected_all').show();
                    $('.selected_latest_tab').show();
                    $('.selected_cnt').show();
                    $('.selected_style').show();
                } else if (md_type == "tab") {
                    $('.selected_tab').show();
                    $('.selected_all').show();
                    $('.selected_latest_tab').show();
                    $('.selected_cnt').show();
                    $('.selected_style').show();
                } else if (md_type == "item_tab") {
                    $('.selected_item').show();
                    $('.selected_item_tab').show();
                    $('.selected_all').show();
                    $('.selected_style').show();
                    $('.selected_item_skin_tab').show();
                } else if (md_type == "widget") {
                    $('.selected_widget').show();
                    $('.selected_all').show();
                    $('.selected_style').show();
                } else if (md_type == "banner") {
                    $('.selected_banner').show();
                    $('.selected_all').show();
                    $('.selected_style').show();
                    $('.selected_cnt').show();
                } else if (md_type == "poll") {
                    $('.selected_poll').show();
                    $('.selected_all').show();
                    $('.selected_style').show();
                } else if (md_type == "item") {
                    $('.selected_item').show();
                    $('.selected_all').show();
                    $('.selected_style').show();
                    $('.selected_item_skin').show();
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

                    $('select[name="md_sca"]').val('');
                    $('select[name="md_module"]').val('0');
                    $('select[name="md_order"]').val('');
                    $('select[name="md_skin"]').val('');
                    $('select[name="md_order_latest"]').val('');

                    $("#md_tab_list").val('');
                    $('#tab_selects .tag').remove();

                    $("#md_item_tab_list").val('');
                    $('#item_tab_selects .item-tag').remove();


                    $('.selected_select').hide();
                    $('.selected_all').hide();
                    $('.selected_style').hide();

                    if (selectedValue == "latest" || selectedValue == "tab") {
                        $('.selected_latest_tab').show();
                        $('.selected_cnt').show();
                    } else if (selectedValue == "widget") {
                        $('.selected_widget').show();
                    } else if (selectedValue == "poll") {
                        $('.selected_poll').show();
                    } else if (selectedValue == "item_tab") {
                        $('.selected_item').show();
                        $('.selected_item_tab').show();
                        $('.selected_item_skin_tab').show();
                    } else if (selectedValue == "item") {
                        $('.selected_item').show();
                        $('.selected_item_skin').show();
                    } else if (selectedValue == "banner") {
                        $('.selected_banner').show();
                        $('.selected_cnt').show();
                    } else {
                        $('.selected_latest_tab').hide();
                        $('.selected_item_tab').hide();
                        $('.selected_cnt').hide();
                        $('.selected_item').hide();
                        $('.selected_widget').hide();
                        $('.selected_poll').hide();
                        $('.selected_banner').hide();
                        $('.selected_item_skin_tab').hide();
                        $('.selected_item_skin').hide();
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

                if (md_banner == "개별출력") {
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

        <?php if(isset($md_skin) && $md_skin && isset($md_type) && $md_type == "item") { ?>
        <ul class="skin_path_url mt-5">
            <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
            <li class="skin_path_url_txt">
                <?php echo '/theme/'.$theme_name.'/skin/shop/',$md_skin; ?>
            </li>
            <div class="cb"></div>
        </ul>
        <?php } ?>

        <?php if(isset($md_item_tab_skin) && $md_item_tab_skin && isset($md_type) && $md_type == "item_tab") { ?>
        <ul class="skin_path_url mt-5">
            <li class="skin_path_url_img"><img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_fd.svg"></li>
            <li class="skin_path_url_txt">
                <?php echo '/theme/'.$theme_name.'/skin/shop/',$md_item_tab_skin; ?>
            </li>
            <div class="cb"></div>
        </ul>
        <?php } ?>


        <ul class="rb_config_sec selected_style selected_select">
            <h6 class="font-B">
                모듈 스타일 설정
            </h6>
            <h6 class="font-R rb_config_sub_txt">모듈 박스의 스타일을 설정할 수 있습니다.</h6>
            <div class="config_wrap">


                <div class="config_wrap_bg">

                    <ul class="rows_inp_lr">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">와이드</span><br>
                            wide
                        </li>
                        <li class="rows_inp_r mt-5">

                            <input type="radio" name="md_wide_is" id="md_wide_is_1" class="magic-radio" value="" <?php if (isset($md_wide_is) && $md_wide_is == "" || empty($md_wide_is)) { ?>checked<?php } ?>><label for="md_wide_is_1">기본</label>
                            <input type="radio" name="md_wide_is" id="md_wide_is_2" class="magic-radio" value="1" <?php if (isset($md_wide_is) && $md_wide_is == "1") { ?>checked<?php } ?>><label for="md_wide_is_2">100%</label>

                        </li>

                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="모듈의 가로 크기를 설정된 가로폭을 무시하고 브라우저 기준으로 100% 로 채울 수 있어요. 와이드 옵션은 가로 1열인 모듈에만 사용해주셔야 되요." data-title="와이드(100%) 란?" data-alt="미리보기" aria-expanded="false">
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


                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">배경컬러</span><br>
                            background
                        </li>
                        <li class="rows_inp_r">

                            <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                                <input type="text" class="coloris" name="md_banner_bg" id="md_banner_bg" value="<?php echo !empty($md_banner_bg) ? $md_banner_bg : '#FFFFFF'; ?>" style="width:25px !important;"> 배경컬러
                            </div>


                        </li>

                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="모듈의 백그라운드 컬러를 설정할 수 있어요. 어두운 컬러의 경우 컨텐츠가 잘 안보일 수 있으니 [라이브 CSS 커스텀] 기능으로 컨텐츠의 컬러도 변경해보세요." data-title="배경컬러 란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">모서리 라운드</span><br>
                            border-radius
                        </li>
                        <li class="rows_inp_r mt-15">
                            <div id="md_radius_range" class="rb_range_item"></div>
                            <input type="hidden" id="md_radius" class="co_range_send" name="md_radius" value="<?php echo !empty($md_radius) ? $md_radius : '0'; ?>">
                        </li>

                        <script type="text/javascript">
                            $("#md_radius_range").slider({
                                range: "min",
                                min: 0,
                                max: 50,
                                value: <?php echo !empty($md_radius) ? $md_radius : '0'; ?>,
                                step: 1,
                                slide: function(e, ui) {
                                    $("#md_radius_range .ui-slider-handle").html(ui.value);
                                    $("#md_radius").val(ui.value); // hidden input에 값 업데이트
                                }
                            });

                            $("#md_radius_range .ui-slider-handle").html("<?php echo !empty($md_radius) ? $md_radius : '0'; ?>");
                            $("#md_radius").val("<?php echo !empty($md_radius) ? $md_radius : '0'; ?>"); // 초기값 설정
                        </script>

                        <div class="cb"></div>
                    </ul>

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span mt-15">
                            <span class="font-B">일괄적용</span>
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="hidden" name="md_cb_batch" value="">
                            <input type="checkbox" id="md_color_border_batch_checkbox" class="magic-checkbox">
                            <label for="md_color_border_batch_checkbox">컬러, 모서리 일괄적용</label>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="동일 레이아웃의 다른 모듈에 현재 설정을 일괄 적용할 수 있어요." data-title="일괄적용 이란?" data-alt="미리보기" aria-expanded="false">
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


                <div class="config_wrap_bg">

                    <ul class="rows_inp_lr ">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">테두리</span><br>
                            border
                        </li>
                        <li class="rows_inp_r mt-5">

                            <input type="radio" name="md_border" id="md_border_1" class="magic-radio" value="" <?php if (isset($md_border) && $md_border == "" || empty($md_border)) { ?>checked<?php } ?>><label for="md_border_1">없음</label>
                            <input type="radio" name="md_border" id="md_border_2" class="magic-radio" value="solid" <?php if (isset($md_border) && $md_border == "solid") { ?>checked<?php } ?>><label for="md_border_2">실선</label>
                            <input type="radio" name="md_border" id="md_border_3" class="magic-radio" value="dashed" <?php if (isset($md_border) && $md_border == "dashed") { ?>checked<?php } ?>><label for="md_border_3">점선</label>

                        </li>

                        <div class="cb"></div>
                    </ul>

                    <ul class="rows_inp_lr mt-5 js-border-dep">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">테두리 두께</span><br>
                            border-width
                        </li>
                        <li class="rows_inp_r mt-15">
                            <div id="md_border_width_range" class="rb_range_item"></div>
                            <input type="hidden" id="md_border_width" class="co_range_send" name="md_border_width" value="<?php echo !empty($md_border_width) ? $md_border_width : '1'; ?>">
                        </li>

                        <script type="text/javascript">
                            $("#md_border_width_range").slider({
                                range: "min",
                                min: 0,
                                max: 10,
                                value: <?php echo !empty($md_border_width) ? $md_border_width : '0'; ?>,
                                step: 1,
                                slide: function(e, ui) {
                                    $("#md_border_width_range .ui-slider-handle").html(ui.value);
                                    $("#md_border_width").val(ui.value); // hidden input에 값 업데이트
                                }
                            });

                            $("#md_border_width_range .ui-slider-handle").html("<?php echo !empty($md_border_width) ? $md_border_width : '0'; ?>");
                            $("#md_border_width").val("<?php echo !empty($md_border_width) ? $md_border_width : '0'; ?>"); // 초기값 설정
                        </script>

                        <div class="cb"></div>
                    </ul>
                    <ul class="rows_inp_lr mt-5 js-border-dep">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">테두리 컬러</span><br>
                            border-color
                        </li>
                        <li class="rows_inp_r">

                            <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                                <input type="text" class="coloris" name="md_border_color" id="md_border_color" value="<?php echo !empty($md_border_color) ? $md_border_color : '#DDDDDD'; ?>" style="width:25px !important;"> 테두리 컬러
                            </div>

                        </li>

                        <div class="cb"></div>
                    </ul>

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span mt-15">
                            <span class="font-B">일괄적용</span>
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="hidden" name="md_border_batch" value="">
                            <input type="checkbox" id="md_border_batch_checkbox" class="magic-checkbox">
                            <label for="md_border_batch_checkbox">테두리 일괄적용</label>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="동일 레이아웃의 다른 모듈에 현재 설정을 일괄 적용할 수 있어요." data-title="일괄적용 이란?" data-alt="미리보기" aria-expanded="false">
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


                    <script>
                        // 테두리 의존 섹션 토글
                        function rb_toggleBorderDeps() {
                            var v = $('input[name="md_border"]:checked').val() || '';
                            if (v === '') {
                                // 없음 → 숨김
                                $('.js-border-dep').css('display', 'none');
                            } else {
                                // 실선/점선 등 → 표시
                                $('.js-border-dep').css('display', '');
                            }
                        }

                        // 페이지 로드 시 & 라디오 변경 시 반영
                        $(function() {
                            rb_toggleBorderDeps();
                            $(document).on('change', 'input[name="md_border"]', rb_toggleBorderDeps);
                        });
                    </script>

                </div>





                <div class="config_wrap_bg">

                    <ul class="rows_inp_lr ">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">그림자</span><br>
                            shadow
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="radio" name="md_box_shadow" id="md_box_shadow_1" class="magic-radio" value="" <?php if (isset($md_box_shadow) && $md_box_shadow == "" || empty($md_box_shadow)) { ?>checked<?php } ?>><label for="md_box_shadow_1">없음</label>
                            <input type="radio" name="md_box_shadow" id="md_box_shadow_2" class="magic-radio" value="1" <?php if (isset($md_box_shadow) && $md_box_shadow == "1") { ?>checked<?php } ?>><label for="md_box_shadow_2">기본</label>
                            <input type="radio" name="md_box_shadow" id="md_box_shadow_3" class="magic-radio" value="2" <?php if (isset($md_box_shadow) && $md_box_shadow == "2") { ?>checked<?php } ?>><label for="md_box_shadow_3">설정</label>
                        </li>

                        <div class="cb"></div>

                    </ul>

                    <ul class="rows_inp_lr mt-5 js-box-shadow-dep">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">그림자 크기</span><br>
                            box-shadow
                        </li>
                        <li class="rows_inp_r mt-15">
                            <div id="md_box_shadow_w_range" class="rb_range_item"></div>
                            <input type="hidden" id="md_box_shadow_w" class="co_range_send" name="md_box_shadow_w" value="<?php echo !empty($md_box_shadow_w) ? $md_box_shadow_w : '0'; ?>">
                        </li>

                        <script type="text/javascript">
                            $("#md_box_shadow_w_range").slider({
                                range: "min",
                                min: 0,
                                max: 50,
                                value: <?php echo !empty($md_box_shadow_w) ? $md_box_shadow_w : '0'; ?>,
                                step: 1,
                                slide: function(e, ui) {
                                    $("#md_box_shadow_w_range .ui-slider-handle").html(ui.value);
                                    $("#md_box_shadow_w").val(ui.value); // hidden input에 값 업데이트
                                }
                            });

                            $("#md_box_shadow_w_range .ui-slider-handle").html("<?php echo !empty($md_box_shadow_w) ? $md_box_shadow_w : '0'; ?>");
                            $("#md_box_shadow_w").val("<?php echo !empty($md_box_shadow_w) ? $md_box_shadow_w : '0'; ?>"); // 초기값 설정
                        </script>

                        <div class="cb"></div>

                    </ul>

                    <ul class="rows_inp_lr mt-5 js-box-shadow-dep">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">그림자 컬러</span><br>
                            border-color
                        </li>
                        <li class="rows_inp_r">

                            <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                                <input type="text" class="coloris" name="md_box_shadow_c" value="<?php echo !empty($md_box_shadow_c) ? $md_box_shadow_c : '#25282b16'; ?>" style="width:25px !important;"> 그림자 컬러
                            </div>

                        </li>

                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-5.png" data-txt="모듈에 그림자를 추가할 수 있어요. 기본의 경우 프리셋이 적용되며, 설정 선택시 임의설정이 가능해요. 그림자는 테두리나 컬러선택에서 투명도를 함께 사용하는게 좋아요!" data-title="그림자 란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span mt-15">
                            <span class="font-B">일괄적용</span>
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="hidden" name="md_shadow_batch" value="">
                            <input type="checkbox" id="md_shadow_batch_checkbox" class="magic-checkbox">
                            <label for="md_shadow_batch_checkbox">그림자 일괄적용</label>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="동일 레이아웃의 다른 모듈에 현재 설정을 일괄 적용할 수 있어요." data-title="일괄적용 이란?" data-alt="미리보기" aria-expanded="false">
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

                    <script>
                        function rb_toggleShadowDeps() {
                            var v = $('input[name="md_box_shadow"]:checked').val() || '';
                            if (v === '') {
                                $('.js-box-shadow-dep').css('display', 'none');
                            } else {
                                $('.js-box-shadow-dep').css('display', '');
                            }
                        }

                        $(function() {
                            rb_toggleShadowDeps();
                            $(document).on('change', 'input[name="md_box_shadow"]', rb_toggleShadowDeps);
                        });
                    </script>

                    <script>
                        (function() {
                            var $modeRadios = $('input[name="md_box_shadow"]');
                            var $sizeHidden = $('#md_box_shadow_w'); // hidden
                            var $sizeSlider = $('#md_box_shadow_w_range'); // jQuery UI slider
                            var $colorInput = $('[name="md_box_shadow_c"]'); // coloris input

                            var DEFAULT_SIZE = 10;
                            var DEFAULT_COLOR = '#25282b16';
                            var prevMode = null; // '', '1', '2'

                            // 커스텀값 저장: '설정' 모드에서 바꾼 값 보존
                            $sizeHidden.data('custom', $sizeHidden.val() || '0');
                            $colorInput.data('custom', $colorInput.val() || DEFAULT_COLOR);

                            function setSliderVal($slider, $hidden, val) {
                                val = parseInt(val, 10);
                                if (isNaN(val)) val = 0;
                                if ($slider.data('ui-slider')) {
                                    $slider.slider('value', val);
                                    $slider.find('.ui-slider-handle').text(val);
                                }
                                $hidden.val(val);
                            }

                            function setColorVal($inp, val) {
                                var el = $inp && $inp[0];
                                if (!el) return;

                                // 1) 값 세팅
                                el.value = val;

                                // 2) Coloris가 듣는 이벤트 두 개 모두 쏘기 (스와치 갱신 트리거)
                                el.dispatchEvent(new Event('input', {
                                    bubbles: true
                                }));
                                el.dispatchEvent(new Event('change', {
                                    bubbles: true
                                }));

                                // 3) 혹시 이벤트를 못 들었을 경우 대비: 래퍼 CSS 변수 직접 세팅
                                // Coloris가 input을 감싸 만든 래퍼는 .clr-field
                                var wrap = el.closest('.clr-field');
                                if (wrap) {
                                    wrap.style.setProperty('--clr-color', val);
                                } else {
                                    // 초기화 타이밍 문제로 아직 래퍼가 없으면 다음 틱에 한 번 더 시도
                                    requestAnimationFrame(function() {
                                        var w2 = el.closest('.clr-field');
                                        if (w2) w2.style.setProperty('--clr-color', val);
                                    });
                                }
                            }

                            function toggleDepsVisible(modeVal) {
                                if (modeVal === '') { // 없음
                                    $('.js-box-shadow-dep').css('display', 'none');
                                } else {
                                    $('.js-box-shadow-dep').css('display', '');
                                }
                            }

                            function setDepsEnabled(enabled) {
                                // 슬라이더 enable/disable
                                if ($sizeSlider.data('ui-slider')) {
                                    $sizeSlider.slider(enabled ? 'enable' : 'disable');
                                }
                                // 색상 인풋 비활성화
                                $colorInput.prop('disabled', !enabled);

                                // 접근성/스타일 보조(선택)
                                $colorInput.toggleClass('is-disabled', !enabled);
                                $sizeSlider.toggleClass('is-disabled', !enabled);
                            }

                            function applyMode(newMode) {
                                // '설정(2)'에서 벗어나는 순간 최신 커스텀값을 기억
                                if (prevMode === '2' && newMode !== '2') {
                                    $sizeHidden.data('custom', $sizeHidden.val() || '0');
                                    $colorInput.data('custom', $colorInput.val() || DEFAULT_COLOR);
                                }

                                toggleDepsVisible(newMode);

                                if (newMode === '1') { // 기본
                                    setSliderVal($sizeSlider, $sizeHidden, DEFAULT_SIZE);
                                    setColorVal($colorInput, DEFAULT_COLOR);
                                    setDepsEnabled(false);

                                } else if (newMode === '2') { // 설정(커스텀)
                                    var customSize = $sizeHidden.data('custom') || $sizeHidden.val() || '0';
                                    var customColor = $colorInput.data('custom') || $colorInput.val() || DEFAULT_COLOR;
                                    setSliderVal($sizeSlider, $sizeHidden, customSize);
                                    setColorVal($colorInput, customColor);
                                    setDepsEnabled(true);

                                } else { // 없음
                                    // 표시만 숨김, 조작 의미 없으니 잠가도 OK
                                    setDepsEnabled(false);
                                }
                                prevMode = newMode;
                            }

                            // 초기 적용
                            $(function() {
                                var initMode = ($modeRadios.filter(':checked').val() || '');
                                prevMode = initMode;
                                applyMode(initMode);

                                // 라디오 변경
                                $(document).on('change', 'input[name="md_box_shadow"]', function() {
                                    var v = ($modeRadios.filter(':checked').val() || '');
                                    applyMode(v);
                                });
                            });
                        })();
                    </script>

                </div>







                <div class="config_wrap_bg">

                    <ul class="rows_inp_lr">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">상단 간격</span><br>
                            margin-top
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="number" id="md_margin_top_pc" class="tiny_input w30 ml-0" name="md_margin_top_pc" placeholder="PC" value="<?php echo (isset($md_margin_top_pc) && $md_margin_top_pc !== '') ? $md_margin_top_pc : ''; ?>"> <span class="font-12">px　</span>
                            <input type="number" id="md_margin_top_mo" class="tiny_input w30 ml-0" name="md_margin_top_mo" placeholder="Mobile" value="<?php echo (isset($md_margin_top_mo) && $md_margin_top_mo !== '') ? $md_margin_top_mo : ''; ?>"> <span class="font-12">px</span>
                        </li>

                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="모듈 위쪽으로 Margin(간격) 값이 들어가요. 마이너스(-)도 입력이 가능하고 모바일 간격의 경우 모바일기기로 접속시에만 반영되요." data-title="상단 간격이란?" data-alt="미리보기" aria-expanded="false">
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


                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">하단 간격</span><br>
                            margin-bottom
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="number" id="md_margin_btm_pc" class="tiny_input w30 ml-0" name="md_margin_btm_pc" placeholder="PC" value="<?php echo (isset($md_margin_btm_pc) && $md_margin_btm_pc !== '') ? $md_margin_btm_pc : ''; ?>"> <span class="font-12">px　</span>
                            <input type="number" id="md_margin_btm_mo" class="tiny_input w30 ml-0" name="md_margin_btm_mo" placeholder="Mobile" value="<?php echo (isset($md_margin_btm_mo) && $md_margin_btm_mo !== '') ? $md_margin_btm_mo : ''; ?>"> <span class="font-12">px</span>
                        </li>

                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="모듈 아래쪽으로 Margin(간격) 값이 들어가요. 마이너스(-)도 입력이 가능하고 모바일 간격의 경우 모바일기기로 접속시에만 반영되요." data-title="하단 간격이란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span mt-15">
                            <span class="font-B">일괄적용</span>
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="hidden" name="md_margin_batch" value="">
                            <input type="checkbox" id="md_margin_batch_checkbox" class="magic-checkbox">
                            <label for="md_margin_batch_checkbox">상/하단 간격 일괄적용</label>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="동일 레이아웃의 다른 모듈에 현재 설정을 일괄 적용할 수 있어요." data-title="일괄적용 이란?" data-alt="미리보기" aria-expanded="false">
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

                <div class="config_wrap_bg">

                    <ul class="rows_inp_lr">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">내부 여백 (가로축)</span><br>
                            padding
                        </li>

                        <li class="rows_inp_r mt-5">
                            <input type="number" id="md_padding_lr_pc" class="tiny_input w30 ml-0" name="md_padding_lr_pc" placeholder="PC" value="<?php echo (isset($md_padding_lr_pc) && $md_padding_lr_pc !== '') ? $md_padding_lr_pc : ''; ?>"> <span class="font-12">px</span>
                            <input type="number" id="md_padding_lr_mo" class="tiny_input w30 ml-0" name="md_padding_lr_mo" placeholder="Mobile" value="<?php echo (isset($md_padding_lr_mo) && $md_padding_lr_mo !== '') ? $md_padding_lr_mo : ''; ?>"> <span class="font-12">px</span>
                        </li>
                        <div class="cb"></div>
                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="모듈 내부 (좌/우) 에 동일한 padding(여백) 값을 설정할 수 있어요. 테두리 옵션을 사용할때 같이 사용하면 좋아요. 모바일 여백의 경우 모바일기기로 접속시에만 반영되요." data-title="내부 여백(가로축) 이란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">내부 여백 (세로축)</span><br>
                            padding
                        </li>

                        <li class="rows_inp_r mt-5">
                            <input type="number" id="md_padding_tb_pc" class="tiny_input w30 ml-0" name="md_padding_tb_pc" placeholder="PC" value="<?php echo (isset($md_padding_tb_pc) && $md_padding_tb_pc !== '') ? $md_padding_tb_pc : ''; ?>"> <span class="font-12">px</span>
                            <input type="number" id="md_padding_tb_mo" class="tiny_input w30 ml-0" name="md_padding_tb_mo" placeholder="Mobile" value="<?php echo (isset($md_padding_tb_mo) && $md_padding_tb_mo !== '') ? $md_padding_tb_mo : ''; ?>"> <span class="font-12">px</span>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="모듈 내부 (상/하) 에 동일한 padding(여백) 값을 설정할 수 있어요. 테두리 옵션을 사용할때 같이 사용하면 좋아요. 모바일 여백의 경우 모바일기기로 접속시에만 반영되요." data-title="내부 여백(세로축) 이란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">일괄설정</span><br>
                            padding
                        </li>

                        <li class="rows_inp_r mt-20">
                            <div id="md_padding_range" class="rb_range_item"></div>
                            <input type="hidden" id="md_padding" class="co_range_send" name="md_padding" value="<?php echo !empty($md_padding) ? $md_padding : '0'; ?>">
                        </li>

                        <script type="text/javascript">
                            $("#md_padding_range").slider({
                                range: "min",
                                min: 0,
                                max: 50,
                                value: <?php echo !empty($md_padding) ? $md_padding : '0'; ?>,
                                step: 1,
                                slide: function(e, ui) {
                                    $("#md_padding_range .ui-slider-handle").html(ui.value);
                                    $("#md_padding").val(ui.value);
                                    $("#md_padding_lr_pc").val(ui.value);
                                    $("#md_padding_lr_mo").val(ui.value);
                                    $("#md_padding_tb_pc").val(ui.value);
                                    $("#md_padding_tb_mo").val(ui.value);
                                }
                            });

                            $("#md_padding_range .ui-slider-handle").html("<?php echo !empty($md_padding) ? $md_padding : '0'; ?>");
                            $("#md_padding").val("<?php echo !empty($md_padding) ? $md_padding : '0'; ?>"); // 초기값 설정
                        </script>

                        <div class="cb"></div>

                    </ul>

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span mt-15">
                            <span class="font-B">일괄적용</span>
                        </li>
                        <li class="rows_inp_r mt-5">
                            <input type="hidden" name="md_padding_batch" value="">
                            <input type="checkbox" id="md_padding_batch_checkbox" class="magic-checkbox">
                            <label for="md_padding_batch_checkbox">내부 여백 일괄적용</label>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="동일 레이아웃의 다른 모듈에 현재 설정을 일괄 적용할 수 있어요." data-title="일괄적용 이란?" data-alt="미리보기" aria-expanded="false">
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



            </div>
        </ul>



        <?php
            if($is_shop == 1) {
        ?>

        <ul class="rb_config_sec selected_item selected_select">
            <h6 class="font-B">
                출력개수 설정
                <div class="rb-help" data-open="false">
                    <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-4.png" data-txt="게시물, 배너, 상품 등의 출력 가능한 개수를 말해요. 가로[열], 세로[행] 을 자유롭게 설정할 수 있어요. 1열X3행의 경우 가로 1개X세로 3개 로 설정되요. 열, 행을 설정하기 전에 개수(전체출력수) 설정을 해주셔야 해요." data-title="출력개수란?" data-alt="미리보기" aria-expanded="false">
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
            <h6 class="font-R rb_config_sub_txt">
                열(가로)X행(세로) 출력개수를 설정할 수 있습니다.
            </h6>
            <div class="config_wrap">
                <ul class="rows_inp_lr">
                    <li class="rows_inp_l">
                        <input type="number" name="md_cnt" id="md_cnt_shop" class="input w70 h40 text-center" value="<?php echo !empty($md_cnt) ? $md_cnt : ''; ?>" placeholder="개수" autocomplete="off" autocomplete="off">　<span>개</span>
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
            <h6 class="font-B">
                간격 설정
                <div class="rb-help" data-open="false">
                    <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-1.png" data-txt="글이나 상품, 배너 등 출력되는 목록 사이의 간격을 조정할 수 있어요." data-title="간격설정 이란?" data-alt="미리보기" aria-expanded="false">
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
            <h6 class="font-R rb_config_sub_txt">
                출력되는 모듈 내부 각 오프젝트 사이의<br>
                간격을 설정할 수 있습니다.
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
                행X열 보다 출력개수가 많을 경우<br>
                스와이프 및 자동롤링 처리 유무를 설정할 수 있습니다.
            </h6>
            <div class="config_wrap">
                <input type="checkbox" name="md_swiper_is" class="md_swiper_is_shop" id="md_swiper_is_shop" class="magic-checkbox" value="1" <?php if (isset($md_swiper_is) && $md_swiper_is == 1) { ?>checked<?php } ?>><label for="md_swiper_is_shop">스와이프 사용</label>
            </div>

            <div class="config_wrap">
                <input type="radio" name="md_arrow_type_shop" id="md_arrow_type_shop_0" class="magic-radio" value="" <?php if (isset($md_arrow_type) && $md_arrow_type == "" || empty($md_arrow_type)) { ?>checked<?php } ?>><label for="md_arrow_type_shop_0">기본버튼</label>
                <input type="radio" name="md_arrow_type_shop" id="md_arrow_type_shop_1" class="magic-radio" value="1" <?php if (isset($md_arrow_type) && $md_arrow_type == "1") { ?>checked<?php } ?>><label for="md_arrow_type_shop_1">원형버튼(오버)</label>
                <input type="radio" name="md_arrow_type_shop" id="md_arrow_type_shop_2" class="magic-radio" value="2" <?php if (isset($md_arrow_type) && $md_arrow_type == "2") { ?>checked<?php } ?>><label for="md_arrow_type_shop_2">버튼숨김</label>
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
                    <input type="checkbox" name="md_subject_is" id="md_subject_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_subject_is) && $md_subject_is == 1) { ?>checked<?php } ?>><label for="md_subject_is_shop">상품명</label>　<br>
                    <input type="checkbox" name="md_content_is" id="md_content_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_content_is) && $md_content_is == 1) { ?>checked<?php } ?>><label for="md_content_is_shop">상품설명</label>
                    <input type="checkbox" name="md_date_is" id="md_date_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_date_is) && $md_date_is == 1) { ?>checked<?php } ?>><label for="md_date_is_shop">등록일</label>
                    <input type="checkbox" name="md_comment_is" id="md_comment_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_comment_is) && $md_comment_is == 1) { ?>checked<?php } ?>><label for="md_comment_is_shop">찜개수</label>
                    <input type="checkbox" name="md_icon_is" id="md_icon_is_shop" class="magic-checkbox" value="1" <?php if(isset($md_icon_is) && $md_icon_is == 1) { ?>checked<?php } ?>><label for="md_icon_is_shop">아이콘</label>
                </ul>
            </div>
        </ul>


        <?php } ?>








    </div>
</ul>


<ul class="rb_config_sec selected_cnt selected_select">
    <h6 class="font-B">
        출력개수 설정
        <div class="rb-help" data-open="false">
            <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-4.png" data-txt="게시물, 배너, 상품 등의 출력 가능한 개수를 말해요. 가로[열], 세로[행] 을 자유롭게 설정할 수 있어요. 1열X3행의 경우 가로 1개X세로 3개 로 설정되요. 열, 행을 설정하기 전에 개수(전체출력수) 설정을 해주셔야 해요." data-title="출력개수란?" data-alt="미리보기" aria-expanded="false">
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
    <h6 class="font-R rb_config_sub_txt">
        열(가로)X행(세로) 출력개수를 설정할 수 있습니다.
        <span class="main_color selected_banner selected_select"><br>배너모듈의 경우 전체개수는 배너관리의 설정에 따릅니다.</span>
    </h6>
    <div class="config_wrap">
        <ul class="rows_inp_lr">

            <li class="rows_inp_l rows_inp_l_span selected_banner selected_select">
                <span class="font-B">PC 버전</span><br>
                1024px 이상
            </li>

            <li class="rows_inp_l selected_latest_tab selected_select">
                <input type="number" name="md_cnt" id="md_cnt" class="input w70 h40 text-center" value="<?php echo !empty($md_cnt) ? $md_cnt : ''; ?>" placeholder="개수" autocomplete="off" autocomplete="off">　<span>개</span>
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

<ul class="rb_config_sec selected_cnt selected_select">
    <h6 class="font-B">
        간격 설정
        <div class="rb-help" data-open="false">
            <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-1.png" data-txt="글이나 상품, 배너 등 출력되는 목록 사이의 간격을 조정할 수 있어요." data-title="간격설정 이란?" data-alt="미리보기" aria-expanded="false">
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
    <h6 class="font-R rb_config_sub_txt">
        출력되는 모듈 내부 각 오프젝트 사이의<br>
        간격을 설정할 수 있습니다.
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

<ul class="rb_config_sec selected_cnt selected_select">
    <h6 class="font-B">스와이프 설정</h6>
    <h6 class="font-R rb_config_sub_txt">
        행X열 보다 출력개수가 많을 경우<br>
        스와이프 및 자동롤링 처리 유무를 설정할 수 있습니다.
    </h6>
    <div class="config_wrap">
        <input type="checkbox" name="md_swiper_is" class="md_swiper_is" id="md_swiper_is" class="magic-checkbox" value="1" <?php if (isset($md_swiper_is) && $md_swiper_is == 1) { ?>checked<?php } ?>><label for="md_swiper_is">스와이프 사용</label>
    </div>

    <div class="config_wrap">
        <input type="radio" name="md_arrow_type" id="md_arrow_type_0" class="magic-radio" value="" <?php if (isset($md_arrow_type) && $md_arrow_type == "" || empty($md_arrow_type)) { ?>checked<?php } ?>><label for="md_arrow_type_0">기본버튼</label>
        <input type="radio" name="md_arrow_type" id="md_arrow_type_1" class="magic-radio" value="1" <?php if (isset($md_arrow_type) && $md_arrow_type == "1") { ?>checked<?php } ?>><label for="md_arrow_type_1">원형버튼(오버)</label>
        <input type="radio" name="md_arrow_type" id="md_arrow_type_2" class="magic-radio" value="2" <?php if (isset($md_arrow_type) && $md_arrow_type == "2") { ?>checked<?php } ?>><label for="md_arrow_type_2">버튼숨김</label>
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
                PX
            </li>
            <li class="rows_inp_r">
                <input type="text" name="md_height" class="input w40 h40 text-center" value="<?php echo !empty($md_height) ? $md_height : 'auto'; ?>" placeholder="auto" autocomplete="off">　<span class="">px</span>

                <input type="checkbox" id="md_height_auto" class="magic-checkbox" <?php if (isset($md_height) && $md_height == 'auto') { ?>checked<?php } ?>><label for="md_height_auto">Auto</label>

                <script>
                    (function() {
                        const inp = document.querySelector('input[name="md_height"]');
                        const chk = document.getElementById('md_height_auto');
                        if (!inp || !chk) return;

                        // 처음 로드 때 'auto'가 아니면 그 값을 기억
                        if (inp.value && inp.value !== 'auto') inp.dataset.prev = inp.value;

                        // 체크 토글
                        chk.addEventListener('change', function() {
                            if (this.checked) {
                                if (inp.value && inp.value !== 'auto') inp.dataset.prev = inp.value;
                                inp.value = 'auto';
                            } else {
                                inp.value = inp.dataset.prev || '';
                            }
                        });

                        // 체크 해제 상태에서 사용자가 숫자 변경하면 그걸 새 이전값으로 기억(선택적)
                        inp.addEventListener('input', function() {
                            if (!chk.checked && this.value !== 'auto') inp.dataset.prev = this.value;
                        });
                    })();
                </script>
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

        <!-- 일괄설정 항목 -->
        <script>
            (function () {
                /* 모서리, 배경색상 */
                const md_cb_chk = document.getElementById('md_color_border_batch_checkbox');     // 체크박스
                const md_cb_inp = document.querySelector('input[name="md_cb_batch"]');  // 숨김 input
                if (!md_cb_chk || !md_cb_inp) return;

                // 초기 동기화
                md_cb_inp.value = md_cb_chk.checked ? '1' : '0';

                // 체크 변경 시 동기화
                md_cb_chk.addEventListener('change', function () {
                    md_cb_inp.value = this.checked ? '1' : '0';
                    console.log('md_cb_batch value =', md_cb_inp.value);
                });


                /* 테두리 */
                const md_border_chk = document.getElementById('md_border_batch_checkbox');     // 체크박스
                const md_border_inp = document.querySelector('input[name="md_border_batch"]');  // 숨김 input
                if (!md_border_chk || !md_border_inp) return;

                // 초기 동기화
                md_border_inp.value = md_border_chk.checked ? '1' : '0';

                // 체크 변경 시 동기화
                md_border_chk.addEventListener('change', function () {
                    md_border_inp.value = this.checked ? '1' : '0';
                    console.log('md_border_inp value =', md_border_inp.value);
                });



                /* 그림자 */
                const md_shadow_chk = document.getElementById('md_shadow_batch_checkbox');     // 체크박스
                const md_shadow_inp = document.querySelector('input[name="md_shadow_batch"]');  // 숨김 input
                if (!md_shadow_chk || !md_shadow_inp) return;

                // 초기 동기화
                md_shadow_inp.value = md_shadow_chk.checked ? '1' : '0';

                // 체크 변경 시 동기화
                md_shadow_chk.addEventListener('change', function () {
                    md_shadow_inp.value = this.checked ? '1' : '0';
                    console.log('md_shadow_inp value =', md_shadow_inp.value);
                });



                /* 상/하단 간격 */
                const md_margin_chk = document.getElementById('md_margin_batch_checkbox');     // 체크박스
                const md_margin_inp = document.querySelector('input[name="md_margin_batch"]');  // 숨김 input
                if (!md_margin_chk || !md_margin_inp) return;

                // 초기 동기화
                md_margin_inp.value = md_margin_chk.checked ? '1' : '0';

                // 체크 변경 시 동기화
                md_margin_chk.addEventListener('change', function () {
                    md_margin_inp.value = this.checked ? '1' : '0';
                    console.log('md_margin_inp value =', md_margin_inp.value);
                });



                /* 내부 간격 */
                const md_padding_chk = document.getElementById('md_padding_batch_checkbox');     // 체크박스
                const md_padding_inp = document.querySelector('input[name="md_padding_batch"]');  // 숨김 input
                if (!md_padding_chk || !md_padding_inp) return;

                // 초기 동기화
                md_padding_inp.value = md_padding_chk.checked ? '1' : '0';

                // 체크 변경 시 동기화
                md_padding_chk.addEventListener('change', function () {
                    md_padding_inp.value = this.checked ? '1' : '0';
                    console.log('md_padding_inp value =', md_padding_inp.value);
                });
            })();
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
    <?php if(isset($set_id) && $set_id != '') { ?>
    <button type="button" class="main_rb_bg font-B" id="edit_css_btn" onclick="edit_css_mod_open(this)" data-layout="<?php echo $set_layout ?>" data-id="<?php echo $set_id ?>" data-tooltip="스타일을 바로 적용할 수 있어요" data-tooltip-pos="top">CSS 라이브 커스텀</button>
    <div class="cb"></div>
    <?php } ?>
    <button type="button" class="rb_config_save mt-5 font-B" onclick="executeAjax_module()">적용하기</button>
    <button type="button" class="rb_config_save2 mt-5 font-B" onclick="openLibPanel()">라이브러리</button>
    <button type="button" class="rb_config_close mt-5 font-B" onclick="toggleSideOptions_close()">취소</button>
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




<?php if(isset($mod_type) && $mod_type == 3) { ?>
<h2 class="font-B"><?php if($set_title) { ?><span><?php echo $set_title ?></span> 섹션설정<?php } else { ?>섹션추가<?php } ?></h2>

<h6 class="font-R rb_config_sub_txt">
    메인 레이아웃에 섹션을 추가 합니다.<br>
    추가된 섹션은 드래그&드랍으로 섹션끼리 위치 변경이 가능합니다.<br>
    섹션 내부에 모듈을 추가할 수 있습니다.
</h6>




<?php if($set_layout && $set_id && $theme_name) { ?>

<?php

                $rb_section = sql_fetch(" select * from {$rb_section_tables} where sec_theme = '{$theme_name}' and sec_id = '{$set_id}' and sec_layout = '{$set_layout}' ");
                $rb_section_is = sql_fetch(" select COUNT(*) as cnt from {$rb_section_tables} where sec_theme = '{$theme_name}' and sec_id = '{$set_id}' and sec_layout = '{$set_layout}' ");


                $sec_id = !empty($rb_section['sec_id']) ? $rb_section['sec_id'] : '';
    
                $sec_title = !empty($rb_section['sec_title']) ? $rb_section['sec_title'] : '';
                $sec_layout = !empty($rb_section['sec_layout']) ? $rb_section['sec_layout'] : '';
                $sec_layout_name = !empty($rb_section['sec_layout_name']) ? $rb_section['sec_layout_name'] : '';
                $sec_theme = !empty($rb_section['sec_theme']) ? $rb_section['sec_theme'] : '';


                $sec_title_color = !empty($rb_section['sec_title_color']) ? $rb_section['sec_title_color'] : '#25282b';
                $sec_title_size = !empty($rb_section['sec_title_size']) ? $rb_section['sec_title_size'] : '26';
                $sec_title_font = !empty($rb_section['sec_title_font']) ? $rb_section['sec_title_font'] : 'font-B';
                $sec_title_align = !empty($rb_section['sec_title_align']) ? $rb_section['sec_title_align'] : 'center';
                $sec_title_hide = !empty($rb_section['sec_title_hide']) ? $rb_section['sec_title_hide'] : '0';

                $sec_sub_title = !empty($rb_section['sec_sub_title']) ? $rb_section['sec_sub_title'] : '';
                $sec_sub_title_color = !empty($rb_section['sec_sub_title_color']) ? $rb_section['sec_sub_title_color'] : '#25282b';
                $sec_sub_title_size = !empty($rb_section['sec_sub_title_size']) ? $rb_section['sec_sub_title_size'] : '18';
                $sec_sub_title_font = !empty($rb_section['sec_sub_title_font']) ? $rb_section['sec_sub_title_font'] : 'font-R';
                $sec_sub_title_align = !empty($rb_section['sec_sub_title_align']) ? $rb_section['sec_sub_title_align'] : 'center';
                $sec_sub_title_hide = !empty($rb_section['sec_sub_title_hide']) ? $rb_section['sec_sub_title_hide'] : '0';

                $sec_width = !empty($rb_section['sec_width']) ? $rb_section['sec_width'] : '0';
                $sec_con_width = !empty($rb_section['sec_con_width']) ? $rb_section['sec_con_width'] : '0';
                $sec_padding_pc = !empty($rb_section['sec_padding_pc']) ? $rb_section['sec_padding_pc'] : '0';
                $sec_padding_mo = !empty($rb_section['sec_padding_mo']) ? $rb_section['sec_padding_mo'] : '0';

                $sec_padding = empty($rb_section['sec_padding']) ? '0' : $rb_section['sec_padding'];
                $sec_padding_lr_pc = $rb_section['sec_padding_lr_pc'] ?? '';
                $sec_padding_lr_mo = $rb_section['sec_padding_lr_mo'] ?? '';
                $sec_padding_tb_pc = $rb_section['sec_padding_tb_pc'] ?? '';
                $sec_padding_tb_mo = $rb_section['sec_padding_tb_mo'] ?? '';

                $sec_margin_top_pc = !empty($rb_section['sec_margin_top_pc']) ? $rb_section['sec_margin_top_pc'] : '0';
                $sec_margin_top_mo = !empty($rb_section['sec_margin_top_mo']) ? $rb_section['sec_margin_top_mo'] : '0';
                $sec_margin_btm_pc = !empty($rb_section['sec_margin_btm_pc']) ? $rb_section['sec_margin_btm_pc'] : '0';
                $sec_margin_btm_mo = !empty($rb_section['sec_margin_btm_mo']) ? $rb_section['sec_margin_btm_mo'] : '0';

                $sec_bg = !empty($rb_section['sec_bg']) ? $rb_section['sec_bg'] : '#FFFFFF';
    
                ?>

<?php } else { ?>



<?php } ?>



<ul class="rb_config_sec">
    <h6 class="font-B">섹션 타이틀 설정</h6>
    <h6 class="font-R rb_config_sub_txt">타이틀의 워딩 및 스타일을 설정할 수 있습니다.</h6>
    <div class="config_wrap">
        <ul>

            <input type="text" name="sec_title" class="input w100" value="<?php echo !empty($sec_title) ? $sec_title : ''; ?>" placeholder="타이틀을 입력하세요." autocomplete="off">
            <input type="hidden" name="sec_layout" value="<?php echo !empty($set_layout) ? $set_layout : ''; ?>">
            <input type="hidden" name="sec_theme" value="<?php echo !empty($theme_name) ? $theme_name : ''; ?>">
            <input type="hidden" name="sec_id" value="<?php echo !empty($sec_id) ? $sec_id : ''; ?>">

        </ul>

        <ul class="config_wrap_flex">

            <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                <input type="text" class="coloris mod_sec_title_color" name="sec_title_color" value="<?php echo !empty($sec_title_color) ? $sec_title_color : '#25282B'; ?>" style="width:25px !important;">
            </div>컬러


            <input type="number" class="tiny_input" name="sec_title_size" value="<?php echo !empty($sec_title_size) ? $sec_title_size : '26'; ?>"> px

            <select class="select select_tiny" name="sec_title_font" id="sec_title_font">
                <option value="">스타일</option>
                <option value="font-R" <?php if (isset($sec_title_font) && $sec_title_font == "font-R") { ?>selected<?php } ?>>Regular</option>
                <option value="font-B" <?php if (isset($sec_title_font) && $sec_title_font == "font-B") { ?>selected<?php } ?>>Bold</option>
                <option value="font-H" <?php if (isset($sec_title_font) && $sec_title_font == "font-H") { ?>selected<?php } ?>>Heavy</option>
            </select>

            <select class="select select_tiny" name="sec_title_align" id="sec_title_align">
                <option value="">정렬</option>
                <option value="center" <?php if (isset($sec_title_align) && $sec_title_align == "center") { ?>selected<?php } ?>>Center</option>
                <option value="left" <?php if (isset($sec_title_align) && $sec_title_align == "left") { ?>selected<?php } ?>>Left</option>
                <option value="right" <?php if (isset($sec_title_align) && $sec_title_align == "right") { ?>selected<?php } ?>>Right</option>
            </select>

            <div style="position: absolute; top:22px; right:0px;">
                <input type="checkbox" name="sec_title_hide" id="sec_title_hide" class="magic-checkbox" value="1" <?php if (isset($sec_title_hide) && $sec_title_hide == "1") { ?>checked<?php } ?>><label for="sec_title_hide">숨김</label>
            </div>

        </ul>

    </div>

</ul>



<ul class="rb_config_sec">
    <h6 class="font-B">섹션 서브워딩 설정</h6>
    <h6 class="font-R rb_config_sub_txt">서브워딩 및 스타일을 설정할 수 있습니다.<br>서브워딩은 타이틀 아래에 출력되며 엔터로 줄바꿈이 가능합니다.</h6>
    <div class="config_wrap">
        <ul>
            <textarea name="sec_sub_title" class="input w100 h100" placeholder="서브워딩을 입력하세요."><?php echo !empty($sec_sub_title) ? $sec_sub_title : ''; ?></textarea>
        </ul>

        <ul class="config_wrap_flex">

            <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                <input type="text" class="coloris mod_sec_sub_title_color" name="sec_sub_title_color" value="<?php echo !empty($sec_sub_title_color) ? $sec_sub_title_color : '#25282B'; ?>" style="width:25px !important;">
            </div>컬러

            <input type="number" class="tiny_input" name="sec_sub_title_size" value="<?php echo !empty($sec_sub_title_size) ? $sec_sub_title_size : '18'; ?>"> px

            <select class="select select_tiny" name="sec_sub_title_font" id="sec_sub_title_font">
                <option value="">스타일</option>
                <option value="font-R" <?php if (isset($sec_sub_title_font) && $sec_sub_title_font == "font-R") { ?>selected<?php } ?>>Regular</option>
                <option value="font-B" <?php if (isset($sec_sub_title_font) && $sec_sub_title_font == "font-B") { ?>selected<?php } ?>>Bold</option>
                <option value="font-H" <?php if (isset($sec_sub_title_font) && $sec_sub_title_font == "font-H") { ?>selected<?php } ?>>Heavy</option>
            </select>

            <select class="select select_tiny" name="sec_sub_title_align" id="sec_sub_title_align">
                <option value="">정렬</option>
                <option value="center" <?php if (isset($sec_sub_title_align) && $sec_sub_title_align == "center") { ?>selected<?php } ?>>Center</option>
                <option value="left" <?php if (isset($sec_sub_title_align) && $sec_sub_title_align == "left") { ?>selected<?php } ?>>Left</option>
                <option value="right" <?php if (isset($sec_sub_title_align) && $sec_sub_title_align == "right") { ?>selected<?php } ?>>Right</option>
            </select>

            <div style="position: absolute; top:22px; right:0px;">
                <input type="checkbox" name="sec_sub_title_hide" id="sec_sub_title_hide" class="magic-checkbox" value="1" <?php if (isset($sec_sub_title_hide) && $sec_sub_title_hide == "1") { ?>checked<?php } ?>><label for="sec_sub_title_hide">숨김</label>
            </div>

        </ul>

    </div>

</ul>




<ul class="rb_config_sec selected_style selected_select">
    <h6 class="font-B">
        섹션 및 컨테이너 설정
        <div class="rb-help" data-open="false">
            <button type="button" class="rb-help-btn" data-img="<?php echo G5_URL ?>/rb/rb.config/image/guide/help-img-3.png" data-txt="섹션은 브라우저를 기준으로 가로 100% 크기를 가진 DIV 에요. 섹션에는 내부에 컨테이너(DIV)가 존재해요." data-title="섹션 및 컨테이너란?" data-alt="미리보기" aria-expanded="false">
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
    <h6 class="font-R rb_config_sub_txt">섹션 및 섹션 내부 컨테이너의 스타일을 설정할 수 있습니다.<br>섹션은 가로 100% 로 생성 됩니다.</h6>
    <div class="config_wrap">


        <input type="hidden" name="sec_width" value="1">

        <div class="config_wrap_bg">
            <ul class="rows_inp_lr mt-10">
                <li class="rows_inp_l rows_inp_l_span">
                    <span class="font-B">컨테이너 사이즈</span><br>
                    container width
                </li>
                <li class="rows_inp_r mt-5">
                    <input type="radio" name="sec_con_width" id="sec_con_width_1" class="magic-radio" value="" <?php if (isset($sec_con_width) && $sec_con_width == "" || empty($sec_con_width)) { ?>checked<?php } ?>><label for="sec_con_width_1">기본</label>
                    <input type="radio" name="sec_con_width" id="sec_con_width_2" class="magic-radio" value="1" <?php if (isset($sec_con_width) && $sec_con_width == "1") { ?>checked<?php } ?>><label for="sec_con_width_2">100%</label>
                </li>

                <div class="cb"></div>

                <div class="rb-help" data-open="false">
                    <button type="button" class="rb-help-btn" data-img="" data-txt="생성된 섹션에는 내부에 컨테이너(DIV)가 존재하고, 해당 DIV의 가로 크기를 말해요. [기본] 인 경우 100% 섹션 중앙에 1024(설정값) 크기의 컨테이너가 들어가요." data-title="컨테이너 사이즈란?" data-alt="미리보기" aria-expanded="false">
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

            <ul class="rows_inp_lr mt-10">
                <li class="rows_inp_l rows_inp_l_span">
                    <span class="font-B">백그라운드</span><br>
                    bg color
                </li>
                <li class="rows_inp_r mt-5">
                    <div class="color_set_wrap square none_inp_cl" style="position: relative;">
                        <input type="text" class="coloris" name="sec_bg" value="<?php echo !empty($sec_bg) ? $sec_bg : '#FFFFFF'; ?>" style="width:25px !important;"> 컬러
                    </div>
                </li>

                <div class="cb"></div>
            </ul>

        </div>

        <div class="config_wrap_bg">

            <ul class="rows_inp_lr">
                <li class="rows_inp_l rows_inp_l_span">
                    <span class="font-B">상단 간격</span><br>
                    margin-top
                </li>
                <li class="rows_inp_r mt-5">
                    <input type="number" id="sec_margin_top_pc" class="tiny_input w25 ml-0" name="sec_margin_top_pc" placeholder="PC" value="<?php echo (isset($sec_margin_top_pc) && $sec_margin_top_pc !== '') ? $sec_margin_top_pc : ''; ?>"> <span class="font-12">px　</span>
                    <input type="number" id="sec_margin_top_mo" class="tiny_input w25 ml-0" name="sec_margin_top_mo" placeholder="Mobile" value="<?php echo (isset($sec_margin_top_mo) && $sec_margin_top_mo !== '') ? $sec_margin_top_mo : ''; ?>"> <span class="font-12">px</span>
                </li>

                <div class="cb"></div>

                <div class="rb-help" data-open="false">
                    <button type="button" class="rb-help-btn" data-img="" data-txt="섹션 위쪽으로 Margin(간격) 값이 들어가요. 마이너스(-)도 입력이 가능하고 모바일 간격의 경우 모바일기기로 접속시에만 반영되요." data-title="상단 간격이란?" data-alt="미리보기" aria-expanded="false">
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


            <ul class="rows_inp_lr mt-10">
                <li class="rows_inp_l rows_inp_l_span">
                    <span class="font-B">하단 간격</span><br>
                    margin-bottom
                </li>
                <li class="rows_inp_r mt-5">
                    <input type="number" id="sec_margin_btm_pc" class="tiny_input w25 ml-0" name="sec_margin_btm_pc" placeholder="PC" value="<?php echo (isset($sec_margin_btm_pc) && $sec_margin_btm_pc !== '') ? $sec_margin_btm_pc : ''; ?>"> <span class="font-12">px　</span>
                    <input type="number" id="sec_margin_btm_mo" class="tiny_input w25 ml-0" name="sec_margin_btm_mo" placeholder="Mobile" value="<?php echo (isset($sec_margin_btm_mo) && $sec_margin_btm_mo !== '') ? $sec_margin_btm_mo : ''; ?>"> <span class="font-12">px</span>
                </li>

                <div class="cb"></div>

                <div class="rb-help" data-open="false">
                    <button type="button" class="rb-help-btn" data-img="" data-txt="섹션 아래쪽으로 Margin(간격) 값이 들어가요. 마이너스(-)도 입력이 가능하고 모바일 간격의 경우 모바일기기로 접속시에만 반영되요." data-title="하단 간격이란?" data-alt="미리보기" aria-expanded="false">
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



        <div class="config_wrap_bg">
                    <ul class="rows_inp_lr">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">내부 여백 (가로축)</span><br>
                            padding
                        </li>

                        <li class="rows_inp_r mt-5">
                            <input type="number" id="sec_padding_lr_pc" class="tiny_input w30 ml-0" name="sec_padding_lr_pc" placeholder="PC" value="<?php echo (isset($sec_padding_lr_pc) && $sec_padding_lr_pc !== '') ? $sec_padding_lr_pc : ''; ?>"> <span class="font-12">px</span>
                            <input type="number" id="sec_padding_lr_mo" class="tiny_input w30 ml-0" name="sec_padding_lr_mo" placeholder="Mobile" value="<?php echo (isset($sec_padding_lr_mo) && $sec_padding_lr_mo !== '') ? $sec_padding_lr_mo : ''; ?>"> <span class="font-12">px</span>
                        </li>
                        <div class="cb"></div>
                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="섹션 내부 (좌/우) 에 동일한 padding(여백) 값을 설정할 수 있어요. 모바일 여백의 경우 모바일기기로 접속시에만 반영되요." data-title="내부 여백(가로축) 이란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">내부 여백 (세로축)</span><br>
                            padding
                        </li>

                        <li class="rows_inp_r mt-5">
                            <input type="number" id="sec_padding_tb_pc" class="tiny_input w30 ml-0" name="sec_padding_tb_pc" placeholder="PC" value="<?php echo (isset($sec_padding_tb_pc) && $sec_padding_tb_pc !== '') ? $sec_padding_tb_pc : ''; ?>"> <span class="font-12">px</span>
                            <input type="number" id="sec_padding_tb_mo" class="tiny_input w30 ml-0" name="sec_padding_tb_mo" placeholder="Mobile" value="<?php echo (isset($sec_padding_tb_mo) && $sec_padding_tb_mo !== '') ? $sec_padding_tb_mo : ''; ?>"> <span class="font-12">px</span>
                        </li>
                        <div class="cb"></div>

                        <div class="rb-help" data-open="false">
                            <button type="button" class="rb-help-btn" data-img="" data-txt="섹션 내부 (상/하) 에 동일한 padding(여백) 값을 설정할 수 있어요. 모바일 여백의 경우 모바일기기로 접속시에만 반영되요." data-title="내부 여백(세로축) 이란?" data-alt="미리보기" aria-expanded="false">
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

                    <ul class="rows_inp_lr mt-5">
                        <li class="rows_inp_l rows_inp_l_span">
                            <span class="font-B">일괄설정</span><br>
                            padding
                        </li>

                        <li class="rows_inp_r mt-20">
                            <div id="sec_padding_range" class="rb_range_item"></div>
                            <input type="hidden" id="sec_padding" class="co_range_send" name="sec_padding" value="<?php echo !empty($sec_padding) ? $sec_padding : '0'; ?>">
                        </li>

                        <script type="text/javascript">
                            $("#sec_padding_range").slider({
                                range: "min",
                                min: 0,
                                max: 100,
                                value: <?php echo !empty($sec_padding) ? $sec_padding : '0'; ?>,
                                step: 1,
                                slide: function(e, ui) {
                                    $("#sec_padding_range .ui-slider-handle").html(ui.value);
                                    $("#sec_padding").val(ui.value);
                                    $("#sec_padding_lr_pc").val(ui.value);
                                    $("#sec_padding_lr_mo").val(ui.value);
                                    $("#sec_padding_tb_pc").val(ui.value);
                                    $("#sec_padding_tb_mo").val(ui.value);
                                }
                            });

                            $("#sec_padding_range .ui-slider-handle").html("<?php echo !empty($sec_padding) ? $sec_padding : '0'; ?>");
                            $("#sec_padding").val("<?php echo !empty($sec_padding) ? $sec_padding : '0'; ?>"); // 초기값 설정
                        </script>

                        <div class="cb"></div>

                    </ul>


                    <input type="hidden" id="sec_padding_pc" class="tiny_input w25 ml-0" name="sec_padding_pc" placeholder="PC" value="<?php echo !empty($sec_padding_pc) ? $sec_padding_pc : ''; ?>">
                    <input type="hidden" id="sec_padding_mo" class="tiny_input w25 ml-0" name="sec_padding_mo" placeholder="Mobile" value="<?php echo !empty($sec_padding_mo) ? $sec_padding_mo : ''; ?>">

        </div>

    </div>
</ul>



<ul class="rb_config_sec">
    <button type="button" class="main_rb_bg font-B" id="edit_css_btn" onclick="edit_css_sec_open(this)" data-layout="<?php echo $set_layout ?>" data-id="<?php echo $set_id ?>">CSS 라이브 커스텀</button>
    <div class="cb"></div>
    <button type="button" class="rb_config_reload mt-5 font-B" onclick="executeAjax_section();">저장</button>
    <button type="button" class="rb_config_close mt-5 font-B" onclick="toggleSideOptions_close()">닫기</button>
    <div class="cb"></div>
</ul>


<?php } ?>

<?php if(isset($mod_type) && $mod_type == "del_sec") { ?>
<h2 class="font-B"><span><?php echo !empty($set_title) ? $set_title : ''; ?></span> 섹션삭제</h2>
<input type="hidden" name="sec_layout" value="<?php echo !empty($set_layout) ? $set_layout : ''; ?>">
<input type="hidden" name="sec_theme" value="<?php echo !empty($theme_name) ? $theme_name : ''; ?>">
<input type="hidden" name="sec_id" value="<?php echo !empty($set_id) ? $set_id : ''; ?>">

<ul class="rb_config_sec">
    <div class="no_data">
        섹션을 삭제합니다. 삭제하신 섹션은 복구할 수 없으며<br>
        내부에 생성된 모듈도 함께 삭제 됩니다.
    </div>
</ul>

<ul class="rb_config_sec">
    <button type="button" class="rb_config_save font-B" onclick="executeAjax_section_del()">삭제하기</button>
    <button type="button" class="rb_config_close font-B" onclick="toggleSideOptions_close()">취소</button>
    <div class="cb"></div>
</ul>
<?php } ?>
