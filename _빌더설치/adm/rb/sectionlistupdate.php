<?php
$sub_menu = '000210';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$post_sec_id_count = (isset($_POST['sec_id']) && is_array($_POST['sec_id'])) ? count($_POST['sec_id']) : 0;
$table_name = (isset($_POST['tables']) && $_POST['tables']) ? $_POST['tables'] : 'rb_section';

for ($i=0; $i<$post_sec_id_count; $i++)
{


    $p_sec_title = is_array($_POST['sec_title']) ? strip_tags(clean_xss_attributes($_POST['sec_title'][$i])) : '';


    $posts = array();

    $check_keys = array('sec_id', 'sec_theme', 'sec_layout_name', 'sec_layout',);

    foreach($check_keys as $key){
        $posts[$key] = (isset($_POST[$key]) && isset($_POST[$key][$i])) ? $_POST[$key][$i] : '';
    }

    $sql = " update {$table_name}
                set sec_title             = '".$p_sec_title."',
                    sec_theme              = '".sql_real_escape_string(strip_tags($posts['sec_theme']))."',
                    sec_layout_name         = '".sql_real_escape_string(strip_tags($posts['sec_layout_name']))."',
                    sec_layout         = '".sql_real_escape_string(strip_tags($posts['sec_layout']))."'
              where sec_id = '".sql_real_escape_string($posts['sec_id'])."' ";

    sql_query($sql);

}

goto_url("./section_list.php?tables=$table_name&amp;$qstr");
