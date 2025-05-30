<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<button type="button" class="cmt_btn"><span class="total"><b>댓글</b> <?php echo $view['wr_comment']; ?></span><span class="cmt_more"></span></button>

<!-- 댓글 시작 { -->
<section id="bo_vc">
    <h2>댓글목록</h2>
    <?php
    $cmt_amt = count($list);
    for ($i=0; $i<$cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 20;
        $cmt_depth_bg = $cmt_depth - 20;
        $comment = $list[$i]['content'];
        /*
        if (strstr($list[$i]['wr_option'], "secret")) {
            $str = $str;
        }
        */
        $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
        $cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결
		$c_reply_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
		$c_edit_href = $comment_common_url.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';
        $is_comment_reply_edit = ($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) ? 1 : 0;
	?>

	<article id="c_<?php echo $comment_id ?>">
        <div class="pf_img"><?php echo get_member_profile_img($list[$i]['mb_id']) ?></div>

        <div class="cm_wrap" <?php if ($cmt_depth) { ?>style="padding-left:<?php echo $cmt_depth ?>px; background-image:url('<?php echo $board_skin_url ?>/img/ico_rep_tiny.svg'); background-position:top 22px left <?php echo $cmt_depth_bg ?>px"<?php } ?>>

            <header style="z-index:<?php echo $cmt_sv; ?>">
	            <?php echo $list[$i]['name'] ?>
	            <?php if ($board['bo_use_ip_view']) { ?>
	            <span>(<?php echo $list[$i]['ip']; ?>)</span>
	            <?php } ?>
	            <span class="bo_vc_hdinfo">　<?php echo passing_time3($list[$i]['datetime']) ?></span>
	            <?php
	            //include(G5_SNS_PATH.'/view_comment_list.sns.skin.php');
	            ?>
	        </header>

	        <!-- 댓글 출력 -->
	        <div class="cmt_contents">
	            <p>
	                <?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?php echo $board_skin_url; ?>/img/ico_sec.svg" alt="비밀글"><?php } ?>
	                <?php echo $comment ?>
	            </p>
	            <?php if($is_comment_reply_edit) {
	                if($w == 'cu') {
	                    $sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
	                    $cmt = sql_fetch($sql);
                        if (isset($cmt)) {
                            if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id']))) {
                                $cmt['wr_content'] = '';
                            }
                            $c_wr_content = $cmt['wr_content'];
                        }
	                }
				?>
	            <?php } ?>

	            <p class="p_times"><span><?php echo date('Y-m-d H:i', strtotime($list[$i]['datetime'])) ?></span></p>
	        </div>
	        <span id="edit_<?php echo $comment_id ?>" class="bo_vc_w"></span><!-- 수정 -->
	        <span id="reply_<?php echo $comment_id ?>" class="bo_vc_w"></span><!-- 답변 -->

	        <input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
	        <textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
		</div>
        <?php if($is_comment_reply_edit){ ?>
		<div class="bo_vl_opt">
            <button type="button" class="btn_cm_opt btn_b01 btn"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>
        	<ul class="bo_vc_act">
                <?php if ($list[$i]['is_reply']) { ?><li><a href="<?php echo $c_reply_href; ?>" onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">답변</a></li><?php } ?>
                <?php if ($list[$i]['is_edit']) { ?>
                <li>
                    <a href="<?php echo $c_edit_href; ?>"
                       onclick="
                           comment_box('<?php echo $comment_id ?>', 'cu');
                           var textarea = document.getElementById('wr_content');
                           if (textarea) {
                               textarea.style.height = 'auto';
                               textarea.style.height = textarea.scrollHeight + 'px';
                               textarea.style.minHeight = '150px';
                           }
                           return false;">
                        수정
                    </a>
                </li>
                <?php } ?>
                <?php if ($list[$i]['is_del']) { ?><li><a href="<?php echo $list[$i]['del_link']; ?>" onclick="return comment_delete();">삭제</a></li><?php } ?>
            </ul>
        </div>
        <?php } ?>
        <script>
			$(function() {
		    // 댓글 옵션창 열기
		    $(".btn_cm_opt").on("click", function(){
		        $(this).parent("div").children(".bo_vc_act").show();
		    });

		    // 댓글 옵션창 닫기
		    $(document).mouseup(function (e){
		        var container = $(".bo_vc_act");
		        if( container.has(e.target).length === 0)
		        container.hide();
		    });
		});

		</script>
    </article>
    <?php } ?>
    <?php if ($i == 0) { //댓글이 없다면 ?><p id="bo_vc_empty">등록된 댓글이 없습니다.</p><?php } ?>

</section>
<!-- } 댓글 끝 -->

<?php if ($is_comment_write) {
    if($w == '')
        $w = 'c';
?>
<!-- 댓글 쓰기 시작 { -->
<aside id="bo_vc_w" class="bo_vc_w">

    <form name="fviewcomment" id="fviewcomment" action="<?php echo $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
    <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="is_good" value="">

    <span class="sound_only">내용</span>
    <span id="char_cnt"><span id="char_count"></span> 글자</span>
    <textarea id="wr_content" name="wr_content" maxlength="10000" required title="댓글" placeholder="댓글 내용을 입력해주세요." onkeyup="check_byte('wr_content', 'char_count');" <?php if ($is_guest) { ?>style="padding-bottom:60px !important;"<?php } ?>><?php echo $c_wr_content; ?></textarea>
    <script> check_byte('wr_content', 'char_count'); </script>
    <script>
    $(document).on("keyup change", "textarea#wr_content[maxlength]", function() {
        var str = $(this).val()
        var mx = parseInt($(this).attr("maxlength"))
        if (str.length > mx) {
            $(this).val(str.substr(0, mx));
            return false;
        }
    });

    $(document).ready(function() {
        function adjustTextareaHeight(textarea) {
            textarea.style.height = 'auto'; // 높이를 초기화
            textarea.style.height = (textarea.scrollHeight) + 'px'; // 스크롤 높이 적용
            textarea.style.minHeight = '150px'; // 최소 높이 설정
        }

        // 페이지 로드시 wr_content의 높이를 자동 설정
        const textarea = document.getElementById('wr_content');
        if (textarea) {
            adjustTextareaHeight(textarea);
        }

        // input 이벤트에도 높이를 자동 조정
        $('#wr_content').on('input', function() {
            adjustTextareaHeight(this);
        });
    });
    </script>
    <div class="bo_vc_w_wr">
        <?php if ($is_guest) { ?>
        <div class="bo_vc_w_info">
            <ul class="bo_vc_w_info_ul1">
                <label for="wr_name" class="sound_only">이름<strong> 필수</strong></label>
                <input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" required class="frm_input required" size="25" placeholder="이름">
                <label for="wr_password" class="sound_only">비밀번호<strong> 필수</strong></label>
                <input type="password" name="wr_password" id="wr_password" required class="frm_input required" size="25" placeholder="비밀번호">
            </ul>
            <ul class="bo_vc_w_info_ul2">
            <?php
            /*if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {
            ?>
            <span class="sound_only">SNS 동시등록</span>
            <span id="bo_vc_send_sns"></span>
            <?php } */?>

            <?php echo $captcha_html; ?>
            </ul>
            <div class="cb"></div>
        </div>
        <?php } ?>
        <div class="btn_confirm btn_confirm_cm_wrap">
            <ul class="cm_wrpa_write_left">
                <?php if($board['bo_comment_point'] > 0) { ?>
                    <span class="font-B">댓글을 작성하시면 <span class="main_color"><?php echo number_format($board['bo_comment_point']); ?>P</span> 를 드려요!</span>
                <?php } else if($board['bo_comment_point'] < 0) { ?>
                    <span class="font-B">댓글을 작성하시면 <span class="main_color"><?php echo number_format($board['bo_comment_point']); ?>P</span> 가 차감되요!</span>
                <?php } else { ?>
                    <span class="font-B">바르고 고운말을 사용해주세요!</span>
                <?php } ?>
            </ul>
            <ul class="cm_wrpa_write_right">
                <i><img src="<?php echo $board_skin_url ?>/img/ico_sec.svg"></i>
                <span class="btn_confirm_btn_wrap">
                    <input type="checkbox" name="wr_secret" value="secret" id="wr_secret">
                    <label for="wr_secret"><span></span>비밀댓글</label>
                </span>
                <button type="submit" id="btn_submit" class="btn_submit">댓글등록</button>
            </ul>
            <div class="cb"></div>
        </div>
    </div>
    </form>
</aside>


<script>
var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;

function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js();  ?>

    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work)
{
    var el_id,
        form_el = 'fviewcomment',
        respond = document.getElementById(form_el);

    // 댓글 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'bo_vc_w';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).appendChild(respond);
        //입력값 초기화
        document.getElementById('wr_content').value = '';

        // 댓글 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        if(save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

function comment_delete()
{
    return confirm("이 댓글을 삭제하시겠습니까?");
}

comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>

$(function() {
    // sns 등록
    $("#bo_vc_send_sns").load(
        "<?php echo G5_SNS_URL; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>
</script>
<?php } ?>
<!-- } 댓글 쓰기 끝 -->
