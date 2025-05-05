<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

if($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js?v=<?php echo G5_JS_VER; ?>"></script>    
<?php } ?>



<style>
    body, html {background-color: #f9fafb;}
    main {background-color: #f9fafb;}
    #container_title {display: none;}
    #header {display: none;}
    .contents_wrap {padding: 0px !important;}
    .sub {padding-top: 0px;}
    #rb_topvisual {display: none;}
</style>

<div class="rb_member new_win<?php if($config['cf_cert_use'] != 0 && $config['cf_cert_find'] != 0) { ?> cert<?php } ?>" id="find_info">
    <div class="rb_login rb_reg">

        

            <ul class="rb_login_box">
                
                <form name="fpasswordlost" action="<?php echo $action_url ?>" onsubmit="return fpasswordlost_submit(this);" method="post" autocomplete="off">
                <input type="hidden" name="cert_no" value="">

                <li class="rb_login_logo">
                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
                
                </li>

                <li class="rb_reg_ok_text font-B">이메일로 찾기</li>
                <li class="rb_reg_sub_title">회원가입 시 등록하신 이메일 주소를 입력해 주세요.<br>아이디와 비밀번호를 보내드려요.</li>

                <li>
                    <input type="text" name="mb_email" id="mb_email" required class="required input full_input email" size="30" placeholder="이메일 주소를 입력하세요.">
                </li>
                <li>
                    <div>
                        <?php echo captcha_html(); ?>
                    </div>
                </li>

                <li>
                    <div class="btn_confirm">
                        <button type="submit" class="btn_submit font-B">인증메일 보내기</button>
                    </div>
                </li>


                </form>
                
                <?php if($config['cf_cert_use'] != 0 && $config['cf_cert_find'] != 0) { ?> 
                <br><br><br>
                
                <li class="rb_reg_ok_text font-B">본인인증으로 찾기</li>
                <li class="rb_reg_sub_title">이메일이 안오신다면 본인인증으로 찾을 수 있어요.</li>
                
                <li class="cert_btns">
                    <?php if(!empty($config['cf_cert_simple'])) { ?>
                        <button type="button" id="win_sa_kakao_cert" class="btn_frmline win_sa_cert" data-type="">간편인증</button>
                    <?php } if(!empty($config['cf_cert_hp']) || !empty($config['cf_cert_ipin'])) { ?>
                        <?php if(!empty($config['cf_cert_hp'])) { ?>
                        <button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>
                        <?php } if(!empty($config['cf_cert_ipin'])) { ?>
                        <button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>
                        <?php } ?>
                    <?php } ?>
                </li>
                <br><br>
                <?php } ?>
                
                
                
                <li class="join_links">
                    <a href="<?php echo G5_URL ?>" class="font-B">돌아가기</a>
                </li>
                
                
            </ul>
        
        

            
            

    </div>
</div>



<script>    
$(function() {
    $("#reg_zip_find").css("display", "inline-block");
    var pageTypeParam = "pageType=find";

	<?php if($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
	// TOSS 간편인증
	var url = "<?php echo G5_INICERT_URL; ?>/ini_request.php";
	var type = "";    
    var params = "";
    var request_url = "";
    
	
	$(".win_sa_cert").click(function() {
		type = $(this).data("type");
		params = "?directAgency=" + type + "&" + pageTypeParam;
        request_url = url + params;
        call_sa(request_url);
	});
    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
    // 아이핀인증
    var params = "";
    $("#win_ipin_cert").click(function() {
        params = "?" + pageTypeParam;
        var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php"+params;
        certify_win_open('kcb-ipin', url);
        return;
    });

    <?php } ?>
    <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
    // 휴대폰인증
    var params = "";
    $("#win_hp_cert").click(function() {
        params = "?" + pageTypeParam;
        <?php     
        switch($config['cf_cert_hp']) {
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
        
        certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>"+params);
        return;
    });
    <?php } ?>
});
function fpasswordlost_submit(f)
{
    <?php echo chk_captcha_js();  ?>

    return true;
}
</script>
<!-- } 회원정보 찾기 끝 -->
