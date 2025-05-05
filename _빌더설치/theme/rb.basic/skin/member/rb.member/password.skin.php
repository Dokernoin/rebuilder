<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$delete_str = "";
if ($w == 'x') $delete_str = "댓";
if ($w == 'u') $g5['title'] = $delete_str."글 수정";
else if ($w == 'd' || $w == 'x') $g5['title'] = $delete_str."글 삭제";
else $g5['title'] = $g5['title'];

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>


<style>
    body, html {background-color: #f9fafb;}
    main {background-color: #f9fafb;}
    #container_title {display: none;}
    #header {display: none;}
    .contents_wrap {padding: 0px !important;}
    .sub {padding-top: 0px;}
    #rb_topvisual {display: none;}
</style>


<div class="rb_member">
    <div class="rb_login rb_reg">

        

            <ul class="rb_login_box">
                
                <form name="fboardpassword" action="<?php echo $action;  ?>" method="post">
                <input type="hidden" name="w" value="<?php echo $w ?>">
                <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
                <input type="hidden" name="comment_id" value="<?php echo $comment_id ?>">
                <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
                <input type="hidden" name="stx" value="<?php echo $stx ?>">
                <input type="hidden" name="page" value="<?php echo $page ?>">

                <li class="rb_login_logo">
                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
                </li>

                <li class="rb_reg_ok_text font-B"><?php echo $g5['title'] ?></li>
                <li class="rb_reg_sub_title">
                    <?php if ($w == 'u') { ?>
                    작성자만 글을 수정할 수 있어요.<br>
                    글 작성시 입력한 비밀번호를 입력해주세요.
                    <?php } else if ($w == 'd' || $w == 'x') {  ?>
                    작성자만 글을 삭제할 수 있어요.<br>
                    글 작성시 입력한 비밀번호를 입력해주세요.
                    <?php } else {  ?>
                    비밀글은 작성자와 관리자만 열람할 수 있어요.<br>
                    비밀번호를 입력해주세요.
                    <?php }  ?>
                </li>

                <li>
                    <input type="password" name="wr_password" id="password_wr_password" required class="input required" maxLength="20" placeholder="비밀번호">
                </li>

                <li>
                    <div class="btn_confirm">
                        <button type="submit" class="btn_submit font-B">확인</button>
                    </div>
                </li>


                </form>
                
                
                
            </ul>
        


    </div>
</div>



