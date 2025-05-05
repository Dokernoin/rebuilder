<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<style>
    body,html {background-color: #f9fafb;}
    main {background-color: #f9fafb;}
    #container_title {display: none;}
    #header {display: none;}
    .contents_wrap {padding: 0px !important;}
    .sub {padding-top: 0px;}
    #rb_topvisual {display: none;}
</style>

<div class="rb_member">
    <div class="rb_login rb_reg">

        <form name="fmemberconfirm" action="<?php echo $url ?>" onsubmit="return fmemberconfirm_submit(this);" method="post">
        <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
        <input type="hidden" name="w" value="u">
           
            <ul class="rb_login_box">
                <li class="rb_login_logo">
                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
                </li>
                <li class="rb_reg_ok_text font-B"><?php echo $g5['title'] ?></li>
                <li class="rb_reg_sub_title">
                    비밀번호를 한번 더 입력해주세요.<br>
                    <?php if ($url == 'member_leave.php') { ?>
                    비밀번호를 입력하시면 회원탈퇴가 완료됩니다.<br>
                    회원탈퇴시 동일 아이디로 재가입이 불가능하며, 보유하신<br>
                    포인트 등의 개인정보는 모두 삭제됩니다.
                    <?php }else{ ?>
                    개인정보 보호를 위해 비밀번호를 한번 더 확인할께요.
                    <?php }  ?>
                </li>
                <li>
                    <input type="password" name="mb_password" id="confirm_mb_password" required class="required input" maxLength="20" placeholder="비밀번호">
                </li>
                <li>
                    <div class="btn_confirm">
                        <button type="submit" class="btn_submit font-B">확인</button>
                    </div>
                </li>
                <li class="join_links">
                    <a href="<?php echo G5_URL ?>" class="font-B">메인으로</a>
                </li>
            </ul>
            
        </form>

    </div>
</div>



<script>
function fmemberconfirm_submit(f)
{
    document.getElementById("btn_submit").disabled = true;

    return true;
}
</script>
<!-- } 회원 비밀번호 확인 끝 -->
