<?php
include_once('../../common.php');
header("Content-Type: text/css");

$rb_header_set = isset($_GET['rb_header_set']) ? htmlspecialchars($_GET['rb_header_set']) : htmlspecialchars($rb_core['header']);
$rb_header_code = isset($_GET['rb_header_code']) ? htmlspecialchars($_GET['rb_header_code']) : htmlspecialchars($rb_config['co_header']);
$rb_header_txt = isset($_GET['rb_header_txt']) ? htmlspecialchars($_GET['rb_header_txt']) : 'black';

if($rb_header_code == "#ffffff" || $rb_header_code == "#FFFFFF" || $rb_header_code == "") {
    $rb_rgba_border = "border-color:rgba(0,0,0,0.1);";
    $rb_rgba_bg = "background-color:rgba(0,0,0,0.05);";
    $rb_header_txt = $rb_config['co_color'];
    $rb_header_search_h = "color:rgba(0,0,0,0.6);"; 
    $rb_header_a = "";
    $arr_w = "";
} else { 
    if($rb_header_txt == "black") { //밝은배경
        $rb_rgba_border = "border-color:rgba(0,0,0,0.1);";
        $rb_rgba_bg = "background-color:rgba(0,0,0,0.05);";
        $rb_header_txt = $rb_config['co_color'];
        $rb_header_search_h = "color:rgba(0,0,0,0.6);"; 
        $rb_header_a = "";
        $arr_w = "";
    } else { //어두운 배경
        $rb_rgba_border = "border-color:rgba(255,255,255,0.1);";
        $rb_rgba_bg = "background-color:rgba(255,255,255,1);";
        $rb_header_txt = "#fff";
        $rb_header_search_h = ""; 
        $rb_header_a = "#fff";
        $arr_w = "background-image: url(../rb.config/image/arr_down_w.svg)";
    }
}
?>


.<?php echo $rb_header_set ?> #header {background-color: <?php echo $rb_header_code ?>; border-bottom: 1px solid <?php echo $rb_header_code ?>;}
.<?php echo $rb_header_set ?> #header .rows_gnb_wrap {<?php echo $rb_rgba_border ?>}
.<?php echo $rb_header_set ?> #header .tog_wrap button svg path {fill:<?php echo $rb_header_txt ?>;}
.<?php echo $rb_header_set ?> #header .gnb_wrap nav a {color:<?php echo $rb_header_a ?>;}
.<?php echo $rb_header_set ?> #header .gnb_wrap nav a:hover{color:<?php echo $rb_header_txt ?>;}
.<?php echo $rb_header_set ?> #header .gnb_wrap .snb_wrap .member_info_wrap span {color:<?php echo $rb_header_txt ?>;}
.<?php echo $rb_header_set ?> #header .gnb_wrap .snb_wrap .member_info_wrap {color:<?php echo $rb_header_txt ?>;}
.<?php echo $rb_header_set ?> #header .my_btn_wrap .btn_round {<?php echo $rb_rgba_border ?>;}
.<?php echo $rb_header_set ?> #header .gnb_wrap .snb_wrap .member_info_wrap a {color:<?php echo $rb_header_a ?>}
.<?php echo $rb_header_set ?> #header .logo_wrap span {color:<?php echo $rb_header_txt ?>;}
.<?php echo $rb_header_set ?> #header .search_top_wrap_inner button svg path {}
.<?php echo $rb_header_set ?> #header .gnb_wrap .snb_wrap .qm_wrap a svg path {fill:<?php echo $rb_header_a ?>}
.<?php echo $rb_header_set ?> #header .gnb_wrap .snb_wrap .qm_wrap button svg path {fill:<?php echo $rb_header_a ?>}
.<?php echo $rb_header_set ?> #header .gnb_all_menu {<?php echo $arr_w ?>}

.<?php echo $rb_header_set ?> .co_header_ex_dd {background-color:<?php echo $rb_header_code ?>; color:<?php echo $rb_header_txt ?>; border:1px solid rgba(0,0,0,0.1);}
.<?php echo $rb_header_set ?> .co_header_ex_dd svg path {fill:<?php echo $rb_header_a ?>;}
.<?php echo $rb_header_set ?> .search_top_wrap input {<?php echo $rb_rgba_bg ?>}
.<?php echo $rb_header_set ?> .search_top_wrap input::placeholder {<?php echo $rb_header_search_h ?>}