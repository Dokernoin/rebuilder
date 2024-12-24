<?php
include_once('../../../../../common.php');
header("Content-Type: text/css");
$bo_gallery_width = isset($_GET['bo_gallery_width']) ? htmlspecialchars($_GET['bo_gallery_width']) : htmlspecialchars($rb_core['bo_gallery_width']);
$bo_mobile_gallery_width = isset($_GET['bo_mobile_gallery_width']) ? htmlspecialchars($_GET['bo_mobile_gallery_width']) : htmlspecialchars($rb_core['bo_mobile_gallery_width']);
$bo_gallery_height = isset($_GET['bo_gallery_height']) ? htmlspecialchars($_GET['bo_gallery_height']).'px' : htmlspecialchars($rb_core['bo_gallery_height']).'px';
$bo_mobile_gallery_height = isset($_GET['bo_mobile_gallery_height']) ? htmlspecialchars($_GET['bo_mobile_gallery_height']).'px' : htmlspecialchars($rb_core['bo_mobile_gallery_height']).'px';

$gap_width_pc = $bo_gallery_width + 30;
$gap_width_mo = $bo_mobile_gallery_width + 30;
?>

.rb_bbs_for_img img {width: <?php echo $bo_gallery_width ?>px; height:<?php echo $bo_gallery_height ?>; border-radius: 10px; object-fit: cover;}
.rb_bbs_wrap .rb_bbs_for .rb_bbs_for_cont {padding-right: <?php echo $gap_width_pc ?>px !important;}

@media all and (max-width:1024px) { 
    .rb_bbs_for_img img {width: <?php echo $bo_mobile_gallery_width ?>px; height:<?php echo $bo_mobile_gallery_height ?>}
    .rb_bbs_wrap .rb_bbs_for .rb_bbs_for_cont {padding-right: <?php echo $gap_width_mo ?>px !important;}
}
