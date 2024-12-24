<?php
include_once('../_common.php');

$act = isset($_POST['act']) ? $_POST['act'] : '';

if ($act == 'alarm') {
    $result = array();
    $row = sql_fetch("SELECT * FROM {$g5['memo_table']} WHERE me_recv_mb_id = '{$member['mb_id']}' AND me_send_datetime >= NOW() - INTERVAL 2 DAY AND me_read_datetime = '0000-00-00 00:00:00' ORDER BY me_id DESC LIMIT 1");

    if ($row) {
        $result['content'] = isset($row['me_memo']) ? $row['me_memo'] : '';
        $result['msg'] = 'SUCCESS';
        $result['me_id'] = isset($row['me_id']) ? $row['me_id'] : '';
        //$result['sound'] = 'N';
        $mb = get_member($row['me_send_mb_id'], 'mb_name');
        $result['title'] = isset($mb['mb_name']) ? $mb['mb_name'] : '';
        $result['me_send_datetime'] = isset($row['me_send_datetime']) ? $row['me_send_datetime'] : '';
        $result['url'] = G5_URL . '/bbs/memo.php';
    } else {
        $result['msg'] = 'NOMSG';
        $result['me_id'] = '';       
    }
    echo json_encode($result);
}

if ($act == 'recv_memo') {
    $result = array(); 

    $me_id = isset($_POST['me_id']) ? $_POST['me_id'] : '';

    $sql = "UPDATE {$g5['memo_table']}
            SET me_read_datetime = '".G5_TIME_YMDHIS."'
            WHERE me_id = '$me_id'
            AND me_read_datetime = '0000-00-00 00:00:00'";
    sql_query($sql);

    $sql = "UPDATE `{$g5['member_table']}` SET mb_memo_cnt = '".get_memo_not_read($member['mb_id'])."' WHERE mb_id = '{$member['mb_id']}'";
    sql_query($sql);

    $result['msg'] = 'SUCCESS';

    echo json_encode($result); 
}