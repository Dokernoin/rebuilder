<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g5['title'] = '마이페이지';
include_once('./_head.php');

// 쿠폰
$cp_count = 0;
$sql = " select cp_id
            from {$g5['g5_shop_coupon_table']}
            where mb_id IN ( '{$member['mb_id']}', '전체회원' )
              and cp_start <= '".G5_TIME_YMD."'
              and cp_end >= '".G5_TIME_YMD."' ";
$res = sql_query($sql);

for($k=0; $cp=sql_fetch_array($res); $k++) {
    if(!is_used_coupon($member['mb_id'], $cp['cp_id']))
        $cp_count++;
}
?>

<!-- 마이페이지 시작 { -->
<div id="smb_my">

    <!-- 회원정보 개요 시작 { -->
    <section id="smb_my_ov">
        <h2>회원정보 개요</h2>
        
        <div class="smb_me">
	        <strong class="my_ov_name"><?php echo get_member_profile_img($member['mb_id']); ?><br><?php echo $member['mb_name']; ?></strong><br>
	        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php" class="smb_info">정보수정</a>
	        <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
        </div>
        
        <?php if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($member['mb_partner']) && $member['mb_partner'] == 2 || isset($pa['pa_is']) && $pa['pa_is'] == 1 && $is_admin) { ?>
        <ul class="partner_wrap">
            <a href="<?php echo G5_URL ?>/rb/partner.php" class="main_rb_bg">입점사 전용 시스템</a>
            <?php if(isset($member['mb_partner']) && $member['mb_partner'] == 2) { ?>
            <a href="<?php echo G5_URL ?>/store/?p=<?php echo $member['mb_id'] ?>" class="main_rb_bg mt-5">내 스토어</a>
            <?php } ?>
        </ul>
        <?php } else if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($member['mb_partner']) && $member['mb_partner'] == 0) { ?>
        <ul class="partner_wrap">
            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php?partner=re" class="main_rb_bg">입점 신청</a>
        </ul>
        <?php } else if(isset($pa['pa_is']) && $pa['pa_is'] == 1 && isset($member['mb_partner']) && $member['mb_partner'] == 1) { ?>
        <ul class="partner_wrap">
            <a href="javascript:alert('입점사 승인 심사중 입니다.');" class="main_rb_bg">입점사 승인대기</a>
        </ul>
        <?php } ?>
        
        <ul id="smb_private">

	    	<li>
	            <a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="win_point">
					
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_518_19)">
                    <path d="M12.5 2C18.023 2 22.5 6.477 22.5 12C22.5 17.523 18.023 22 12.5 22C6.977 22 2.5 17.523 2.5 12C2.5 6.477 6.977 2 12.5 2ZM14 7H11.5C10.9696 7 10.4609 7.21071 10.0858 7.58579C9.71071 7.96086 9.5 8.46957 9.5 9V16C9.5 16.2652 9.60536 16.5196 9.79289 16.7071C9.98043 16.8946 10.2348 17 10.5 17C10.7652 17 11.0196 16.8946 11.2071 16.7071C11.3946 16.5196 11.5 16.2652 11.5 16V14H14C14.9283 14 15.8185 13.6313 16.4749 12.9749C17.1313 12.3185 17.5 11.4283 17.5 10.5C17.5 9.57174 17.1313 8.6815 16.4749 8.02513C15.8185 7.36875 14.9283 7 14 7ZM14 9C14.3978 9 14.7794 9.15804 15.0607 9.43934C15.342 9.72064 15.5 10.1022 15.5 10.5C15.5 10.8978 15.342 11.2794 15.0607 11.5607C14.7794 11.842 14.3978 12 14 12H11.5V9H14Z" fill="#09244B"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_518_19">
                    <rect width="24" height="24" fill="white" transform="translate(0.5)"/>
                    </clipPath>
                    </defs>
                    </svg>

                    포인트
					<strong><?php echo number_format($member['mb_point']); ?>P</strong>
	            </a>
	        </li>
	        <li>
	        	<a href="<?php echo G5_SHOP_URL ?>/coupon.php" target="_blank" class="win_coupon">
	        		
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_518_27)">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.037 2.16395C11.4407 2.12722 11.8477 2.1727 12.2334 2.29765C12.6191 2.4226 12.9755 2.62443 13.281 2.89095L13.431 3.03095L21.253 10.854C21.7913 11.3924 22.1048 12.1153 22.1298 12.8763C22.1549 13.6372 21.8897 14.3793 21.388 14.952L21.253 15.096L15.596 20.753C15.0576 21.2913 14.3346 21.6047 13.5736 21.6298C12.8127 21.6549 12.0707 21.3897 11.498 20.888L11.354 20.753L3.52998 12.93C3.24346 12.6434 3.01795 12.3019 2.86705 11.9258C2.71615 11.5498 2.64299 11.147 2.65198 10.742L2.66299 10.537L3.13498 5.35195C3.19558 4.68374 3.47844 4.05512 3.93834 3.56658C4.39824 3.07803 5.00864 2.75776 5.67198 2.65695L5.85098 2.63595L11.037 2.16395ZM8.52399 8.02495C8.33823 8.21071 8.19088 8.43123 8.09035 8.67393C7.98982 8.91663 7.93808 9.17676 7.93808 9.43945C7.93808 9.70215 7.98982 9.96227 8.09035 10.205C8.19088 10.4477 8.33823 10.6682 8.52399 10.854C8.70974 11.0397 8.93026 11.1871 9.17296 11.2876C9.41566 11.3881 9.67579 11.4399 9.93849 11.4399C10.2012 11.4399 10.4613 11.3881 10.704 11.2876C10.9467 11.1871 11.1672 11.0397 11.353 10.854C11.7281 10.4788 11.9389 9.96999 11.9389 9.43945C11.9389 8.90891 11.7281 8.4001 11.353 8.02495C10.9778 7.6498 10.469 7.43905 9.93849 7.43905C9.40795 7.43905 8.89913 7.6498 8.52399 8.02495Z" fill="#09244B"/>
                </g>
                <defs>
                <clipPath id="clip0_518_27">
                <rect width="24" height="24" fill="white" transform="translate(0.5)"/>
                </clipPath>
                </defs>
                </svg>

                쿠폰
	        		<strong><?php echo number_format($cp_count); ?></strong>
	        	</a>
	        </li>
	        <li>
	            <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo">
	            	
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20.735 5.68597C21.167 4.49097 20.009 3.33297 18.814 3.76597L4.20904 9.04797C3.01004 9.48197 2.86504 11.118 3.96804 11.757L8.63004 14.456L12.793 10.293C12.9816 10.1108 13.2342 10.01 13.4964 10.0123C13.7586 10.0146 14.0095 10.1197 14.1949 10.3051C14.3803 10.4906 14.4854 10.7414 14.4877 11.0036C14.49 11.2658 14.3892 11.5184 14.207 11.707L10.044 15.87L12.744 20.532C13.382 21.635 15.018 21.489 15.452 20.291L20.735 5.68597Z" fill="#09244B"/>
                </svg>
                메세지
	           <strong><?php echo $memo_not_read ?></strong>
	            </a>
	        </li>
	        <li>
	            <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="win_scrap">
	            	
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_518_35)">
                <path d="M17.235 2.83503C16.8945 2.49437 16.4426 2.28799 15.9622 2.25382C15.4818 2.21965 15.0052 2.35998 14.62 2.64903L11.707 4.83403C10.4969 5.74181 9.0775 6.32992 7.57999 6.54403L5.40299 6.85403C4.67299 6.95903 4.13799 7.74503 4.48999 8.51603C4.82099 9.23903 5.87499 11.145 8.84999 14.236L4.67199 18.414C4.57648 18.5063 4.5003 18.6166 4.44789 18.7386C4.39548 18.8606 4.36789 18.9918 4.36674 19.1246C4.36558 19.2574 4.39088 19.3891 4.44117 19.512C4.49145 19.6349 4.5657 19.7465 4.65959 19.8404C4.75349 19.9343 4.86514 20.0086 4.98803 20.0588C5.11093 20.1091 5.24261 20.1344 5.37539 20.1333C5.50817 20.1321 5.63939 20.1045 5.76139 20.0521C5.8834 19.9997 5.99374 19.9235 6.08599 19.828L10.264 15.65C13.355 18.625 15.261 19.679 15.984 20.01C16.754 20.362 17.541 19.827 17.645 19.097L17.956 16.92C18.1701 15.4225 18.7582 14.0031 19.666 12.793L21.85 9.88003C22.139 9.4948 22.2794 9.0182 22.2452 8.5378C22.211 8.0574 22.0046 7.60547 21.664 7.26503L17.234 2.83503H17.235Z" fill="#09244B"/>
                </g>
                <defs>
                <clipPath id="clip0_518_35">
                <rect width="24" height="24" fill="white" transform="translate(0.5)"/>
                </clipPath>
                </defs>
                </svg>

                스크랩
	            	<strong class="scrap"><?php echo number_format($member['mb_scrap_cnt']); ?></strong>
	            </a>
	        </li>
	    </ul>
	    
        <h3>내정보</h3>
        <dl class="op_area">
            <dt>휴대전화</dt>
            <dd><?php echo ($member['mb_hp'] ? $member['mb_hp'] : '미등록'); ?></dd>
            <dt>E-Mail</dt>
            <dd><?php echo ($member['mb_email'] ? $member['mb_email'] : '미등록'); ?></dd>
            <dt>최종접속일시</dt>
            <dd><?php echo $member['mb_today_login']; ?></dd>
            <dt>회원가입일시</dt>
            <dd><?php echo $member['mb_datetime']; ?></dd>
            <dt id="smb_my_ovaddt">주소</dt>
            <dd id="smb_my_ovaddd"><?php echo print_address($member['mb_addr1'], $member['mb_addr2'], $member['mb_addr3'], $member['mb_addr_jibeon']); ?></dd>
        </dl>

        <a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="withdrawal withdrawal_none_ov">회원탈퇴</a>
    </section>
    <!-- } 회원정보 개요 끝 -->

	<div id="smb_my_list">
    
	    <!-- 최근 주문내역 시작 { -->
	    <section id="smb_my_od">
        
            <!-- { -->
            <ul class="bbs_main_wrap_tit mb-10">

                <li class="bbs_main_wrap_tit_l">
                    <!-- 타이틀 { -->
                        <h2 class="font-B font-18">주문내역 조회</h2>
                    <!-- } -->
                </li>


                <li class="bbs_main_wrap_tit_r">
                    <button type="button" class="more_btn" onclick="location.href='./orderinquiry.php';">더보기</button>
                </li>


                <div class="cb"></div>
            </ul>
            <!-- } -->

	        <?php
	        // 최근 주문내역
	        define("_ORDERINQUIRY_", true);
	
	        $limit = " limit 0, 5 ";
	        include G5_SHOP_PATH.'/orderinquiry.sub.php';
	        ?>

	    </section>
	    <!-- } 최근 주문내역 끝 -->
	
	    <!-- 최근 위시리스트 시작 { -->
	        <!-- { -->
            <ul class="bbs_main_wrap_tit mb-20">

                <li class="bbs_main_wrap_tit_l">
                    <!-- 타이틀 { -->
                        <h2 class="font-B font-18">최근 위시리스트</h2>
                    <!-- } -->
                </li>


                <li class="bbs_main_wrap_tit_r">
                    <button type="button" class="more_btn" onclick="location.href='./wishlist.php';">더보기</button>
                </li>


                <div class="cb"></div>
            </ul>
            <!-- } -->
	        <section id="smb_my_wish">
	        <form name="fwishlist" method="post" action="./cartupdate.php">
            <input type="hidden" name="act" value="multi">
            <input type="hidden" name="sw_direct" value="">
            <input type="hidden" name="prog" value="wish">
                <div class="rb_shop_list5">
                <div class="swiper-container swiper-container-list-item-mywish">
                <div class="swiper-wrapper swiper-wrapper-list-item-mywish">
                <?php
                $sql = " select *
                           from {$g5['g5_shop_wish_table']} a,
                                {$g5['g5_shop_item_table']} b
                          where a.mb_id = '{$member['mb_id']}'
                            and a.it_id  = b.it_id
                          order by a.wi_id desc
                          limit 0, 8 ";
                $result = sql_query($sql);
                for ($i=0; $row = sql_fetch_array($result); $i++)
                {
                    $image = rb_it_image($row['it_id'], 80, 80, true);

                    $sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
                    $tmp = sql_fetch($sql);
                    $out_cd = (isset($tmp['cnt']) && $tmp['cnt']) ? 'no' : '';
                ?>
                
                
                <ul class="swiper-slide swiper-slide-list-item-mywish sct">

                    <li class="rb_shop_list_item sct_li">
                        <div class="v_ch_list" style="width:15%;">

                            <div class="rb_shop_list_item_img">
                                <a href="<?php echo shop_item_url($row['it_id']); ?>">
                                    <?php echo $image; ?>
                                </a>

                                <?php if(is_soldout($row['it_id'])) { //품절검사 ?>
                                    <div class="sold_out_wrap">
                                        <ul><li><span>품절</span></li></ul>
                                    </div>
                                <?php } ?>

                            </div>

                        </div>

                        <div class="v_ch_list_r" style="width:80%;">

                            <ul class="v_ch_list_r_l">

                                <div class="rb_shop_list_item_name" style="margin-top:0px;">
                                    <a href="<?php echo shop_item_url($row['it_id']); ?>" class="font-R cut">
                                        <?php echo stripslashes($row['it_name']); ?>
                                    </a>
                                </div>


                                <div class="rb_shop_list_item_basic cut2">
                                    <?php echo stripslashes($row['it_basic']) ?>
                                </div>


                                <div class="rb_shop_list_item_pri">
                                    <dd class="font-B font-16"><?php echo display_price(get_price($row), $row['it_tel_inq']); ?></dd>
                                </div>


                            </ul>

                            <div class="mt-10">
                                <ul class="date_fl"><?php echo $row['wi_time']; ?></ul>
                                <div class="cb"></div>

                            </div>


                        </div>

                        <div class="cb"></div>



                    </li>

                    <div class="list_wish_int">
                        <dl>
                            <a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $row['wi_id']; ?>" class="wish_del">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><title>delete_2_line</title><g id="delete_2_line" fill="none" fill-rule="nonzero"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z"></path><path fill="#09244BFF" d="M14.28 2a2 2 0 0 1 1.897 1.368L16.72 5H20a1 1 0 1 1 0 2l-.003.071-.867 12.143A3 3 0 0 1 16.138 22H7.862a3 3 0 0 1-2.992-2.786L4.003 7.07A1.01 1.01 0 0 1 4 7a1 1 0 0 1 0-2h3.28l.543-1.632A2 2 0 0 1 9.721 2h4.558Zm3.717 5H6.003l.862 12.071a1 1 0 0 0 .997.929h8.276a1 1 0 0 0 .997-.929L17.997 7ZM10 10a1 1 0 0 1 .993.883L11 11v5a1 1 0 0 1-1.993.117L9 16v-5a1 1 0 0 1 1-1Zm4 0a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0v-5a1 1 0 0 1 1-1Zm.28-6H9.72l-.333 1h5.226l-.334-1Z"></path></g></svg>
                            </a>
                        </dl>
                        <div class="cb"></div>
                    </div>
                    
                                <?php if(is_soldout($row['it_id'])) { //품절검사 ?>
                                <?php } else { //품절이 아니면 체크할수 있도록한다 ?>
                                <div class="wish_new_chk_box">
                                    <input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="chk_it_id_<?php echo $i; ?>" onclick="out_cd_check(this, '<?php echo $out_cd; ?>');" class="selec_chk">
                                    <label for="chk_it_id_<?php echo $i; ?>"><span></span><b class="sound_only"><?php echo $row['it_name']; ?></b></label>
                                    <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                                    <input type="hidden" name="io_type[<?php echo $row['it_id']; ?>][0]" value="0">
                                    <input type="hidden" name="io_id[<?php echo $row['it_id']; ?>][0]" value="">
                                    <input type="hidden" name="io_value[<?php echo $row['it_id']; ?>][0]" value="<?php echo $row['it_name']; ?>">
                                    <input type="hidden" name="ct_qty[<?php echo $row['it_id']; ?>][0]" value="1">
                                </div>
                                <?php } ?>


                </ul>
                


                <?php } ?>
                <?php if($i == 0) echo "<div class=\"da_data\">등록된 상품이 없습니다.</div>"; ?>


                </div>
                </div>
                </div>
                
                
                <script>
                        var swiper = new Swiper('.swiper-container-list-item-mywish', {
                            slidesPerColumnFill: 'row',
                            slidesPerView: 1, //가로갯수
                            slidesPerColumn: 999, // 세로갯수
                            spaceBetween: 20, // 간격
                            touchRatio: 0, // 드래그 가능여부(1, 0)
                        });
                </script>
                
                <div id="smb_ws_act">
                    <button type="submit" class="btn01" onclick="return fwishlist_check(document.fwishlist,'');">장바구니</button>
                    <button type="submit" class="btn02" onclick="return fwishlist_check(document.fwishlist,'direct_buy');">주문하기</button>
                </div>
            </form>
	    </section>
	    <!-- } 최근 위시리스트 끝 -->
	</div>
</div>

<script>
function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}

function out_cd_check(fld, out_cd)
{
    if (out_cd == 'no'){
        alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
        fld.checked = false;
        return;
    }

    if (out_cd == 'tel_inq'){
        alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
        fld.checked = false;
        return;
    }
}

function fwishlist_check(f, act)
{
    var k = 0;
    var length = f.elements.length;

    for(i=0; i<length; i++) {
        if (f.elements[i].checked) {
            k++;
        }
    }

    if(k == 0)
    {
        alert("상품을 하나 이상 체크 하십시오");
        return false;
    }

    if (act == "direct_buy")
    {
        f.sw_direct.value = 1;
    }
    else
    {
        f.sw_direct.value = 0;
    }

    return true;
}
</script>
<!-- } 마이페이지 끝 -->

<?php
include_once("./_tail.php");
