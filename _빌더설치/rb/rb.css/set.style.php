<?php
include_once('../../common.php');
header("Content-Type: text/css");
$rb_color_code = isset($_GET['rb_color_code']) ? htmlspecialchars($_GET['rb_color_code']) : htmlspecialchars($rb_config['co_color']);

$rb_header_color = !empty($rb_config['co_header']) ? $rb_config['co_header'] : '';
$rb_main_width = !empty($rb_core['main_width']) ? $rb_core['main_width'].'px' : '';
$rb_sub_width = !empty($rb_core['sub_width']) ? $rb_core['sub_width'].'px' : '';
$rb_tb_width = !empty($tb_width_inner) ? $tb_width_inner : '';
$rb_gap = !empty($rb_core['gap_pc']) ? $rb_core['gap_pc'].'px' : '';
$rb_gap_mo = !empty($rb_core['gap_mo']) ? $rb_core['gap_mo'] : '';
$rb_main_bg = !empty($rb_core['main_bg']) ? $rb_core['main_bg'] : '';
$rb_sub_bg = !empty($rb_core['sub_bg']) ? $rb_core['sub_bg'] : '';

$rb_padding_top_sub = isset($rb_core['padding_top_sub']) && $rb_core['padding_top_sub'] != "" ? $rb_core['padding_top_sub'].'px' : '40px';
$rb_padding_btm_sub = isset($rb_core['padding_btm_sub']) && $rb_core['padding_btm_sub'] != "" ? $rb_core['padding_btm_sub'].'px' : '40px';
$rb_padding_top = isset($rb_core['padding_top']) && $rb_core['padding_top'] != "" ? $rb_core['padding_top'].'px' : '40px';
$rb_padding_btm = isset($rb_core['padding_btm']) && $rb_core['padding_btm'] != "" ? $rb_core['padding_btm'].'px' : '40px';

$rb_padding_top_sub_shop = isset($rb_core['padding_top_sub_shop']) && $rb_core['padding_top_sub_shop'] != "" ? $rb_core['padding_top_sub_shop'].'px' : '40px';
$rb_padding_btm_sub_shop = isset($rb_core['padding_btm_sub_shop']) && $rb_core['padding_btm_sub_shop'] != "" ? $rb_core['padding_btm_sub_shop'].'px' : '40px';
$rb_padding_top_shop = isset($rb_core['padding_top_shop']) && $rb_core['padding_top_shop'] != "" ? $rb_core['padding_top_shop'].'px' : '40px';
$rb_padding_btm_shop = isset($rb_core['padding_btm_shop']) && $rb_core['padding_btm_shop'] != "" ? $rb_core['padding_btm_shop'].'px' : '40px';

$is_index = isset($_GET['rb_is_index']) ? $_GET['rb_is_index'] : 0;
$is_shop = isset($_GET['rb_is_shop']) ? $_GET['rb_is_shop'] : 0;
?>

:root {
  --rb-main-color: <?php echo $rb_color_code; ?>;
  --rb-sub-color: #25282B;
  --rb-main-bg: <?php echo $rb_main_bg; ?>;
  --rb-sub-bg: <?php echo $rb_sub_bg; ?>;
  --rb-header-color: <?php echo $rb_header_color; ?>;
  --rb-main-width: <?php echo $rb_main_width; ?>;
  --rb-sub-width: <?php echo $rb_sub_width; ?>;
  --rb-header-width: <?php echo $rb_tb_width; ?>;
  --rb-footer-width: <?php echo $rb_tb_width; ?>;
  --rb-gap: <?php echo $rb_gap; ?>;
  --rb-padding-top: <?php echo $rb_padding_top; ?>;
  --rb-padding-btm: <?php echo $rb_padding_btm; ?>;
  --rb-padding-top-sub: <?php echo $rb_padding_top_sub; ?>;
  --rb-padding-btm-sub: <?php echo $rb_padding_btm_sub; ?>;

  --rb-padding-top-shop: <?php echo $rb_padding_top_shop; ?>;
  --rb-padding-btm-shop: <?php echo $rb_padding_btm_shop; ?>;
  --rb-padding-top-sub-shop: <?php echo $rb_padding_top_sub_shop; ?>;
  --rb-padding-btm-sub-shop: <?php echo $rb_padding_btm_sub_shop; ?>;
}


<?php if(isset($is_index) && $is_index == '1') { ?>

    main {background-color:var(--rb-main-bg);}
    body, html {background-color:var(--rb-main-bg);}
    <?php if(isset($is_shop) && $is_shop == '1') { ?>
    section.index {padding-top:var(--rb-padding-top-shop); padding-bottom:var(--rb-padding-btm-shop); width:var(--rb-main-width);}
    <?php } else { ?>
    section.index {padding-top:var(--rb-padding-top); padding-bottom:var(--rb-padding-btm); width:var(--rb-main-width);}
    <?php } ?>

<?php } else { ?>

    main {background-color:var(--rb-sub-bg);}
    body, html {background-color:var(--rb-sub-bg);}
    <?php if(isset($is_shop) && $is_shop == '1') { ?>
    section.sub {padding-top:var(--rb-padding-top-sub-shop); padding-bottom:var(--rb-padding-btm-sub-shop); width:var(--rb-sub-width);}
    <?php } else { ?>
    section.sub {padding-top:var(--rb-padding-top-sub); padding-bottom:var(--rb-padding-btm-sub); width:var(--rb-sub-width);}
    <?php } ?>

<?php } ?>

@media all and (max-width:1024px) {
   #rb_sidemenu {margin-top:var(--rb-gap);}
   #rb_sidemenu_shop {margin-top:var(--rb-gap);}
   <?php if($rb_gap_mo == 1) { ?>
    .flex_box {gap:var(--rb-gap) 0px;}
    .content_box {padding-top:0px !important; padding-bottom: 0px !important
    <?php } ?>
}
