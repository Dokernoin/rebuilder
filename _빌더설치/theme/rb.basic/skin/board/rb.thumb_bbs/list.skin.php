<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$bo_gallery_width = isset($board['bo_gallery_width']) ? $board['bo_gallery_width'] : '';
$bo_mobile_gallery_width = isset($board['bo_mobile_gallery_width'])  ? $board['bo_mobile_gallery_width'] : '';
$bo_gallery_height = isset($board['bo_gallery_height']) ? $board['bo_gallery_height'] : '';
$bo_mobile_gallery_height = isset($board['bo_mobile_gallery_height'])  ? $board['bo_mobile_gallery_height'] : '';
?>

<link rel="stylesheet" href="<?php echo $board_skin_url ?>/style.php?bo_gallery_width=<?php echo $bo_gallery_width; ?>&bo_mobile_gallery_width=<?php echo $bo_mobile_gallery_width; ?>&bo_gallery_height=<?php echo $bo_gallery_height; ?>&bo_mobile_gallery_height=<?php echo $bo_mobile_gallery_height; ?>">

<div class="rb_bbs_wrap" id="scroll_container" style="width:<?php echo $width; ?>">
  
   
    <form name="fboardlist"  id="fboardlist" action="<?php echo G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">
    
    <div class="btns_gr_wrap">
      
       <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭에 따른 버튼의 위치 설정) -->
       <div class="sub" style="width:<?php echo $rb_core['sub_width'] ?>px;">
            
            <?php if(!$wr_id) { //목록보기를 했을 경우 노출되는 부분 방지?>
            
            <div class="btns_gr">
               <?php if ($admin_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $admin_href ?>');">
               <img src="<?php echo $board_skin_url ?>/img/ico_set.svg">
               <span class="tooltips">관리</span>
               </button>
               <?php } ?>
              
               <button type="button" class="fl_btns btn_bo_sch">
               <img src="<?php echo $board_skin_url ?>/img/ico_ser.svg">
               <span class="tooltips">검색</span>
               </button>

               
               <?php if ($rss_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $rss_href ?>');">
               <img src="<?php echo $board_skin_url ?>/img/ico_rss.svg">
               <span class="tooltips">RSS</span>
               </button>
               <?php } ?>
               
               
               <?php if ($write_href) { ?>
               <button type="button" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
               <img src="<?php echo $board_skin_url ?>/img/ico_write.svg">
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
      
        <?php if($board['bo_read_point'] || $board['bo_write_point'] || $board['bo_comment_point'] || $board['bo_download_point']) { ?>
        <li class="point_info_btns_wrap">
            <button type="button" class="point_info_btns" id="point_info_opens_btn">
            <i><svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 0C15.523 0 20 4.477 20 10C20 15.523 15.523 20 10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 0 10 0ZM11.5 5H9C8.46957 5 7.96086 5.21071 7.58579 5.58579C7.21071 5.96086 7 6.46957 7 7V14C7 14.2652 7.10536 14.5196 7.29289 14.7071C7.48043 14.8946 7.73478 15 8 15C8.26522 15 8.51957 14.8946 8.70711 14.7071C8.89464 14.5196 9 14.2652 9 14V12H11.5C12.4283 12 13.3185 11.6313 13.9749 10.9749C14.6313 10.3185 15 9.42826 15 8.5C15 7.57174 14.6313 6.6815 13.9749 6.02513C13.3185 5.36875 12.4283 5 11.5 5ZM11.5 7C11.8978 7 12.2794 7.15804 12.5607 7.43934C12.842 7.72064 13 8.10218 13 8.5C13 8.89782 12.842 9.27936 12.5607 9.56066C12.2794 9.84196 11.8978 10 11.5 10H9V7H11.5Z" fill="#09244B"/></svg></i>
            <span class="pc">포인트정책</span></button>
            
            <div class="point_info_opens">
                <h6><?php echo $board['bo_subject'] ?> 포인트 정책</h6>
                <ul>
                    <?php if($board['bo_read_point']) { ?>
                    <dl>
                        <dd>글읽기</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_read_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                    <?php if($board['bo_write_point']) { ?>
                    <dl>
                        <dd>글쓰기</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_write_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                    <?php if($board['bo_comment_point']) { ?>
                    <dl>
                        <dd>댓글</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_comment_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                    <?php if($board['bo_download_point']) { ?>
                    <dl>
                        <dd>다운로드</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_download_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                </ul>
            </div>
            
            <script>
                $(document).ready(function() {
                    $(document).click(function(event) {
                        if (!$(event.target).closest('#point_info_opens_btn, .point_info_opens').length) {
                            if ($('.point_info_opens').is(':visible')) {
                                $('.point_info_opens').hide();
                                $('#point_info_opens_btn').removeClass('act');
                            }
                        }
                    });

                    $('#point_info_opens_btn').click(function(event) {
                        event.stopPropagation(); 
                        $('.point_info_opens').toggle();
                        $(this).toggleClass('act');
                    });
                });
            </script>
            
            
        </li>
        <?php } ?>
       
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
    <?php if ($is_category) { ?>
    <nav id="bo_cate" class="swiper-container swiper-container-category">
        <ul id="bo_cate_ul" class="swiper-wrapper swiper-wrapper-category">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <script>
        $(document).ready(function() {
            $("#bo_cate_ul li").addClass("swiper-slide swiper-slide-category");

            var activeElement = document.querySelector('#bo_cate_on'); // ID로 바로 찾기
            var initialSlideIndex = 0;

            if (activeElement) {
                var parentLi = activeElement.closest('li.swiper-slide-category');
                var allSlides = document.querySelectorAll('li.swiper-slide-category');
                initialSlideIndex = Array.prototype.indexOf.call(allSlides, parentLi);
            }

            //console.log('초기 인덱스:', initialSlideIndex);

            var swiper = new Swiper('.swiper-container-category', {
                slidesPerView: 'auto',
                spaceBetween: 0,
                observer: true,
                observeParents: true,
                touchRatio: 1,
                initialSlide: initialSlideIndex
            });
        });
    </script>
    <?php } ?>
    <!-- } -->
    
    <ul class="rb_bbs_list">
       
        <?php 
        for ($i=0; $i<count($list); $i++) { 
            
            $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);
            
            if($thumb['src']) {
                if (strstr($list[$i]['wr_option'], 'secret')) {
                    $img_content = '<img src="'.G5_THEME_URL.'/rb.img/sec_image.png" alt="'.$thumb['alt'].'" >';
                } else { 
                    $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" >';
                }
                
            } else {
                $img_content = '';
            }

            $sec_icon = '';
            if (strstr($list[$i]['wr_option'], 'secret')) {
                $sec_txt = '<span style="opacity:0.6">작성자 및 관리자 외 열람할 수 없습니다.<br>비밀글 기능으로 보호된 글입니다.</span>';
                $sec_icon = '<img src="'.$board_skin_url.'/img/ico_sec.svg"> ';
            }
            
            //if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }
            //if (isset($list[$i]['icon_link'])) echo rtrim($list[$i]['icon_link']);
            //if (isset($list[$i]['icon_file'])) echo rtrim($list[$i]['icon_file']);
            
            
        ?>
        
        <div class="rb_bbs_for">
            <div class="rb_bbs_for_wrap">
               
   
                        <div class="rb_bbs_for_info">


                            <ul class="rb_bbs_for_info1">

                                <li class="font-B rb_bbs_for_info1_num">
                                <?php 
                                    if($list[$i]['is_notice']) {
                                        echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-volume-2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>';
                                    } else if (strstr($list[$i]['wr_option'], 'secret')) {
                                        echo $sec_icon;
                                    } else { 
                                        echo number_format($list[$i]['num']); 
                                    }
                                ?>
                                </li>

                                <?php if ($is_checkbox) { ?>
                                <li class="rb_bbs_for_info1_chk">
                                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="">
                                    <label for="chk_wr_id_<?php echo $i ?>"></label>
                                </li>
                                <?php } ?>

                                <div class="cb"></div>

                            </ul>
                            <ul class="rb_bbs_for_info2">
                                <li class="font-R"><?php echo passing_time2($list[$i]['wr_datetime']) ?></li>  
                                <?php if ($is_category && $list[$i]['ca_name']) { ?>
                                <li class="ca_names"><a href="<?php echo $list[$i]['ca_name_href'] ?>" class="font-B"><?php echo $list[$i]['ca_name'] ?></a></li>
                                <?php } ?>
                            </ul>

                        </div>
                        <div class="rb_bbs_for_cont" <?php if(!$thumb['src']) { ?>style="padding-right:0px !important;"<?php } ?>>

                            <div class="mobile">
                                <li class="font-R mo_date_wrap">
                                <?php echo passing_time3($list[$i]['wr_datetime']) ?>
                                <?php if ($is_category && $list[$i]['ca_name']) { ?>
                                 <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="font-B"><?php echo $list[$i]['ca_name'] ?></a>
                                <?php } ?>
                                </li>  

                            </div>
                            <li class="rb_bbs_for_cont_subj cut">
                                <a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject'] ?></a>
                            </li>
                            <li class="rb_bbs_for_cont_txt cut2 font-R">
                            <?php if (strstr($list[$i]['wr_option'], 'secret')) { ?>
                            <?php echo $sec_txt ?>
                            <?php } else { ?>
                            <?php echo strip_tags($list[$i]['wr_content'], '<br>'); ?>
                            <?php } ?>
                            </li>

                            <ul class="rb_bbs_for_mem">

                                <li class="rb_bbs_for_mem_names"><?php echo $list[$i]['name'] ?></li>

                                <?php if($list[$i]['icon_new'] || $list[$i]['icon_hot'] || $list[$i]['is_notice']) { ?>
                                <li class="rb_bbs_for_mem_icos">
                                    <?php if ($list[$i]['icon_new']) echo "<span class=\"lb_ico_new\">새글</span>"; ?>
                                    <?php if ($list[$i]['icon_hot']) echo "<span class=\"lb_ico_hot\">인기</span>"; ?>
                                    <?php if ($list[$i]['is_notice']) echo "<span class=\"lb_ico_noti\">공지</span>"; ?>
                                </li>
                                <?php } ?>

                                <li class="rb_bbs_for_btm_info">
                                    <dd>
                                        <i><img src="<?php echo $board_skin_url ?>/img/ico_eye.svg"></i>
                                        <span><?php echo number_format($list[$i]['wr_hit']); ?></span>
                                    </dd>
                                    <?php if($list[$i]['comment_cnt']) { ?>
                                    <dd>
                                        <i><img src="<?php echo $board_skin_url ?>/img/ico_comm.svg"></i>
                                        <span><?php echo number_format($list[$i]['wr_comment']); ?></span>
                                    </dd>
                                    <?php } ?>
                                    <?php if($is_good) { ?>
                                    <dd class="is_good">
                                        <i><img src="<?php echo $board_skin_url ?>/img/ico_good.svg"></i>
                                        <span><?php echo $list[$i]['wr_good'] ?></span>
                                    </dd>
                                    <?php } ?>
                                    <?php if($is_nogood) { ?>
                                    <dd class="is_nogood">
                                        <i><img src="<?php echo $board_skin_url ?>/img/ico_nogood.svg"></i>
                                        <span><?php echo $list[$i]['wr_nogood'] ?></span>
                                    </dd>
                                    <?php } ?>
                                </li>

                            </ul>
                        </div>
                
            </div>
            <?php if($thumb['src']) { ?>
            <div class="rb_bbs_for_img">
                <ul class="rb_thumb_wrap">
                    <a href="<?php echo $list[$i]['href'] ?>"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
                </ul>
            </div>
            <?php } ?>
            <div class="cb"></div>
        </div>
        
        <?php } ?>
        
        <?php if (count($list) == 0) { echo "<div class=\"no_data\" style=\"text-align:center\">데이터가 없습니다.</div>"; } ?>
        
    </ul>
    
    <ul class="btm_btns">
        
        <dd class="btm_btns_right">

            <?php if ($rss_href) { ?>
            <button type="button" name="btn_submit" class="fl_btns rss_pc" onclick="window.open('<?php echo $rss_href ?>');">
                RSS
            </button>
            <?php } ?>

            <?php if ($write_href) { ?>
            <button type="button" name="btn_submit" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
                <img src="<?php echo $board_skin_url ?>/img/ico_write.svg">
                <span class="font-R">글 등록</span>
            </button>
            <?php } ?>

        </dd>
        
        <dd class="btm_btns_left">
        <?php if ($is_admin == 'super' || $is_auth) { ?>
            <?php if ($is_checkbox) { ?>
                <button type="submit" name="btn_submit" class="fl_btns" value="선택삭제" onclick="document.pressed=this.value">
                <span class="font-B">선택삭제</span>
                </button>

                <button type="submit" name="btn_submit" class="fl_btns" value="선택복사" onclick="document.pressed=this.value">
                <span class="font-B">선택복사</span>
                </button>

                <button type="submit" name="btn_submit" class="fl_btns" value="선택이동" onclick="document.pressed=this.value">
                <span class="font-B">선택이동</span>
                </button>
            <?php } ?>
        <?php } ?>
        
        <button type="button" name="btn_submit" class="fl_btns btn_bo_sch"><span class="font-B">검색</span></button>     
        </dd>
        <dd class="cb"></dd>
    </ul>
    
    
    <!-- 페이지 -->
    <?php echo $write_pages; ?>
    <!-- 페이지 -->
    
    
    
    
    </form>
    
</div>






    
    
    
    
    <!--</form>-->

    <!-- 게시판 검색 시작 { -->
			    <div class="bo_sch_wrap">
				    <fieldset class="bo_sch">
				    	<h3>검색</h3>
				        <legend>게시물 검색</legend>
				        <form name="fsearch" method="get">
                        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                        <input type="hidden" name="sca" value="<?php echo $sca ?>">
                        <input type="hidden" name="sop" value="and">
                        <label for="sfl" class="sound_only">검색대상</label>
                        
                        <select name="sfl" id="sfl" class="select">
                            <?php echo get_board_sfl_select_options($sfl); ?>
                        </select>
                        
				        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
				        <div class="sch_bar">
				       		<input type="text" name="stx" value="<?php echo stripslashes($stx); ?>" id="stx" required class="input" maxlength="20" placeholder="검색어를 입력해주세요">
							<button type="submit" value="검색" class="sch_btn" title="검색"><img src="<?php echo $board_skin_url ?>/img/ico_ser.svg"></button>
				        </div>
				        <button type="button" class="bo_sch_cls"><img src="<?php echo $board_skin_url ?>/img/icon_close.svg"></button>
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
			    
   

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == 'copy')
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}

// 게시판 리스트 관리자 옵션
jQuery(function($){
    $(".btn_more_opt.is_list_btn").on("click", function(e) {
        e.stopPropagation();
        $(".more_opt.is_list_btn").toggle();
    });
    $(document).on("click", function (e) {
        if(!$(e.target).closest('.is_list_btn').length) {
            $(".more_opt.is_list_btn").hide();
        }
    });
});
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
