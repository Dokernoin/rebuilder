<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$mb_id = isset($mb['mb_id']) ? $mb['mb_id'] : '';
$mb_nick = isset($mb['mb_nick']) ? $mb['mb_nick'] : '';
$mb_email = isset($mb['mb_email']) ? $mb['mb_email'] : '';
$mb_homepage = isset($mb['mb_homepage']) ? $mb['mb_homepage'] : '';

$nick = get_sideview($mb_id, $mb_nick, $mb_email, $mb_homepage);

if($kind == "recv") {
    $kind_str = "보낸";
    $kind_date = "받은";
}
else {
    $kind_str = "받는";
    $kind_date = "보낸";
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지보기 시작 { -->
<div id="memo_view" class="new_win">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>
    <div class="new_win_con2">
        <!-- 쪽지함 선택 시작 { -->
        <ul class="win_ul">
            <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li><a href="./memo_form.php">쪽지쓰기</a></li>
        </ul>
        <!-- } 쪽지함 선택 끝 -->

        <article id="memo_view_contents">
            <header>
                <h2>쪽지 내용</h2>
            </header>
            <div id="memo_view_ul">
                <div class="memo_view_li memo_view_name">
                	<ul class="memo_from">
                	    <?php if($memo['me_send_mb_id'] != "system-msg") { ?>
                		<li class="memo_profile">
				            <?php echo get_member_profile_img($mb['mb_id']); ?>
				        </li>
				        <?php } ?>
						<li class="memo_view_nick"><?php echo $nick ?></li>
						<li class="memo_view_date"><span class="sound_only"><?php echo $kind_date ?>시간</span><?php if($memo['me_send_mb_id'] == "system-msg") { ?>시스템메세지　<?php } ?><?php echo $memo['me_send_datetime'] ?></li> 
						<li class="memo_op_btn list_btn" <?php if($memo['me_send_mb_id'] == "system-msg") { ?>style="top:10px;"<?php } ?>><a href="<?php echo $list_link ?>" class="btn_b01 btn"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_back.svg"><span class="sound_only">목록</span></a></li>
						<li class="memo_op_btn del_btn" <?php if($memo['me_send_mb_id'] == "system-msg") { ?>style="top:10px;"<?php } ?>><a href="<?php echo $del_link; ?>" onclick="del(this.href); return false;" class="memo_del btn_b01 btn"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_del.svg"> <span class="sound_only">삭제</span></a></li>
					</ul>
                   <!--
                    <div class="memo_btn">
                    	<?php if($prev_link) {  ?>
			            <a href="<?php echo $prev_link ?>" class="btn_left"><i class="fa fa-chevron-left" aria-hidden="true"></i> 이전쪽지</a>
			            <?php }  ?>
			            <?php if($next_link) {  ?>
			            <a href="<?php echo $next_link ?>" class="btn_right">다음쪽지 <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
			            <?php }  ?>  
                    </div>
                    -->
                </div>
            </div>
            <p>
                <?php echo conv_content($memo['me_memo'], 0) ?>
            </p>
        </article>
		<div class="win_btn">
		    <?php if($memo['me_send_mb_id'] != "system-msg") { ?>
			<?php if ($kind == 'recv') {  ?><a href="./memo_form.php?me_recv_mb_id=<?php echo $mb['mb_id'] ?>&amp;me_id=<?php echo $memo['me_id'] ?>" class="reply_btn">답장</a><?php }  ?>
			<?php } ?>
			<button type="button" onclick="window.close();" class="btn_close">창닫기</button>
    	</div>
    </div>
</div>
<!-- } 쪽지보기 끝 -->
