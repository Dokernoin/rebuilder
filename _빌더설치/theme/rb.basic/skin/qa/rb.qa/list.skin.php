<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>


<div class="rb_bbs_wrap rb_bbs_wrap_qa" id="scroll_container" style="width:<?php echo $width; ?>">
  
   
    <form name="fqalist" id="fqalist" action="./qadelete.php" onsubmit="return fqalist_submit(this);" method="post">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="sca" value="<?php echo $sca; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <input type="hidden" name="token" value="<?php echo get_text($token); ?>">
    
    <div class="btns_gr_wrap">
      
       <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭에 따른 버튼의 위치 설정) -->
       <div class="sub" style="width:<?php echo $rb_core['sub_width'] ?>px;">
            
            <?php if(!$wr_id) { //목록보기를 했을 경우 노출되는 부분 방지?>
            
            <div class="btns_gr">
               <?php if ($admin_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $admin_href ?>');">
               <img src="<?php echo $qa_skin_url ?>/img/ico_set.svg">
               <span class="tooltips">관리</span>
               </button>
               <?php } ?>
              
               <button type="button" class="fl_btns btn_bo_sch">
               <img src="<?php echo $qa_skin_url ?>/img/ico_ser.svg">
               <span class="tooltips">검색</span>
               </button>

               
               <?php if (isset($rss_href) && $rss_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $rss_href ?>');">
               <img src="<?php echo $qa_skin_url ?>/img/ico_rss.svg">
               <span class="tooltips">RSS</span>
               </button>
               <?php } ?>
               
               
               <?php if ($write_href) { ?>
               <button type="button" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
               <img src="<?php echo $qa_skin_url ?>/img/ico_write.svg">
               <span class="tooltips">글 등록</span>
               </button>
               <?php } ?>
               
            </div>
            <?php } ?>
            
            <div class="cb"></div>
        </div>
    </div>
    
    <!-- 갯수, 전체선택 { -->
    <ul class="rb_bbs_top">
      
       
        <?php if ($is_checkbox) { ?>
        <li>
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            <label for="chkall"></label>
        </li>
        <?php } ?>
        
        <li class="cnts">
            전체 <?php echo number_format($total_count) ?>건 / <?php echo $page ?> 페이지
        </li>
        
        <div class="cb"></div>
    </ul>
    <!-- } -->
    

    
    <!-- 카테고리 { -->
    <?php if ($category_option) { ?>
    <nav id="bo_cate" class="swiper-container swiper-container-category">
        <ul id="bo_cate_ul" class="swiper-wrapper swiper-wrapper-category">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <script>
        $(document).ready(function(){
            $("#bo_cate_ul li").addClass("swiper-slide swiper-slide-category");
        });
        
        var swiper = new Swiper('.swiper-container-category', {
            slidesPerView: 'auto', //가로갯수
            spaceBetween: 0, // 간격
            //slidesOffsetBefore: 40, //좌측여백
            //slidesOffsetAfter: 40, // 우측여백
            observer: true, //리셋
            observeParents: true, //리셋
            touchRatio: 1, // 드래그 가능여부

        });

    </script>
    <?php } ?>
    <!-- } -->
    
    <!-- 게시판 설명글 임시보류
    <?php if($is_member) { ?>
        <div class="list_help_wrap">
            <?php if($is_admin) { ?>
                작성자와 관리자만 볼 수 있어요
            <?php } else { ?>
                <?php echo $member['mb_nick']; ?>님과 관리자만 볼 수 있어요
            <?php } ?>
        </div>
    <?php } ?>
    -->
    
    <ul class="rb_bbs_list">
       
        
       
        <?php 
        for ($i=0; $i<count($list); $i++) { 
        ?>
        
        <div class="rb_bbs_for">
            <div class="rb_bbs_for_info">
                <ul class="rb_bbs_for_info1">
                   
                    
                    <?php if ($is_checkbox) { ?>
                    <li class="rb_bbs_for_info1_chk">
                        <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>" class="">
                        <label for="chk_qa_id_<?php echo $i ?>"></label>
                    </li>
                    <?php } ?>
                    
                    <div class="cb"></div>
                    
                </ul>

            </div>
            <div class="rb_bbs_for_cont">
                <li class="rb_bbs_for_cont_subj cut">
                    <a href="<?php echo $list[$i]['view_href']; ?>"><?php echo $list[$i]['subject'] ?>
                    </a>
                </li>
                <li class="rb_bbs_for_cont_txt cut2 font-R">
                <?php echo $list[$i]['name'] ?>　<?php echo $list[$i]['date']; ?>　<?php echo $list[$i]['category']; ?>　<span class="<?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변준비중'); ?></span>
                </li>

            </div>

            <div class="rb_bbs_for_img">
                <ul class="rb_thumb_wrap">
                    <button type="button" class="rb_status_bt <?php echo ($list[$i]['qa_status'] ? 'active' : ''); ?> font-B" onclick="location.href='<?php echo $list[$i]['view_href'] ?>';"><?php echo ($list[$i]['qa_status'] ? '완료' : '접수'); ?></button>
                </ul>
            </div>

            <div class="cb"></div>
        </div>
        
        <?php } ?>
        
        <?php if ($i == 0) { echo "<div class=\"no_data\" style=\"text-align:center\">데이터가 없습니다.</div>"; } ?>

    </ul>
    
    <ul class="btm_btns">
       
        <dd class="btm_btns_right">

            <?php if ($write_href) { ?>
            <button type="button" name="btn_submit" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
                <img src="<?php echo $qa_skin_url ?>/img/ico_write.svg">
                <span class="font-R">문의 등록</span>
            </button>
            <?php } ?>

        </dd>
        <dd class="btm_btns_left">
        <?php if ($is_admin == 'super' || $is_auth) { ?>
            <?php if ($is_checkbox) { ?>
                
                <button type="submit" class="fl_btns" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value">
                <span class="font-B">선택삭제</span>
                </button>

            <?php } ?>
        <?php } ?>
        
        <button type="button" name="btn_submit" class="fl_btns btn_bo_sch"><span class="font-B">검색</span></button>
        </dd>
    </ul>
    
    
    <!-- 페이지 -->
    <?php echo $list_pages; ?>
    <!-- 페이지 -->
    
    
    
    
    </form>
    
</div>





        <?php if ($admin_href || $write_href) { ?>

				<!-- 게시판 검색 시작 { -->
			    <div class="bo_sch_wrap">
				    <fieldset class="bo_sch">
				    	<h3>검색</h3>
				        <legend>게시물 검색</legend>
				        <form name="fsearch" method="get">
				        <input type="hidden" name="sca" value="<?php echo $sca ?>">
                        <input type="hidden" name="sop" value="and">
                        <label for="sfl" class="sound_only">검색대상</label>
                        <select name="sfl" id="sfl" class="select">
                            <?php echo get_qa_sfl_select_options($sfl); ?>
                        </select>
				        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
				        <div class="sch_bar">
				       		<input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" id="stx" required class="input" maxlength="15" placeholder="검색어를 입력해주세요">
							<button type="submit" value="검색" class="sch_btn" title="검색"><img src="<?php echo $qa_skin_url ?>/img/ico_ser.svg"></button>
				        </div>
				        <button type="button" class="bo_sch_cls"><img src="<?php echo $qa_skin_url ?>/img/icon_close.svg"></button>
				        </form>
				    </fieldset>
			    	<div class="bo_sch_bg"></div>
			    </div>
			    <script>
					// 게시판 검색
					$(".btn_bo_sch").on("click", function() {
					    $(".bo_sch_wrap").toggle();
					})
					$('.bo_sch_bg, .bo_sch_cls').click(function(){
					    $('.bo_sch_wrap').hide();
					});
				</script>
			    <!-- } 게시판 검색 끝 -->

        <?php } ?>



<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->