<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MSHOP_PATH.'/shop.tail.php');
    return;
}

$admin = get_admin("super");

?>
        
       </section>
    </div>
    
    
    <?php 

    if (isset($rb_core['layout_ft_shop']) && $rb_core['layout_ft_shop'] == "") {
        echo "<div class='no_data' style='padding:30px 0 !important; margin-top:0px; border:0px !important; background-color:#f9f9f9;'><span class='no_data_section_ul1 font-B color-000'>선택된 푸터 레이아웃이 없습니다.</span><br>환경설정 패널에서 먼저 푸터 레이아웃을 설정해주세요.</div>";
    } else if (isset($rb_core['layout_ft_shop'])) { 
        // 레이아웃 인클루드
        include_once(G5_THEME_SHOP_PATH . '/rb.layout_ft/' . $rb_core['layout_ft_shop'] . '/footer.php'); 
    } else {
        echo "<div class='no_data' style='padding:30px 0 !important; margin-top:0px; border:0px !important; background-color:#f9f9f9;'><span class='no_data_section_ul1 font-B color-000'>푸터 레이아웃 설정이 올바르지 않습니다.</span><br>환경설정 패널에서 먼저 푸터 레이아웃을 설정해주세요.</div>";
    }

    ?>
    
    


                <!-- 전체메뉴 { -->
                <nav id="cbp-hrmenu-btm" class="cbp-hrmenu cbp-hrmenu-btm mobile">
                   
                    <div class="user_prof_bg">
                        <?php if($is_member) { ?>
                            <li class="user_prof_bg_info font-B"><?php echo $member['mb_nick'] ?></li>
                            <li class="user_prof_bg_info font-B"><span><?php echo $member['mb_level'] ?> Lv</span> <a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point font-B"><span><?php echo number_format($member['mb_point']); ?> P</span></a></li>
                        <?php } else { ?>
                            <li class="user_prof_bg_info font-B">Guest</li>
                        <?php } ?>
                    </div>
                    <div class="user_prof">
                        <?php if($is_member) { ?>
                        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="font-B"><?php echo get_member_profile_img($member['mb_id']); ?></a>
                        <?php } else { ?>
                        <?php echo get_member_profile_img($member['mb_id']); ?>
                        <?php } ?>
                    </div>
                    <div class="user_prof_btns">
                        <li class="">
                            <?php if($is_member) { ?>
                            <button type="button" alt="로그아웃" class="btn_round" onclick="location.href='<?php echo G5_BBS_URL ?>/logout.php';">로그아웃</button>
                            <button type="button" alt="마이페이지" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_SHOP_URL; ?>/mypage.php';">My</button>
                            <?php } else { ?>
                            <button type="button" alt="로그인" class="btn_round" onclick="location.href='<?php echo G5_BBS_URL ?>/login.php';">로그인</button>
                            <button type="button" alt="회원가입" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_BBS_URL ?>/register.php';">회원가입</button>
                            <?php } ?>
                        </li>
                    </div>
                    
                    
                    <ul>
                    <?php
                    $menu_datas = get_menu_db(0, true);
                    $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                    $i = 0;
                    foreach( $menu_datas as $row ){
                        if( empty($row) ) continue;
                        $add_arr = (isset($row['sub']) && $row['sub']) ? 'add_arr_svg' : '';
                        $add_arr_btn = (isset($row['sub']) && $row['sub']) ? '<button type="button" class="add_arr_btn"></button>' : '';
                    ?>
                    <li class="<?php echo $add_arr ?>">
                        <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="font-B"><?php echo $row['me_name'] ?></a>
                        <?php echo $add_arr_btn ?>
                        <?php
                        $k = 0;
                        foreach( (array) $row['sub'] as $row2 ){

                            if( empty($row2) ) continue; 
                            
                            if($k == 0)
                                echo '<div class="cbp-hrsub"><div class="cbp-hrsub-inner"><div><!--<h4 class="font-B">그룹</h4>--><ul>'.PHP_EOL;
                            
                        ?>
                            <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                        <?php
                        $k++;
                        }   //end foreach $row2

                        if($k > 0)
                            echo '</ul></div></div></div>'.PHP_EOL;
                        ?>
                    </li>
                    <?php
                    $i++;
                    }   //end foreach $row
                    ?>
                    

                    <?php /* 쇼핑몰 분류 사용시
                        $i = 0;
                        foreach($mshop_categories as $cate1){
                            if( empty($cate1) ) continue;

                            $mshop_ca_row1 = $cate1['text'];
                            
                            // 2차 분류가 있는지 확인
                            $has_subcategory = false;
                            foreach($cate1 as $key=>$cate2){
                                if( empty($cate2) || $key === 'text' ) continue;
                                $has_subcategory = true;
                                break;
                            }
                            
                            $add_arr = $has_subcategory ? 'add_arr_svg' : '';
                            $add_arr_btn = $has_subcategory ? '<button type="button" class="add_arr_btn"></button>' : '';
                    ?>
                    <li class="<?php echo $add_arr ?>">
                        <a href="<?php echo $mshop_ca_row1['url']; ?>" class="font-B"><?php echo get_text($mshop_ca_row1['ca_name']); ?></a>
                        <?php echo $add_arr_btn ?>
                           
                        <?php
                            $j=0;
                            foreach($cate1 as $key=>$cate2){
                                if( empty($cate2) || $key === 'text' ) continue;

                                $mshop_ca_row2 = $cate2['text'];
                                if($j == 0)
                                    echo '<div class="cbp-hrsub"><div class="cbp-hrsub-inner"><div><!--<h4 class="font-B">그룹</h4>--><ul>'.PHP_EOL;
                        ?>
                            
                            <li><a href="<?php echo $mshop_ca_row2['url']; ?>"><?php echo get_text($mshop_ca_row2['ca_name']); ?></a></li>
                            
                        <?php
                            $j++;
                            }

                            if($j > 0)
                                echo '</ul></div></div></div>'.PHP_EOL;
                            ?>

                    </li>
                    
                    <?php
                        $i++;
                        }   // end for
                    ?>
                    
                    */ ?>

                    </ul>
                </nav>
                <!-- } -->



<button type="button" id="m_gnb_close_btn" class="mobile">
    <img src="<?php echo G5_URL ?>/rb/rb.config/image/icon_close.svg">
</button>

<script>
    $(document).ready(function() {
        $('#m_gnb_close_btn').click(function() {
            $('#cbp-hrmenu-btm').removeClass('active');
            $('#m_gnb_close_btn').removeClass('active');
            $('main').removeClass('moves');
            $('header').removeClass('moves');
        });
    });
</script>


<script src="<?php echo G5_THEME_URL ?>/rb.js/cbpHorizontalMenu.min.js"></script>
<script>
    $(function() {
        cbpHorizontalMenu.init();
        cbpHorizontalMenu_btm.init();
    });
</script>
<!-- } -->

<!-- 캘린더 옵션 { -->
<script>
    $.datepicker.setDefaults({
        closeText: "닫기",
        prevText: "이전달",
        nextText: "다음달",
        currentText: "오늘",
        monthNames: ["1월", "2월", "3월", "4월", "5월", "6월",
            "7월", "8월", "9월", "10월", "11월", "12월"
        ],
        monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월",
            "7월", "8월", "9월", "10월", "11월", "12월"
        ],
        dayNames: ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"],
        dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
        dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
        weekHeader: "주",
        dateFormat: "yy-mm-dd",
        firstDay: 0,
        isRTL: false,
        showMonthAfterYear: true,
        yearSuffix: "년"
    })

    $(".datepicker_inp").datepicker({
        //minDate: 0
    })
</script>

<link rel="stylesheet" href="<?php echo G5_THEME_URL ?>/rb.css/datepicker.css" />
<!-- } -->

<?php
    //리빌드세팅
    if($is_admin) {
        include_once(G5_PATH.'/rb/rb.config/right.php'); //환경설정
    }
         
    // HOOK 추가, (tail.php 가 로드되는 페이지에서만 / 쪽지, 로그인 등의 모듈 페이지에서는 실행 되지않게 하기위함.)
    // 관련 HOOK : add_event('tail_sub', 'aaa');
    $rb_hook_tail = "true";

?>

<?php
$sec = get_microtime() - $begin_time;
$file = $_SERVER['SCRIPT_NAME'];

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<script src="<?php echo G5_JS_URL; ?>/sns.js"></script>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH.'/tail.sub.php');