<?php
$sub_menu = '000300';
include_once('./_common.php');

check_demo();

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

@mkdir(G5_DATA_PATH."/banners", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH."/banners", G5_DIR_PERMISSION);

$bn_bimg      = isset($_FILES['bn_bimg']['tmp_name']) ? $_FILES['bn_bimg']['tmp_name'] : null;
$bn_bimg_name = isset($_FILES['bn_bimg']['name']) ? $_FILES['bn_bimg']['name'] : null;

$bn_id = isset($bn_id) ? (int) $bn_id : 0;

$bn_bimg_del = isset($bn_bimg_del) ? $bn_bimg_del : null;

if ($bn_bimg_del) {
    @unlink(G5_DATA_PATH."/banners/$bn_id");
}

// 파일이 이미지인지 체크합니다.
if ($bn_bimg || $bn_bimg_name) {
    if (!preg_match('/\.(gif|jpe?g|bmp|png)$/i', $bn_bimg_name)) {
        alert("이미지 파일만 업로드 할 수 있습니다.");
    }

    $timg = @getimagesize($bn_bimg);
    if ($timg === false || $timg[2] < 1 || $timg[2] > 16) {
        alert("이미지 파일만 업로드 할 수 있습니다.");
    }
}

$bn_url = isset($bn_url) ? clean_xss_tags($bn_url) : '';
$bn_alt = isset($bn_alt) ? (function_exists('clean_xss_attributes') ? clean_xss_attributes(strip_tags($bn_alt)) : strip_tags($bn_alt)) : '';

if(isset($_POST['bn_position_use']) && $_POST['bn_position_use']) { 
    $bn_position = $_POST['bn_position_use'];
} else { 
    $bn_position = $_POST['bn_position'];
}

if ($w == "") {
    if (!$bn_bimg_name) alert('배너 이미지를 업로드 하세요.');

    sql_query("ALTER TABLE rb_banner AUTO_INCREMENT=1");

    $sql = "INSERT INTO rb_banner
                SET bn_alt        = '$bn_alt',
                    bn_url        = '$bn_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
                    bn_radius     = '$bn_radius',
                    bn_ad_ico     = '$bn_ad_ico',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
                    bn_time       = '$now',
                    bn_hit        = '0',
                    bn_order      = '$bn_order'";
    sql_query($sql);

    $bn_id = sql_insert_id();
} elseif ($w == "u") {
    $sql = "UPDATE rb_banner
                SET bn_alt        = '$bn_alt',
                    bn_url        = '$bn_url',
                    bn_device     = '$bn_device',
                    bn_position   = '$bn_position',
                    bn_border     = '$bn_border',
                    bn_radius     = '$bn_radius',
                    bn_ad_ico     = '$bn_ad_ico',
                    bn_new_win    = '$bn_new_win',
                    bn_begin_time = '$bn_begin_time',
                    bn_end_time   = '$bn_end_time',
                    bn_order      = '$bn_order'
              WHERE bn_id = '$bn_id'";
    sql_query($sql);
} elseif ($w == "d") {
    @unlink(G5_DATA_PATH."/banners/$bn_id");

    $sql = "DELETE FROM rb_banner WHERE bn_id = $bn_id";
    $result = sql_query($sql);
}

if ($w == "" || $w == "u") {
    if (isset($_FILES['bn_bimg']['name']) && $_FILES['bn_bimg']['name']) {
        rb_upload_files($_FILES['bn_bimg']['tmp_name'], $bn_id, G5_DATA_PATH."/banners");
    }

    goto_url("./banner_form.php?w=u&amp;bn_id=$bn_id");
} else {
    goto_url("./banner_list.php");
}
?>