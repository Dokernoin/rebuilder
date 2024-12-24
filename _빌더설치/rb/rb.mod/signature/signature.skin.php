<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
if(isset($sb['sb_use']) && $sb['sb_use'] == 1) {
    $sb_is = sb_is($view['mb_id']);
}
?>


<?php if($view['mb_id']) { ?>
    <div class="writer_prof">
        <ul class="writer_prof_ul1">
            <li class="writer_prof_li_prof">
                <dd class="writer_prof_li_prof_img"><?php echo get_member_profile_img($view['mb_id']) ?></dd>
                <dd class="writer_prof_li_prof_txt">
                <span class="prof_nick"><?php echo $view['name'] ?></span>
                @<?php echo $view['mb_id'] ?>　<?php if(isset($sb['sb_use']) && $sb['sb_use'] == 1) { // 구독 사용시 ?><?php echo sb_cnt($view['mb_id']) ?><?php } ?>
                </dd>
                <div class="cb"></div>
            </li>
            <?php if ($is_signature && $signature) { ?>
            <li class="writer_prof_li_txt">
                <?php echo $signature ?>
            </li>
            <?php } ?>

        </ul>
        <ul class="writer_prof_ul2">
           
            <?php if($is_member) { ?>
            <a class="fl_btns" href="<?php echo G5_URL ?>/rb/home.php?mb_id=<?php echo $view['mb_id'] ?>">
            <?php } else { ?>
            <a class="fl_btns" href="javascript:alert('로그인 후 이용해주세요.');">
            <?php } ?>
               <img src="<?php echo $board_skin_url ?>/img/ico_home.svg">
               <span class="tooltips">미니홈</span>
            </a>

            
            <a class="fl_btns" href="<?php echo G5_BBS_URL ?>/memo_form.php?me_recv_mb_id=<?php echo $view['mb_id'] ?>" onclick="win_memo(this.href); return false;">
               <img src="<?php echo $board_skin_url ?>/img/ico_msg.svg">
               <span class="tooltips">쪽지</span>
            </a>
            
            <?php 
                if(isset($sb['sb_use']) && $sb['sb_use'] == 1) { // 구독 사용시 
                    $sb_mb_id = $view['mb_id'];
                    include_once(G5_PATH.'/rb/rb.mod/subscribe/subscribe.skin.php');
                }
            ?>

        </ul>
        <div class="cb"></div>
    </div>
<?php } ?>          