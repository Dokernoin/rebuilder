<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);
?>


<div class="rb_faq">
   
    <?php
    if ($himg_src)
        echo '<div id="faq_himg" class="faq_img"><img src="'.$himg_src.'" alt=""></div>';

    // 상단 HTML
    echo '<div id="faq_hhtml">'.conv_content($fm['fm_head_html'], 1).'</div>';
    ?>
    
    
   
    <div class="btns_gr_wrap">
      
       <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭에 따른 버튼의 위치 설정) -->
       <div class="sub" style="width:<?php echo $rb_core['sub_width'] ?>px;">
            
            <div class="btns_gr">
               <?php if ($admin_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $admin_href ?>');">
               <img src="<?php echo $faq_skin_url ?>/img/ico_set.svg">
               <span class="tooltips">관리</span>
               </button>
               <?php } ?>
               
            </div>
            
            <div class="cb"></div>
        </div>
    </div>
    
    
   
    <h2>자주하시는 질문들을 모았어요!</h2>
    
    <ul>
        <div class="faq_ser_wrap">
            <form name="faq_search_form" method="get">
                <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
                <input type="text" name="stx" value="<?php echo $stx;?>" required id="stx" class="ser_inps font-B" maxlength="15">
                <button type="submit" value="검색" class="ser_btns">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B"/>
                    </svg>
                </button>
            </form>
        </div>
    </ul>
    
    <ul class="rb_faq_sub_tit">
        자주하는질문을 검색해보세요.<br>
        원하는 질문이 없다면, 1:1문의를 이용해주세요.
    </ul>

    
    <?php
    if( count($faq_master_list) ){
    ?>
    <nav id="bo_cate" class="swiper-container swiper-container-category">
        <ul id="bo_cate_ul" class="swiper-wrapper swiper-wrapper-category">
            <?php
            foreach( $faq_master_list as $v ){
                $category_msg = '';
                $category_option = '';
                if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
                    $category_option = ' id="bo_cate_on"';
                    $category_msg = '<span class="sound_only">열린 분류 </span>';
                }
            ?>
            <li class="swiper-slide swiper-slide-category"><a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>" <?php echo $category_option;?> ><?php echo $category_msg.$v['fm_subject'];?></a></li>
            <?php
            }
            ?>
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

    
    
    <div id="faq_wrap" class="faq_<?php echo $fm_id; ?>">
        <?php // FAQ 내용
        if( count($faq_list) ){
        ?>
        <section id="faq_con">
            <h2><?php echo $g5['title']; ?> 목록</h2>
            <ol>
                <?php
                foreach($faq_list as $key=>$v){
                    if(empty($v))
                        continue;
                ?>
                <li>
                    <h3>
                        <span class="tit_bg">Q</span><a href="#none" onclick="return faq_open(this);"><?php echo conv_content($v['fa_subject'], 1); ?></a>
                        <button class="tit_btn" onclick="return faq_open(this);"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">열기</span></button>
                    </h3>
                    <div class="con_inner">
                        <?php echo conv_content($v['fa_content'], 1); ?>
                        <button type="button" class="closer_btn"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">닫기</span></button>
                    </div>
                </li>
                <?php
                }
                ?>
            </ol>
        </section>
        <?php

        } else {
            if($stx){
                echo '<p class="no_data">검색된 게시물이 없습니다.</p>';
            } else {
                echo '<div class="no_data">등록된 FAQ가 없어요.';
                if($is_admin)
                    echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용해 주세요.';
                echo '</div>';
            }
        }
        ?>
    </div>
    
    
    <?php echo get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

<?php
// 하단 HTML
echo '<div id="faq_thtml">'.conv_content($fm['fm_tail_html'], 1).'</div>';

if ($timg_src)
    echo '<div id="faq_timg" class="faq_img"><img src="'.$timg_src.'" alt=""></div>';
?>

</div>



<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<script>
jQuery(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle('slow', function() {
			var $h3 = $(this).closest("li").find("h3");

			$("#faq_con li h3").removeClass("faq_li_open");
			if($(this).is(":visible")) {
				$h3.addClass("faq_li_open");
			}
		});
    });
});

function faq_open(el)
{	
    var $con = $(el).closest("li").find(".con_inner"),
		$h3 = $(el).closest("li").find("h3");

    if($con.is(":visible")) {
        $con.slideUp();
		$h3.removeClass("faq_li_open");
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
				$("#faq_con li h3").removeClass("faq_li_open");

				$h3.addClass("faq_li_open");
            }
        );
    }

    return false;
}
</script>
