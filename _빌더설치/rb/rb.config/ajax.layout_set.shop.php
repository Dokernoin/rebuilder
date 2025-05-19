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
    $layout_sql = "SELECT md_id, md_order_id, md_radius, md_border, md_padding, md_width, md_height FROM rb_module_shop WHERE md_layout = '" . $layout_no . "' AND md_theme = '" . $theme_name . "' AND md_layout_name = '" . $layout_name . "' ORDER BY md_order_id, md_id ASC";
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
        <div class="rb_layout_box" style="width:<?php echo $row_mod['md_width']; ?>%; height:<?php echo $row_mod['md_height']; ?>;" data-order-id="<?php echo $row_mod['md_id']; ?>" data-id="<?php echo $row_mod['md_id']; ?>" data-layout="<?php echo $row_mod['md_layout']; ?>" data-title="<?php echo $row_mod['md_title']; ?>">

            <ul class="content_box rb_module_shop_<?php echo $row_mod['md_id']; ?> rb_module_border_<?php echo $row_mod['md_border']; ?> rb_module_radius_<?php echo $row_mod['md_radius']; ?><?php if (isset($row_mod['md_padding']) && $row_mod['md_padding'] > 0) { ?> rb_module_padding_<?php echo $row_mod['md_padding']; ?><?php } ?>" >

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'latest') { ?>
                    <div class="module_latest_wrap">
                        <?php echo '<?php echo rb_latest("' . $row_mod['md_skin'] . '", "' . $row_mod['md_bo_table'] . '", ' . $row_mod['md_cnt'] . ', 999, 1, ' . $row_mod['md_id'] . ', "' . $row_mod['md_sca'] . '", "' . $row_mod['md_order_latest'] . '", "' . $rb_module_table . '"); ?>'; ?>
                    </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'tab') { ?>
                <div class="module_latest_wrap">
                <?php
                    $tab_list_clean = addslashes($row_mod['md_tab_list']);

                    $tab_code = '<?php echo rb_latest_tabs("' . $row_mod['md_tab_skin'] . '", "' . $tab_list_clean . '", ' . intval($row_mod['md_cnt']) . ', 999, 1, "' . $row_mod['md_id'] . '", "' . $row_mod['md_order_latest'] . '", "' . $rb_module_table . '"); ?>';
                    echo $tab_code;
                ?>
                </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'widget') { ?>
                    <div class="module_widget_wrap">
                        <?php echo '<?php @include_once(G5_PATH . "/rb/' . $row_mod['md_widget'] . '/widget.php"); ?>'; ?>
                    </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'banner') { ?>
                    <div class="module_banner_wrap">
                        <?php echo '<?php echo rb_banners("' . $row_mod['md_banner'] . '", "' . $row_mod['md_banner_id'] . '", "' . $row_mod['md_banner_skin'] . '"); ?>'; ?>
                    </div>
                <?php } ?>

                <?php if (isset($row_mod['md_type']) && $row_mod['md_type'] == 'poll') { ?>
                    <div class="module_poll_wrap">
                        <?php echo '<?php echo poll("' . $row_mod['md_poll'] . '", "' . $row_mod['md_poll_id'] . '"); ?>'; ?>
                    </div>
                <?php } ?>


                <?php if(isset($row_mod['md_type']) && $row_mod['md_type'] == "item") { ?>
                    <?php
                    // item 관련 SQL문 및 변수들을 동적으로 생성하도록 PHP 코드로 기록합니다.
                    $code  = "\n<?php\n";
                    $code .= "\$item_where = \" where it_use = '1' and it_stock_qty > 0 and it_soldout = 0\";\n";
                    $code .= "if(isset(\$row_mod['md_module']) && \$row_mod['md_module'] > 0) {\n";
                    $code .= "    \$item_where .= \" and it_type\".\$row_mod['md_module'].\" = '1' \";\n";
                    $code .= "}\n";
                    $code .= "if(isset(\$row_mod['md_sca']) && \$row_mod['md_sca']) {\n";
                    $code .= "    \$item_where .= \" AND (ca_id = '\".\$row_mod['md_sca'].\"' OR ca_id LIKE '\".\$row_mod['md_sca'].\"%') \";\n";
                    $code .= "}\n";
                    $code .= "if(isset(\$row_mod['md_order']) && \$row_mod['md_order']) {\n";
                    $code .= "    \$item_order = \" order by \" . \$row_mod['md_order'];\n";
                    $code .= "} else { \n";
                    $code .= "    \$item_order = \" order by it_id desc\";\n";
                    $code .= "}\n";
                    $code .= "\$item_limit = \" limit \" . \$row_mod['md_cnt'];\n";
                    $code .= "\$item_sql = \" select * from {\$g5['g5_shop_item_table']} \" . \$item_where . \" \" . \$item_order . \" \" . \$item_limit;\n";
                    ?>
                    <div class="module_item_wrap">
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


