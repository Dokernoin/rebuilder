<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$config['cf_social_login_use']) {     //소셜 로그인을 사용하지 않으면
    return;
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/remodal/remodal.css">', 11);
add_stylesheet('<link rel="stylesheet" href="'.G5_JS_URL.'/remodal/remodal-default-theme.css">', 12);
add_stylesheet('<link rel="stylesheet" href="'.get_social_skin_url().'/style.css?ver='.G5_CSS_VER.'">', 13);
add_javascript('<script src="'.G5_JS_URL.'/remodal/remodal.js"></script>', 10);
add_javascript('<script src="'.G5_JS_URL.'/jquery.register_form.js"></script>', 14);
if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp']))
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 15);

$email_msg = $is_exists_email ? '등록할 이메일이 중복되었습니다.다른 이메일을 입력해 주세요.' : '';

add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
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
    <div class="rb_login rb_reg rb_join">

        <form name="fregisterform" id="fregisterform" action="<?php echo $register_action_url; ?>" onsubmit="return fregisterform_submit(this);" method="POST" autocomplete="off">
        <ul class="rb_login_box">

            <li class="rb_login_logo">
                <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
            </li>
            <li class="rb_reg_sub_title">안녕하세요! <?php echo $config['cf_title'] ?> 에 오신것을 진심으로 환영해요!<br>다양한 이벤트와 풍성한 혜택 받아가세요 :D</li>


            <li>
                <span>회원가입약관</span>
                <textarea readonly class="textarea"><?php echo get_text($config['cf_stipulation']) ?></textarea>
                <div class="mt-10">
                    <input type="checkbox" name="agree" value="1" id="agree11">
                    <label for="agree11">회원가입약관의 내용에 동의합니다.</label>
                </div>
            </li>
            <li>
                <span>개인정보 수집 및 이용정책</span>
                <textarea readonly class="textarea"><?php echo get_text($config['cf_privacy']) ?></textarea>
                <div class="mt-10">
                    <input type="checkbox" name="agree2" value="1" id="agree21">
                    <label for="agree21">개인정보 수집 및 이용정책의 내용에 동의합니다.</label>
                </div>
            </li>

            <li>
                <div id="fregister_chkall" class="chk_all">
                    <input type="checkbox" name="chk_all" id="chk_all">
                    <label for="chk_all">회원가입 약관에 모두 동의합니다</label>
                </div>
            </li>


            <?php if (isset($config['cf_use_promotion']) && (int)$config['cf_use_promotion'] === 1) { ?>

                <li>
                    <span>수신설정</span>


                        <!-- (선택) 마케팅 목적의 개인정보 수집 및 이용 -->
                        <div class="alt_boxs">

                                <!-- (선택) 광고성 정보 수신 동의 (상위) -->
                                <ul class="">
                                        <input type="checkbox" name="mb_marketing_agree" value="1" id="reg_mb_marketing_agree" aria-describedby="desc_marketing" <?php echo !empty($member['mb_marketing_agree']) ? 'checked' : ''; ?> class="selec_chk marketing-sync">
                                        <label for="reg_mb_marketing_agree">(선택) 마케팅 목적의 개인정보 수집 및 이용</label>
                                        <button type="button" class="js-open-consent" data-title="마케팅 목적의 개인정보 수집 및 이용" data-template="#tpl_marketing" data-check="#reg_mb_marketing_agree" aria-controls="consentDialog">자세히보기</button>
                                </ul>
                                <input type="hidden" name="mb_marketing_agree_default" value="<?php echo isset($member['mb_marketing_agree']) ? htmlspecialchars((string)$member['mb_marketing_agree'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div id="desc_marketing" class="sound_only">마케팅 목적의 개인정보 수집·이용에 대한 안내입니다. 자세히보기를 눌러 전문을 확인할 수 있습니다.</div>


                                <template id="tpl_marketing">
                                    * 목적: 서비스 마케팅 및 프로모션<br>
                                    * 항목: 이름, 이메일<?php echo (!empty($config['cf_use_hp']) || (!empty($config["cf_cert_use"]) && (!empty($config['cf_cert_hp']) || !empty($config['cf_cert_simple'])))) ? ", 휴대폰 번호" : ""; ?><br>
                                    * 보유기간: 회원 탈퇴 시까지<br>
                                    동의를 거부하셔도 서비스 기본 이용은 가능하나, 맞춤형 혜택 제공은 제한될 수 있습니다.
                                </template>

                                <ul class="">
                                    <input type="checkbox" name="mb_promotion_agree" value="1" id="reg_mb_promotion_agree" aria-describedby="desc_promotion" class="selec_chk marketing-sync parent-promo">
                                    <label for="reg_mb_promotion_agree">(선택) 광고성 정보 수신 동의</label>
                                    <button type="button" class="js-open-consent" data-title="광고성 정보 수신 동의" data-template="#tpl_promotion" data-check="#reg_mb_promotion_agree" data-check-group=".child-promo" aria-controls="consentDialog">자세히보기</button>
                                </ul>
                                <div id="desc_promotion" class="sound_only">광고성 정보(이메일/SMS·카카오톡) 수신 동의의 상위 항목입니다. 자세히보기를 눌러 전문을 확인할 수 있습니다.</div>

                                <!-- 하위 채널(이메일/SMS) -->
                                <ul class="desc_sub">
                                    <input type="checkbox" name="mb_mailling" value="1" id="reg_mb_mailling" <?php echo !empty($member['mb_mailling']) ? 'checked' : ''; ?> class="selec_chk child-promo">
                                    <label for="reg_mb_mailling">광고성 이메일 수신 동의</label>
                                </ul>
                                <input type="hidden" name="mb_mailling_default" value="<?php echo isset($member['mb_mailling']) ? htmlspecialchars((string)$member['mb_mailling'], ENT_QUOTES, 'UTF-8') : ''; ?>">


                                <!-- 휴대폰번호 입력 보이기 or 필수입력일 경우에만 -->
                                <?php if (!empty($config['cf_use_hp']) || !empty($config['cf_req_hp']) || !empty($app['ap_title']) && !empty($app['ap_key']) && !empty($app['ap_pid'])) { ?>
                                <ul class="desc_sub">
                                    <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo !empty($member['mb_sms']) ? 'checked' : ''; ?> class="selec_chk child-promo">
                                    <label for="reg_mb_sms">광고성 SMS / 알림톡 <?php if (!empty($app['ap_title']) && !empty($app['ap_key']) && !empty($app['ap_pid'])) { ?><?php if($config['cf_use_hp']) { ?>/ <?php } ?>Push 알림 <?php } ?>수신동의</label>
                                </ul>
                                <input type="hidden" name="mb_sms_default" value="<?php echo isset($member['mb_sms']) ? htmlspecialchars((string)$member['mb_sms'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <?php } ?>
                                <template id="tpl_promotion">
                                    수집·이용에 동의한 개인정보를 이용하여 이메일/SMS/카카오톡 등으로 오전 8시~오후 9시에 광고성 정보를 전송할 수 있습니다.<br>
                                    동의는 언제든지 마이페이지에서 철회할 수 있습니다.
                                </template>

                                <!-- (선택) 개인정보 제3자 제공 동의 -->
                                <!-- SMS 사용시에만 -->
                                <?php
                                    $configKeys = ['cf_sms_use'];
                                    $companies = ['icode' => '아이코드'];

                                    $usedCompanies = array();
                                    foreach ($configKeys as $key) {
                                        if (!empty($config[$key]) && isset($companies[$config[$key]])) {
                                            $usedCompanies[] = $companies[$config[$key]];
                                        }
                                    }
                                ?>

                                <?php if (!empty($usedCompanies)) { ?>
                                <ul class="">
                                    <input type="checkbox" name="mb_thirdparty_agree" value="1" id="reg_mb_thirdparty_agree" aria-describedby="desc_thirdparty" <?php echo !empty($member['mb_thirdparty_agree']) ? 'checked' : ''; ?> class="selec_chk marketing-sync">
                                    <label for="reg_mb_thirdparty_agree">(선택) 개인정보 제3자 제공 동의</label>
                                    <button type="button" class="js-open-consent" data-title="개인정보 제3자 제공 동의" data-template="#tpl_thirdparty" data-check="#reg_mb_thirdparty_agree" aria-controls="consentDialog">자세히보기</button>
                                </ul>

                                <input type="hidden" name="mb_thirdparty_agree_default" value="<?php echo isset($member['mb_thirdparty_agree']) ? htmlspecialchars((string)$member['mb_thirdparty_agree'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                                <div id="desc_thirdparty" class="sound_only">개인정보 제3자 제공 동의에 대한 안내입니다. 자세히보기를 눌러 전문을 확인할 수 있습니다.</div>

                                <template id="tpl_thirdparty">
                                    * 목적: 상품/서비스, 사은/판촉행사, 이벤트 등의 마케팅 안내(카카오톡 등)<br>
                                    * 항목: 이름, 휴대폰 번호<br>
                                    * 제공받는 자: <?php echo implode(', ', $usedCompanies); ?><br>
                                    * 보유기간: 제공 목적 서비스 기간 또는 동의 철회 시까지
                                </template>
                                <?php } ?>

                        </div>



                </li>

                <?php } ?>



            <!-- 새로가입 시작 -->
            <input type="hidden" name="w" value="<?php echo $w; ?>">
            <input type="hidden" name="url" value="<?php echo $urlencode; ?>">
            <input type="hidden" name="provider" value="<?php echo $provider_name; ?>">
            <input type="hidden" name="action" value="register">
            <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
            <input type="hidden" name="cert_no" value="">
            <input type="hidden" name="mb_id" value="<?php echo $user_id; ?>" id="reg_mb_id">

            <?php if ($config["cf_cert_use"]) { ?>
                <input type="hidden" id="reg_mb_name" name="mb_name" value="<?php echo $user_name ? $user_name : $user_nick ?>">
            <?php } ?>
            <?php if ($config['cf_use_hp'] || ($config["cf_cert_use"] && ($config['cf_cert_hp'] || $config['cf_cert_simple']))) {  ?>
                <input type="hidden" name="mb_hp" value="<?php echo get_text($user_phone); ?>" id="reg_mb_hp">
                <?php if ($config['cf_cert_use'] && ($config['cf_cert_hp'] || $config['cf_cert_simple'])) { ?>
                    <input type="hidden" name="old_mb_hp" value="<?php echo get_text($user_phone); ?>">
                <?php } ?>
            <?php }  ?>


            <?php if ($config['cf_cert_use']) { ?>
            <li>
                   <span>본인확인</span>
                    <?php
                            if ($config['cf_cert_simple']) {
                                echo '<button type="button" id="win_sa_kakao_cert" class="btn_frmline win_sa_cert" data-type="">간편인증</button>'.PHP_EOL;
                            }
                            if ($config['cf_cert_hp'])
                                echo '<button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>' . PHP_EOL;
                            if ($config['cf_cert_ipin'])
                                echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>' . PHP_EOL;

                        ?>

            </li>
            <?php } ?>

            <?php if ($req_nick) {  ?>
            <li>
                <span>닉네임</span>
                <input type="hidden" name="mb_nick_default" value="<?php echo isset($user_nick) ? get_text($user_nick) : ''; ?>">
                <input type="text" name="mb_nick" value="<?php echo isset($user_nick) ? get_text($user_nick) : ''; ?>" id="reg_mb_nick" required class="input required nospace full_input" maxlength="20" placeholder="닉네임">
            </li>
            <?php }  ?>

            <li>
                <span>이메일</span>
                <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
	            <input type="text" name="mb_email" value="<?php echo isset($user_email) ? $user_email : ''; ?>" id="reg_mb_email" required <?php echo (isset($user_email) && $user_email != '' && !$is_exists_email)? "readonly":''; ?> class="input email full_input required" maxlength="100" placeholder="이메일">
                <?php if ($config['cf_use_email_certify']) { ?>
                    <?php if ($w=='') { echo "<span class='help_text'>이메일 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.</span>"; }  ?>
                    <?php if ($w=='u') { echo "<span class='help_text'>이메일을 변경하시면 다시 인증하셔야 합니다.</span>"; }  ?>
                <?php } ?>
            </li>



            <li>
            <div class="btn_confirm">
                <button type="submit" class="btn_submit font-B" accesskey="s"><?php echo $w == '' ? '회원가입' : '정보수정'; ?></button>
            </div>
            </li>




            <li class="join_links">
                나중에 가입할래요.　<a href="<?php echo G5_URL ?>" class="font-B">회원가입 취소</a>
            </li>

        </ul>
        </form>

    </div>
</div>












<!--

<div class="member_connect">
    <p class="strong">혹시 기존 회원이신가요?</p>
    <button type="button" class="connect-opener btn-txt" data-remodal-target="modal">
        기존 계정에 연결하기
        <i class="fa fa-angle-double-right"></i>
    </button>
</div>

<div id="sns-link-pnl" class="remodal" data-remodal-id="modal" role="dialog" aria-labelledby="modal1Title" aria-describedby="modal1Desc">
    <button type="button" class="connect-close" data-remodal-action="close">
        <i class="fa fa-close"></i>
        <span class="txt">닫기</span>
    </button>
    <div class="connect-fg">
        <form method="post" action="<?php echo $login_action_url ?>" onsubmit="return social_obj.flogin_submit(this);">
            <input type="hidden" id="url" name="url" value="<?php echo $login_url ?>">
            <input type="hidden" id="provider" name="provider" value="<?php echo $provider_name ?>">
            <input type="hidden" id="action" name="action" value="social_account_linking">

            <div class="connect-title">기존 계정에 연결하기</div>

            <div class="connect-desc">
                기존 아이디에 SNS 아이디를 연결합니다.<br>
                이 후 SNS 아이디로 로그인 하시면 기존 아이디로 로그인 할 수 있습니다.
            </div>

            <div id="login_fs">
                <label for="login_id" class="login_id">아이디 (필수)</label>
                <span class="lg_id"><input type="text" name="mb_id" id="login_id" class="frm_input required" size="20" maxLength="20"></span>
                <label for="login_pw" class="login_pw">비밀번호 (필수)</label>
                <span class="lg_pw"><input type="password" name="mb_password" id="login_pw" class="frm_input required" size="20" maxLength="20"></span>
                <br>
                <input type="submit" value="연결하기" class="login_submit btn_submit">
            </div>

        </form>
    </div>
</div>

-->

<?php
$path = __DIR__ . '/consent_modal.inc.php';
if (is_file($path)) {
    include_once $path;
}
?>

<script>
    $(function() {
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });

        $("#reg_zip_find").css("display", "inline-block");
        var pageTypeParam = "pageType=register";

        <?php if ($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
            // 이니시스 간편인증
            var url = "<?php echo G5_INICERT_URL; ?>/ini_request.php";
            var type = "";
            var params = "";
            var request_url = "";

            $(".win_sa_cert").click(function() {
                if (!cert_confirm()) return false;
                type = $(this).data("type");
                params = "?directAgency=" + type + "&" + pageTypeParam;
                request_url = url + params;
                call_sa(request_url);
            });
        <?php } ?>
        <?php if ($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
            // 아이핀인증
            var params = "";
            $("#win_ipin_cert").click(function() {
                if (!cert_confirm()) return false;
                params = "?" + pageTypeParam;
                var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php" + params;
                certify_win_open('kcb-ipin', url);
                return;
            });

        <?php } ?>
        <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
            // 휴대폰인증
            var params = "";
            $("#win_hp_cert").click(function() {
                if (!cert_confirm()) return false;
                params = "?" + pageTypeParam;
                <?php
                switch ($config['cf_cert_hp']) {
                    case 'kcb':
                        $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                        $cert_type = 'kcb-hp';
                        break;
                    case 'kcp':
                        $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                        $cert_type = 'kcp-hp';
                        break;
                    case 'lg':
                        $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                        $cert_type = 'lg-hp';
                        break;
                    default:
                        echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                        echo 'return false;';
                        break;
                }
                ?>

                certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>" + params);
                return;
            });
        <?php } ?>

        //tooltip
        $(document).on("click", ".tooltip_icon", function(e) {
            $(this).next(".tooltip").fadeIn(400).css("display", "inline-block");
        }).on("mouseout", ".tooltip_icon", function(e) {
            $(this).next(".tooltip").fadeOut();
        });
    });

    // submit 최종 폼체크
    function fregisterform_submit(f) {

        if (!f.agree.checked) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree.focus();
            return false;
        }

        if (!f.agree2.checked) {
            alert("개인정보 수집 및 이용의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            f.agree2.focus();
            return false;
        }

        <?php if ($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
            // 본인확인 체크
            if (f.cert_no.value == "") {
                alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
                return false;
            }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    function flogin_submit(f) {
        var mb_id = $.trim($(f).find("input[name=mb_id]").val()),
            mb_password = $.trim($(f).find("input[name=mb_password]").val());

        if (!mb_id || !mb_password) {
            return false;
        }

        return true;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const parentPromo = document.getElementById('reg_mb_promotion_agree');
        const childPromo  = Array.from(document.querySelectorAll('.child-promo'));
        if (!parentPromo || childPromo.length === 0) return;

        const syncParentFromChildren = () => {
            const anyChecked = childPromo.some(cb => cb.checked);
            parentPromo.checked = anyChecked; // 하나라도 체크되면 부모 체크
        };

        const syncChildrenFromParent = () => {
            const isChecked = parentPromo.checked;
            childPromo.forEach(cb => {
            cb.checked = isChecked;
            cb.dispatchEvent(new Event('change', { bubbles: true }));
            });
        };

        syncParentFromChildren();

        parentPromo.addEventListener('change', syncChildrenFromParent);
        childPromo.forEach(cb => cb.addEventListener('change', syncParentFromChildren));
    });
</script>

<!-- } 회원정보 입력/수정 끝 -->
