<?php
if (!defined('_GNUBOARD_')) exit;

// 관리자 화면에서만 동작
if (!defined('G5_IS_ADMIN') || !G5_IS_ADMIN) return;

/**
 * admin head.sub.php에서 출력된 메타를 정리하고,
 * 아래 3개 메타만 </head> 직전에 주입
 */
if (!function_exists('rb_adm_meta_filter')) {
    function rb_adm_meta_filter($buffer) {
        if (stripos($buffer, '</head>') === false) return $buffer;


        $patterns = [
            // viewport(id or name)
            '/<meta[^>]+(?:id=["\']meta_viewport["\']|name=["\']viewport["\'])[^>]*>\s*/i',
            // HandheldFriendly
            '/<meta[^>]+name=["\']HandheldFriendly["\'][^>]*>\s*/i',
            // format-detection
            '/<meta[^>]+name=["\']format-detection["\'][^>]*>\s*/i',
            // (옵션) PC 옛 태그도 제거
            '/<meta[^>]+http-equiv=["\']imagetoolbar["\'][^>]*>\s*/i',
            '/<meta[^>]+http-equiv=["\']X-UA-Compatible["\'][^>]*>\s*/i',
        ];
        $buffer = preg_replace($patterns, '', $buffer);

        $inject = implode(PHP_EOL, [
            '<meta name="viewport" id="meta_viewport" content="width=device-width,initial-scale=0.9,minimum-scale=0,maximum-scale=10">',
            '<meta name="HandheldFriendly" content="true">',
            '<meta name="format-detection" content="telephone=no">',
            '<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin_extend_rb_theme.css">',
            '<link rel="stylesheet" href="'.G5_THEME_URL.'/rb.fonts/Pretendard/Pretendard.css">',
            '<script src="'.G5_THEME_URL.'/rb.js/rb.common.js"></script>',
        ]) . PHP_EOL;

        // 3) </head> 바로 앞에 1회 삽입
        return preg_replace('/<\/head>/i', $inject.'</head>', $buffer, 1);
    }
}

// 가장 먼저 잡도록 버퍼 시작
if (!headers_sent()) {
    ob_start('rb_adm_meta_filter');
}
