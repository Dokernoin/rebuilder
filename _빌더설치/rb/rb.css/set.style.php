<?php
include_once('../../common.php');
header("Content-Type: text/css");
$rb_color_code = isset($_GET['rb_color_code']) ? htmlspecialchars($_GET['rb_color_code']) : htmlspecialchars($rb_config['co_color']);

$rb_header_color = isset($rb_config['co_header']) ? $rb_config['co_header'] : '';
$rb_main_width = isset($rb_core['main_width']) ? $rb_core['main_width'] : '';
$rb_sub_width = isset($rb_core['sub_width']) ? $rb_core['sub_width'] : '';
$rb_tb_width = isset($tb_width_inner) ? $tb_width_inner : '';
$rb_gap = isset($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '';
$rb_gap_mo = isset($rb_core['gap_mo']) ? $rb_core['gap_mo'] : '';
$rb_main_bg = isset($rb_core['main_bg']) ? $rb_core['main_bg'] : '';
$rb_sub_bg = isset($rb_core['sub_bg']) ? $rb_core['sub_bg'] : '';

$is_index = isset($_GET['rb_is_index']) ? $_GET['rb_is_index'] : 0;
?>

:root {
  --rb-main-color: <?php echo $rb_color_code; ?>;
  --rb-sub-color: #25282B;
  --rb-main-bg: <?php echo $rb_main_bg; ?>;
  --rb-sub-bg: <?php echo $rb_sub_bg; ?>;
  --rb-header-color: <?php echo $rb_header_color; ?>;
  --rb-main-width: <?php echo $rb_main_width; ?>px;
  --rb-sub-width: <?php echo $rb_sub_width; ?>px;
  --rb-header-width: <?php echo $rb_tb_width; ?>;
  --rb-footer-width: <?php echo $rb_tb_width; ?>;
  --rb-gap: <?php echo $rb_gap; ?>px; <?php echo $is_index ?>px;
}


<?php if(isset($is_index) && $is_index == '1') { ?>
main {background-color:var(--rb-main-bg);}
body, html {background-color:var(--rb-main-bg);}
<?php } else { ?>
main {background-color:var(--rb-sub-bg);}
body, html {background-color:var(--rb-sub-bg);}
<?php } ?>


<?php if($rb_gap_mo == 1) { ?>
@media all and (max-width:1024px) {
    .flex_box {gap:20px 0px;}
    .content_box {padding-top:0px !important; padding-bottom: 0px !important;}
}
<?php } ?>
