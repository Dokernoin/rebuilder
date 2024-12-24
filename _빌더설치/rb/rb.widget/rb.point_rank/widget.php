<!--
경로 : /rb/rb.widget/rb.point_rank/
출처 : https://sir.kr/g5_skin/59210
제작자 : 미니님a

사용자코드를 입력하세요.
배너관리 > 출력형태 : 개별출력 ID=5 배너가 연동되어 있습니다.
배너를 변경하고자 하시는 경우 마지막 라인의 rb_banners() 함수의 ID를 변경해주세요.
-->

<?php

//모듈정보 불러오기
$md_id = $row_mod['md_id']; //현재 모듈 ID
$rb_skin = sql_fetch (" select * from {$rb_module_table} where md_id = '{$md_id}' "); //환경설정 테이블 조회
$md_subject = $rb_skin['md_title']; //모듈 타이틀

// 이번 주의 시작과 지난 주의 시작 계산
$this_week_start = date('Y-m-d', strtotime('last Monday'));
$last_week_start = date('Y-m-d', strtotime('last Monday -1 week'));
$last_week_end = date('Y-m-d', strtotime('last Sunday'));

// 출력 인원수
$limit = 10;

// 제외할 아이디
$exclude_ids_array = ['admin', 'webmaster', 'test3'];
$exclude_ids = implode("','", $exclude_ids_array);

// 현재 주의 총 포인트를 가져오는 쿼리
$sql_current_week = "
    SELECT
        m.mb_id,
        m.mb_nick,
        SUM(IFNULL(p.po_point, 0)) AS total_points
    FROM
        {$g5['member_table']} m
    LEFT JOIN
        {$g5['point_table']} p ON m.mb_id = p.mb_id
    WHERE
        m.mb_id NOT IN ('{$exclude_ids}')
    GROUP BY
        m.mb_id
    ORDER BY
        total_points DESC
    LIMIT {$limit}
";
$current_week_result = sql_query($sql_current_week);

// 지난 주의 총 포인트를 가져오는 쿼리
$sql_last_week = "
    SELECT
        m.mb_id,
        SUM(IFNULL(p.po_point, 0)) AS total_points
    FROM
        {$g5['member_table']} m
    LEFT JOIN
        {$g5['point_table']} p ON m.mb_id = p.mb_id
    WHERE
        m.mb_id NOT IN ('{$exclude_ids}')
        AND p.po_datetime BETWEEN '{$last_week_start}' AND '{$last_week_end}'
    GROUP BY
        m.mb_id
    ORDER BY
        total_points DESC
";
$last_week_result = sql_query($sql_last_week);

// 지난 주의 랭킹을 계산
$last_week_ranking = [];
$rank = 1;
while ($rows = sql_fetch_array($last_week_result)) {
    $last_week_ranking[$rows['mb_id']] = $rank++;
}

// 순위 변동 계산 함수
function get_rank_change($mb_id, $current_rank, $last_week_ranking) {
    if (isset($last_week_ranking[$mb_id])) {
        $last_rank = $last_week_ranking[$mb_id];
        $change = $last_rank - $current_rank;
        if ($change > 0) {
            return "<span style='color:blue'>▲ {$change}</span>";
        } elseif ($change < 0) {
            return "<span style='color:red'>▼ " . abs($change) . "</span>";
        } else {
            return "-";
        }
    } else {
        return "<span style='color:black'>New</span>";
    }
}
?>

<div class="bbs_main">

    <ul class="bbs_main_wrap_tit">
        <li class="bbs_main_wrap_tit_l"><a href="#">
                <h2 class="font-B"><?php echo $md_subject ?></h2>
            </a>
        </li>
        <!--
        <li class="bbs_main_wrap_tit_r">
            <button type="button" class="tiny_tab_btn active">보유</button>
            <button type="button" class="tiny_tab_btn">누적</button>
        </li>
        -->
        <div class="cb"></div>
    </ul>
    <ul class="bbs_main_wrap_point_con">
        <div class="swiper-container swiper-container-point_rank">
            <ul class="swiper-wrapper swiper-wrapper-point_rank">

                <?php
                    $rank = 1;
                    while ($rows = sql_fetch_array($current_week_result)) {
                        $mb_id = $rows['mb_id'];
                        $mb_nick = $rows['mb_nick'];
                        $total_points = number_format($rows['total_points']);
                        $rank_change = get_rank_change($mb_id, $rank, $last_week_ranking);

                        echo "<dd class='swiper-slide swiper-slide-point_rank'>";
                        if($rank == 1) {
                            echo "<span class='point_list_num top1_bg'>{$rank}</span>";
                        } else if($rank == 2) {
                            echo "<span class='point_list_num top2_bg'>{$rank}</span>";
                        } else { 
                            echo "<span class='point_list_num'>{$rank}</span>";
                        }
                        echo "<span class='point_list_name'><span class='cut'>{$mb_nick}</span></span>";
                        echo "<span class='point_list_point font-H'>{$total_points} P</span>";
                        //echo "<span class='point_list_ch'>{$rank_change}</span>";
                        echo "</dd>";
                        
                        $rank++;
                    }
                ?>
                <!-- } -->

            </ul>
        </div>

        <script>
            var swiper = new Swiper('.swiper-container-point_rank', {
                slidesPerColumnFill: 'row', //세로형
                slidesPerView: 2, //가로갯수
                slidesPerColumn: 5, // 세로갯수
                spaceBetween: 12, // 간격
                observer: true, //리셋
                observeParents: true, //리셋
                touchRatio: 0, // 드래그 가능여부

                breakpoints: { // 반응형
                    1024: {
                        slidesPerView: 2, //가로갯수
                        slidesPerColumn: 5, // 세로갯수

                        spaceBetween: 12, // 간격
                    },
                    10: {
                        slidesPerView: 1, //가로갯수
                        slidesPerColumn: 10, // 세로갯수

                        spaceBetween: 12, // 간격
                    }
                }

            });
        </script>

    </ul>


</div>