<?php
include_once('../common.php');
@set_time_limit(0);

$sitemap_file = G5_PATH . '/sitemap.xml';
$base_url = G5_URL;

// XML 시작
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

// 게시판
$boards = [];
$res = sql_query("SELECT bo_table FROM {$g5['board_table']} WHERE bo_use_search='1'");
while ($r = sql_fetch_array($res)) $boards[] = $r['bo_table'];

// 게시판 메인 URL
foreach ($boards as $bo_table) {
    $xml .= '  <url>';
    $xml .= '<loc>' . htmlspecialchars($base_url.'/bbs/board.php?bo_table='.$bo_table, ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
    $xml .= '<changefreq>daily</changefreq><priority>0.7</priority>';
    $xml .= '</url>' . PHP_EOL;
}

// 게시글
foreach ($boards as $bo_table) {
    $sql = "SELECT wr_id, wr_last, wr_option FROM {$g5['write_prefix']}{$bo_table} WHERE wr_is_comment=0";
    $res = sql_query($sql);
    while ($r = sql_fetch_array($res)) {
        if (strpos($r['wr_option'],'secret')!==false) continue;
        $xml .= '  <url>';
        $xml .= '<loc>' . htmlspecialchars($base_url.'/bbs/board.php?bo_table='.$bo_table.'&wr_id='.$r['wr_id'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
        $xml .= '<lastmod>' . date('Y-m-d', strtotime($r['wr_last'])) . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq><priority>1.0</priority>';
        $xml .= '</url>' . PHP_EOL;
    }
}

// 일반페이지
$res = sql_query("SELECT co_id FROM {$g5['content_table']}");
while ($r = sql_fetch_array($res)) {
    $xml .= '  <url>';
    $xml .= '<loc>' . htmlspecialchars($base_url.'/bbs/content.php?co_id='.$r['co_id'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
    $xml .= '<lastmod>' . date('Y-m-d') . '</lastmod>';
    $xml .= '<changefreq>monthly</changefreq><priority>0.5</priority>';
    $xml .= '</url>' . PHP_EOL;
}

// 카테고리
$res = sql_query("SELECT ca_id FROM {$g5['g5_shop_category_table']} WHERE ca_use='1'");
while ($r = sql_fetch_array($res)) {
    $xml .= '  <url>';
    $xml .= '<loc>' . htmlspecialchars($base_url.'/shop/list.php?ca_id='.$r['ca_id'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
    $xml .= '<changefreq>weekly</changefreq><priority>0.7</priority>';
    $xml .= '</url>' . PHP_EOL;
}

// 상품 - 히트/추천/신/인기/할인 → 가장 먼저! (priority 1.0, 중복X)
$special_types = [
    'it_type1' => '히트',
    'it_type2' => '추천',
    'it_type3' => '신상품',
    'it_type4' => '인기',
    'it_type5' => '할인',
];
$already_output = [];
foreach ($special_types as $col => $desc) {
    $sql = "SELECT it_id, it_time FROM {$g5['g5_shop_item_table']} WHERE it_use='1' AND {$col}='1'";
    $res = sql_query($sql);
    while ($r = sql_fetch_array($res)) {
        if (isset($already_output[$r['it_id']])) continue;
        $already_output[$r['it_id']] = 1;
        $xml .= '  <url>';
        $xml .= '<loc>' . htmlspecialchars($base_url.'/shop/item.php?it_id='.$r['it_id'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
        $xml .= '<lastmod>' . date('Y-m-d', strtotime($r['it_time'])) . '</lastmod>';
        $xml .= '<changefreq>daily</changefreq><priority>1.0</priority>';
        $xml .= '</url>' . PHP_EOL;
    }
}

// 상품 - 나머지 전체 상품 (히트/추천/신/인기/할인 중복제외, priority 0.9)
$res = sql_query("SELECT it_id, it_time FROM {$g5['g5_shop_item_table']} WHERE it_use='1'");
while ($r = sql_fetch_array($res)) {
    if (isset($already_output[$r['it_id']])) continue;
    $already_output[$r['it_id']] = 1;
    $xml .= '  <url>';
    $xml .= '<loc>' . htmlspecialchars($base_url.'/shop/item.php?it_id='.$r['it_id'], ENT_QUOTES | ENT_XML1, 'UTF-8') . '</loc>';
    $xml .= '<lastmod>' . date('Y-m-d', strtotime($r['it_time'])) . '</lastmod>';
    $xml .= '<changefreq>daily</changefreq><priority>0.9</priority>';
    $xml .= '</url>' . PHP_EOL;
}

$xml .= '</urlset>';

file_put_contents($sitemap_file, $xml);

// 기존 se_robots 불러오기
$row = sql_fetch("SELECT se_robots FROM rb_seo LIMIT 1");
$robots = $row['se_robots'] ?? '';
$robots = trim($robots);

// 모든 기존 Sitemap 줄 제거 (정규식)
$robots = preg_replace('#^Sitemap:.*$#mi', '', $robots);
$robots = trim($robots);

// 새 줄 추가
$sitemap_url = G5_URL . '/sitemap.xml';
$sitemap_line = "Sitemap: {$sitemap_url}";
if ($robots !== '' && substr($robots, -1) !== "\n") {
    $robots .= "\n";
}
$robots .= $sitemap_line . "\n";

// 저장
sql_query("UPDATE rb_seo SET se_robots = '".sql_real_escape_string($robots)."'");

// robots.txt 생성
$filePath = G5_PATH . '/robots.txt';
file_put_contents($filePath, $robots);

// AJAX 경로 반환
echo json_encode([
    'success' => true,
    'url' => G5_URL . '/sitemap.xml'
]);
exit;
?>
