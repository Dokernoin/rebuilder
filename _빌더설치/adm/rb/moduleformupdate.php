<?php
$sub_menu = '000200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "d");

check_admin_token();

$md_id = isset($_REQUEST['md_id']) ? preg_replace('/[^0-9a-z]/i', '', $_REQUEST['md_id']) : '';
$table_name = (isset($_REQUEST['tables']) && $_REQUEST['tables']) ? $_REQUEST['tables'] : 'rb_module';

if( ! $md_id ){
    alert('모듈 ID가 없습니다.');
}

if ($w == 'd' && $is_admin != 'super')
    alert("최고관리자만 삭제할 수 있습니다.");

if ($w == "d")
{
    // 삭제
    $sql = " delete from {$table_name} where md_id = '$md_id' ";
    sql_query($sql);

}

goto_url("./module_list.php?tables=$table_name&amp;$qstr");