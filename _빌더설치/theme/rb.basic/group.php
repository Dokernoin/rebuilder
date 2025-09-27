<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/group.php');
    return;
}

if(!$is_admin && $group['gr_device'] == 'mobile')
    alert($group['gr_subject'].' 그룹은 모바일에서만 접근할 수 있습니다.');

$g5['title'] = $group['gr_subject'];
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
?>

<style>
    #container_title {display: none;}
    .sub {padding-left: 0px !important; padding-right: 0px !important;}
</style>

<?php if(isset($gr_id) && $gr_id) { ?>
    <div class="rb_gr flex_box" data-layout="rb_gr_<?php echo $gr_id ?>"></div>
<?php } ?>

<?php
include_once(G5_THEME_PATH.'/tail.php');
