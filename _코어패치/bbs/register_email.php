<?php
include_once('./_common.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

$g5['title'] = '메일인증 메일주소 변경';
include_once('./_head.php');

$mb_id = isset($_GET['mb_id']) ? substr(clean_xss_tags($_GET['mb_id']), 0, 20) : '';
$sql = " select mb_email, mb_datetime, mb_ip, mb_email_certify, mb_id from {$g5['member_table']} where mb_id = '{$mb_id}' ";
$mb = sql_fetch($sql);

if(! (isset($mb['mb_id']) && $mb['mb_id'])){
    alert("해당 회원이 존재하지 않습니다.", G5_URL);
}

if (substr($mb['mb_email_certify'],0,1)!=0) {
    alert("이미 메일인증 하신 회원입니다.", G5_URL);
}

$ckey = isset($_GET['ckey']) ? trim($_GET['ckey']) : '';
$key  = md5($mb['mb_ip'].$mb['mb_datetime']);

if(!$ckey || $ckey != $key)
    alert('올바른 방법으로 이용해 주십시오.', G5_URL);
?>




<style>
    body, html {background-color: #f9fafb;}
    main {background-color: #f9fafb;}
    #container_title {display: none;}
    #header {display: none;}
    .contents_wrap {padding: 0px !important;}
    .sub {padding-top: 0px;}
</style>

<div class="rb_member">
    <div class="rb_login rb_reg">

        <form method="post" name="fregister_email" action="<?php echo G5_HTTPS_BBS_URL.'/register_email_update.php'; ?>" onsubmit="return fregister_email_submit(this);">
        <input type="hidden" name="mb_id" value="<?php echo $mb_id; ?>">

        <ul class="rb_login_box">

                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>


                 <li class="rb_reg_ok_text font-B">인증메일 변경</li>
                 <li class="rb_reg_sub_title">메일인증을 받지 못한 경우 이메일 주소를<br>변경 할 수 있어요.</li>

            <li>
                <span>변경할 이메일주소</span>
                <input type="text" name="mb_email" id="reg_mb_email" required class="input email required" maxlength="100" value="<?php echo $mb['mb_email']; ?>">
            </li>
            <li>
                <div>
                    <?php echo captcha_html(); ?>
                </div>
            </li>


            <li>
            <div class="btn_confirm">
                <button type="submit" class="btn_submit font-B">인증메일 변경</button>
            </div>
            </li>




            <li class="join_links">
                <a href="<?php echo G5_URL ?>" class="font-B">변경취소</a>
            </li>

        </ul>
        </form>

    </div>
</div>










<script>
function fregister_email_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<?php
include_once('./_tail.php');
