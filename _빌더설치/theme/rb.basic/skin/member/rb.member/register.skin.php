<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

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
       
        <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">
        <ul class="rb_login_box">
          
            <li class="rb_login_logo">
                <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                        <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>
            </li>
            <li class="rb_reg_sub_title">안녕하세요! <?php echo $config['cf_title'] ?> 에 오신것을 진심으로 환영해요!<br>다양한 이벤트와 풍성한 혜택 받아가세요 :D</li>
           
            <?php if($config['cf_social_login_use'] == 1) { ?>
            <li class="sns_reg_wrap">
                <span class="sns_titles">SNS로 간편하게 가입하기</span>
                <?php
                // 소셜로그인 사용시 소셜로그인 버튼
                @include_once(get_social_skin_path().'/social_register.skin.php');
                ?>
            </li>
            <?php } ?>
           
            <?php 
            if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($pa['pa_use']) && $pa['pa_use'] == 1) { 
                if(isset($pa['pa_add_use']) && $pa['pa_add_use'] == 1) {
                    $is_mb_partner = 2;
                } else { 
                    $is_mb_partner = 1;
                }
            ?>
            <li>
                <span>회원유형</span>
                
                <div>
                    <label class="switch_rb">
                        <input type="radio" name="mb_partner" value="0" id="mem_st1" onchange="setDisplay()">
                        <span class="toggle_btn">
                            <span class="tog_txt">일반회원</span>
                        </span>

                    </label>
                    <label class="switch_rb fr">
                        <input type="radio" name="mb_partner" value="<?php echo $is_mb_partner ?>" id="mem_st2" onchange="setDisplay()">
                        <span class="toggle_btn">
                            <span class="tog_txt">입점사</span>
                        </span>
                    </label>
                    <div class="cb"></div>
                </div>
                <div class="help_st1" id="help_st1">
                    일반회원으로 가입 합니다.<br>
                    가입즉시 다양한 서비스를 이용하실 수 있습니다.
                </div>
                <div class="help_st2" id="help_st1">
                    <?php if(isset($pa['pa_add_use']) && $pa['pa_add_use'] == 1) { ?>
                    입점사 회원으로 가입 합니다.<br>
                    가입즉시 입점사 전용 시스템을 사용할 수 있습니다.
                    <?php } else { ?>
                    입점사 회원 으로 가입신청 합니다.<br>
                    관리자 승인 후 입점사 전용 시스템을 사용할 수 있습니다.
                    <?php } ?>
                </div>


                <script>
                    $('.help_st1').hide();
                    $('.help_st2').hide();

                    function setDisplay() {
                        if ($('input:radio[id=mem_st1]').is(':checked')) {
                            $('.help_st1').show();
                            $('.help_st2').hide();
                        } else if ($('input:radio[id=mem_st2]').is(':checked')) {
                            $('.help_st1').hide();
                            $('.help_st2').show();
                        }
                    }
                </script>
            </li>
            <?php } ?>
            
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
            
            <li>
            <div class="btn_confirm">
                <button type="submit" class="btn_submit font-B">회원가입</button>
            </div>
            </li>
            


            
            <li class="join_links">
                나중에 가입할래요.　<a href="<?php echo G5_URL ?>" class="font-B">회원가입 취소</a>
            </li>
            
        </ul>
        </form>
        
    </div>
</div>


<script>
    function fregister_submit(f)
    {
        
        <?php if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($pa['pa_use']) && $pa['pa_use'] == 1) { ?>
        if ($(f).find('[name=mb_partner]:checked').length < 1 ) {
             alert("회원 유형을 선택해주세요.");
             return false;
        }
        <?php } ?>
        
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

        return true;
    }
    
    jQuery(function($){
        // 모두선택
        $("input[name=chk_all]").click(function() {
            if ($(this).prop('checked')) {
                $("input[name^=agree]").prop('checked', true);
            } else {
                $("input[name^=agree]").prop("checked", false);
            }
        });
    });

</script>
