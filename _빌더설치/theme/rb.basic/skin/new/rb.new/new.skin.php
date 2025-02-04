<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$thumb_width = 0; //썸네일 가로 사이즈
$thumb_height = 120; //썸네일 세로 사이즈

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_admin) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css?ver='.G5_TIME_YMDHIS.'">', 0);


?>

<div class="rb_serch_skin">
   
    <form name="fnew" method="get">
        <ul>
            <div class="faq_ser_wrap">
                <input type="text" name="mb_id" value="<?php echo $mb_id;?>" required id="mb_id" class="ser_inps font-B" placeholder="회원아이디 검색">
                <input type="hidden" name="view" value="<?php echo $view ?>">
                <button type="submit" value="검색" class="ser_btns">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B" />
                    </svg>
                </button>
            </div>
        </ul>
        
        <?php if($config['cf_new_del'] > 0) { ?>
        <ul class="rb_faq_sub_tit">
            최근 <?php echo $config['cf_new_del'] ?>일 이내 등록된 새글 이에요.
        </ul>
        <?php } ?>

    </form>
    
    <div class="rb_bbs_wrap rb_bbs_wrap_new">
    <nav id="bo_cate" class="swiper-container swiper-container-category">
        <ul id="bo_cate_ul" class="swiper-wrapper swiper-wrapper-category">
            <li class="swiper-slide swiper-slide-category"><a href="./new.php?mb_id=<?php echo $mb_id ?>" <?php if($view == "") { ?>id="bo_cate_on"<?php } ?>>전체</a></li>
            <li class="swiper-slide swiper-slide-category"><a href="./new.php?mb_id=<?php echo $mb_id ?>&view=w" <?php if($view == "w") { ?>id="bo_cate_on"<?php } ?>>글</a></li>
            <li class="swiper-slide swiper-slide-category"><a href="./new.php?mb_id=<?php echo $mb_id ?>&view=c" <?php if($view == "c") { ?>id="bo_cate_on"<?php } ?>>댓글</a></li>
        </ul>
    </nav>
    </div>

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



    <form name="fnewlist" id="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
    <input type="hidden" name="sw"       value="move">
    <input type="hidden" name="view"     value="<?php echo $view ?>">
    <input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
    <input type="hidden" name="stx"      value="<?php echo $stx; ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
    <input type="hidden" name="page"     value="<?php echo $page; ?>">
    <input type="hidden" name="pressed"  value="">

    <div id="sch_result">
        <!--
        <section id="sch_res_ov">
            <h2><strong><?php echo $stx ?></strong> 전체글</h2>
            <ul>
                <li></li>
                <li></li>
            </ul>
        </section>
        -->
        
        <section class="sch_res_list">
            <div class="search_board_result">
                <?php if ($is_admin) { ?>
                <div class="mt-30">
                <button type="submit" class="more_btn" onclick="document.pressed=this.title" title="선택삭제">선택삭제</button>
                    <input type="checkbox" id="all_chk">
                    <label for="all_chk"></label>
                </div>
                <?php } ?>

                <ul>
                    <?php
                    for ($i=0; $i<count($list); $i++)
                    {
                        $num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
                        $gr_subject = cut_str($list[$i]['gr_subject'], 20);
                        $bo_subject = cut_str($list[$i]['bo_subject'], 20);
                        $wr_subject = get_text($list[$i]['wr_subject']);
                        
                        $sec_txt = '<span style="opacity:0.6">작성자 및 관리자 외 열람할 수 없습니다.<br>비밀글 기능으로 보호된 글입니다.</span>';
                        
                        //$wr_content = preg_replace("/<(.*?)\>/","",$list[$i]['wr_content']);
                        //$wr_content = preg_replace("/&nbsp;/","",$wr_content);
                        $wr_content = strip_tags($list[$i]['wr_content']);
                        
                        $thumb = get_list_thumbnail($list[$i]['bo_table'], $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);
                        if($thumb['src']) {
                            $img = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" width="'.$thumb_width.'" height="'.$thumb_height.'">';
                        }
                        
                        if($list[$i]['comment']) {
                            $list[$i]['comment'] = "[댓글]";
                        }

                    ?>

                        <div class="new_ul_wrap">
                            <li class="new_li_left" <?php if($is_admin) { ?>style="<?php if($thumb['src']) { ?>padding-right:130px;<?php } else { ?>padding-right:50px;<?php } ?>"<?php } else { ?>style="<?php if($thumb['src']) { ?>padding-right:80px;<?php } else { ?>padding-right:0px;<?php } ?><?php } ?>">
                                <div class="sch_tit">
                                    <a href="<?php echo $list[$i]['href'] ?>" class="sch_res_title font-B"><?php echo $wr_subject ?></a>
                                    <a href="javascript:void(0);" class="pop_a_blank">　<?php echo $list[$i]['comment'] ?></a>
                                </div>
                                
                                <?php if (strstr($list[$i]['wr_option'], 'secret')) { ?>
                                <span class="">
                                    <?php echo $sec_txt; ?>
                                </span>
                                <?php } else { ?>
                                <span class="cut2">
                                    <?php echo $wr_content; ?>
                                </span>
                                <?php } ?>

                                <div class="sch_info">
                                    <span class="sch_datetime"><?php echo $list[$i]['wr_name'] ?>　<?php echo $list[$i]['datetime'] ?>　<a href="<?php echo get_pretty_url($list[$i]['bo_table']); ?>"><?php echo $bo_subject ?></a><!--　<a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>"><?php echo $gr_subject ?></a>--></span>
                                </div>
                            </li>
                            <li class="new_li_right">

                                <?php if($thumb['src']) { ?>
                                    <?php if (!strstr($list[$i]['wr_option'], 'secret')) { ?>
                                    <a href="<?php echo $list[$i]['href']; ?>"><?php echo $img; ?></a>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($is_admin) { ?>
                                    <input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>">
                                    <label for="chk_bn_id_<?php echo $i; ?>"></label>
                                    <input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
                                    <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
                                <?php } ?>
                            </li>
                        </div>

                    <?php } ?>

                    <?php if ($i == 0)
                        echo '<div class="no_data mt-50">게시물이 없어요.</div>';
                    ?>
                    
                </ul>

            </div>
        </section>
    </div>
    
    <?php echo $write_pages ?>
    
    </form>
    
</div>



<?php if ($is_admin) { ?>
<script>
$(function(){
    $('#all_chk').click(function(){
        $('[name="chk_bn_id[]"]').attr('checked', this.checked);
    });
});

function fnew_submit(f)
{
    f.pressed.value = document.pressed;

    var cnt = 0;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            cnt++;
    }

    if (!cnt) {
        alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
        return false;
    }

    f.action = "<?php echo G5_BBS_URL ?>/new_delete.php";

    return true;
}
</script>
<?php } ?>
<!-- } 전체게시물 목록 끝 -->
