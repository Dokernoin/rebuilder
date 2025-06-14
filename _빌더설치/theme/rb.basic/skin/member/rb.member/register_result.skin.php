<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

$partner_add = isset($_GET['partner']) ? $_GET['partner'] : '';
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
          
            <li class="rb_login_logo">
            
                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
                    
            </li>
            
            <?php if($partner_add == "1" || $partner_add == "2") { ?>

                <?php if($partner_add == "1") { ?>
                <li class="rb_reg_ok_text font-B">입점사 전환 신청이 완료 되었어요 :D</li>
                <li class="rb_reg_sub_title">
                    관리자 승인 이후 입점사 전용 서비스를 이용하실 수 있어요!<br>
                    신청 결과는 알림을 확인해주세요.
                </li>
                <?php } else { ?>
                <li class="rb_reg_ok_text font-B">입점사 전환이 완료 되었어요 :D</li>
                <li class="rb_reg_sub_title">
                    입점사 전용 서비스를 바로 이용하실 수 있어요!<br>
                    신청 결과는 알림을 확인해주세요.
                </li>
                <?php } ?>

            <?php } else { ?>
            
                <?php if (is_use_email_certify()) {  ?>
                     <li class="rb_reg_ok_text font-B">인증메일이 발송 되었어요 :D</li>
                     <li class="rb_reg_sub_title"><?php echo $mb['mb_email'] ?> 으로 발송된 인증메일을 확인해주세요!<br>이메일 주소가 잘못되었다면 관리자에게 문의해주세요.</li>
                <?php } else { ?>
                    <li class="rb_reg_ok_text font-B">회원가입이 완료 되었어요 :D</li>
                    <li class="rb_reg_sub_title">
                        <?php echo get_text($mb['mb_name']); ?>님 안녕하세요!<br>
                        <?php echo $config['cf_title'] ?> 에 오신것을 진심으로 환영해요!

                        <?php if($config['cf_register_point']) { ?>
                        <br><br><b class="font-B"><?php echo number_format($config['cf_register_point']); ?> 포인트</span>가 지급 되었어요.
                        <?php } ?>

                    </li>
                <?php } ?>

            <?php } ?>


            <li class="join_links">
                <a href="<?php echo G5_URL ?>" class="font-B">메인으로</a>
            </li>
            
        </ul>
        </form>
        
    </div>
</div>

