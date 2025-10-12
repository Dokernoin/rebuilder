<?php
if (!defined('_GNUBOARD_')) {
    exit;
}

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

$files = glob(G5_ADMIN_PATH . '/css/admin_extend_*');
if (is_array($files)) {
    foreach ((array) $files as $k => $css_file) {

        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];

        if ($ext !== 'css') {
            continue;
        }

        $css_file = str_replace(G5_ADMIN_PATH, G5_ADMIN_URL, $css_file);
        add_stylesheet('<link rel="stylesheet" href="' . $css_file . '">', $k);
    }
}

require_once G5_PATH . '/head.sub.php';

function print_menu1($key, $no = '')
{
    global $menu;

    $str = print_menu2($key, $no);

    return $str;
}

function print_menu2($key, $no = '')
{
    global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

    $str = "<ul>";
    for ($i = 1; $i < count($menu[$key]); $i++) {
        if (!isset($menu[$key][$i])) {
            continue;
        }

        if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0], $auth) || !strstr($auth[$menu[$key][$i][0]], 'r'))) {
            continue;
        }

        $gnb_grp_div = $gnb_grp_style = '';

        if (isset($menu[$key][$i][4])) {
            if (($menu[$key][$i][4] == 1 && $gnb_grp_style == false) || ($menu[$key][$i][4] != 1 && $gnb_grp_style == true)) {
                $gnb_grp_div = 'gnb_grp_div';
            }

            if ($menu[$key][$i][4] == 1) {
                $gnb_grp_style = 'gnb_grp_style';
            }
        }

        $current_class = '';

        if ($menu[$key][$i][0] == $sub_menu) {
            $current_class = ' on';
        }

        $str .= '<li data-menu="' . $menu[$key][$i][0] . '"><a href="' . $menu[$key][$i][2] . '" class="gnb_2da ' . $gnb_grp_style . ' ' . $gnb_grp_div . $current_class . '">' . $menu[$key][$i][1] . '</a></li>';

        $auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
    }
    $str .= "</ul>";

    return $str;
}

$adm_menu_cookie = array(
    'container' => '',
    'gnb'       => '',
    'btn_gnb'   => '',
);

if(is_mobile()) {
    $adm_menu_cookie['container'] = 'container-small';
    $adm_menu_cookie['gnb'] = 'gnb_small';
    $adm_menu_cookie['btn_gnb'] = 'btn_gnb_open';
} else {
    if( ! empty($_COOKIE['g5_admin_btn_gnb']) ){
        $adm_menu_cookie['container'] = 'container-small';
        $adm_menu_cookie['gnb'] = 'gnb_small';
        $adm_menu_cookie['btn_gnb'] = 'btn_gnb_open';
    }
}


// 오늘 날짜
$today = date("Y-m-d");
$timestamp = strtotime($today);

// 요일 숫자 (0=일, 6=토)
$weekday_num = date("w", $timestamp);

// 요일 한글 매핑
$week_map = array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
$week_kor = $week_map[$weekday_num];

// 색상 지정
$color = "black";
if ($weekday_num == 0) {
    $color = "red";   // 일요일
} else if ($weekday_num == 6) {
    $color = "blue";  // 토요일
}

?>

<script>
    var g5_admin_csrf_token_key = "<?php echo (function_exists('admin_csrf_token_key')) ? admin_csrf_token_key() : ''; ?>";
    var tempX = 0;
    var tempY = 0;

    function imageview(id, w, h) {

        menu(id);

        var el_id = document.getElementById(id);

        //submenu = eval(name+".style");
        submenu = el_id.style;
        submenu.left = tempX - (w + 11);
        submenu.top = tempY - (h / 2);

        selectBoxVisible();

        if (el_id.style.display != 'none')
            selectBoxHidden(id);
    }
</script>

<div id="to_content"><a href="#container">본문 바로가기</a></div>

<header id="hd">
    <h1><?php echo $config['cf_title'] ?></h1>
    <div id="hd_top">
        <button type="button" id="btn_gnb" class="btn_gnb_close <?php echo $adm_menu_cookie['btn_gnb']; ?>">메뉴</button>
        <div id="logo">
        <a href="<?php echo correct_goto_url(G5_ADMIN_URL); ?>" title="<?php echo get_text($config['cf_title']); ?> 관리자모드"><strong>Administrator</strong></a>
        <?php
        if (defined('RB_VER')) {
            echo "Rb <strong>".RB_VER."</strong>　";
        } else {
            echo '';
        }
        ?>
        <span class="v_times"><?php echo date("Y년 n월 j일", $timestamp) . " <span style='color:{$color};'>{$week_kor}</span>"; ?></span>
        </div>

        <div id="tnb">
            <ul>
                <?php if (defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
                    <li class="tnb_li"><a href="<?php echo G5_SHOP_URL ?>/" target="_blank" title="쇼핑몰 바로가기"><img src="<?php echo G5_ADMIN_URL ?>/img/sh.svg"></a></li>
                <?php } ?>
                <li class="tnb_li"><a href="<?php echo G5_URL ?>/" target="_blank" title="커뮤니티 바로가기"><img src="<?php echo G5_ADMIN_URL ?>/img/hm.svg"></a></li>
                <!--
                <li class="tnb_li"><a href="<?php echo G5_ADMIN_URL ?>/service.php" class="tnb_service">부가서비스</a></li>
                -->
                <li><a href="<?php echo G5_ADMIN_URL ?>/member_form.php?w=u&amp;mb_id=<?php echo $member['mb_id'] ?>" title="관리자 정보수정"><img src="<?php echo G5_ADMIN_URL ?>/img/am.svg"></a></li>
                <li id="tnb_logout"><a href="<?php echo G5_BBS_URL ?>/logout.php" title="로그아웃"><img src="<?php echo G5_ADMIN_URL ?>/img/pw.svg"></a></li>
            </ul>
        </div>
    </div>
    <nav id="gnb" class="gnb_large <?php echo $adm_menu_cookie['gnb']; ?>">
        <h2>관리자 주메뉴</h2>
        <ul class="gnb_ul">
            <?php
            $jj = 1;
            foreach ($amenu as $key => $value) {
                $href1 = $href2 = '';

                if (isset($menu['menu' . $key][0][2]) && $menu['menu' . $key][0][2]) {
                    $href1 = '<a href="' . $menu['menu' . $key][0][2] . '" class="gnb_1da">';
                    $href2 = '</a>';
                } else {
                    continue;
                }

                $current_class = "";
                if (isset($sub_menu) && (substr($sub_menu, 0, 3) == substr($menu['menu' . $key][0][0], 0, 3))) {
                    $current_class = " on";
                }

                $button_title = $menu['menu' . $key][0][1];
            ?>
                <li class="gnb_li<?php echo $current_class; ?>">
                    <button type="button" class="btn_op menu-<?php echo $key; ?> menu-order-<?php echo $jj; ?>" title="<?php echo $button_title; ?>"><?php echo $button_title; ?></button>
                    <div class="gnb_oparea_wr">
                        <div class="gnb_oparea">
                            <h3><?php echo $menu['menu' . $key][0][1]; ?></h3>
                            <?php echo print_menu1('menu' . $key, 1); ?>
                        </div>
                    </div>
                </li>
            <?php
                $jj++;
            }     //end foreach
            ?>
        </ul>
    </nav>

</header>
<script>
    jQuery(function($) {
        var menu_cookie_key = 'g5_admin_btn_gnb';

        $(".tnb_mb_btn").click(function() {
            $(".tnb_mb_area").toggle();
        });

        $("#btn_gnb").click(function() {
            var $this = $(this);

            try {
                if (!$this.hasClass("btn_gnb_open")) {
                    // 열릴 때 쿠키 저장
                    set_cookie(menu_cookie_key, 1, 60 * 60 * 24 * 365);
                } else {
                    // 닫을 때 쿠키 삭제
                    delete_cookie(menu_cookie_key);
                }
            } catch (err) {}

            $("#container").toggleClass("container-small");
            $("#gnb").toggleClass("gnb_small");
            $("#logo").toggleClass("logo_small");
            $this.toggleClass("btn_gnb_open");
        });

        $(".gnb_ul li .btn_op").click(function() {
            $(this).parent().addClass("on").siblings().removeClass("on");
        });

        // 페이지 로딩 시 쿠키값 확인 → 클래스 적용
        if (get_cookie(menu_cookie_key)) {
            $("#container").addClass("container-small");
            $("#gnb").addClass("gnb_small");
            $("#logo").addClass("logo_small");
            $("#btn_gnb").addClass("btn_gnb_open");
        }
    });

    jQuery(function($){
      $('.btn_fixed_top').each(function(){
        if (this.getAttribute('style') && this.style.right === '60px') {
          this.style.right = '80px';
        }
      });
    });
</script>


<div id="wrapper">

    <div id="container" class="<?php echo $adm_menu_cookie['container']; ?>">

        <h1 id="container_title"><?php echo $g5['title'] ?></h1>
        <div class="container_wr">
