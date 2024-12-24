<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<style>
    .rb_prof_tab {border-top: 1px solid #ddd;}
    .rb_prof_tab .cont_info_wrap dd {border-bottom: 1px solid #eee;}
</style>
<!-- 자기소개 시작 { -->
<div id="profile" class="new_win">
    <h1 id="win_title"><?php echo $mb['mb_nick'] ?>님의 프로필</h1>
    <div class="profile_name">
        <span class="my_profile_img">
            <?php echo get_member_profile_img($mb['mb_id']); ?>
        </span>
        <?php echo $mb_nick ?><br><br>
    </div>
    

        <div class="rb_prof_tab">
            <ul class="cont_info_wrap">
                <li class="cont_info_wrap_l">
                    <dd>닉네임</dd>
                    <dd><?php echo $mb['mb_nick'] ?> <!--<span>@<?php echo $mb['mb_id'] ?></span>--></dd>
                </li>
                <li class="cont_info_wrap_r">
                    <dd>회원레벨</dd>
                    <dd><?php echo $mb['mb_level'] ?>레벨</dd>
                </li>
                <div class="cb"></div>
            </ul>
            <ul class="cont_info_wrap">
                <li class="cont_info_wrap_l">
                    <dd>포인트</dd>
                    <dd><?php echo number_format($mb['mb_point']) ?>P</dd>
                </li>
                <li class="cont_info_wrap_r">
                    <dd>가입일</dd>
                    <dd><?php echo ($member['mb_level'] >= $mb['mb_level']) ?  substr($mb['mb_datetime'],0,10) ." (+".number_format($mb_reg_after)."일)" : "알 수 없음";  ?></dd>
                </li>
                <div class="cb"></div>
            </ul>
            <ul class="cont_info_wrap">
                <li class="cont_info_wrap_l">
                    <dd>운영채널</dd>
                    <dd>
                    <?php if($mb_homepage) { ?>
                    <a href="<?php echo $mb_homepage ?>" target="_blank"><?php echo $mb_homepage ?></a>
                    <?php } else { ?>
                    -
                    <?php } ?>
                    </dd>
                </li>
                <li class="cont_info_wrap_r">
                    <dd>최종접속</dd>
                    <dd><?php echo ($member['mb_level'] >= $mb['mb_level']) ? $mb['mb_today_login'] : "알 수 없음"; ?></dd>
                </li>
                <div class="cb"></div>
            </ul>
        </div>
    
    <br><br>
    <div class="win_btn">
        <button type="button" onclick="window.close();" class="btn_close">창닫기</button>
    </div>
    <br><br>
</div>
<!-- } 자기소개 끝 -->