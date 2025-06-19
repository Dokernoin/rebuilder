<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<?php run_event('tail_sub'); ?>

</main>

<?php // 앱 토큰을 위한 처리
    if (!isset($app)) {
        $app = []; // $app 변수를 배열로 초기화
    }

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($app['ap_title']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == $app['ap_title']) {
        if(isset($member['mb_id']) && $member['mb_id']) {
    ?>

        <script>
            function setMsg(msg) {
                //alert(msg); // 토큰 확인을 위해 alert 추가
                $.post("<?php echo G5_URL ?>/rb/rb.lib/ajax.token_update.php", { 
                    user_idx: "<?php echo $member['mb_id'] ?>", 
                    token: msg  
                }, function(result){ 
                    console.log("Token update result: " + result); 
                });        
            }

            // 초기화 및 토큰 요청
            window.onload = function() {
                setTimeout(function() {
                    window.Android.call_log('token');
                }, 2000); // 일정 시간 후에 호출하여 토큰을 전달받도록 합니다.
            }
        </script>
    <?php
        }
    }
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // PHP 데이터를 JavaScript 객체로 전달
        const rbConfig = {
            headerColor: "<?php echo $rb_config['co_header'] ?>",
            headerSet: "<?php echo $rb_core['header'] ?>",
            logoMo: "<?php echo !empty($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w']) ? G5_URL . '/data/logos/mo' : G5_THEME_URL . '/rb.img/logos/mo.png' ?>",
            logoMoWhite: "<?php echo !empty($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w']) ? G5_URL . '/data/logos/mo_w' : G5_THEME_URL . '/rb.img/logos/mo_w.png' ?>",
            logoPc: "<?php echo !empty($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w']) ? G5_URL . '/data/logos/pc' : G5_THEME_URL . '/rb.img/logos/pc.png' ?>",
            logoPcWhite: "<?php echo !empty($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w']) ? G5_URL . '/data/logos/pc_w' : G5_THEME_URL . '/rb.img/logos/pc_w.png' ?>",
            serverTime: "<?php echo G5_SERVER_TIME ?>"
        };

        // 밝기 계산 함수
        function isLightColor(hex) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            const yiq = (r * 299 + g * 587 + b * 114) / 1000;
            return yiq >= 210;
        }

        // 밝기와 텍스트 색상 결정
        const isLight = isLightColor(rbConfig.headerColor);
        const newTextCode = isLight ? 'black' : 'white';

        // 링크 태그 업데이트
        const headerHref = `<?php echo G5_URL ?>/rb/rb.css/set.header.php?rb_header_set=${rbConfig.headerSet}&rb_header_code=${encodeURIComponent(rbConfig.headerColor)}&rb_header_txt=${newTextCode}`;
        const headerLink = document.querySelector('link[href*="set.header.php"]');
        if (headerLink) {
            headerLink.setAttribute('href', headerHref);
        }

        // 로고 이미지 업데이트
        const newSrcset1 = isLight ? rbConfig.logoMo : rbConfig.logoMoWhite;
        const newSrcset2 = isLight ? rbConfig.logoPc : rbConfig.logoPcWhite;

        const sourceSmall = document.getElementById('sourceSmall');
        const sourceLarge = document.getElementById('sourceLarge');
        const fallbackImage = document.getElementById('fallbackImage');

        if (sourceSmall) {
            sourceSmall.setAttribute('srcset', `${newSrcset1}?ver=${rbConfig.serverTime}`);
        }
        if (sourceLarge) {
            sourceLarge.setAttribute('srcset', `${newSrcset2}?ver=${rbConfig.serverTime}`);
        }
        if (fallbackImage) {
            fallbackImage.setAttribute('src', `${newSrcset2}?ver=${rbConfig.serverTime}`);
        }
        });
</script>

<?php
    $rb_core_colors = isset($rb_core['color']) ? $rb_core['color'] : '';
    $rb_core_headers = isset($rb_core['header']) ? $rb_core['header'] : '';
    $rb_config_colors = isset($rb_config['co_color']) ? $rb_config['co_color'] : '';
    $rb_config_headers = isset($rb_config['co_header']) ? $rb_config['co_header'] : '';

    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.color.php?rb_color_set=' . urlencode($rb_core_colors) . '&rb_color_code=' . urlencode($rb_config_colors) . '" />', 0);
    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.header.php?rb_header_set=' . urlencode($rb_core_headers) . '&rb_header_code=' . urlencode($rb_config_headers) . '" />', 0);
    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.style.css?ver='.G5_SERVER_TIME.'" />', 0);
?>
</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.
