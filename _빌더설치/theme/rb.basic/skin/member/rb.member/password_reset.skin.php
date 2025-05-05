<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="' . $member_skin_url . '/style.css">', 0);
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

        <form name="fpasswordreset" action="<?php echo $action_url; ?>" onsubmit="return fpasswordreset_submit(this);" method="post" autocomplete="off">
           
            <ul class="rb_login_box">
                <li class="rb_login_logo">
                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
                </li>
                <li class="rb_reg_ok_text font-B">비밀번호 재설정</li>
                <li class="rb_reg_sub_title">새로운 비밀번호를 입력해주세요.</li>
                <li>
                    <div>
                        <input type="password" name="mb_password" id="mb_pw" required class="required input full_input" placeholder="새 비밀번호">
                    </div>
                    <div class="mt-10">
                        <input type="password" name="mb_password_re" id="mb_pw2" required class="required input full_input" placeholder="새 비밀번호 확인">
                    </div>
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
    function fpasswordreset_submit(f) {
        if ($("#mb_pw").val() == $("#mb_pw2").val()) {
            alert("비밀번호 변경되었습니다. 다시 로그인해 주세요.");
        } else {
            alert("새 비밀번호와 비밀번호 확인이 일치하지 않습니다.");
            return false;
        }
    }
</script>
<!-- } 비밀번호 재설정 끝 -->
