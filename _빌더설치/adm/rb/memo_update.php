<?php
$sub_menu = '000630';
include_once('./_common.php');

check_demo();
check_admin_token();

$sql_common = " FROM {$g5['member_table']}";
$sql_where = " WHERE (1) AND mb_id NOT IN ('{$config['cf_admin']}') ";

for ($i = 0; $i < count($_POST['mb_level']); $i++) {
    
    $sql = "SELECT * {$sql_common} {$sql_where} AND mb_level = '".sql_escape_string($_POST['mb_level'][$i])."'";
    $sql_cnt = sql_fetch ("SELECT COUNT(*) as cnt {$sql_common} {$sql_where} AND mb_level = '".sql_escape_string($_POST['mb_level'][$i])."'");
    $result = sql_query($sql);
    
    if (isset($sql_cnt['cnt']) && $sql_cnt['cnt'] > 0) {
    
        while ($row = sql_fetch_array($result)) {
            if (!$row['mb_leave_date']) {

                $rows_me = sql_fetch("SELECT MAX(me_id) AS new_me_id FROM {$g5['memo_table']}");
                $me_id = $rows_me['new_me_id'] + 1;

                $send_id = 'system-msg'; // 발송할 아이디
                $memo_content = sql_escape_string($_POST['me_memo']);
                $from_id = $row['mb_id'];

                $sql_m1 = "INSERT INTO {$g5['memo_table']} SET me_id='$me_id', me_recv_mb_id='$from_id', me_send_mb_id='$send_id', me_type='recv', me_send_datetime='".G5_TIME_YMDHIS."', me_memo='$memo_content'";
                sql_query($sql_m1);

                $sql_m2 = "UPDATE {$g5['member_table']} SET mb_memo_call='$send_id', mb_memo_cnt='".get_memo_not_read($from_id)."' WHERE mb_id='$from_id'";
                sql_query($sql_m2);

            }
        }
        
        alert('시스템메세지를 발송했습니다.');
        
    } else { 
        alert('시스템메세지를 발송할 회원이 없습니다.');
    }
}


?>
