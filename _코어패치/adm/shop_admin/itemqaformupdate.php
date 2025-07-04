<?php
$sub_menu = '400660';
include_once('./_common.php');

check_demo();

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

if ($w == "u")
{
    $sql = "update {$g5['g5_shop_item_qa_table']}
               set iq_subject = '$iq_subject',
                   iq_question = '$iq_question',
                   iq_answer = '$iq_answer'
             where iq_id = '$iq_id' ";
    sql_query($sql);
    run_event('shop_admin_item_qa_updated', $iq_id);

    if(trim($iq_answer)) {
        $sql = " select a.iq_email, a.iq_hp, a.mb_id, b.it_name, b.it_id
                    from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
                    where a.iq_id = '$iq_id' ";
        $row = sql_fetch($sql);

        // SMS 알림
        if($config['cf_sms_use'] == 'icode' && $row['iq_hp']) {
            $sms_content = get_text($row['it_name']).' 상품문의에 답변이 등록되었습니다.';
            $send_number = preg_replace('/[^0-9]/', '', $default['de_admin_company_tel']);
            $recv_number = preg_replace('/[^0-9]/', '', $row['iq_hp']);

            if($recv_number) {
                if($config['cf_sms_type'] == 'LMS') {
                    include_once(G5_LIB_PATH.'/icode.lms.lib.php');

                    $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

                    // SMS 모듈 클래스 생성
                    if($port_setting !== false) {
                        $SMS = new LMS;
                        $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

                        $strDest     = array();
                        $strDest[]   = $recv_number;
                        $strCallBack = $send_number;
                        $strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
                        $strSubject  = '';
                        $strURL      = '';
                        $strData     = iconv_euckr($sms_content);
                        $strDate     = '';
                        $nCount      = count($strDest);

                        $res = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

                        $SMS->Send();
                        $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
                    }
                } else {
                    include_once(G5_LIB_PATH.'/icode.sms.lib.php');

                    $SMS = new SMS; // SMS 연결
                    $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
                    $SMS->Add($recv_number, $send_number, $config['cf_icode_id'], iconv_euckr(stripslashes($sms_content)), "");
                    $SMS->Send();
                }
            }
        }

        // 답변 이메일전송
        if(trim($row['iq_email'])) {
            include_once(G5_LIB_PATH.'/mailer.lib.php');

            $subject = $config['cf_title'].' '.$row['it_name'].' 상품문의 답변 알림 메일';
            $content = conv_content($iq_answer, 1);

            mailer($config['cf_title'], $config['cf_admin_email'], $row['iq_email'], $subject, $content, 1);
        }

        if($row['mb_id']) {

            $od_al = "[".$row['it_name']."] 상품 문의에 답변이 등록 되었습니다.";
            memo_auto_send($od_al, shop_item_url($row['it_id']), $row['mb_id'], "system-msg");

        }
    }

    goto_url("./itemqaform.php?w=$w&amp;iq_id=$iq_id&amp;sca=$sca&amp;$qstr");
}
else {
    alert();
}
