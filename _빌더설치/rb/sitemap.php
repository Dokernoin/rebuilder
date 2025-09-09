<?php
// sitemap.build.php (그누보드 기반 사이트맵 생성)
// - 공개 보드/게시글/콘텐츠/쇼핑 카테고리/상품 포함
// - URL은 get_pretty_url() 우선, 없으면 기본 URL 폴백
// - <lastmod> ISO8601(date('c')) 사용 (게시글/상품에 한함)
// - 원자적 파일 쓰기(tmp→rename) 적용
// - robots.txt 및 rb_seo.se_robots에 Sitemap 라인 최신화
// - 분할/압축 없이 단일 sitemap.xml 생성

include_once('../common.php');
@set_time_limit(0);
header('Content-Type: application/json; charset=utf-8');

if (!defined('G5_PATH') || !defined('G5_URL')) {
    echo json_encode(['success' => false, 'msg' => 'G5_PATH/G5_URL undefined']); exit;
}

// 경로/URL
$sitemap_file = G5_PATH . '/sitemap.xml';
$base_url     = G5_URL;
$bbs_url      = defined('G5_BBS_URL') ? G5_BBS_URL : (G5_URL . '/bbs');

// 원자적 쓰기 헬퍼
function rb_write_atomic($path, $content) {
    $tmp = $path . '.tmp';
    if (file_put_contents($tmp, $content, LOCK_EX) === false) return false;
    if (!@rename($tmp, $path)) { @unlink($tmp); return false; }
    return true;
}

// URL 이스케이프 헬퍼
function esc_loc($url) {
    return htmlspecialchars($url, ENT_XML1 | ENT_QUOTES, 'UTF-8');
}

// === XML 시작 ===
$xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// 메인페이지
$xml .= "  <url>";
$xml .= '<loc>' . esc_loc($base_url) . '</loc>';
$xml .= '<changefreq>daily</changefreq><priority>1.0</priority>';
$xml .= "</url>\n";

// ===== 보드/게시글 (공개 보드만) =====
$boards = [];
$sql = "
    SELECT bo_table
      FROM {$g5['board_table']}
     WHERE bo_use_search='1'
       AND bo_list_level='1'
       AND bo_read_level='1'
";
$res = sql_query($sql);
while ($r = sql_fetch_array($res)) {
    if (!empty($r['bo_table'])) $boards[] = $r['bo_table'];
}

// 보드 메인 URL
foreach ($boards as $bo_table) {
    if (function_exists('get_pretty_url')) {
        $loc = get_pretty_url($bo_table);
    } else {
        $loc = $bbs_url . '/board.php?bo_table=' . urlencode($bo_table);
    }
    $xml .= "  <url>";
    $xml .= '<loc>' . esc_loc($loc) . '</loc>';
    $xml .= '<changefreq>daily</changefreq><priority>0.7</priority>';
    $xml .= "</url>\n";
}

// 게시글 URL
foreach ($boards as $bo_table) {
    $wsql = "
        SELECT wr_id, wr_last, wr_option
          FROM {$g5['write_prefix']}{$bo_table}
         WHERE wr_is_comment = 0
    ";
    $wres = sql_query($wsql);
    while ($w = sql_fetch_array($wres)) {
        // 비밀글 제외
        $opt = (string)($w['wr_option'] ?? '');
        if (strpos($opt, 'secret') !== false) continue;

        if (function_exists('get_pretty_url')) {
            $loc = get_pretty_url($bo_table, $w['wr_id']);
        } else {
            $loc = $bbs_url . '/board.php?bo_table=' . urlencode($bo_table) . '&wr_id=' . (int)$w['wr_id'];
        }

        $xml .= "  <url>";
        $xml .= '<loc>' . esc_loc($loc) . '</loc>';
        if (!empty($w['wr_last'])) {
            $ts = strtotime($w['wr_last']);
            if ($ts) $xml .= '<lastmod>' . date('c', $ts) . '</lastmod>';
        }
        $xml .= '<changefreq>daily</changefreq><priority>1.0</priority>';
        $xml .= "</url>\n";
    }
}

// ===== 일반페이지(content) =====
$cres = sql_query("SELECT co_id FROM {$g5['content_table']}");
while ($c = sql_fetch_array($cres)) {
    $co_id = $c['co_id'] ?? '';
    if ($co_id === '') continue;

    if (function_exists('get_pretty_url')) {
        $loc = get_pretty_url('content', $co_id);
    } else {
        $loc = $bbs_url . '/content.php?co_id=' . urlencode($co_id);
    }

    $xml .= "  <url>";
    $xml .= '<loc>' . esc_loc($loc) . '</loc>';
    // content는 수정일 컬럼 표준이 없어 lastmod 생략 권장
    $xml .= '<changefreq>monthly</changefreq><priority>0.5</priority>';
    $xml .= "</url>\n";
}

// ===== 쇼핑몰 =====
if (defined('G5_USE_SHOP') && G5_USE_SHOP) {

    // 카테고리
    $catres = sql_query("SELECT ca_id FROM {$g5['g5_shop_category_table']} WHERE ca_use='1'");
    while ($cr = sql_fetch_array($catres)) {
        $ca_id = $cr['ca_id'] ?? '';
        if ($ca_id === '') continue;
        $loc = G5_URL . '/shop/list.php?ca_id=' . urlencode($ca_id);
        $xml .= "  <url>";
        $xml .= '<loc>' . esc_loc($loc) . '</loc>';
        $xml .= '<changefreq>weekly</changefreq><priority>0.7</priority>';
        $xml .= "</url>\n";
    }

    // 스페셜 상품(히트/추천/신/인기/할인) 먼저(중복 방지)
    $special_types = [
        'it_type1' => 'hit',
        'it_type2' => 'recom',
        'it_type3' => 'new',
        'it_type4' => 'pop',
        'it_type5' => 'sale',
    ];
    $already = [];

    foreach ($special_types as $col => $_desc) {
        $isql = "
            SELECT it_id, it_time
              FROM {$g5['g5_shop_item_table']}
             WHERE it_use='1' AND {$col}='1'
        ";
        $ires = sql_query($isql);
        while ($it = sql_fetch_array($ires)) {
            $it_id  = $it['it_id'] ?? '';
            if ($it_id === '' || isset($already[$it_id])) continue;
            $already[$it_id] = 1;

            $loc = G5_URL . '/shop/item.php?it_id=' . urlencode($it_id);

            $xml .= "  <url>";
            $xml .= '<loc>' . esc_loc($loc) . '</loc>';
            if (!empty($it['it_time'])) {
                $ts = strtotime($it['it_time']);
                if ($ts) $xml .= '<lastmod>' . date('c', $ts) . '</lastmod>';
            }
            $xml .= '<changefreq>daily</changefreq><priority>1.0</priority>';
            $xml .= "</url>\n";
        }
    }

    // 나머지 전체 상품 (중복 제외)
    $aisql = "SELECT it_id, it_time FROM {$g5['g5_shop_item_table']} WHERE it_use='1'";
    $aires = sql_query($aisql);
    while ($it = sql_fetch_array($aires)) {
        $it_id  = $it['it_id'] ?? '';
        if ($it_id === '' || isset($already[$it_id])) continue;
        $already[$it_id] = 1;

        $loc = G5_URL . '/shop/item.php?it_id=' . urlencode($it_id);

        $xml .= "  <url>";
        $xml .= '<loc>' . esc_loc($loc) . '</loc>';
        if (!empty($it['it_time'])) {
            $ts = strtotime($it['it_time']);
            if ($ts) $xml .= '<lastmod>' . date('c', $ts) . '</lastmod>';
        }
        $xml .= '<changefreq>daily</changefreq><priority>0.9</priority>';
        $xml .= "</url>\n";
    }
}

// 닫기
$xml .= '</urlset>';


if (!rb_write_atomic($sitemap_file, $xml)) {
    echo json_encode(['success' => false, 'msg' => 'sitemap write failed']); exit;
}

// === robots 라인 구성 ===
$robots = '';
$rb_seo_ok = false;
$rb_row = null;

$sql = "SELECT se_robots FROM rb_seo LIMIT 1";
$rb_res = @sql_query($sql);
if ($rb_res) {
    $rb_row = @sql_fetch_array($rb_res);
    if ($rb_row && isset($rb_row['se_robots'])) {
        $robots = (string)$rb_row['se_robots'];
        $rb_seo_ok = true;
    }
}
$robots = trim($robots);

// 기존 Sitemap 라인 제거
$robots = preg_replace('#^Sitemap:.*$#mi', '', $robots);
$robots = trim($robots);

// 새 Sitemap 라인 추가
$sitemap_url  = G5_URL . '/sitemap.xml';
$append_lines = [];
$append_lines[] = "Sitemap: {$sitemap_url}";

if ($robots !== '' && substr($robots, -1) !== "\n") $robots .= "\n";
$robots .= implode("\n", $append_lines) . "\n";

// rb_seo 저장(가능할 때만)
if ($rb_seo_ok) {
    $esc = function_exists('sql_real_escape_string') ? sql_real_escape_string($robots) : addslashes($robots);
    @sql_query("UPDATE rb_seo SET se_robots = '{$esc}'");
}


$filePath = G5_PATH . '/robots.txt';
if (!rb_write_atomic($filePath, $robots)) {
    echo json_encode(['success' => false, 'msg' => 'robots write failed']); exit;
}

// === 응답 ===
echo json_encode([
    'success' => true,
    'url'     => $sitemap_url
]);
exit;
