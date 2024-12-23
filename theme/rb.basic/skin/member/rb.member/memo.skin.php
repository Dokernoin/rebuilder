<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 쪽지 목록 시작 { -->
<div id="memo_list" class="new_win">
    <h1 id="win_title">
    	<?php echo $g5['title'] ?>
    	<div class="win_total">전체 <?php echo $kind_title ?>쪽지 <?php echo $total_count ?>통<br></div>
    </h1>
    <div class="new_win_con2">
        <ul class="win_ul">
            <li class="<?php if ($kind == 'recv') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=recv">받은쪽지</a></li>
            <li class="<?php if ($kind == 'send') {  ?>selected<?php }  ?>"><a href="./memo.php?kind=send">보낸쪽지</a></li>
            <li><a href="./memo_form.php">쪽지쓰기</a></li>

            <li class="selected system_del_btn"><a href="javascript:void(0);" id="system_del">시스템메세지 삭제</a></li>

            <script>
                document.getElementById('system_del').addEventListener('click', function() {
                    var userConfirmed = confirm('시스템메세지를 일괄 삭제 합니다. 사용자에게 받은 쪽지는 삭제되지 않습니다.\n시스템메세지를 일괄 삭제 하시겠습니까?');

                    if (userConfirmed) {
                       $.ajax({
                            url: '<?php echo G5_URL ?>/rb/rb.lib/ajax.memo_system_delete.php',
                            method: 'POST',
                            //data: { order: orderData, mod_type: "mod_order" },
                            success: function(response) {
                                location.reload();
                            },
                            error: function(xhr, status, error) {
                                alert('삭제처리에 문제가 있습니다. 관리자에게 문의해주세요.');
                            }
                        });
                    } else {

                    }
                });
            </script>
            <div class="cb"></div>
        </ul>

        <div class="memo_list">
            <ul>
	            <?php
                for ($i=0; $i<count($list); $i++) {
                $readed = (substr($list[$i]['me_read_datetime'],0,1) == 0) ? '' : 'read';
                $memo_preview = utf8_strcut(strip_tags($list[$i]['me_memo']), 30, '..');
                ?>
	            <li class="<?php echo $readed; ?>">
	            	<div class="memo_li profile_big_img">
	            	    <?php if($list[$i]['mb_id'] != "system-msg") { ?>
	            		<?php echo get_member_profile_img($list[$i]['mb_id']); ?>
	            		<?php if (! $readed){ ?><span class="no_read">안 읽은 쪽지</span><?php } ?>
	            		<?php } ?>
	            	</div>
	                <div class="memo_li memo_name" <?php if($list[$i]['mb_id'] == "system-msg") { ?>style="padding-top:0px !important;"<?php } ?>>
	                   <?php if($list[$i]['mb_id'] != "system-msg") { ?><?php echo $list[$i]['name']; ?> <?php } ?>
	                   <span class="memo_datetime"><?php if($list[$i]['mb_id'] == "system-msg") { ?>시스템메세지　<?php } else { ?>　<?php } ?><?php echo $list[$i]['send_datetime']; ?></span>

						<div class="memo_preview">
						    <a href="<?php echo $list[$i]['view_href']; ?>"><?php echo $memo_preview; ?></a>
                        </div>
					</div>
					<a href="<?php echo $list[$i]['del_href']; ?>" onclick="del(this.href); return false;" class="memo_del"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_close.svg"> <span class="sound_only">삭제</span></a>
	            </li>
	            <?php } ?>
	            <?php if ($i==0) { echo '<li class="empty_table">자료가 없습니다.</li>'; }  ?>
            </ul>
        </div>

        <!-- 페이지 -->
        <?php echo $write_pages; ?>

        <p class="win_desc"><i class="fa fa-info-circle" aria-hidden="true"></i> 쪽지 보관일수는 최장 <strong><?php echo $config['cf_memo_del'] ?></strong>일 입니다.
        </p>

        <div class="win_btn">
            <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
        </div>
    </div>
</div>
<!-- } 쪽지 목록 끝 -->
