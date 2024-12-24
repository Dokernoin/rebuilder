<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>


<div class="rb_bbs_wrap bdr">
   
    <h2 style="margin-top:0px;"><button type="button" class="bo_v_reply">답변</button><?php echo get_text($answer['qa_subject']); ?></h2>
    
    <!-- 게시물 정보 { -->
    <ul class="rb_bbs_for_mem rb_bbs_for_mem_view">

        <li class="rb_bbs_for_mem_names">
            <span class="view_info_span"><?php echo date("Y.m.d H:i", strtotime($view['qa_datetime'])) ?></span> 
        </li>

        <div class="cb"></div>

    </ul>
    <!-- } -->
    
    
    <!-- 첨부파일 / 링크 { -->
    <?php if(isset($answer['download_count']) && $answer['download_count']) { ?>
    
    <div class="rb_bbs_file">
        <?php
        // 가변 파일
        for ($i=0; $i<$answer['download_count']; $i++) {
        ?>
        <ul class="rb_bbs_file_for">
            <i><img src="<?php echo $qa_skin_url ?>/img/ico_file.svg"></i>
            <a href="<?php echo $answer['download_href'][$i]; ?>" download><?php echo $answer['download_source'][$i] ?></a>
        </ul>
        <?php } ?>
    </div>
    
    <?php } ?>
    



    
    <!-- 본문 내용 시작 { -->
    <div id="bo_v_con">
    
        
        <?php
        // 파일 출력
        if(isset($answer['img_count']) && $answer['img_count']) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<$answer['img_count']; $i++) {
                echo get_view_thumbnail($answer['img_file'][$i], $qaconfig['qa_image_width']);
            }

            echo "</div>\n";
        }
        ?>

        <?php echo get_view_thumbnail(conv_content($answer['qa_content'], $answer['qa_html']), $qaconfig['qa_image_width']); ?>

        
    </div>
    <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
    <!-- } 본문 내용 끝 -->

    
    
    <ul class="btm_btns">
        <div id="bo_v_btns">

            <?php if ( $answer_update_href || $answer_delete_href ){ ?>
                

                <?php if ($answer_update_href) { ?>
                <a href="<?php echo $answer_update_href ?>" class="fl_btns">
                <span class="font-B">답변수정</span>
                </a>
                <?php } ?>

                <?php if ($answer_delete_href) { ?>
                <a href="<?php echo $answer_delete_href ?>" onclick="del(this.href); return false;" class="fl_btns">
                <span class="font-B">답변삭제</span>
                </a>
                <?php } ?>
                

            <?php } ?>
	       
        </div>

       
       <div class="cb"></div>
	       
    </ul>
    
    

    <ul class="text-center">
        <a href="<?php echo $rewrite_href; ?>" class="add_qa" title="추가질문">추가질문</a>
    </ul>


    

</div>



