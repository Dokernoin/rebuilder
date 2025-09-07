<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$css_dir = G5_DATA_PATH . '/rb_custom_css';
$css_url = G5_DATA_URL  . '/rb_custom_css';

if (is_dir($css_dir)) {
    // 모든 css 수집 + 정렬
    $files = glob($css_dir.'/*.css') ?: [];
    sort($files, SORT_NATURAL | SORT_FLAG_CASE);

    // 캐시 무력화용 버전 문자열
    if (!function_exists('rb_css_ver')) {
        function rb_css_ver($path){
            $mt  = @filemtime($path) ?: time();
            $sz  = @filesize($path) ?: 0;
            $md5 = @md5_file($path);
            if (!$md5) $md5 = md5($mt.$sz);
            return $mt.'-'.$sz.'-'.substr($md5,0,8);
        }
    }

    foreach ($files as $f) {
        $id   = 'rb-css-'.pathinfo($f, PATHINFO_FILENAME);
        $ver  = rb_css_ver($f);
        $href = $css_url . '/' . basename($f) . '?v=' . $ver;

        // 테마/플러그인보다 뒤에서 로드되도록 우선순위 넉넉히
        add_stylesheet(
            '<link id="'.htmlspecialchars($id, ENT_QUOTES).'" rel="stylesheet" href="'.
            htmlspecialchars($href, ENT_QUOTES).'" media="all">',
            99
        );
    }
}
