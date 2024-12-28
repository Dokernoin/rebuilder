<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once($board_skin_path."/skin/top/{$board['bo_rb_skin_top']}/skin.php");
include_once($board_skin_path."/skin/category/{$board['bo_rb_skin_category']}/skin.php");
?>

    <ul class="rb_bbs_list">

        <div class="rb-board-container">

            <div class="rb-board-content">
                <table class="rb-board-table">
                    <thead>
                        <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th class="board_pc">작성자</th>
                            <th class="board_pc">조회</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i=0; $i<count($list); $i++) {


                            $sec_icon = '';
                            if (strstr($list[$i]['wr_option'], 'secret')) {
                                $sec_txt = '<span style="opacity:0.6">작성자 및 관리자 외 열람할 수 없습니다.<br>비밀글 기능으로 보호된 글입니다.</span>';
                                $sec_icon = '<img src="'.$board_skin_url.'/img/ico_sec.svg"> ';
                            }


                        ?>
                        <tr>
                            <td class="rb-board-no">
                                <?php if ($is_checkbox) { ?>
                                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>" class="">
                                <label for="chk_wr_id_<?php echo $i ?>"></label>
                                <?php } else { ?>
                                    <?php
                                        if($list[$i]['is_notice']) {
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-volume-2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><path d="M19.07 4.93a10 10 0 0 1 0 14.14M15.54 8.46a5 5 0 0 1 0 7.07"></path></svg>';
                                        } else if (strstr($list[$i]['wr_option'], 'secret')) {
                                            echo $sec_icon;
                                        } else {
                                            echo number_format($list[$i]['num']);
                                        }
                                    ?>
                                <?php } ?>
                            </td>
                            <td class="rb-board-title" style="padding-left:<?php echo $list[$i]['reply'] ? (strlen($list[$i]['wr_reply'])*50) : '15'; ?>px; <?php if($list[$i]['reply']) { ?>background-image:url('<?php echo $board_skin_url ?>/img/ico_rep.svg'); background-position:center left 15px<?php } ?>">



                                <a href="<?php echo $list[$i]['href'] ?>" class="font-R"><?php echo $list[$i]['subject'] ?></a>

                                <div class="bbs_basic_infos_wrap">
                                    <span class="mobile write_mobiles font-B"><?php echo $list[$i]['name'] ?></span>
                                    <?php if ($is_category && $list[$i]['ca_name']) { ?><a href="<?php echo $list[$i]['ca_name_href'] ?>" class="cats"><?php echo $list[$i]['ca_name'] ?></a><?php } ?>
                                    <?php echo passing_time3($list[$i]['wr_datetime']) ?>
                                    <?php if($list[$i]['comment_cnt']) { ?>댓글 <?php echo number_format($list[$i]['wr_comment']); ?>　<?php } ?>

                                    <?php if($list[$i]['icon_new'] || $list[$i]['icon_hot'] || $list[$i]['is_notice']) { ?>
                                        <?php if ($list[$i]['icon_new']) echo "<span class=\"lb_ico_new\">새글</span>"; ?>
                                        <?php if ($list[$i]['icon_hot']) echo "<span class=\"lb_ico_hot\">인기</span>"; ?>
                                        <?php if ($list[$i]['is_notice']) echo "<span class=\"lb_ico_noti\">공지</span>"; ?>
                                    <?php } ?>

                                </div>



                            </td>
                            <td class="rb-board-writer board_pc"><?php echo $list[$i]['name'] ?></td>
                            <td class="rb-board-views board_pc"><?php echo number_format($list[$i]['wr_hit']); ?></td>
                        </tr>
                        <?php } ?>

                    </tbody>
                </table>
                <?php if (count($list) == 0) { echo "<div class=\"no_data\" style=\"text-align:center\">데이터가 없습니다.</div>"; } ?>
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
