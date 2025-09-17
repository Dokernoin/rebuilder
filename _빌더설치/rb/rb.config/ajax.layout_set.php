<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');

if (!defined('_GNUBOARD_')) exit;

$is_index = isset($_POST['is_index']) && $_POST['is_index'] === 'true';

$layouts = array();
if (isset($_POST['layouts']) && is_array($_POST['layouts'])) {
    $layouts = $_POST['layouts'];
}

$layout_name = '';
if (isset($rb_core['layout'])) {
    $layout_name = $rb_core['layout'];
}

$theme_name = '';
if (isset($rb_core['theme'])) {
    $theme_name = $rb_core['theme'];
}

$result_data = array();

foreach ($layouts as $layout_no) {
    $cache_file = G5_DATA_PATH . "/cache/rb_layout_" . $layout_no . ".php";
    $hash_file  = G5_DATA_PATH . "/cache/rb_layout_" . $layout_no . ".hash";

    // checksum using modules + sections
    $layout_sql_mod = "SELECT * FROM rb_module WHERE md_layout = '{$layout_no}' AND md_theme = '{$theme_name}' AND md_layout_name = '{$layout_name}' ORDER BY md_order_id, md_id ASC";
    $layout_sql_sec = "SELECT * FROM rb_section WHERE sec_layout = '{$layout_no}' AND sec_theme = '{$theme_name}' AND sec_layout_name = '{$layout_name}' ORDER BY sec_order_id, sec_id ASC";

    $layout_rows_mod = sql_query($layout_sql_mod);
    $layout_rows_sec = sql_query($layout_sql_sec);

    $layout_structure = '';
    while ($row = sql_fetch_array($layout_rows_mod)) {
        $layout_structure .= 'M:' . implode('|', $row) . ';';
    }
    while ($row = sql_fetch_array($layout_rows_sec)) {
        $layout_structure .= 'S:' . implode('|', $row) . ';';
    }

    $layout_checksum = md5($layout_structure);

    $use_cache = !$is_admin;

    // use cache if checksum matches
    if ($use_cache && file_exists($cache_file) && file_exists($hash_file)) {
        $saved_checksum = file_get_contents($hash_file);
        if ($saved_checksum === $layout_checksum) {
            $result_data[$layout_no] = include $cache_file;
            continue;
        }
    }

    // fetch modules and sections without order in SQL; we will sort in PHP by common order
    $res_mod = sql_query("SELECT * FROM rb_module WHERE md_layout = '{$layout_no}' AND md_theme = '{$theme_name}' AND md_layout_name = '{$layout_name}'");
    $res_sec = sql_query("SELECT * FROM rb_section WHERE sec_layout = '{$layout_no}' AND sec_theme = '{$theme_name}' AND sec_layout_name = '{$layout_name}'");

    // counts for admin message
    $sql_cnts     = sql_fetch("SELECT COUNT(*) as cnt FROM rb_module WHERE md_layout = '{$layout_no}' AND md_theme = '{$theme_name}' AND md_layout_name = '{$layout_name}'");
    $sql_cnts_sec = sql_fetch("SELECT COUNT(*) as cnt FROM rb_section WHERE sec_layout = '{$layout_no}' AND sec_theme = '{$theme_name}' AND sec_layout_name = '{$layout_name}'");

    // build one list with common order
    $items = array();

    while ($r = sql_fetch_array($res_mod)) {
        $items[] = array(
            'type'  => 'mod',
            'order' => (int)$r['md_order_id'],
            'id'    => (int)$r['md_id'],
            'row'   => $r
        );
    }

    while ($r = sql_fetch_array($res_sec)) {
        $items[] = array(
            'type'  => 'sec',
            'order' => (int)$r['sec_order_id'],
            'id'    => (int)$r['sec_id'],
            'row'   => $r
        );
    }

    // sort by common order, then by id for stability
    usort($items, function($a, $b){
        if ($a['order'] === $b['order']) {
            return $a['id'] <=> $b['id'];
        }
        return $a['order'] <=> $b['order'];
    });

    // start output buffer content
    $rb_module_table = "rb_module";
    $output  = "<?php\nob_start();\n\n\$rb_module_table = 'rb_module';\n\$GLOBALS['rb_module_table'] = \$rb_module_table;\n\$is_admin = " . var_export($is_admin, true) . ";\n?>\n";

    // render items in unified order
    foreach ($items as $it) {
        if ($it['type'] === 'mod') {
            $row_mod = $it['row'];
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
              data-order-id="<?php echo $row_mod['md_order_id']; ?>"
              data-id="<?php echo $row_mod['md_id']; ?>"
              data-layout="<?php echo $row_mod['md_layout']; ?>"
              data-sec-key="<?php echo isset($row_mod['md_sec_key']) ? $row_mod['md_sec_key'] : ''; ?>"
              data-sec-uid="<?php echo isset($row_mod['md_sec_uid']) ? $row_mod['md_sec_uid'] : ''; ?>"
              data-title="<?php echo $row_mod['md_title']; ?>"
              data-shop="0"
            >

                <ul class="content_box rb_module_<?php echo $row_mod['md_id']; ?> rb_module_border_<?php echo $row_mod['md_border']; ?> rb_module_radius_<?php echo $row_mod['md_radius']; ?><?php if (isset($row_mod['md_padding']) && $row_mod['md_padding'] > 0) { ?> rb_module_padding_<?php echo $row_mod['md_padding']; ?><?php } ?> <?php echo isset($row_mod['md_show']) ? $row_mod['md_show'] : ''; ?> <?php if (isset($row_mod['md_wide_is']) && $row_mod['md_wide_is'] == 1) { ?>rb_module_wide<?php } ?> <?php if (isset($row_mod['md_wide_is']) && $row_mod['md_wide_is'] == 2) { ?>rb_module_mid<?php } ?>"

                    style="<?php if (isset($row_mod['md_wide_is']) && $row_mod['md_wide_is'] == 1) { ?>
                    min-width:<?php if($is_index) { ?><?php echo $rb_core['main_width'] ?>px<?php } else { ?><?php echo $rb_core['sub_width'] ?>px<?php } ?>;
                    <?php } ?>">



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
                                <a href="javascript:void(0);">
                                    <h2 class="<?php echo isset($row_mod['md_title_font']) ? $row_mod['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($row_mod['md_title_color']) ? $row_mod['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($row_mod['md_title_size']) ? $row_mod['md_title_size'] : '20'; ?>px; "><?php echo $row_mod['md_title'] ?></h2>
                                </a>
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
                                <a href="javascript:void(0);">
                                    <h2 class="<?php echo isset($row_mod['md_title_font']) ? $row_mod['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($row_mod['md_title_color']) ? $row_mod['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($row_mod['md_title_size']) ? $row_mod['md_title_size'] : '20'; ?>px; "><?php echo $row_mod['md_title'] ?></h2>
                                </a>
                            </ul>
                            <ul class="bbs_main_wrap_tit_r"></ul>
                            <div class="cb"></div>
                        </div>
                        <div class="module_poll_wrap">
                            <?php echo '<?php echo poll("' . $row_mod['md_poll'] . '", "' . $row_mod['md_poll_id'] . '"); ?>'; ?>
                        </div>
                    <?php } ?>

                    <?php if ($is_admin) { ?>
                        <span class="admin_ov">
                            <?php if ($is_admin) { ?>
                                <span class="rb-mod-label">모듈 <?php echo $row_mod['md_id']; ?> / <?php echo cut_str($row_mod['md_title'], 15); ?> (<?php echo $row_mod['md_width']; ?><?php echo !empty($row_mod['md_size']) ? $row_mod['md_size'] : '%'; ?>)</span>
                            <?php } ?>
                            <div class="mod_edit">
                                <ul class="middle_y text-center">
                                    <!--
                                    <h2 class="font-B"><?php echo isset($row_mod['md_title']) ? $row_mod['md_title'] : ''; ?> <span>모듈 설정</span></h2>
                                    <h6 class="font-R">해당 모듈의 설정을 변경할 수 있습니다.</h6>
                                    -->
                                    <button type="button" class="btn_round btn_round_bg admin_set_btn" onclick="set_module_send(this);" data-tooltip="모듈설정" data-tooltip-pos="bottom">
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#000' d='M10.586 2.1a2 2 0 0 1 2.7-.116l.128.117L15.314 4H18a2 2 0 0 1 1.994 1.85L20 6v2.686l1.9 1.9a2 2 0 0 1 .116 2.701l-.117.127-1.9 1.9V18a2 2 0 0 1-1.85 1.995L18 20h-2.685l-1.9 1.9a2 2 0 0 1-2.701.116l-.127-.116-1.9-1.9H6a2 2 0 0 1-1.995-1.85L4 18v-2.686l-1.9-1.9a2 2 0 0 1-.116-2.701l.116-.127 1.9-1.9V6a2 2 0 0 1 1.85-1.994L6 4h2.686zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6'/></g></svg>
                                    </button>
                                    <button type="button" class="btn_round admin_set_btn" onclick="set_module_del(this);" data-tooltip="모듈삭제" data-tooltip-pos="bottom">
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#000' d='m12 13.414 5.657 5.657a1 1 0 0 0 1.414-1.414L13.414 12l5.657-5.657a1 1 0 0 0-1.414-1.414L12 10.586 6.343 4.929A1 1 0 0 0 4.93 6.343L10.586 12l-5.657 5.657a1 1 0 1 0 1.414 1.414z'/></g></svg>
                                    </button>
                                </ul>
                            </div>
                        </span>
                    <?php } ?>
                </ul>

                <div class="flex_box_inner flex_box" data-layout="<?php echo $row_mod['md_layout']; ?>-<?php echo $row_mod['md_id']; ?>"></div>
            </div>


            <?php
            $output .= ob_get_clean();

        } else {
            $row_sec = $it['row'];
            ob_start();
            ?>
            <div class="rb_section_box rb_section_<?php echo $row_sec['sec_id']; ?> <?php if (isset($row_sec['sec_width']) && $row_sec['sec_width'] == 1) { ?>rb_sec_wide<?php } ?>"
                 style="

                    <?php if (isset($row_sec['sec_width']) && $row_sec['sec_width'] == 1) { ?>
                    min-width:<?php if($is_index) { ?><?php echo $rb_core['main_width'] ?>px<?php } else { ?><?php echo $rb_core['sub_width'] ?>px<?php } ?>;
                    <?php } ?>

                    background-color:<?php echo !empty($row_sec['sec_bg']) ? $row_sec['sec_bg'] : '#FFFFFF'; ?>;
                    padding:<?php
                        echo IS_MOBILE()
                            ? (!empty($row_sec['sec_padding_mo']) ? $row_sec['sec_padding_mo'] : '0')
                            : (!empty($row_sec['sec_padding_pc']) ? $row_sec['sec_padding_pc'] : '0');
                    ?>px;
                    margin-top:<?php
                          echo IS_MOBILE()
                              ? (!empty($row_sec['sec_margin_top_mo']) ? $row_sec['sec_margin_top_mo'] : '0')
                              : (!empty($row_sec['sec_margin_top_pc']) ? $row_sec['sec_margin_top_pc'] : '0');
                    ?>px;
                      margin-bottom:<?php
                          echo IS_MOBILE()
                              ? (!empty($row_sec['sec_margin_btm_mo']) ? $row_sec['sec_margin_btm_mo'] : '0')
                              : (!empty($row_sec['sec_margin_btm_pc']) ? $row_sec['sec_margin_btm_pc'] : '0');
                    ?>px;
                 "
                 data-order-id="<?php echo $row_sec['sec_order_id']; ?>"
                 data-id="<?php echo $row_sec['sec_id']; ?>"
                 data-title="<?php echo $row_sec['sec_title']; ?>"
                 data-layout="<?php echo $row_sec['sec_layout']; ?>"
                 data-sec-key="<?php echo $row_sec['sec_key']; ?>"
                 data-sec-uid="<?php echo $row_sec['sec_uid']; ?>"
                 data-shop="0"
                 >

                 <?php if ($is_admin) { ?>
                   <span class="rb-sec-label">섹션 <?php echo $row_sec['sec_id']; ?> / <?php echo cut_str($row_sec['sec_title'], 15); ?></span>
                   <?php } ?>


                <div class="rb_section_title">
                    <h2 class="<?php echo !empty($row_sec['sec_title_font']) ? $row_sec['sec_title_font'] : 'font-B'; ?>" style="color:<?php echo !empty($row_sec['sec_title_color']) ? $row_sec['sec_title_color'] : '#25282b'; ?>; font-size:<?php echo !empty($row_sec['sec_title_size']) ? $row_sec['sec_title_size'] : '26'; ?>px; text-align:<?php echo !empty($row_sec['sec_title_align']) ? $row_sec['sec_title_align'] : 'center'; ?>; display:<?php echo (isset($row_sec['sec_title_hide']) && $row_sec['sec_title_hide'] == '1') ? 'none' : 'block'; ?>;"><?php echo $row_sec['sec_title'] ?></h2>
                    <h6 class="<?php echo !empty($row_sec['sec_sub_title_font']) ? $row_sec['sec_sub_title_font'] : 'font-R'; ?>" style="color:<?php echo !empty($row_sec['sec_sub_title_color']) ? $row_sec['sec_sub_title_color'] : '#25282b'; ?>; font-size:<?php echo !empty($row_sec['sec_sub_title_size']) ? $row_sec['sec_sub_title_size'] : '26'; ?>px;  text-align:<?php echo !empty($row_sec['sec_sub_title_align']) ? $row_sec['sec_sub_title_align'] : 'center'; ?>; display:<?php echo (isset($row_sec['sec_sub_title_hide']) && $row_sec['sec_sub_title_hide'] == '1') ? 'none' : 'block'; ?>;"><?php echo nl2br($row_sec['sec_sub_title']); ?></h6>
                </div>



                <div class="flex_box" style="
                   <?php if (isset($row_sec['sec_con_width']) && $row_sec['sec_con_width'] == 1) { ?><?php } else { ?>width: calc(<?php if($is_index) { ?><?php echo $rb_core['main_width'] ?>px<?php } else { ?><?php echo $rb_core['sub_width'] ?>px<?php } ?> + <?php echo $rb_core['gap_pc']*2 ?>px); transform: translateX(0px);<?php } ?>"
                    data-layout="<?php echo $row_sec['sec_layout']; ?>"
                    data-order-id="<?php echo (int)$row_sec['sec_order_id']; ?>"
                    data-sec-key="<?php echo $row_sec['sec_key']; ?>"
                    data-sec-uid="<?php echo $row_sec['sec_uid']; ?>"
                    data-shop="0"
                    >


                    <?php if ($is_admin) { ?>
                      <div class="add_module_wrap add_module_wrap_sec">
                        <button type="button" class="add_module_btns font-B" onclick="set_module_send(this);" data-tooltip="모듈을 추가할 수 있어요" data-tooltip-pos="bottom">모듈추가</button>
                      </div>

                      <div class="add_section_wrap add_section_wrap_sec">
                        <button type="button" class="add_section_btns font-B" onclick="set_section_send(this);" data-tooltip="섹션설정" data-tooltip-pos="bottom">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#FFFFFFFF' d='M10.586 2.1a2 2 0 0 1 2.7-.116l.128.117L15.314 4H18a2 2 0 0 1 1.994 1.85L20 6v2.686l1.9 1.9a2 2 0 0 1 .116 2.701l-.117.127-1.9 1.9V18a2 2 0 0 1-1.85 1.995L18 20h-2.685l-1.9 1.9a2 2 0 0 1-2.701.116l-.127-.116-1.9-1.9H6a2 2 0 0 1-1.995-1.85L4 18v-2.686l-1.9-1.9a2 2 0 0 1-.116-2.701l.116-.127 1.9-1.9V6a2 2 0 0 1 1.85-1.994L6 4h2.686zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6'/></g></svg>
                        </button>
                        <button type="button" class="del_section_btns font-B" onclick="set_section_del(this);" data-tooltip="섹션삭제" data-tooltip-pos="bottom">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#FFFFFFFF' d='m12 13.414 5.657 5.657a1 1 0 0 0 1.414-1.414L13.414 12l5.657-5.657a1 1 0 0 0-1.414-1.414L12 10.586 6.343 4.929A1 1 0 0 0 4.93 6.343L10.586 12l-5.657 5.657a1 1 0 1 0 1.414 1.414z'/></g></svg>
                        </button>
                      </div>
                    <?php } ?>

                </div>
            </div>


            <?php
            $output .= ob_get_clean();
        }
    }

    // admin extra blocks
    if ($is_admin) {
        if (!isset($sql_cnts['cnt']) || !$sql_cnts['cnt']) {
            $output .= '<div class="no_data_section add_module_wrap"><ul><img src="'.G5_THEME_URL.'/rb.img/icon/icon_error.svg" style="width:50px;"></ul><ul class="no_data_section_ul1 font-B">추가된 모듈이 없습니다.</ul><ul class="no_data_section_ul2">모듈추가 버튼을 클릭해주세요.<br>모듈은 계속 추가할 수 있습니다.</ul></div>';
        }
        $output .= '<div class="add_module_wrap adm_co_gap_pc_' . $rb_core['gap_pc'] . '"><button type="button" class="add_module_btns font-B" onclick="set_module_send(this);" data-tooltip="자유롭게 이동이 가능한 모듈을 추가할 수 있어요." data-tooltip-pos="bottom">모듈추가</button></div>';

        $output .= '<div class="add_section_wrap adm_co_gap_pc_' . $rb_core['gap_pc'] . '"><button type="button" class="add_section_btns font-B" onclick="set_section_send(this);" data-tooltip="가로 100% 섹션을 추가할 수 있어요. 섹션 내부에는 모듈을 추가할 수 있어요." data-tooltip-pos="bottom">섹션추가</button></div>';

    }

    // finalize buffer return
    $output .= "<?php\nreturn ob_get_clean();\n?>";

    if ($use_cache) {
        file_put_contents($cache_file, $output);
        file_put_contents($hash_file, $layout_checksum);
    }

    // evaluate and store result
    $result_data[$layout_no] = eval('?>' . $output);
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result_data);
?>
