<?php
$sub_menu = '000200';
include_once('./_common.php');

check_demo();

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$post_md_id_count = (isset($_POST['md_id']) && is_array($_POST['md_id'])) ? count($_POST['md_id']) : 0;
$table_name = (isset($_POST['tables']) && $_POST['tables']) ? $_POST['tables'] : 'rb_module';

for ($i=0; $i<$post_md_id_count; $i++)
{

    
    $p_md_title = is_array($_POST['md_title']) ? strip_tags(clean_xss_attributes($_POST['md_title'][$i])) : '';

    
    $posts = array();

    $check_keys = array('md_id', 'md_theme', 'md_layout_name', 'md_layout',);

    foreach($check_keys as $key){
        $posts[$key] = (isset($_POST[$key]) && isset($_POST[$key][$i])) ? $_POST[$key][$i] : '';
    }
    
    $sql = " update {$table_name} 
                set md_title             = '".$p_md_title."',
                    md_theme              = '".sql_real_escape_string(strip_tags($posts['md_theme']))."',
                    md_layout_name         = '".sql_real_escape_string(strip_tags($posts['md_layout_name']))."',
                    md_layout         = '".sql_real_escape_string(strip_tags($posts['md_layout']))."' 
              where md_id = '".sql_real_escape_string($posts['md_id'])."' ";

    sql_query($sql);

}

goto_url("./module_list.php?tables=$table_name&amp;$qstr");