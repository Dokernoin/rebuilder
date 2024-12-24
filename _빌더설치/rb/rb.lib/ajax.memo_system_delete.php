<?php
include_once('../../common.php');

if (!$is_member)
    alert('회원만 이용하실 수 있습니다.');

$sql = " delete from {$g5['memo_table']} where me_send_mb_id = 'system-msg' and me_recv_mb_id = '{$member['mb_id']}' ";
sql_query($sql);

$sql = " update `{$g5['member_table']}` set mb_memo_cnt = '".get_memo_not_read($member['mb_id'])."' where mb_id = '{$member['mb_id']}' ";
sql_query($sql);
