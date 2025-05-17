<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<style>
#scroll_container {margin-top: 20px;}
#scroll_container .rb_bbs_top{display: none;}
</style>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<div class="rb_bbs_wrap" style="width:<?php echo $width; ?>">
       
    <div class="btns_gr_wrap">
      
       <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭에 따른 버튼의 위치 설정) -->
       <div class="sub" style="width:<?php echo $rb_core['sub_width'] ?>px;">
            
            <div class="btns_gr">
               <?php if ($admin_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $admin_href ?>');">
               <img src="<?php echo $board_skin_url ?>/img/ico_set.svg">
               <span class="tooltips">관리</span>
               </button>
               <?php } ?>
               
               <?php if ($scrap_href) { ?>
               <a class="fl_btns" href="<?php echo $scrap_href;  ?>" target="_blank" onclick="win_scrap(this.href); return false;">
               <img src="<?php echo $board_skin_url ?>/img/ico_scr.svg">
               <span class="tooltips">스크랩</span>
               </a>
               <?php } ?>
               
               <?php if ($list_href) { ?>
               <button type="button" class="fl_btns" onclick="location.href='<?php echo $list_href ?>';">
               <img src="<?php echo $board_skin_url ?>/img/ico_list.svg">
               <span class="tooltips">목록</span>
               </button>
               <?php } ?>

               
               <?php if ($write_href) { ?>
               <button type="button" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
               <img src="<?php echo $board_skin_url ?>/img/ico_write.svg">
               <span class="tooltips">글 등록</span>
               </button>
               <?php } ?>
               
            </div>
            
            <div class="cb"></div>
        </div>
    </div>
   
    <span class="view_info_span mobile"><?php echo date("Y.m.d H:i", strtotime($view['wr_datetime'])) ?></span>
    <h2><?php echo get_text($view['wr_subject']);?></h2>
    
    <!-- 게시물 정보 { -->
    <ul class="rb_bbs_for_mem rb_bbs_for_mem_view">

        <li class="rb_bbs_for_mem_names">
            <?php echo $view['name'] ?> <?php if ($board['bo_use_ip_view']) { echo "<span class='view_info_span_ip'>($ip)</span>"; } ?>
            <span class="view_info_span"><?php echo passing_time3($view['wr_datetime']) ?></span> 
            <span class="view_info_span view_info_span_date"><?php echo date("Y.m.d H:i", strtotime($view['wr_datetime'])) ?></span> 
            <?php if ($category_name) { ?>
            <span class="view_info_span"><a href="<?php echo $view['ca_name_href'] ?>"><?php echo $view['ca_name'] ?></a></span> 
            <?php } ?>
            
            <?php
            $view['icon_new'] = "";
            if ($view['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
                $view['icon_new'] = "<span class=\"lb_ico_new\">새글</span>";
            $view['icon_hot'] = "";
            if ($board['bo_hot'] > 0 && $view['wr_hit'] >= $board['bo_hot'])
                $view['icon_hot'] = "<span class=\"lb_ico_hot\">인기</span>";

            echo $view['icon_new']; //뉴아이콘
            echo $view['icon_hot']; //인기아이콘 
            ?>
        </li>

        <li class="rb_bbs_for_btm_info">
            <dd>
                <i><img src="<?php echo $board_skin_url ?>/img/ico_eye.svg"></i>
                <span><?php echo number_format($view['wr_hit']); ?></span>
            </dd>

            <dd>
                <i><img src="<?php echo $board_skin_url ?>/img/ico_comm.svg"></i>
                <span><?php echo number_format($view['wr_comment']); ?></span>
            </dd>

        </li>
        
        <div class="cb"></div>

    </ul>
    <!-- } -->
    
    
    <!-- 첨부파일 / 링크 { -->
    <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
            //if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'])
                $cnt++;
        }
    }

	?>

    <?php if($cnt) { ?>
    
    
    <div class="rb_bbs_file">
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
            //if (isset($view['file'][$i]['source']) && $view['file'][$i]['source']) {
        ?>
        <ul class="rb_bbs_file_for">
            <i><img src="<?php echo $board_skin_url ?>/img/ico_file.svg"></i>
            <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download"><?php echo $view['file'][$i]['source'] ?></a> (<?php echo $view['file'][$i]['size'] ?>)　<!--<?php echo $view['file'][$i]['datetime'] ?>　--><?php echo number_format($view['file'][$i]['download']); ?>회
            <?php if($view['file'][$i]['content']) { ?>
            <li class="file_contents"><?php echo $view['file'][$i]['content'] ?></li>
            <?php } ?>
        </ul>
        <?php
            }
        }
        ?>
    </div>
    
    <?php } ?>
    
    
    
    <?php if(isset($view['link']) && array_filter($view['link'])) { ?>
    
    <div class="rb_bbs_file">
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
        ?>
        <ul class="rb_bbs_file_for">
            <i><img src="<?php echo $board_skin_url ?>/img/ico_link.svg"></i>
            <a href="<?php echo $view['link_href'][$i] ?>" target="_blank"><?php echo $link ?></a>　<?php echo $view['link_hit'][$i] ?>회
        </ul>
        <?php
            }
        }
        ?>
    </div>
    
    <?php } ?>

    
    <!-- 본문 내용 시작 { -->
    <div id="bo_v_con">
    
    
        <?php
            // 파일 출력

            $v_img_count = count($view['file']);

            if($v_img_count) {
                echo "<div id=\"bo_v_img\">\n";

                foreach($view['file'] as $view_file) {
                    echo get_file_thumbnail($view_file);
                }

                echo "</div>\n";
            }

        ?>
        <?php $original_content = isset($view['content']) ? $view['content'] : ''; ?>
        <?php echo get_view_thumbnail($view['content']); ?>
    </div>
    
    
    <div id="bo_v_share">
        	<?php include_once(G5_SNS_PATH."/view.sns.skin.php"); ?>
        	<ul class="copy_urls">
                <li>
                    <a href="javascript:void(0);" id="data-copy">
                       <img src="<?php echo $board_skin_url ?>/img/ico_sha.png" alt="공유링크 복사" width="32">
                    </a>
        	    </li>
        	    <?php
                $currents_url = G5_URL.$_SERVER['REQUEST_URI'];
                ?>
        	    <input type="hidden" id="data-area" class="data-area" value="<?php echo $currents_url ?>">
        	    <script>
        	        $(document).ready(function() {

        	            $('#data-copy').click(function() {
        	                $('#data-area').attr('type', 'text'); // 화면에서 hidden 처리한 input box type을 text로 일시 변환
        	                $('#data-area').select(); // input에 담긴 데이터를 선택
        	                var copy = document.execCommand('copy'); // clipboard에 데이터 복사
        	                $('#data-area').attr('type', 'hidden'); // input box를 다시 hidden 처리
        	                if (copy) {
        	                    alert("공유 링크가 복사 되었습니다."); // 사용자 알림
        	                }
        	            });

        	        });
        	    </script>
        	</ul>

    </div>
    
    
    <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
    <!-- } 본문 내용 끝 -->
    
    <!--  추천 비추천 시작 { -->
    <?php if ( $good_href || $nogood_href) { ?>
    <div id="bo_v_act">
        <?php if ($good_href) { ?>
        <span class="bo_v_act_gng">
            <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?><?php echo $good_href.'&amp;'.$qstr ?><?php } ?>" id="good_button" class="bo_v_good">추천해요 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
            <b id="bo_v_act_good" class="font-R"></b>
        </span>
        <?php } ?>
        <?php if ($nogood_href) { ?>
        <span class="bo_v_act_gng">
            <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?><?php echo $nogood_href.'&amp;'.$qstr ?><?php } ?>" id="nogood_button" class="bo_v_nogood">별로에요 <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
            <b id="bo_v_act_nogood" class="font-R"></b>
        </span>
        <?php } ?>
    </div>
    <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
    <div id="bo_v_act">
        <?php if($board['bo_use_good']) { ?>
            <span class="bo_v_act_gng">
                
                <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?>javascript:void(0);<?php } ?>" class="bo_v_good">추천해요 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                <b id="bo_v_act_good" class="font-R"></b>
            </span>
        <?php } ?>
        <?php if($board['bo_use_nogood']) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?>javascript:void(0);<?php } ?>" class="bo_v_nogood">별로에요 <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                <b id="bo_v_act_nogood" class="font-R"></b>
            </span>
        <?php } ?>
    </div>
    <?php
            }
        }
    ?>
    <!-- }  추천 비추천 끝 -->
    
    
    <ul class="btm_btns">
      
      
        <dd class="btm_btns_right">
        
            <?php if ($list_href) { ?>
            <a href="<?php echo $list_href ?>" type="button" class="fl_btns font-B">목록</a>
            <?php } ?>
               

            <?php if ($scrap_href) { ?>
            <a href="<?php echo $scrap_href;  ?>" class="fl_btns font-B" target="_blank" onclick="win_scrap(this.href); return false;">스크랩</a>
            <?php } ?>

            <?php if ($write_href) { ?>
            <button type="button" name="btn_submit" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
                <img src="<?php echo $board_skin_url ?>/img/ico_write.svg">
                <span class="font-R">글 등록</span>
            </button>
            <?php } ?>
            
            <div class="cb"></div>

        </dd>
       
        <div id="bo_v_btns">
            <?php ob_start(); ?>

            <?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
                
                <?php if ($reply_href) { ?>
                <!-- // 답글을 사용하지 않음
                <a href="<?php echo $reply_href ?>" class="fl_btns">
                <span class="font-B">답글</span>
                </a>
                -->
                <?php } ?>
                
                <?php if ($update_href) { ?>
                <a href="<?php echo $update_href ?>" class="fl_btns">
                <span class="font-B">수정</span>
                </a>
                <?php } ?>

                <?php if ($copy_href) { ?>
                <a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" class="fl_btns">
                <span class="font-B">복사</span>
                </a>
                <?php } ?>
                
                <?php if ($move_href) { ?>
                <a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" class="fl_btns">
                <span class="font-B">이동</span>
                </a>
                <?php } ?>
                
                <?php if ($delete_href) { ?>
                <a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" class="fl_btns">
                <span class="font-B">삭제</span>
                </a>
                <?php } ?>
                
            <?php } ?>
            
            <?php
	        $link_buttons = ob_get_contents();
	        ob_end_flush();
	       ?>
	       
        </div>
        

        <dd class="cb"></dd>

	       
    </ul>
    
    <!-- 배너 {
    <ul class="bbs_bn_box">
        배너를 추가해보세요.
    </ul>
    } -->
    
    <?php 
    if(isset($board['bo_use_signature']) && $board['bo_use_signature']) {
        // 서명 출력
        include_once(G5_PATH.'/rb/rb.mod/signature/signature.skin.php');
    } 
    ?>
    
    <ul>
        <?php if ($prev_href || $next_href) { ?>
        <div class="bo_v_nb">
            <?php if ($prev_href) { ?><li class="btn_prv" onclick="location.href='<?php echo $prev_href ?>';"><span class="nb_tit">이전글</span><a href="javascript:void(0);"><?php echo $prev_wr_subject;?></a><span class="nb_date"><?php echo str_replace('-', '.', substr($prev_wr_date, '0', '10')); ?></span></li><?php } ?>
            <?php if ($next_href) { ?><li class="btn_next" onclick="location.href='<?php echo $next_href ?>';"><span class="nb_tit">다음글</span><a href="javascript:void(0);"><?php echo $next_wr_subject;?></a><span class="nb_date"><?php echo str_replace('-', '.', substr($next_wr_date, '0', '10')); ?></span></li><?php } ?>
        </div>
        <?php } ?>

        <?php
        // 코멘트 입출력
        include_once(G5_BBS_PATH.'/view_comment.php');
        ?>
    </ul>

    
</div>













<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->
