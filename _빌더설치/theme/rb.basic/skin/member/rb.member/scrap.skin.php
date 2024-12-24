<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 스크랩 목록 시작 { -->
<div id="scrap" class="new_win">
    <h1 id="win_title"><?php echo $g5['title'] ?></h1>
    <ul>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
        <li>
            <?php if(IS_MOBILE()) { ?>
            <a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" class="scrap_tit" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; window.close(); return false;"><?php echo $list[$i]['subject'] ?></a>
            <?php } else { ?>
            <a href="<?php echo $list[$i]['opener_href_wr_id'] ?>" class="scrap_tit" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href_wr_id'] ?>'; return false;"><?php echo $list[$i]['subject'] ?></a>
            <?php } ?>
            <a href="<?php echo $list[$i]['opener_href'] ?>" class="scrap_cate" target="_blank" onclick="opener.document.location.href='<?php echo $list[$i]['opener_href'] ?>'; return false;"><?php echo $list[$i]['bo_subject'] ?></a>
            <span class="scrap_datetime"><?php echo $list[$i]['ms_datetime'] ?></span>
            <a href="<?php echo $list[$i]['del_href'];  ?>" onclick="del(this.href); return false;" class="scrap_del"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_close.svg"></a>
        </li>
        <?php }  ?>

        <?php if ($i == 0) echo "<li class=\"empty_li\">자료가 없습니다.</li>";  ?>
    </ul>
    <?php echo get_paging($config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?>

    <div class="win_btn">
        <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
    </div>
</div>
<!-- } 스크랩 목록 끝 -->