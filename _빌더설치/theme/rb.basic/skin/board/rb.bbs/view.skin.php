<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/css/style.css">', 0);
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


    <?php include_once($board_skin_path."/skin/view/{$board['bo_rb_skin_view']}/skin.php"); ?>


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

<?php if(isset($board['bo_lightbox']) && $board['bo_lightbox'] == 1) { ?>
<script src="<?php echo $board_skin_url ?>/js/rb.lightbox.js"></script>
<?php } ?>
