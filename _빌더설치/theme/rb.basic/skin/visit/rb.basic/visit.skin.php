<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

global $is_admin;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<div class="visit_flex">
    <ul><li class="RealCount_t main_color font-B">RealCount</li>
        <li>오늘 <span class="font-B"><?php echo number_format($visit[1]) ?></span></li>
        <li>어제 <span class="font-B"><?php echo number_format($visit[2]) ?></span></li>
        <li>최대 <span class="font-B"><?php echo number_format($visit[3]) ?></span></li>
        <li>전체 <span class="font-B"><?php echo number_format($visit[4]) ?></span></li>
    </ul>
</div>

