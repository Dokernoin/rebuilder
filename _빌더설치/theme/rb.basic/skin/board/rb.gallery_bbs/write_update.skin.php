<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
    @include_once(G5_PATH.'/rb/rb.lib/ajax.upload_write_update.php'); // 파일첨부를 끌어오기 형태로 업로드 하는 경우만 추가해주세요.

    if($w == "") {
        //관리자에게 쪽지발송
        memo_auto_send($board['bo_subject'].'에 새글이 등록 되었습니다.', G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id, $config['cf_admin'], "system-msg");
    }
?> 
