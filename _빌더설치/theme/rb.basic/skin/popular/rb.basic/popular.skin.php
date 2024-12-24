<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$popular_skin_url.'/style.css">', 0);
?>


<?php
if( isset($list) && is_array($list) ){
    for ($i=0; $i<count($list); $i++) {
?>
    <a class="ser_label" href="javascript:void(0);" data-key="<?php echo get_text($list[$i]['pp_word']); ?>"><b>#</b> <?php echo get_text($list[$i]['pp_word']); ?></a>
<?php
    }   //end for
}   //end if
?>



<?php if (isset($list) && $list && is_array($list)) { //게시물이 있다면 ?>
<?php } else { ?>
<div class="no_data" style="padding-top:0px !important; padding-bottom:30px !important;">키워드가 없습니다.</div>
<?php } ?>
<!-- } 인기검색어 끝 -->