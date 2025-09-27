<?php
include_once('../../common.php');
header("Content-Type: text/css");
$rb_color_code = isset($_GET['rb_color_code']) ? htmlspecialchars($_GET['rb_color_code']) : htmlspecialchars($rb_config['co_color']);

$rb_header_color = isset($rb_config['co_header']) ? $rb_config['co_header'] : '';
$rb_main_width = isset($rb_core['main_width']) ? $rb_core['main_width'] : '';
$rb_sub_width = isset($rb_core['sub_width']) ? $rb_core['sub_width'] : '';
$rb_tb_width = isset($tb_width_inner) ? $tb_width_inner : '';
$rb_gap = isset($rb_core['gap_pc']) ? $rb_core['gap_pc'] : '';

?>

:root {
  --rb-main-color: <?php echo $rb_color_code; ?>;
  --rb-sub-color: #25282B;
  --rb-header-color: <?php echo $rb_header_color; ?>;
  --rb-main-width: <?php echo $rb_main_width; ?>px;
  --rb-sub-width: <?php echo $rb_sub_width; ?>px;
  --rb-header-width: <?php echo $rb_tb_width; ?>;
  --rb-footer-width: <?php echo $rb_tb_width; ?>;
  --rb-gap: <?php echo $rb_gap; ?>px;
}
