<?php
include_once('../../common.php');
header("Content-Type: text/css");
$rb_color_set = isset($_GET['rb_color_set']) ? htmlspecialchars($_GET['rb_color_set']) : htmlspecialchars($rb_core['color']);
$rb_color_code = isset($_GET['rb_color_code']) ? htmlspecialchars($_GET['rb_color_code']) : htmlspecialchars($rb_config['co_color']);
?>

.<?php echo $rb_color_set ?> .gnb_wrap .snb_wrap .qm_wrap button span {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .gnb_wrap .snb_wrap .qm_wrap a span {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .gnb_wrap .snb_wrap .member_info_wrap a span {color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .top1_bg {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .gnb_wrap nav a:hover {color:<?php echo $rb_color_code ?>}
.<?php echo $rb_color_set ?> .bbs_list_label2.label_w3 {color:<?php echo $rb_color_code ?>}
.<?php echo $rb_color_set ?> .content_box .admin_ov .mod_edit h2 span {color:<?php echo $rb_color_code ?>}
.<?php echo $rb_color_set ?> .bbs_list_label2.label_w3 {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_config h2 span {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .btn_round.btn_round_bg {background-color: <?php echo $rb_color_code ?>; border:1px solid <?php echo $rb_color_code ?>; color:#fff;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap .btns_gr_wrap .btns_gr .fl_btns.main_color_bg {background-color: <?php echo $rb_color_code ?>; border-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap #bo_cate #bo_cate_on {color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap .btns_gr_wrap .btns_gr .fl_btns:hover {border-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .sch_word {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap .btm_btns .fl_btns:hover {border-color:<?php echo $rb_color_code ?>; color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .btn_submit {background:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .btn_submit:hover {background:<?php echo $rb_color_code ?>}
.<?php echo $rb_color_set ?> .main_color {color:<?php echo $rb_color_code ?> !important;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap .writer_prof_ul2 .fl_btns:hover {border-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap .writer_prof_ul2 .gd_btn {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .btn_submit {background-color: <?php echo $rb_color_code ?> !important;}
.<?php echo $rb_color_set ?> .new_win .win_ul .selected {background: <?php echo $rb_color_code ?>; border-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .reply_btn {background: <?php echo $rb_color_code ?> !important;}
.<?php echo $rb_color_set ?> .memo_list .no_read {background-color: <?php echo $rb_color_code ?> !important;}
.<?php echo $rb_color_set ?> .add_qa {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_status_bt.active {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_faq .faq_ser_wrap input {border:1px solid <?php echo $rb_color_code ?>; color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_faq #faq_con .con_inner .closer_btn {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_faq #bo_cate #bo_cate_on {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_faq .btns_gr_wrap .btns_gr .fl_btns:hover {border-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .pg_current {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> #point .point_all {background-color: <?php echo $rb_color_code ?> !important;}
.<?php echo $rb_color_set ?> .cbp-hrmenu > ul > li.cbp-hropen a {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .cbp-hrmenu > ul > li.cbp-hropen > a:hover {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> #search_top_btn.ser_open svg path {fill:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> #search_box_wrap .ser_ul_pd .ser_label b {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> #search_box_wrap ul input.w100 {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_serch_skin #bo_cate .sch_on {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_serch_skin .faq_ser_wrap input {color:<?php echo $rb_color_code ?>; border-color:<?php echo $rb_color_code ?>}
.<?php echo $rb_color_set ?> .rb_prof .rb_prof_btn .fl_btns {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_prof_tab #bo_cate #bo_cate_on {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> #loadings_spin {border-top-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> #current_connect .cc_flex .fl_btns:hover {border-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_bbs_wrap .btm_btns .fl_btns.main_color_bg {background-color: <?php echo $rb_color_code ?>; border-color:<?php echo $rb_color_code ?>}
.<?php echo $rb_color_set ?> .beta_ico {background-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .cc_total_cnt {background-color: <?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .main_rb_bg {background-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .main_rb_color {color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .main_rb_bordercolor {border-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_range_item .ui-slider-handle {background-color:<?php echo $rb_color_code ?>;}
.<?php echo $rb_color_set ?> .rb_range_item .ui-slider-range {background-color:<?php echo $rb_color_code ?>;}