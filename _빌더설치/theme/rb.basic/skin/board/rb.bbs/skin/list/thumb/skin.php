<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once($board_skin_path."/skin/top/{$board['bo_rb_skin_top']}/skin.php");
include_once($board_skin_path."/skin/category/{$board['bo_rb_skin_category']}/skin.php");
?>


<ul class="rb_bbs_thumb">

    <div class="rb_swiper" id="rb_swiper_<?php echo $bo_table ?>"
       data-pc-w="<?php echo $board['bo_gallery_cols'] ?>"
       data-pc-h="999"
       data-mo-w="<?php echo $board['bo_mobile_gallery_cols'] ?>"
       data-mo-h="999"
       data-pc-gap="<?php echo $board['bo_gap_pc'] ?>"
       data-mo-gap="<?php echo $board['bo_gap_mo'] ?>"
       data-autoplay="0"
       data-autoplay-time="0"
       data-pc-swap="0"
       data-mo-swap="0"
    >
        <div class="rb_swiper_inner">
            <div class="rb-swiper-wrapper swiper-wrapper">

                <?php
                for ($i=0; $i<count($list); $i++) {

                    if(isset($board['bo_border']) && $board['bo_border'] == 1) {
                        $set_border = "border:1px dashed rgba(0,0,0,0.1);";
                    } else if(isset($board['bo_border']) && $board['bo_border'] == 2) {
                        $set_border = "border:1px solid rgba(0,0,0,0.1);";
                    } else {
                        $set_border = "border:0px;";
                    }

                    if(isset($board['bo_radius']) && $board['bo_radius']) {
                        $set_radius = "border-radius:".$board['bo_radius']."px;";
                    } else {
                        $set_radius = "border-radius:0px;";
                    }


                    $thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $board['bo_gallery_width'], $board['bo_gallery_height'], false, true);

                    if($thumb['src']) {
                        if (strstr($list[$i]['wr_option'], 'secret')) {
                            $img_content = '<img src="'.G5_THEME_URL.'/rb.img/sec_image.png" alt="'.$thumb['alt'].'" style="'.$set_border.' '.$set_radius.' width:'.$board['bo_gallery_width'].'px;">';
                        } else {
                            $img_content = '<img src="'.$thumb['src'].'" alt="'.$thumb['alt'].'" style="'.$set_border.' '.$set_radius.' width:'.$board['bo_gallery_width'].'px;">';
                        }
                    } else {
                        $img_content = '<img src="'.G5_THEME_URL.'/rb.img/no_image.png" alt="이미지가 없습니다." style="'.$set_border.' '.$set_radius.' width:'.$board['bo_gallery_width'].'px;">';
                    }


                    $wr_href = $list[$i]['href'];
                    $sec_txt = '<span style="opacity:0.6">작성자 및 관리자 외 열람할 수 없습니다.<br>비밀글 기능으로 보호된 글입니다.</span>';

                    $wr_content = preg_replace("/<(.*?)\>/","",$list[$i]['wr_content']);
                    $wr_content = preg_replace("/&nbsp;/","",$wr_content);
                    $wr_content = get_text($wr_content);


                    $cont_width = $board['bo_gallery_width'] + $board['bo_gap_pc'];

                ?>


                <div class="rb_swiper_list">

                    <div class="rb_bbs_for_img">
                        <ul class="rb_thumb_wrap">
                            <a href="<?php echo $list[$i]['href'] ?>"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
                        </ul>
                    </div>

                    <?php if ($is_checkbox) { ?>
                    <li class="rb_bbs_for_info1_chk">
                        <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="">
                        <label for="chk_wr_id_<?php echo $i ?>"></label>
                    </li>
                    <?php } ?>

                    <div class="rb_bbs_for_wrap">

                        <div class="rb_bbs_for_cont" style="padding-left:<?php echo $cont_width ?>px;">

                            <li class="rb_bbs_for_cont_subj cut">
                                <a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject'] ?></a>
                            </li>

                            <div class="rb_bbs_for_cont_info">
                                <li class="font-R mo_date_wrap">
                                <?php echo passing_time3($list[$i]['wr_datetime']) ?>
                                <?php if ($is_category && $list[$i]['ca_name']) { ?>
                                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="font-B"><?php echo $list[$i]['ca_name'] ?></a>
                                <?php } ?>
                                </li>

                            </div>

                            <li class="rb_bbs_for_cont_txt cut2 font-R">
                                <?php if (strstr($list[$i]['wr_option'], 'secret')) { ?>
                                <?php echo $sec_txt ?>
                                <?php } else { ?>
                                <?php echo strip_tags($list[$i]['wr_content'], ''); ?>
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
                                    <!--
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
                                    -->
                                </li>

                            </ul>
                        </div>

                    </div>


                </div>

                <?php } ?>

                <?php if (count($list) == 0) { echo "<div class=\"no_data\" style=\"text-align:center\">데이터가 없습니다.</div>"; } ?>

            </div>
        </div>
    </div>
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
