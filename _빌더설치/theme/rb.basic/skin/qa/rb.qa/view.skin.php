<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>


<div class="rb_bbs_wrap" style="width:<?php echo $width; ?>">
       
    <div class="btns_gr_wrap">
      
       <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭에 따른 버튼의 위치 설정) -->
       <div class="sub" style="width:<?php echo $rb_core['sub_width'] ?>px;">
            
            <div class="btns_gr">
               
               <?php if ($list_href) { ?>
               <button type="button" class="fl_btns" onclick="location.href='<?php echo $list_href ?>';">
               <img src="<?php echo $qa_skin_url ?>/img/ico_list.svg">
               <span class="tooltips">목록</span>
               </button>
               <?php } ?>

               
               <?php if ($write_href) { ?>
               <button type="button" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
               <img src="<?php echo $qa_skin_url ?>/img/ico_write.svg">
               <span class="tooltips">글 등록</span>
               </button>
               <?php } ?>
               
            </div>

            
            <div class="cb"></div>
        </div>
    </div>
   
   
    <h2><?php echo get_text($view['subject']);?></h2>
    
    <!-- 게시물 정보 { -->
    <ul class="rb_bbs_for_mem rb_bbs_for_mem_view">

        <li class="rb_bbs_for_mem_names">
            <?php echo $view['name'] ?>　
            <span class="view_info_span"><?php echo passing_time3($view['datetime']) ?></span> 
            <span class="view_info_span"><?php echo date("Y.m.d H:i", strtotime($view['datetime'])) ?></span> 
            <?php if ($view['category']) { ?>
            <span class="view_info_span"><a href="javascript:void(0);"><?php echo $view['category'] ?></a></span> 
            <?php } ?>

        </li>

        
        <div class="cb"></div>

    </ul>
    <!-- } -->
    
    
    <?php if($view['email'] || $view['hp']) { ?>
    <ul class="cont_info_wrap">
        <?php if($view['email']) { ?>
        <li class="cont_info_wrap_l">
            <dd>이메일</dd>
            <dd><?php echo $view['email']; ?></dd>
        </li>
        <?php } ?>
        <?php if($view['hp']) { ?>
        <li class="cont_info_wrap_r">
            <dd>휴대전화</dd>
            <dd><?php echo $view['hp']; ?></dd>
        </li>
        <?php } ?>
        <div class="cb"></div>
    </ul>
    <?php } ?>
           


    
    
    <!-- 첨부파일 / 링크 { -->
    <?php if($view['download_count']) { ?>
    
    <div class="rb_bbs_file">
        <?php
        // 가변 파일
        for ($i=0; $i<$view['download_count']; $i++) {
        ?>
        <ul class="rb_bbs_file_for">
            <i><img src="<?php echo $qa_skin_url ?>/img/ico_file.svg"></i>
            <a href="<?php echo $view['download_href'][$i]; ?>" download><?php echo $view['download_source'][$i] ?></a>
        </ul>
        <?php } ?>
    </div>
    
    <?php } ?>
    


    
    <!-- 본문 내용 시작 { -->
    <div id="bo_v_con">
    
        
        <?php
        // 파일 출력
        if($view['img_count']) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<$view['img_count']; $i++) {
                //echo $view['img_file'][$i];
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
            }

            echo "</div>\n";
        }
         ?>

        <?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?>
        
    </div>
    <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
    <!-- } 본문 내용 끝 -->

    
    
    <ul class="btm_btns">
       
        <dd class="btm_btns_right">
        
            <?php if ($list_href) { ?>
            <a href="<?php echo $list_href ?>" type="button" class="fl_btns font-B">목록</a>
            <?php } ?>

            <?php if ($write_href) { ?>
            <button type="button" name="btn_submit" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
                <img src="<?php echo $qa_skin_url ?>/img/ico_write.svg">
                <span class="font-R">문의 등록</span>
            </button>
            <?php } ?>
            
            <div class="cb"></div>

        </dd>
       
        <div id="bo_v_btns">
            <?php ob_start(); ?>

            <?php if($update_href || $delete_href) { ?>
                

                <?php if ($update_href) { ?>
                <a href="<?php echo $update_href ?>" class="fl_btns">
                <span class="font-B">수정</span>
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

       
       <div class="cb"></div>
	       
    </ul>
    
    
    <?php if($view['qa_type']) { ?>
    <ul>
        <div id="bo_v_addq"><a href="<?php echo $rewrite_href; ?>" class="btn_b01">추가질문</a></div>
    </ul>
    <?php } ?>
    
    
    
    
    <?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($qa_skin_path.'/view.answer.skin.php');
        else
            include_once($qa_skin_path.'/view.answerform.skin.php');
    }
    ?>

    <?php if($view['rel_count']) { ?>
    <h2 class="qa_sub_tit font-B">연관된 질문</h2>
    <ul class="rb_bbs_list qa_sub_wrap">
       
        <?php 
        for($i=0; $i<$view['rel_count']; $i++) {
        ?>
        
        <div class="rb_bbs_for">
            <div class="rb_bbs_for_cont">
                <li class="rb_bbs_for_cont_subj cut">
                    <a href="<?php echo $rel_list[$i]['view_href']; ?>"><?php echo $rel_list[$i]['subject']; ?>
                    </a>
                </li>
                <li class="rb_bbs_for_cont_txt cut2 font-R">
                <?php echo $rel_list[$i]['date']; ?>　<?php echo get_text($rel_list[$i]['category']); ?>　<span class="<?php echo ($rel_list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($rel_list[$i]['qa_status'] ? '답변완료' : '답변준비중'); ?></span>
                </li>

            </div>

            <div class="rb_bbs_for_img">
                <ul class="rb_thumb_wrap">
                    <button type="button" class="rb_status_bt <?php echo ($rel_list[$i]['qa_status'] ? 'active' : ''); ?> font-B" onclick="location.href='<?php echo $rel_list[$i]['view_href']; ?>';"><?php echo ($rel_list[$i]['qa_status'] ? '완료' : '접수'); ?></button>
                </ul>
            </div>

            <div class="cb"></div>
        </div>
        
        <?php } ?>
        
        <?php if ($i == 0) { echo "<div class=\"rb_bbs_for\" style=\"text-align:center\">데이터가 없습니다.</div>"; } ?>

    </ul>

    <?php } ?>

</div>








<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>