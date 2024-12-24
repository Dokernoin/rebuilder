<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

            
<?php
$i = 0; // $i 변수를 초기화

while ($row = sql_fetch_array($result)) {
    $bn_border  = isset($row['bn_border']) && $row['bn_border'] ? ' bn_border' : '';
    $bn_radius  = isset($row['bn_radius']) && $row['bn_radius'] ? ' bn_radius' : '';
    
    // 새창 옵션
    $bn_new_win = isset($row['bn_new_win']) && $row['bn_new_win'] ? ' target="_blank"' : '';
    
    if ($i == 0) echo '<div class="random_bn">'.PHP_EOL;
    
    $bimg = G5_DATA_PATH.'/banners/'.$row['bn_id'];
    if (file_exists($bimg)) {
        $banner = '';
        $size = getimagesize($bimg);
        echo '<div class="random_item top_ad'.$bn_border.$bn_radius.'">'.PHP_EOL;
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://') {
            $banner .= '<a href="'.G5_URL.'/rb/rb.mod/banner/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';
        }
        echo $banner.'<img src="'.G5_DATA_URL.'/banners/'.$row['bn_id'].'?ver='.G5_SERVER_TIME.'" title="'.get_text($row['bn_alt']).'" width="100%">';
        if ($banner) {
            echo '</a>'.PHP_EOL;
        }
        
        if (isset($row['bn_ad_ico']) && $row['bn_ad_ico']) {
            echo '<span class="ico_ad">AD</span>'.PHP_EOL;
        }
        echo '</div>'.PHP_EOL;
    }
    $i++;
}

if ($i > 0) echo '</div>'.PHP_EOL;
?>
