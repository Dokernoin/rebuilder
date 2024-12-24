<?php
$sub_menu = '000400';
include_once('./_common.php');

check_demo();

check_admin_token();

$count_post_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
$bo_table = $_POST['bo_table'];
$write_table = $g5['write_prefix'] . $bo_table;

if (! $count_post_chk) {
    alert($_POST['act_button']." 하실 항목을 하나 이상 체크하세요.");
}

if ($_POST['act_button'] == "선택삭제") {

    auth_check_menu($auth, $sub_menu, 'd');

    for ($i=0; $i<$count_post_chk; $i++) {
        // 실제 번호를 넘김
        $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;
        $iwr_id = isset($_POST['wr_id'][$i]) ? (int) $_POST['wr_id'][$k] : 0;

        // 게시글과 댓글 삭제
        sql_query(" delete from {$write_table} where wr_parent = '{$iwr_id}' ");

        // 최근게시물 삭제
        sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$bo_table}' and wr_parent = '{$iwr_id}' ");

        // 스크랩 삭제
        sql_query(" delete from {$g5['scrap_table']} where bo_table = '{$bo_table}' and wr_id = '{$iwr_id}' ");
        
    }
}

goto_url("./bbs_list.php?sca=$sca&amp;sst=$sst&amp;sod=$sod&amp;sfl=$sfl&amp;stx=$stx&amp;page=$page&amp;bo_table=$bo_table");