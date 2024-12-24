<?php
include_once('../../../../../common.php');
header("Content-Type: text/css");
$bo_gallery_height = isset($_GET['bo_gallery_height']) ? htmlspecialchars($_GET['bo_gallery_height']).'px' : htmlspecialchars($rb_core['bo_gallery_height']).'px';
$bo_mobile_gallery_height = isset($_GET['bo_mobile_gallery_height']) ? htmlspecialchars($_GET['bo_mobile_gallery_height']).'px' : htmlspecialchars($rb_core['bo_mobile_gallery_height']).'px';
?>

.gallery-item-img img {width: 100%; height:<?php echo $bo_gallery_height ?>; border-radius: 10px; object-fit: cover;}

@media all and (max-width:1024px) { 
    .gallery-item-img img {height:<?php echo $bo_mobile_gallery_height ?>}
}
