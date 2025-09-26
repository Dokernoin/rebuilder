<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if ($w == 'u') { 
    if(isset($pa['pa_is']) && $pa['pa_is'] == 1) {
        $re = isset($_GET['partner']) ? $_GET['partner'] : '';
        
        if($re == "re") { 
            if(isset($pa['pa_add_use']) && $pa['pa_add_use'] == 1) {
                $is_mb_partner = 2;
            } else { 
                $is_mb_partner = 1;
            }
        }
        
    }
}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery.register_form.js"></script>', 0);
if ($config['cf_cert_use'] && ($config['cf_cert_simple'] || $config['cf_cert_ipin'] || $config['cf_cert_hp']))
    add_javascript('<script src="'.G5_JS_URL.'/certify.js?v='.G5_JS_VER.'"></script>', 0);
?>

<!-- 회원정보 입력/수정 시작 { -->


<style>
    body,
    html {
        background-color: #f9fafb;
    }

    main {
        background-color: #f9fafb;
    }

    #container_title {
        display: none;
    }

    #header {
        display: none;
    }

    .contents_wrap {
        padding: 0px !important;
    }

    .sub {
        padding-top: 0px;
    }

    #rb_topvisual {
        display: none;
    }
</style>

<div class="rb_member">
    <div class="rb_login rb_reg rb_join">

        <form id="fregisterform" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="w" value="<?php echo $w ?>">
            <input type="hidden" name="url" value="<?php echo $urlencode ?>">
            <input type="hidden" name="agree" value="<?php echo $agree ?>">
            <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
            <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
            <input type="hidden" name="cert_no" value="">
            <input type="hidden" name="re" value="<?php echo isset($re) ? $re : ''; ?>">

            <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
            <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
            <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
            <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
            <?php }  ?>

            <?php if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($pa['pa_use']) && $pa['pa_use'] == 1) { ?>
            <?php if($w == "") { ?>
            <input type="hidden" name="mb_partner" value="<?php echo $_POST['mb_partner'] ?>">
            <?php } else { ?>
            <?php if (isset($re) && $re == "re") { ?>
            <input type="hidden" name="mb_partner" value="<?php echo $is_mb_partner ?>">
            <?php } else { ?>
            <input type="hidden" name="mb_partner" value="<?php echo isset($member['mb_partner']) ? get_text($member['mb_partner']) : ''; ?>">
            <?php } ?>
            <?php } ?>
            <?php } ?>

            <ul class="rb_login_box">

                <li class="rb_login_logo">

                    <?php if (!empty($rb_builder['bu_logo_pc'])) { ?>
                    <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } else { ?>
                    <a href="<?php echo G5_URL ?>"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" id="logo_img"></a>
                    <?php } ?>


                </li>

                <?php if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($pa['pa_use']) && $pa['pa_use'] == 1) { ?>
                <?php if($w == "" || isset($re) && $re == "re") { ?>
                <?php if(isset($_POST['mb_partner']) && $_POST['mb_partner'] == 1 || isset($re) && $re == "re") { ?>
                <?php if(isset($pa['pa_add_use']) && $pa['pa_add_use'] == 1) { ?>
                <li class="rb_reg_sub_title">입점사 회원으로 <?php if(isset($re) && $re == "re") { ?>전환<?php } ?>가입 합니다.</li>
                <?php } else { ?>
                <li class="rb_reg_sub_title">입점사 회원으로 <?php if(isset($re) && $re == "re") { ?>전환<?php } ?>가입 신청 합니다.<br>관리자 승인 이후 입점사 전용 서비스를 이용하실 수 있습니다.</li>
                <?php } ?>
                <?php } else { ?>
                <li class="rb_reg_sub_title">일반 회원으로 가입 합니다.</li>
                <?php } ?>
                <?php } ?>
                <?php } ?>

                <li>
                    <span>아이디</span>
                    <div class="input_wrap">
                        <input type="text" name="mb_id" value="<?php echo $member['mb_id'] ?>" id="reg_mb_id" <?php echo $required ?> <?php echo $readonly ?> class="input full_input <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="3글자 이상 (영문, 숫자, _ 입력가능)">
                        <button type="button" class="btn_frmline" onclick="checkDuplicate('id')">중복확인</button>
                    </div>
                    <span class="result_message main_color font-R" id="msg_mb_id"></span>
                </li>
                <li>
                    <span>비밀번호</span>
                    <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="input full_input <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호">
                    <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="input full_input mt-10 <?php echo $required ?>" minlength="3" maxlength="20" placeholder="비밀번호 확인">
                    <span class="result_message main_color font-R" id="msg_mb_password_re"></span>
                </li>


                <?php if ($config['cf_cert_use']) { ?>
                <li>
                    <span>본인확인</span>
                    <?php 
					$desc_name = '';
					$desc_phone = '';
					if ($config['cf_cert_use']) {
                        $desc_name = '<span class="cert_desc"> 본인확인 시 자동입력</span>';
                        $desc_phone = '<span class="cert_desc"> 본인확인 시 자동입력</span>';
    
                        if (!$config['cf_cert_simple'] && !$config['cf_cert_hp'] && $config['cf_cert_ipin']) {
                            $desc_phone = '';
                        }

	                    if ($config['cf_cert_simple']) {
                            echo '<button type="button" id="win_sa_kakao_cert" class="btn_frmline win_sa_cert" data-type="">간편인증</button>'.PHP_EOL;
						}
						if ($config['cf_cert_hp'])
							echo '<button type="button" id="win_hp_cert" class="btn_frmline">휴대폰 본인확인</button>'.PHP_EOL;
						if ($config['cf_cert_ipin'])
							echo '<button type="button" id="win_ipin_cert" class="btn_frmline">아이핀 본인확인</button>'.PHP_EOL;
	
	                    //echo '<noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>'.PHP_EOL;
	                }
	                ?>
                    <?php
	                if ($member['mb_certify']) {
						switch ($member['mb_certify']) {
							case "simple": 
								$mb_cert = "간편인증";
								break;
							case "ipin": 
								$mb_cert = "아이핀";
								break;
							case "hp": 
								$mb_cert = "휴대폰";
								break;
						}                 
	                ?>
                    <div id="msg_certify">
                        <strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료
                    </div>
                    <?php } ?>
                </li>
                <?php } ?>

                <li>
                    <span>이름</span>
                    <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $name_readonly; ?> class="input full_input <?php echo $required ?> <?php echo $name_readonly ?>" placeholder="이름 (실명)">
                </li>

                <?php if ($req_nick) {  ?>
                <li>
                    <span>닉네임
                    <div class="rb-help" data-open="false">
                        <button type="button" class="rb-help-btn"
                           data-img=""
                           data-txt="공백없이 한글, 영문, 숫자만 입력 가능 (한글 2글자, 영문 4글자 이상) 닉네임을 바꾸시면 <?php echo (int)$config['cf_nick_modify'] ?>일 이내에는 변경 할 수 없습니다."
                           data-title="닉네임 설정 도움말"
                           data-alt="도움말"
                           aria-expanded="false">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
                                <g fill='none'>
                                    <path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z' />
                                    <path fill='#DDDDDDFF' d='M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 14a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-9.5a3.625 3.625 0 0 0-3.625 3.625 1 1 0 1 0 2 0 1.625 1.625 0 1 1 2.23 1.51c-.676.27-1.605.962-1.605 2.115V14a1 1 0 1 0 2 0c0-.244.05-.366.261-.47l.087-.04A3.626 3.626 0 0 0 12 6.5' />
                                </g>
                            </svg>
                        </button>
                        <aside role="tooltip" class="rb-help-pop" aria-hidden="true"></aside>
                    </div>
                    </span>
                    <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                    <div class="input_wrap">
                        <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="input required nospace full_input" size="10" maxlength="20" placeholder="닉네임">
                        <button type="button" class="btn_frmline" onclick="checkDuplicate('nick')">중복확인</button>
                    </div>
                    <span class="result_message main_color font-R" id="msg_mb_nick"></span>
                </li>
                <?php }  ?>


                <li>
                    <span>이메일</span>
                    <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                    <div class="input_wrap">
                        <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="input email full_input required" maxlength="100" placeholder="이메일">
                        <button type="button" class="btn_frmline" onclick="checkDuplicate('email')">중복확인</button>
                    </div>
                    <span class="result_message main_color font-R" id="msg_mb_email"></span>
                    <?php if ($config['cf_use_email_certify']) { ?>
                    <?php if ($w=='') { echo "<span class='help_text'>이메일 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다.</span>"; }  ?>
                    <?php if ($w=='u') { echo "<span class='help_text'>이메일을 변경하시면 다시 인증하셔야 합니다.</span>"; }  ?>
                    <?php } ?>
                </li>

                <?php if ($config['cf_use_homepage']) {  ?>
                <li>
                    <span>
                    운영채널
                    <div class="rb-help" data-open="false">
                        <button type="button" class="rb-help-btn"
                           data-img=""
                           data-txt="운영중인 웹사이트, 쇼핑몰, 블로그, 유튜브, SNS 등의 채널이 있다면 입력해주세요. 대표채널 1개만 입력할 수 있습니다."
                           data-title="운영채널 설정 도움말"
                           data-alt="도움말"
                           aria-expanded="false">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
                                <g fill='none'>
                                    <path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z' />
                                    <path fill='#DDDDDDFF' d='M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 14a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-9.5a3.625 3.625 0 0 0-3.625 3.625 1 1 0 1 0 2 0 1.625 1.625 0 1 1 2.23 1.51c-.676.27-1.605.962-1.605 2.115V14a1 1 0 1 0 2 0c0-.244.05-.366.261-.47l.087-.04A3.626 3.626 0 0 0 12 6.5' />
                                </g>
                            </svg>
                        </button>
                        <aside role="tooltip" class="rb-help-pop" aria-hidden="true"></aside>
                    </div>
                    </span>
                    <input type="text" name="mb_homepage" value="<?php echo get_text($member['mb_homepage']) ?>" id="reg_mb_homepage" <?php echo $config['cf_req_homepage']?"required":""; ?> class="input full_input <?php echo $config['cf_req_homepage']?"required":""; ?>" maxlength="255" placeholder="http:// 또는 https:// 포함입력">
                </li>
                <?php } ?>

                <?php if ($config['cf_use_tel']) {  ?>
                <li>
                    <span>일반전화</span>
                    <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" <?php echo $config['cf_req_tel']?"required":""; ?> class="input full_input <?php echo $config['cf_req_tel']?"required":""; ?>" maxlength="20" placeholder="일반전화번호">
                </li>
                <?php }  ?>

                <?php if ($config['cf_use_hp'] || ($config["cf_cert_use"] && ($config['cf_cert_hp'] || $config['cf_cert_simple']))) {  ?>
                <li>
                    <span>휴대전화</span>
                    <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" <?php echo $hp_required; ?> <?php echo $hp_readonly; ?> class="input full_input <?php echo $hp_required; ?> <?php echo $hp_readonly; ?>" maxlength="20" placeholder="휴대전화번호">
                    <?php if ($config['cf_cert_use'] && ($config['cf_cert_hp'] || $config['cf_cert_simple'])) { ?>
                    <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                    <?php } ?>
                </li>
                <?php }  ?>

                <?php if ($config['cf_use_addr']) { ?>
                <li>
                    <span>주소</span>
                    <div>
                        <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="input twopart_input <?php echo $config['cf_req_addr']?"required":""; ?>" maxlength="6" placeholder="우편번호">
                        <button type="button" class="btn_frmline btn_win_zip" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>
                    </div>
                    <div class="mt-5">
                        <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="input frm_address full_input <?php echo $config['cf_req_addr']?"required":""; ?>" placeholder="기본주소">
                    </div>
                    <div class="mt-5">
                        <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="input frm_address full_input" placeholder="상세주소">
                    </div>
                    <div class="mt-5">
                        <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="input frm_address full_input" readonly="readonly" placeholder="참고항목">
                        <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
                    </div>
                </li>
                <?php }  ?>

                <?php if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($pa['pa_use']) && $pa['pa_use'] == 1) { ?>
                <?php if(isset($_POST['mb_partner']) && $_POST['mb_partner'] == 1 || isset($member['mb_partner']) && $member['mb_partner'] == 2 || isset($re) && $re == "re") { ?>
                <li>
                    <span>출금계좌</span>
                    <input type="text" name="mb_bank" value="<?php echo isset($member['mb_bank']) ? get_text($member['mb_bank']) : ''; ?>" id="reg_mb_bank" class="input full_input" placeholder="계좌번호/은행명/예금주명">
                    <span class="help_text">판매대금을 정산할 수 있는 계좌를 등록해주세요.</span>
                </li>
                <?php } ?>
                <?php } ?>



                <?php if ($config['cf_use_signature']) {  ?>
                <li>
                    <span>서명</span>
                    <textarea name="mb_signature" id="reg_mb_signature" <?php echo $config['cf_req_signature']?"required":""; ?> class="<?php echo $config['cf_req_signature']?"required":""; ?> textarea" placeholder="서명을 입력하세요."><?php echo $member['mb_signature'] ?></textarea>
                    <span class="help_text">프로필 페이지 및 게시물 하단 작성자정보에 노출 됩니다.</span>
                </li>
                <?php }  ?>

                <?php if ($config['cf_use_profile']) {  ?>
                <li>
                    <span>소개글</span>
                    <textarea name="mb_profile" id="reg_mb_profile" <?php echo $config['cf_req_profile']?"required":""; ?> class="<?php echo $config['cf_req_profile']?"required":""; ?> textarea" placeholder="소개글을 입력하세요."><?php echo $member['mb_profile'] ?></textarea>
                    <span class="help_text">프로필 페이지에 노출 됩니다.</span>
                </li>
                <?php }  ?>


                <?php if ($config['cf_use_member_icon'] && $member['mb_level'] >= $config['cf_icon_level']) {  ?>
                <li>
                    <span>회원아이콘</span>

                    <div>
                        <dd class="mem_imgs_dd1">
                            <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
                            <img src="<?php echo $mb_icon_url ?>" style="width:<?php echo $config['cf_member_icon_width'] ?>px; height:<?php echo $config['cf_member_icon_height'] ?>px;" id="mem_img_icon">
                            <?php } else { ?>
                            <img src="<?php echo G5_URL ?>/img/no_profile.gif" style="width:<?php echo $config['cf_member_icon_width'] ?>px; height:<?php echo $config['cf_member_icon_height'] ?>px;" id="mem_img_icon">
                            <?php } ?>

                        </dd>
                        <dd class="mem_imgs_dd2">
                            <input type="file" name="mb_icon" id="reg_mb_icon" class="input_tiny files_inp">
                            <span class="help_text">GIF, JPG, PNG 파일 (<?php echo $config['cf_member_icon_width'] ?>X<?php echo $config['cf_member_icon_height'] ?> / <?php echo byteFormat($config['cf_member_icon_size'], "MB"); ?> 이하)</span>
                            <?php if ($w == 'u' && file_exists($mb_icon_path)) {  ?>
                            <input type="checkbox" name="del_mb_icon" value="1" id="del_mb_icon"><label for="del_mb_icon" class="inline">삭제</label>
                            <?php } ?>
                        </dd>
                        <div class="cb"></div>

                    </div>

                </li>

                <script type="text/javascript">
                    var sel_file;
                    $(document).ready(function() {
                        $("#reg_mb_icon").on("change", handleImgFileSelect);
                    });

                    function handleImgFileSelect(e) {
                        var files = e.target.files;
                        var filesArr = Array.prototype.slice.call(files);

                        filesArr.forEach(function(f) {
                            if (!f.type.match("image.*")) {
                                alert("이미지 파일만 첨부해주세요.");
                                return;
                            }

                            sel_file = f;
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $("#mem_img_icon").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(f);
                        });
                    }
                </script>
                <?php } ?>



                <?php if ($member['mb_level'] >= $config['cf_icon_level'] && $config['cf_member_img_size'] && $config['cf_member_img_width'] && $config['cf_member_img_height']) {  ?>
                <li>
                    <span>회원이미지</span>

                    <div>
                        <dd class="mem_imgs_dd1">
                            <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
                            <img src="<?php echo $mb_img_url ?>" style="width:<?php echo $config['cf_member_img_width'] ?>px; height:<?php echo $config['cf_member_img_height'] ?>px;" id="mem_img_img">
                            <?php } else { ?>
                            <img src="<?php echo G5_URL ?>/img/no_profile.gif" style="width:<?php echo $config['cf_member_img_width'] ?>px; height:<?php echo $config['cf_member_img_height'] ?>px;" id="mem_img_img">
                            <?php } ?>

                        </dd>
                        <dd class="mem_imgs_dd2">
                            <input type="file" name="mb_img" id="reg_mb_img" class="input_tiny files_inp">
                            <span class="help_text">GIF, JPG, PNG 파일 (<?php echo $config['cf_member_img_width'] ?>X<?php echo $config['cf_member_img_height'] ?> / <?php echo byteFormat($config['cf_member_img_size'], "MB"); ?> 이하)</span>
                            <?php if ($w == 'u' && file_exists($mb_img_path)) {  ?>
                            <input type="checkbox" name="del_mb_img" value="1" id="del_mb_img"><label for="del_mb_img" class="inline">삭제</label>
                            <?php } ?>
                        </dd>
                        <div class="cb"></div>

                    </div>

                </li>

                <script type="text/javascript">
                    var sel_file2;
                    $(document).ready(function() {
                        $("#reg_mb_img").on("change", handleImgFileSelect2);
                    });

                    function handleImgFileSelect2(e) {
                        var files = e.target.files;
                        var filesArr = Array.prototype.slice.call(files);

                        filesArr.forEach(function(f) {
                            if (!f.type.match("image.*")) {
                                alert("이미지 파일만 첨부해주세요.");
                                return;
                            }

                            sel_file2 = f;
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $("#mem_img_img").attr("src", e.target.result);
                            }
                            reader.readAsDataURL(f);
                        });
                    }
                </script>
                <?php } ?>


                <?php if( $w == 'u' && function_exists('social_member_provider_manage') ){ ?>
                <?php social_member_provider_manage(); ?>
                <?php } ?>


                <li>
                
                    <span>
                    프로필 정보공개
                    <div class="rb-help" data-open="false">
                        <button type="button" class="rb-help-btn"
                           data-img=""
                           data-txt="정보공개를 하셔야만 쪽지를 사용할 수 있고, 활동 알림을 받으실 수 있습니다."
                           data-title="프로필 정보공개 도움말"
                           data-alt="도움말"
                           aria-expanded="false">
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'>
                                <g fill='none'>
                                    <path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z' />
                                    <path fill='#DDDDDDFF' d='M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2m0 14a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-9.5a3.625 3.625 0 0 0-3.625 3.625 1 1 0 1 0 2 0 1.625 1.625 0 1 1 2.23 1.51c-.676.27-1.605.962-1.605 2.115V14a1 1 0 1 0 2 0c0-.244.05-.366.261-.47l.087-.04A3.626 3.626 0 0 0 12 6.5' />
                                </g>
                            </svg>
                        </button>
                        <aside role="tooltip" class="rb-help-pop" aria-hidden="true"></aside>
                    </div>
                    </span>


                    <?php if (isset($member['mb_open_date']) && $member['mb_open_date'] <= date("Y-m-d", G5_SERVER_TIME - ($config['cf_open_modify'] * 86400)) || empty($member['mb_open_date'])) { // 정보공개 수정일이 지났다면 수정가능 ?>
                    <div class="alt_boxs">
                        <ul>
                        <input type="checkbox" name="mb_open" value="1" id="reg_mb_open" <?php echo ($w=='' || $member['mb_open'])?'checked':''; ?>>
                        <label for="reg_mb_open">프로필 정보공개 / 쪽지수신 동의</label>
                        <input type="hidden" name="mb_open_default" value="<?php echo $member['mb_open'] ?>">
                        </ul>
                    </div>


                    <?php if($config['cf_open_modify']) { ?>
                    <div class="help_t_text">
                        정보공개 항목을 변경 하시면 <?php echo (int)$config['cf_open_modify'] ?>일 이내에는 변경을 할 수 없어요.
                    </div>
                    <?php } ?>

                    <?php } else { ?>

                    <div class="alt_boxs">
                        <ul>
                        <input type="hidden" name="mb_open" value="<?php echo $member['mb_open'] ?>">
                        정보공개 항목을 최근에 변경하신적이 있어요.<br>
                        정보공개는 변경 후 <?php echo (int)$config['cf_open_modify'] ?>일 이내, <?php echo date("Y년 m월 j일", isset($member['mb_open_date']) ? strtotime("{$member['mb_open_date']} 00:00:00")+$config['cf_open_modify']*86400:G5_SERVER_TIME+$config['cf_open_modify']*86400); ?> 까지는 변경 할 수 없어요.
                        </ul>
                    </div>


                    <?php }  ?>


                </li>



                <?php if ($w == "" && $config['cf_use_recommend']) {  ?>
                <li>
                    <span>추천인아이디</span>
                    <input type="text" name="mb_recommend" id="reg_mb_recommend" class="input" placeholder="추천인아이디">
                    <span class="help_text">
                        추천인 아이디가 있다면 입력해주세요.
                        <?php if($config['cf_recommend_point'] > 0) { ?>
                        <br>입력하신 회원에게 감사의 표시로 <b class="font-B"><?php echo number_format($config['cf_recommend_point']) ?> 포인트</b>가 지급되요 :D
                        <?php } ?>
                    </span>
                </li>
                <?php }  ?>


                <!-- 회원가입 약관 동의에 광고성 정보 수신 동의 표시 여부가 사용시에만 -->
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
                                <?php
                                    if (!empty($member['mb_marketing_agree']) && !empty($member['mb_marketing_date']) && $member['mb_marketing_date'] !== "0000-00-00 00:00:00") {
                                        echo "<span class='help_text'>(동의일자: ".$member['mb_marketing_date'].")</span>";
                                    }
                                    ?>
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
                                    <?php
                                    if (isset($w) && $w === 'u' && !empty($member['mb_mailling']) && !empty($member['mb_mailling_date']) && $member['mb_mailling_date'] !== "0000-00-00 00:00:00") {
                                           echo "<span class='help_text'>(동의일자: ".$member['mb_mailling_date'].")</span>";
                                    }
                                    ?>


                                <!-- 휴대폰번호 입력 보이기 or 필수입력일 경우에만 -->
                                <?php if (!empty($config['cf_use_hp']) || !empty($config['cf_req_hp']) || !empty($app['ap_title']) && !empty($app['ap_key']) && !empty($app['ap_pid'])) { ?>
                                <ul class="desc_sub">
                                    <input type="checkbox" name="mb_sms" value="1" id="reg_mb_sms" <?php echo !empty($member['mb_sms']) ? 'checked' : ''; ?> class="selec_chk child-promo">
                                    <label for="reg_mb_sms">광고성 SMS / 알림톡 <?php if (!empty($app['ap_title']) && !empty($app['ap_key']) && !empty($app['ap_pid'])) { ?><?php if($config['cf_use_hp']) { ?>/ <?php } ?>Push 알림 <?php } ?>수신동의</label>
                                </ul>
                                <input type="hidden" name="mb_sms_default" value="<?php echo isset($member['mb_sms']) ? htmlspecialchars((string)$member['mb_sms'], ENT_QUOTES, 'UTF-8') : ''; ?>">

                                    <?php
                                    if (isset($w) && $w === 'u' && !empty($member['mb_sms']) && !empty($member['mb_sms_date']) && $member['mb_sms_date'] !== "0000-00-00 00:00:00") {
                                        echo "<span class='help_text'>(동의일자: ".$member['mb_sms_date'].")</span>";
                                    }
                                    ?>

                                <?php } ?>
                                <template id="tpl_promotion">
                                    수집·이용에 동의한 개인정보를 이용하여 이메일/SMS/ 등으로 오전 8시~오후 9시에 광고성 정보를 전송할 수 있습니다.<br>
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

                                    <?php
                                    if (!empty($member['mb_thirdparty_agree']) && !empty($member['mb_thirdparty_date']) && $member['mb_thirdparty_date'] !== "0000-00-00 00:00:00") {
                                        echo "<span class='help_text'>(동의일자: ".$member['mb_thirdparty_date'].")</span>";
                                    }
                                    ?>

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




                <li class="is_captcha_use">
                    <?php echo captcha_html(); ?>
                </li>



                <li>
                    <div class="btn_confirm">
                        <button type="submit" class="btn_submit font-B" accesskey="s"><?php if (isset($re) && $re == "re") { ?>전환가입<?php } else { ?><?php echo $w==''?'회원가입':'정보수정'; ?><?php } ?></button>

                        <?php if($w == 'u') { ?>
                        <button type="button" class="btn_submit font-B mt-10" onclick="javascript:member_leaves();" style="background-color:#f1f1f1 !important; color:#000;">회원탈퇴</button>

                        <script>
                            function member_leaves() { // 회원 탈퇴
                                if (confirm("탈퇴시 보유하신 포인트 및 기타 혜택, 개인정보 등\n모든 정보가 삭제 되며 동일 아이디로 재가입이 불가능합니다.\n\n정말 탈퇴 하시겠습니까?"))
                                    location.href = '<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php';
                            }
                        </script>
                        <?php } ?>
                    </div>
                </li>



                <li class="join_links">
                    <?php if($w == '') { ?>
                    나중에 가입할래요.　<a href="<?php echo G5_URL ?>" class="font-B">회원가입 취소</a>
                    <?php } else { ?>
                    <a href="<?php echo G5_URL ?>" class="font-B">취소</a>
                    <?php } ?>
                </li>

            </ul>
        </form>

    </div>
</div>

<?php
$path = __DIR__ . '/consent_modal.inc.php';
if (is_file($path)) {
    include_once $path;
}
?>


<script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");
        var pageTypeParam = "pageType=register";

        <?php if($config['cf_cert_use'] && $config['cf_cert_simple']) { ?>
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
        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
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
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        var params = "";
        $("#win_hp_cert").click(function() {
            if (!cert_confirm()) return false;
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

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>" + params);
            return;
        });
        <?php } ?>
    });

    // submit 최종 폼체크
    function fregisterform_submit(f) {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("비밀번호가 같지 않습니다.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value == "") {
            if (f.mb_name.value.length < 1) {
                alert("이름을 입력하십시오.");
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
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

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원아이콘이 이미지 파일이 아닙니다.");
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof f.mb_img != "undefined") {
            if (f.mb_img.value) {
                if (!f.mb_img.value.toLowerCase().match(/.(gif|jpe?g|png)$/i)) {
                    alert("회원이미지가 이미지 파일이 아닙니다.");
                    f.mb_img.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert("본인을 추천할 수 없습니다.");
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

    jQuery(function($) {
        //tooltip
        $(document).on("click", ".tooltip_icon", function(e) {
            $(this).next(".tooltip").fadeIn(400).css("display", "inline-block");
        }).on("mouseout", ".tooltip_icon", function(e) {
            $(this).next(".tooltip").fadeOut();
        });
    });

    // 미니님a님 코드적용
    function checkDuplicate(type) {
        let url;
        let fieldId;
        let msgId;
        let typeName;

        switch (type) {
            case 'id':
                url = "ajax.mb_id.php";
                fieldId = "#reg_mb_id";
                msgId = "#msg_mb_id";
                typeName = "아이디";
                break;
            case 'nick':
                url = "ajax.mb_nick.php";
                fieldId = "#reg_mb_nick";
                msgId = "#msg_mb_nick";
                typeName = "닉네임";
                break;
            case 'email':
                url = "ajax.mb_email.php";
                fieldId = "#reg_mb_email";
                msgId = "#msg_mb_email";
                typeName = "이메일";
                break;
            default:
                return;
        }

        var fieldValue = $(fieldId).val();
        var data = {};
        data['reg_mb_' + type] = fieldValue;
        if (type !== 'id') {
            data['checkDuplicate' + type.charAt(0).toUpperCase() + type.slice(1)] = 1;
        }

        $.post(url, data, function(response) {
            $(msgId).html('').removeClass('error success');
            if (response) {
                $(msgId).html(response).addClass('error');
            } else {
                $(msgId).html('사용할 수 있는 ' + typeName + '입니다.').addClass('success');
            }
        });
    }

    $('#reg_mb_password_re').on('input', function() {
        var password = $('#reg_mb_password').val();
        var passwordRe = $(this).val();
        var $msg = $('#msg_mb_password_re');

        $msg.removeClass('error success');

        if (password === '' || passwordRe === '') {
            $msg.html('').removeClass('error success');
            return;
        }

        if (password === passwordRe) {
            $msg.html('비밀번호가 일치합니다.').addClass('success');
        } else {
            $msg.html('비밀번호가 일치하지 않습니다.').addClass('error');
        }
    });

    $('#reg_mb_password').on('input', function() {
        $('#reg_mb_password_re').trigger('input');
    });

    document.addEventListener('DOMContentLoaded', function() {
        const parentPromo = document.getElementById('reg_mb_promotion_agree');
        const childPromo = Array.from(document.querySelectorAll('.child-promo'));
        if (!parentPromo || childPromo.length === 0) return;

        const syncParentFromChildren = () => {
            const anyChecked = childPromo.some(cb => cb.checked);
            parentPromo.checked = anyChecked; // 하나라도 체크되면 부모 체크
        };

        const syncChildrenFromParent = () => {
            const isChecked = parentPromo.checked;
            childPromo.forEach(cb => {
                cb.checked = isChecked;
                cb.dispatchEvent(new Event('change', {
                    bubbles: true
                }));
            });
        };

        syncParentFromChildren();

        parentPromo.addEventListener('change', syncChildrenFromParent);
        childPromo.forEach(cb => cb.addEventListener('change', syncParentFromChildren));
    });
</script>

<!-- } 회원정보 입력/수정 끝 -->
