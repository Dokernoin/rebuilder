<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');

if (!defined('_GNUBOARD_')) exit;

$layouts = array();
if (isset($_POST['layouts']) && is_array($_POST['layouts'])) {
    $layouts = $_POST['layouts'];
}

$layout_name = '';
if (isset($rb_core['layout_shop'])) {
    $layout_name = $rb_core['layout_shop'];
}

$theme_name = '';
if (isset($rb_core['theme'])) {
    $theme_name = $rb_core['theme'];
}

$result_data = array();

foreach ($layouts as $layout_no) {
    $cache_file = G5_DATA_PATH . "/cache/rb_layout_shop_" . $layout_no . ".php";
    $hash_file = G5_DATA_PATH . "/cache/rb_layout_shop_" . $layout_no . ".hash";

    // 체크섬 생성
    $layout_sql = "SELECT * FROM rb_module_shop WHERE md_layout = '" . $layout_no . "' AND md_theme = '" . $theme_name . "' AND md_layout_name = '" . $layout_name . "' ORDER BY md_order_id, md_id ASC";
    $layout_rows = sql_query($layout_sql);
    $layout_structure = '';
    while ($row = sql_fetch_array($layout_rows)) {
        $layout_structure .= implode('|', $row) . ';';
    }
    $layout_checksum = md5($layout_structure);

    $use_cache = !$is_admin;

    // 캐시 사용 조건 확인
    if ($use_cache && file_exists($cache_file) && file_exists($hash_file)) {
        $saved_checksum = file_get_contents($hash_file);
        if ($saved_checksum === $layout_checksum) {
            $result_data[$layout_no] = include $cache_file;
            continue;
        }
    }

    $sql = "SELECT * FROM rb_module_shop WHERE md_layout = '" . $layout_no . "' AND md_theme = '" . $theme_name . "' AND md_layout_name = '" . $layout_name . "' ORDER BY md_order_id, md_id ASC";
    $result = sql_query($sql);
    $sql_cnts = sql_fetch("SELECT COUNT(*) as cnt FROM rb_module_shop WHERE md_layout = '" . $layout_no . "' AND md_theme = '" . $theme_name . "' AND md_layout_name = '" . $layout_name . "'");
    $rb_module_table = "rb_module_shop";

    $output = "<?php\nob_start();\n\n\$rb_module_table = 'rb_module_shop';\n\$GLOBALS['rb_module_table'] = \$rb_module_table;\n\$is_admin = " . var_export($is_admin, true) . ";\n?>\n";

    while ($row_mod = sql_fetch_array($result)) {
        ob_start();
        echo "<?php\n\$row_mod = " . var_export($row_mod, true) . ";\n?>\n";
        ?>

        <div
        class="rb_layout_box <?php echo isset($row_mod['md_show']) ? $row_mod['md_show'] : ''; ?>"
        style="width:<?php echo $row_mod['md_width']; ?><?php echo !empty($row_mod['md_size']) ? $row_mod['md_size'] : '%'; ?>; height:<?php echo $row_mod['md_height']; ?>;
        margin-top:<?php
            echo IS_MOBILE()
                ? (!empty($row_mod['md_margin_top_mo']) ? $row_mod['md_margin_top_mo'] : '0')
                : (!empty($row_mod['md_margin_top_pc']) ? $row_mod['md_margin_top_pc'] : '0');
        ?>px;
        margin-bottom:<?php
            echo IS_MOBILE()
                ? (!empty($row_mod['md_margin_btm_mo']) ? $row_mod['md_margin_btm_mo'] : '0')
                : (!empty($row_mod['md_margin_btm_pc']) ? $row_mod['md_margin_btm_pc'] : '0');
        ?>px;"
        data-order-id="<?php echo $row_mod['md_id']; ?>"
        data-id="<?php echo $row_mod['md_id']; ?>"
        data-layout="<?php echo $row_mod['md_layout']; ?>"
        data-title="<?php echo $row_mod['md_title']; ?>"
        >

            <ul class="content_box rb_module_shop_<?php echo $row_mod['md_id']; ?> rb_module_border_<?php echo $row_mod['md_border']; ?> rb_module_radius_<?php echo $row_mod['md_radius']; ?><?php if (isset($row_mod['md_padding']) && $row_mod['md_padding'] > 0) { ?> rb_module_padding_<?php echo $row_mod['md_padding']; ?><?php } ?> <?php echo isset($row_mod['md_show']) ? $row_mod['md_show'] : ''; ?> <?php if (isset($row_mod['md_wide_is']) && $row_mod['md_wide_is'] == 1) { ?>rb_module_wide<?php } ?> <?php if (isset($row_mod['md_wide_is']) && $row_mod['md_wide_is'] == 2) { ?>rb_module_mid<?php } ?>" >

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'latest') { ?>
                    <div class="module_latest_wrap md_arrow_<?php echo isset($row_mod['md_arrow_type']) ? $row_mod['md_arrow_type'] : ''; ?>">
                        <?php echo '<?php echo rb_latest("' . $row_mod['md_bo_table'] . '", "' . $row_mod['md_skin'] . '", ' . $row_mod['md_cnt'] . ', 999, 1, ' . $row_mod['md_id'] . ', "' . $row_mod['md_sca'] . '", "' . $row_mod['md_order_latest'] . '", "' . $rb_module_table . '", "' . $row_mod['md_notice'] . '"); ?>'; ?>
                    </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'tab') { ?>
                <div class="module_latest_wrap md_arrow_<?php echo isset($row_mod['md_arrow_type']) ? $row_mod['md_arrow_type'] : ''; ?>">
                <?php
                    $tab_list_clean = addslashes($row_mod['md_tab_list']);

                    $tab_code = '<?php echo rb_latest_tabs("' . $row_mod['md_tab_skin'] . '", "' . $tab_list_clean . '", ' . intval($row_mod['md_cnt']) . ', 999, 1, "' . $row_mod['md_id'] . '", "' . $row_mod['md_order_latest'] . '", "' . $rb_module_table . '", "' . $row_mod['md_notice'] . '"); ?>';
                    echo $tab_code;
                ?>
                </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'widget') { ?>
                    <div class="module_widget_wrap">
                        <?php echo '<?php @include (G5_PATH . "/rb/' . $row_mod['md_widget'] . '/widget.php"); ?>'; ?>
                    </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'banner') { ?>

                    <div class="bbs_main_wrap_tit mo-mb-0" style="display:<?php echo (isset($row_mod['md_title_hide']) && $row_mod['md_title_hide'] == '1') ? 'none' : 'block'; ?>">
                        <ul class="bbs_main_wrap_tit_l">
                            <!-- 타이틀 { -->
                            <a href="javascript:void(0);">
                                <h2 class="<?php echo isset($row_mod['md_title_font']) ? $row_mod['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($row_mod['md_title_color']) ? $row_mod['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($row_mod['md_title_size']) ? $row_mod['md_title_size'] : '20'; ?>px; "><?php echo $row_mod['md_title'] ?></h2>
                            </a>
                            <!-- } -->
                        </ul>

                        <ul class="bbs_main_wrap_tit_r"></ul>

                        <div class="cb"></div>
                    </div>

                    <div class="module_banner_wrap md_arrow_<?php echo isset($row_mod['md_arrow_type']) ? $row_mod['md_arrow_type'] : ''; ?>">
                        <?php echo '<?php echo rb_banners("' . $row_mod['md_banner'] . '", "' . $row_mod['md_banner_id'] . '", "' . $row_mod['md_banner_skin'] . '", "' . $row_mod['md_order_banner'] . '"); ?>'; ?>
                    </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'poll') { ?>

                    <div class="bbs_main_wrap_tit" style="display:<?php echo (isset($row_mod['md_title_hide']) && $row_mod['md_title_hide'] == '1') ? 'none' : 'block'; ?>">
                        <ul class="bbs_main_wrap_tit_l">
                            <!-- 타이틀 { -->
                            <a href="javascript:void(0);">
                                <h2 class="<?php echo isset($row_mod['md_title_font']) ? $row_mod['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($row_mod['md_title_color']) ? $row_mod['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($row_mod['md_title_size']) ? $row_mod['md_title_size'] : '20'; ?>px; "><?php echo $row_mod['md_title'] ?></h2>
                            </a>
                            <!-- } -->
                        </ul>

                        <ul class="bbs_main_wrap_tit_r"></ul>

                        <div class="cb"></div>
                    </div>

                    <div class="module_poll_wrap">
                        <?php echo '<?php echo poll("' . $row_mod['md_poll'] . '", "' . $row_mod['md_poll_id'] . '"); ?>'; ?>
                    </div>
                <?php } ?>


                <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "item") { ?>
                    <?php
                    $code = "";
                    $code .= "\n<?php\n";
                    $code .= "if(isset(\$row_mod['md_soldout_hidden']) && \$row_mod['md_soldout_hidden'] == 1) {\n";
                    $code .= "\$item_where = \" where it_use = '1' and it_stock_qty > 0 and it_soldout = 0\";\n";
                    $code .= "} else { \n";
                    $code .= "\$item_where = \" where it_use = '1'\";\n";
                    $code .= "}\n";
                    $code .= "if(isset(\$row_mod['md_module']) && \$row_mod['md_module'] > 0) {\n";
                    $code .= "    \$item_where .= \" and it_type\".\$row_mod['md_module'].\" = '1' \";\n";
                    $code .= "}\n";
                    $code .= "if(isset(\$row_mod['md_sca']) && \$row_mod['md_sca']) {\n";
                    $code .= "\$item_where .= \" AND (ca_id = '\".\$row_mod['md_sca'].\"' OR ca_id LIKE '\".\$row_mod['md_sca'].\"%') \";\n";
                    $code .= "}\n";
                    $code .= "if(isset(\$row_mod['md_order']) && \$row_mod['md_order']) {\n";
                    $code .= "if(isset(\$row_mod['md_soldout_asc']) && \$row_mod['md_soldout_asc'] == 1) {\n";
                    $code .= "    \$item_order = \" order by it_soldout asc, \" . \$row_mod['md_order'];\n";
                    $code .= "} else { \n";
                    $code .= "    \$item_order = \" order by \" . \$row_mod['md_order'];\n";
                    $code .= "}\n";
                    $code .= "} else { \n";
                    $code .= "if(isset(\$row_mod['md_soldout_asc']) && \$row_mod['md_soldout_asc'] == 1) {\n";
                    $code .= "    \$item_order = \" order by it_soldout asc, it_id desc\";\n";
                    $code .= "} else { \n";
                    $code .= "    \$item_order = \" order by it_id desc\";\n";
                    $code .= "}\n";
                    $code .= "}\n";
                    $code .= "\$item_limit = \" limit \" . \$row_mod['md_cnt'];\n";
                    $code .= "\$item_sql = \" select * from {\$g5['g5_shop_item_table']} \" . \$item_where . \" \" . \$item_order . \" \" . \$item_limit;\n";
                    ?>
                    <div class="module_item_wrap md_arrow_<?php echo isset($row_mod['md_arrow_type']) ? $row_mod['md_arrow_type'] : ''; ?>">
                    <?php
                    $code .= "\$list = new item_list();\n";
                    $code .= "\$list->set_img_size(300, 300);\n";
                    $code .= "\$list->set_list_skin(G5_SHOP_SKIN_PATH.'/'.\$row_mod['md_skin']);\n";
                    $code .= "\$list->set_view('it_cust_price', true);\n";
                    $code .= "\$list->set_view('it_price', true);\n";
                    $code .= "\$list->set_view('sns', true);\n";
                    $code .= "\$list->set_view('md_table', \$rb_module_table);\n";
                    $code .= "\$list->set_view('md_id', \$row_mod['md_id']);\n";
                    $code .= "\$list->set_query(\$item_sql);\n";
                    $code .= "echo \$list->run();\n";
                    $code .= "?>\n";
                    echo $code;
                    ?>
                    </div>
                <?php } ?>


                <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "item_tab") { ?>


                <div class="module_item_wrap md_arrow_<?php echo isset($row_mod['md_arrow_type']) ? $row_mod['md_arrow_type'] : ''; ?>">

                <?php
                // md_item_tab_list를 배열로 변환
                $tab_list = [];
                if (!empty($row_mod['md_item_tab_list'])) {
                    $tab_list = json_decode($row_mod['md_item_tab_list'], true);
                    if (!is_array($tab_list)) $tab_list = [];
                }

                $item_subject = $row_mod['md_title']; //타이틀

                ?>

                <div class="rb_item_po_rels">

                <!-- { -->
                <ul class="bbs_main_wrap_tit" style="display:<?php echo (isset($row_mod['md_title_hide']) && $row_mod['md_title_hide'] == '1') ? 'none' : 'block'; ?>">

                    <li class="bbs_main_wrap_tit_l">
                        <!-- 타이틀 { -->
                        <a href="javascript:void(0);">
                            <h2 class="<?php echo isset($row_mod['md_title_font']) ? $row_mod['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($row_mod['md_title_color']) ? $row_mod['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($row_mod['md_title_size']) ? $row_mod['md_title_size'] : '20'; ?>px; "><?php echo $item_subject ?></h2>
                        </a>
                        <!-- } -->
                    </li>

                    <div class="cb"></div>
                </ul>
                <!-- } -->

                <nav class="rb_item_tab_nav swiper-container swiper-container-tab-item-<?php echo $row_mod['md_id']; ?>">
                <ul class="rb_tab_nav swiper-wrapper rb_tab_nav_<?php echo $row_mod['md_id']; ?>">
                    <?php foreach ($tab_list as $idx => $sca) { ?>
                        <li class="swiper-slide <?php echo $idx==0?'on':'';?>" data-tab="tab_<?php echo $sca; ?>">
                            <a href="javascript:void(0);"><?php echo get_category_name($sca); ?></a>
                        </li>
                    <?php } ?>
                </ul>
                </nav>

                <script>
                    $(document).ready(function() {
                        setTimeout(function() {

                            var swiper = new Swiper('.swiper-container-tab-item-<?php echo $row_mod['md_id']; ?>', {
                                slidesPerView: 'auto',
                                spaceBetween: 5,
                                touchRatio: 1,
                                observer: true,
                                observeParents: true
                            });

                        }, 50);
                    });
                </script>

                <?php
                $idx = 0;
                foreach ($tab_list as $tab_sca) {
                    $code = "";
                    $code .= "<?php\n";
                    $code .= "if(isset(\$row_mod['md_soldout_hidden']) && \$row_mod['md_soldout_hidden'] == 1) {\n";
                    $code .= "\$item_where = \" where it_use = '1' and it_stock_qty > 0 and it_soldout = 0\";\n";
                    $code .= "} else { \n";
                    $code .= "\$item_where = \" where it_use = '1'\";\n";
                    $code .= "}\n";
                    $code .= "if(isset(\$row_mod['md_module']) && \$row_mod['md_module'] > 0) {\n";
                    $code .= "    \$item_where .= \" and it_type\".\$row_mod['md_module'].\" = '1' \";\n";
                    $code .= "}\n";
                    $code .= "\$item_where .= \" AND (ca_id = '{$tab_sca}' OR ca_id LIKE '{$tab_sca}%') \";\n";
                    $code .= "if(isset(\$row_mod['md_order']) && \$row_mod['md_order']) {\n";
                    $code .= "if(isset(\$row_mod['md_soldout_asc']) && \$row_mod['md_soldout_asc'] == 1) {\n";
                    $code .= "    \$item_order = \" order by it_soldout asc, \" . \$row_mod['md_order'];\n";
                    $code .= "} else { \n";
                    $code .= "    \$item_order = \" order by \" . \$row_mod['md_order'];\n";
                    $code .= "}\n";
                    $code .= "} else { \n";
                    $code .= "if(isset(\$row_mod['md_soldout_asc']) && \$row_mod['md_soldout_asc'] == 1) {\n";
                    $code .= "    \$item_order = \" order by it_soldout asc, it_id desc\";\n";
                    $code .= "} else { \n";
                    $code .= "    \$item_order = \" order by it_id desc\";\n";
                    $code .= "}\n";
                    $code .= "}\n";
                    $code .= "\$item_limit = \" limit \" . \$row_mod['md_cnt'];\n";
                    $code .= "\$item_sql = \" select * from {\$g5['g5_shop_item_table']} \" . \$item_where . \" \" . \$item_order . \" \" . \$item_limit;\n";
                    //$code .= "echo \$item_sql;\n";
                    ?>

                    <div class="module_item_wrap_inner <?php echo $idx==0 ? 'rb-item-tab-visible' : 'rb-item-tab-hidden'; ?>" data-tab-content="tab_<?php echo $tab_sca; ?>" data-tab-group="tabgroup_<?php echo $row_mod['md_id']; ?>">

                    <?php
                    if($tab_sca) {
                        $links_url = shop_category_url($tab_sca); //링크
                    ?>

                    <button type="button" class="more_btn more_btn_item_tabs" onclick="location.href='<?php echo $links_url ?>';" style="display:<?php echo (isset($row_mod['md_title_hide']) && $row_mod['md_title_hide'] == '1') ? 'none' : 'block'; ?>">전체보기</button>
                    <?php } ?>

                    <?php
                    $code .= "\$list = new item_list();\n";
                    $code .= "\$list->set_img_size(300, 300);\n";
                    $code .= "\$list->set_list_skin(G5_SHOP_SKIN_PATH.'/'.\$row_mod['md_item_tab_skin']);\n";
                    $code .= "\$list->set_view('it_cust_price', true);\n";
                    $code .= "\$list->set_view('it_price', true);\n";
                    $code .= "\$list->set_view('sns', true);\n";
                    $code .= "\$list->set_view('md_table', \$rb_module_table);\n";
                    $code .= "\$list->set_view('md_id', \$row_mod['md_id']);\n";
                    $code .= "\$list->set_query(\$item_sql);\n";
                    $code .= "echo \$list->run();\n";
                    $code .= "?>\n";
                    echo $code;
                    ?>
                    </div>
                    <?php $idx++; } ?>
                </div>
                </div>
                <?php } ?>

                <?php if ($is_admin) { ?>
                    <span class="admin_ov">
                        <div class="mod_edit">
                            <ul class="middle_y text-center">
                                <h2 class="font-B"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?> <span>모듈 설정</span></h2>
                                <h6 class="font-R">해당 모듈의 설정을 변경할 수 있습니다.</h6>
                                <button type="button" class="btn_round btn_round_bg admin_set_btn" onclick="set_module_send(this);">설정</button>
                                <button type="button" class="btn_round admin_set_btn" onclick="set_module_del(this);">삭제</button>
                            </ul>
                        </div>
                    </span>
                <?php } ?>
            </ul>

            <div class="flex_box_inner flex_box" data-layout="<?php echo $row_mod['md_layout']; ?>-<?php echo $row_mod['md_id']; ?>"></div>

        </div>

        <script>
            $(function(){
                $('.content_box.rb_module_wide, .content_box.rb_module_mid').each(function(){
                    var parentWidth = $(this).parent().width();
                    $(this).css('min-width', parentWidth + 'px');
                });
            });
        </script>

        <script>
                $(function(){
                    $('.rb_tab_nav').each(function(){
                        var $nav = $(this);
                        var groupId = $nav.attr('class').match(/rb_tab_nav_([^\s]+)/)[1];

                        $nav.find('li').on('click', function(){
                            var tab = $(this).data('tab');
                            $nav.find('li').removeClass('on');
                            $(this).addClass('on');

                            // 숨김 처리 (display:none 대신 클래스 변경)
                            $('.module_item_wrap_inner[data-tab-group="tabgroup_' + groupId + '"]')
                                .removeClass('rb-item-tab-visible').addClass('rb-item-tab-hidden');
                            $('.module_item_wrap_inner[data-tab-group="tabgroup_' + groupId + '"][data-tab-content="'+tab+'"]')
                                .removeClass('rb-item-tab-hidden').addClass('rb-item-tab-visible');
                        });
                    });
                });
        </script>
        <?php
        $output .= ob_get_clean();
    }

    if ($is_admin) {
        if (!isset($sql_cnts['cnt']) || !$sql_cnts['cnt']) {
            $output .= '<div class="no_data_section add_module_wrap"><ul><img src="'.G5_THEME_URL.'/rb.img/icon/icon_error.svg" style="width:50px;"></ul><ul class="no_data_section_ul1 font-B">추가된 모듈이 없습니다.</ul><ul class="no_data_section_ul2">모듈추가 버튼을 클릭해주세요.<br>모듈은 계속 추가할 수 있습니다.</ul></div>';
        }
        $output .= '<div class="add_module_wrap adm_co_gap_pc_' . $rb_core['gap_pc'] . '"><button type="button" class="add_module_btns font-B" onclick="set_module_send(this);">모듈추가</button></div>';
    }

    $output .= "<?php\nreturn ob_get_clean();\n?>";

    if ($use_cache) {
        file_put_contents($cache_file, $output);
        file_put_contents($hash_file, $layout_checksum);
    }

    $result_data[$layout_no] = eval('?>' . $output);
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result_data);
