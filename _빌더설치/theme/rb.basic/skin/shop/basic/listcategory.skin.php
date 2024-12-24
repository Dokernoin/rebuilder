<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$str = '';
$exists = false;

$ca_id_len = strlen($ca_id);
$ca_id_len_mi = substr($ca_id, 0, -2);
$len2 = $ca_id_len + 2;
$len4 = $ca_id_len + 4;

$ca_is = sql_fetch (" select COUNT(*) as cnt from {$g5['g5_shop_category_table']} where ca_id like '$ca_id%' and length(ca_id) = $len2 and ca_use = '1' ");
if($ca_is['cnt'] == 0) { 
    $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '$ca_id_len_mi%' and length(ca_id) = $ca_id_len and ca_use = '1' order by ca_order, ca_id ";
} else { 
    $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']} where ca_id like '$ca_id%' and length(ca_id) = $len2 and ca_use = '1' order by ca_order, ca_id ";
}

$result = sql_query($sql);


while ($row=sql_fetch_array($result)) {

    $row2 = sql_fetch(" select count(*) as cnt from {$g5['g5_shop_item_table']} where (ca_id like '{$row['ca_id']}%' or ca_id2 like '{$row['ca_id']}%' or ca_id3 like '{$row['ca_id']}%') and it_use = '1'  ");
    if($ca_id == $row['ca_id']) {
        $class_act = "font-B main_color";
    } else { 
        $class_act = "";
    }
    $str .= "<li class=\"swiper-slide swiper-slide-ss\"><a href=\"".shop_category_url($row['ca_id'])."\" class=\"{$class_act}\">{$row['ca_name']} (".$row2['cnt'].")</a></li>";
}

if ($ca_id_len > 2) {
    $ca_idx_prev = substr($ca_id, 0, -2);
    $links = shop_category_url($ca_idx_prev);
    $str .= "<li class=\"swiper-slide swiper-slide-ss\"><a href=\"{$links}\" class=\"ss_back\">뒤로</a></li>";
}


    // add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
    add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_SKIN_URL.'/style.css">', 0);
?>

<!-- 상품분류 1 시작 { -->
<aside id="sct_ct_1" class="sct_ct">
    <ul>
            <div class="swiper-container swiper-container-ss">
                <ul class="swiper-wrapper swiper-wrapper-ss flex_ct">
                    <?php echo $str; ?>
                </ul>
            </div>

            <script>
                var swiper = new Swiper('.swiper-container-ss', {
                    slidesPerView: 'auto', //가로갯수
                    spaceBetween: 25, // 간격
                    touchRatio: 1, // 드래그 가능여부(1, 0)
                    slidesOffsetBefore: 20, //좌측여백 px
                    slidesOffsetAfter: 20, // 우측여백 px

                    breakpoints: { // 반응형 처리
                        1024: {
                            slidesPerView: 'auto',
                            touchRatio: 1,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 'auto',
                            touchRatio: 1,
                            spaceBetween: 20,
                        },
                        10: {
                            slidesPerView: 'auto',
                            touchRatio: 1,
                            spaceBetween: 20,
                        }
                    }

                });
            </script>
        
    </ul>
</aside>
<!-- } 상품분류 1 끝 -->
