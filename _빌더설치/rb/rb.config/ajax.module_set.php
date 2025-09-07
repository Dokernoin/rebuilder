<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

$md_id = isset($_POST['md_id']) ? $_POST['md_id'] : '';
$md_title = isset($_POST['md_title']) ? $_POST['md_title'] : '';
$md_title_color = isset($_POST['md_title_color']) ? $_POST['md_title_color'] : '#25282b';
$md_title_size = isset($_POST['md_title_size']) ? $_POST['md_title_size'] : '20';
$md_title_font = isset($_POST['md_title_font']) ? $_POST['md_title_font'] : 'font-B';
$md_title_hide = isset($_POST['md_title_hide']) ? $_POST['md_title_hide'] : '0';
$md_layout = isset($_POST['md_layout']) ? $_POST['md_layout'] : '';
$md_skin = isset($_POST['md_skin']) ? $_POST['md_skin'] : '';
$md_tab_list = isset($_POST['md_tab_list']) ? $_POST['md_tab_list'] : '';
$md_tab_skin = isset($_POST['md_tab_skin']) ? $_POST['md_tab_skin'] : '';
$md_item_tab_list = isset($_POST['md_item_tab_list']) ? $_POST['md_item_tab_list'] : '';
$md_item_tab_skin = isset($_POST['md_item_tab_skin']) ? $_POST['md_item_tab_skin'] : '';
$md_type = isset($_POST['md_type']) ? $_POST['md_type'] : '';
$md_bo_table = isset($_POST['md_bo_table']) ? $_POST['md_bo_table'] : '';
$md_sca = isset($_POST['md_sca']) ? $_POST['md_sca'] : '';
$md_widget = isset($_POST['md_widget']) ? $_POST['md_widget'] : '';
$md_banner = isset($_POST['md_banner']) ? $_POST['md_banner'] : '';
$md_banner_id = isset($_POST['md_banner_id']) ? $_POST['md_banner_id'] : '';
$md_banner_bg = isset($_POST['md_banner_bg']) ? $_POST['md_banner_bg'] : '';
$md_banner_skin = isset($_POST['md_banner_skin']) ? $_POST['md_banner_skin'] : '';
$md_poll = isset($_POST['md_poll']) ? $_POST['md_poll'] : '';
$md_poll_id = isset($_POST['md_poll_id']) ? $_POST['md_poll_id'] : '';
$md_theme = isset($_POST['md_theme']) ? $_POST['md_theme'] : '';
$md_sec_key = isset($_POST['md_sec_key']) ? $_POST['md_sec_key'] : '';
$md_sec_uid = isset($_POST['md_sec_uid']) ? $_POST['md_sec_uid'] : '';
$md_layout_name = isset($_POST['md_layout_name']) ? $_POST['md_layout_name'] : '';
$md_cnt = isset($_POST['md_cnt']) ? $_POST['md_cnt'] : '1';
$md_notice = isset($_POST['md_notice']) ? $_POST['md_notice'] : '0';
$md_wide_is = isset($_POST['md_wide_is']) ? $_POST['md_wide_is'] : '0';
$md_arrow_type = isset($_POST['md_arrow_type']) ? $_POST['md_arrow_type'] : '0';
$md_col = isset($_POST['md_col']) ? $_POST['md_col'] : '1';
$md_row = isset($_POST['md_row']) ? $_POST['md_row'] : '1';
$md_col_mo = isset($_POST['md_col_mo']) ? $_POST['md_col_mo'] : '1';
$md_row_mo = isset($_POST['md_row_mo']) ? $_POST['md_row_mo'] : '1';
$md_width = isset($_POST['md_width']) ? $_POST['md_width'] : '100%';
$md_height = isset($_POST['md_height']) ? $_POST['md_height'] : '';
$md_show = isset($_POST['md_show']) ? $_POST['md_show'] : '';
$md_size = isset($_POST['md_size']) ? $_POST['md_size'] : '%';
$md_subject_is = isset($_POST['md_subject_is']) ? $_POST['md_subject_is'] : '';
$md_thumb_is = isset($_POST['md_thumb_is']) ? $_POST['md_thumb_is'] : '';
$md_nick_is = isset($_POST['md_nick_is']) ? $_POST['md_nick_is'] : '';
$md_date_is = isset($_POST['md_date_is']) ? $_POST['md_date_is'] : '';
$md_comment_is = isset($_POST['md_comment_is']) ? $_POST['md_comment_is'] : '';
$md_content_is = isset($_POST['md_content_is']) ? $_POST['md_content_is'] : '';
$md_icon_is = isset($_POST['md_icon_is']) ? $_POST['md_icon_is'] : '';
$md_ca_is = isset($_POST['md_ca_is']) ? $_POST['md_ca_is'] : '';
$md_gap = isset($_POST['md_gap']) ? $_POST['md_gap'] : '40';
$md_gap_mo = isset($_POST['md_gap_mo']) ? $_POST['md_gap_mo'] : '20';
$md_swiper_is = isset($_POST['md_swiper_is']) ? $_POST['md_swiper_is'] : '';
$md_auto_is = isset($_POST['md_auto_is']) ? $_POST['md_auto_is'] : '';
$md_auto_time = isset($_POST['md_auto_time']) ? $_POST['md_auto_time'] : '';
$md_module = isset($_POST['md_module']) ? $_POST['md_module'] : '';
$md_soldout_hidden = isset($_POST['md_soldout_hidden']) ? $_POST['md_soldout_hidden'] : '';
$md_soldout_asc = isset($_POST['md_soldout_asc']) ? $_POST['md_soldout_asc'] : '';
$md_order = isset($_POST['md_order']) ? $_POST['md_order'] : '';
$md_order_latest = isset($_POST['md_order_latest']) ? $_POST['md_order_latest'] : '';
$md_order_banner = isset($_POST['md_order_banner']) ? $_POST['md_order_banner'] : '';
$md_border = isset($_POST['md_border']) ? $_POST['md_border'] : '';
$md_radius = isset($_POST['md_radius']) ? $_POST['md_radius'] : '0';
$md_padding = isset($_POST['md_padding']) ? $_POST['md_padding'] : '0';
$md_margin_top_pc = isset($_POST['md_margin_top_pc']) ? $_POST['md_margin_top_pc'] : '';
$md_margin_top_mo = isset($_POST['md_margin_top_mo']) ? $_POST['md_margin_top_mo'] : '';
$md_margin_btm_pc = isset($_POST['md_margin_btm_pc']) ? $_POST['md_margin_btm_pc'] : '';
$md_margin_btm_mo = isset($_POST['md_margin_btm_mo']) ? $_POST['md_margin_btm_mo'] : '';
$del = isset($_POST['del']) ? $_POST['del'] : '';
$is_shop = isset($_POST['is_shop']) ? $_POST['is_shop'] : '';

if(isset($is_shop) && $is_shop == 1) {
    $rb_module_tables = "rb_module_shop";
} else { 
    $rb_module_tables = "rb_module";
}

?>


    <?php
        if(isset($del) && $del == "true") { 
            
            if($is_admin) {
                $sql = " delete from {$rb_module_tables} where md_id = '{$md_id}' and md_layout = '{$md_layout}' and md_theme = '{$md_theme}' and md_layout_name = '{$md_layout_name}' ";
                sql_query($sql);
            }
            $data = array(
                'status' => 'ok',
            );
            echo json_encode($data);
            
            
        } else {
            if(isset($md_id) && $md_id == "new") {
                
                // rb_module 테이블에 md_sca 컬럼이 있는지 검사
                $checkColumnQuery = "SHOW COLUMNS FROM `rb_module` LIKE 'md_sca'";
                $result = sql_query($checkColumnQuery);
                
                if (sql_num_rows($result) == 0) {
                    // md_sca 컬럼이 없으면 추가
                    $addColumnQuery = "ALTER TABLE {$rb_module_tables} ADD `md_sca` varchar(255) COLLATE 'utf8_general_ci' NOT NULL AFTER `md_bo_table`";
                    sql_query($addColumnQuery);
                }
                
                // rb_module 테이블에 md_order_id 컬럼이 있는지 검사
                $checkColumnQuery2 = "SHOW COLUMNS FROM {$rb_module_tables} LIKE 'md_order_id'";
                $result2 = sql_query($checkColumnQuery2);
                
                if (sql_num_rows($result2) == 0) {
                    // md_order_id 컬럼이 없으면 추가
                    $addColumnQuery2 = "ALTER TABLE {$rb_module_tables} ADD `md_order_id` INT(4) COLLATE 'utf8_general_ci' NOT NULL AFTER `md_ip`";
                    sql_query($addColumnQuery2);
                }


                if($is_admin) {
  
                //컬럼의 가장 큰 숫자를 얻는다
                $mod_num = sql_fetch( " SELECT MAX(md_order_id) AS max_value FROM {$rb_module_tables} " );
                $md_order_id = isset($mod_num['max_value']) ? $mod_num['max_value'] + 1 : '0';
                    
                $sql = " insert {$rb_module_tables} set 
                md_title = '{$md_title}', 
                md_title_color = '{$md_title_color}',
                md_title_size = '{$md_title_size}',
                md_title_font = '{$md_title_font}',
                md_title_hide = '{$md_title_hide}',
                md_layout = '{$md_layout}',
                md_skin = '{$md_skin}', 
                md_tab_skin = '{$md_tab_skin}',
                md_tab_list = '{$md_tab_list}',
                md_item_tab_skin = '{$md_item_tab_skin}',
                md_item_tab_list = '{$md_item_tab_list}',
                md_type = '{$md_type}', 
                md_bo_table = '{$md_bo_table}', 
                md_sca = '{$md_sca}',
                md_widget = '{$md_widget}',
                md_banner = '{$md_banner}',
                md_banner_id = '{$md_banner_id}',
                md_banner_bg = '{$md_banner_bg}',
                md_banner_skin = '{$md_banner_skin}',
                md_poll = '{$md_poll}',
                md_poll_id = '{$md_poll_id}',
                md_theme = '{$md_theme}', 
                md_sec_key = '{$md_sec_key}',
                md_sec_uid = '{$md_sec_uid}',
                md_layout_name = '{$md_layout_name}', 
                md_cnt = '{$md_cnt}', 
                md_notice = '{$md_notice}',
                md_wide_is = '{$md_wide_is}',
                md_arrow_type = '{$md_arrow_type}',
                md_col = '{$md_col}', 
                md_row = '{$md_row}', 
                md_col_mo = '{$md_col_mo}', 
                md_row_mo = '{$md_row_mo}', 
                md_width = '{$md_width}', 
                md_height = '{$md_height}', 
                md_show = '{$md_show}',
                md_size = '{$md_size}',
                md_subject_is = '{$md_subject_is}', 
                md_thumb_is = '{$md_thumb_is}', 
                md_nick_is = '{$md_nick_is}', 
                md_date_is = '{$md_date_is}', 
                md_comment_is = '{$md_comment_is}', 
                md_content_is = '{$md_content_is}',
                md_icon_is = '{$md_icon_is}', 
                md_ca_is = '{$md_ca_is}', 
                md_gap = '{$md_gap}', 
                md_gap_mo = '{$md_gap_mo}', 
                md_swiper_is = '{$md_swiper_is}', 
                md_auto_is = '{$md_auto_is}', 
                md_auto_time = '{$md_auto_time}', 
                md_module = '{$md_module}', 
                md_soldout_hidden = '{$md_soldout_hidden}',
                md_soldout_asc = '{$md_soldout_asc}',
                md_order = '{$md_order}',
                md_order_latest = '{$md_order_latest}',
                md_order_banner = '{$md_order_banner}',
                md_border = '{$md_border}', 
                md_radius = '{$md_radius}', 
                md_padding = '{$md_padding}',
                md_margin_top_pc = '{$md_margin_top_pc}',
                md_margin_top_mo = '{$md_margin_top_mo}',
                md_margin_btm_pc = '{$md_margin_btm_pc}',
                md_margin_btm_mo = '{$md_margin_btm_mo}',
                md_datetime = '".G5_TIME_YMDHIS."', 
                md_ip = '{$_SERVER['REMOTE_ADDR']}',
                md_order_id = '{$md_order_id}' ";
                sql_query($sql);
                }

                $data = array(
                    'md_title' => $md_title,
                    'status' => 'ok',
                );
                echo json_encode($data);

            } else { 

                if($is_admin) {
                $sql = " update {$rb_module_tables} 
                set md_title = '{$md_title}', 
                md_title_color = '{$md_title_color}',
                md_title_size = '{$md_title_size}',
                md_title_font = '{$md_title_font}',
                md_title_hide = '{$md_title_hide}',
                md_layout = '{$md_layout}', 
                md_skin = '{$md_skin}', 
                md_tab_skin = '{$md_tab_skin}',
                md_tab_list = '{$md_tab_list}',
                md_item_tab_skin = '{$md_item_tab_skin}',
                md_item_tab_list = '{$md_item_tab_list}',
                md_type = '{$md_type}', 
                md_bo_table = '{$md_bo_table}', 
                md_sca = '{$md_sca}', 
                md_widget = '{$md_widget}', 
                md_banner = '{$md_banner}',
                md_banner_id = '{$md_banner_id}',
                md_banner_bg = '{$md_banner_bg}',
                md_banner_skin = '{$md_banner_skin}',
                md_poll = '{$md_poll}', 
                md_poll_id = '{$md_poll_id}',
                md_theme = '{$md_theme}', 
                md_sec_key = '{$md_sec_key}',
                md_sec_uid = '{$md_sec_uid}',
                md_layout_name = '{$md_layout_name}', 
                md_cnt = '{$md_cnt}', 
                md_notice = '{$md_notice}',
                md_wide_is = '{$md_wide_is}',
                md_arrow_type = '{$md_arrow_type}',
                md_col = '{$md_col}', 
                md_row = '{$md_row}', 
                md_col_mo = '{$md_col_mo}', 
                md_row_mo = '{$md_row_mo}', 
                md_width = '{$md_width}', 
                md_height = '{$md_height}',
                md_show = '{$md_show}',
                md_size = '{$md_size}',
                md_subject_is = '{$md_subject_is}', 
                md_thumb_is = '{$md_thumb_is}', 
                md_nick_is = '{$md_nick_is}', 
                md_date_is = '{$md_date_is}', 
                md_comment_is = '{$md_comment_is}', 
                md_content_is = '{$md_content_is}', 
                md_icon_is = '{$md_icon_is}', 
                md_ca_is = '{$md_ca_is}', 
                md_gap = '{$md_gap}', 
                md_gap_mo = '{$md_gap_mo}', 
                md_swiper_is = '{$md_swiper_is}', 
                md_auto_is = '{$md_auto_is}', 
                md_auto_time = '{$md_auto_time}',
                md_module = '{$md_module}', 
                md_soldout_hidden = '{$md_soldout_hidden}',
                md_soldout_asc = '{$md_soldout_asc}',
                md_order = '{$md_order}', 
                md_order_latest = '{$md_order_latest}',
                md_order_banner = '{$md_order_banner}',
                md_border = '{$md_border}', 
                md_radius = '{$md_radius}',
                md_padding = '{$md_padding}',
                md_margin_top_pc = '{$md_margin_top_pc}',
                md_margin_top_mo = '{$md_margin_top_mo}',
                md_margin_btm_pc = '{$md_margin_btm_pc}',
                md_margin_btm_mo = '{$md_margin_btm_mo}',
                md_datetime = '".G5_TIME_YMDHIS."', 
                md_ip = '{$_SERVER['REMOTE_ADDR']}' 
                where md_id = '{$md_id}'";
                sql_query($sql);
                }

                $data = array(
                    'md_title' => $md_title,
                    'status' => 'ok',
                );
                echo json_encode($data);


            }
        }
    ?>

