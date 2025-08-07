<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
add_javascript('<script src="'.G5_URL.'/js/rb.common.js"></script>', 0);

$pattern1 = "/[\<\>\'\"\\\'\\\"\(\)]/";
$pattern2 = "/\r\n|\r|\n|[^\x20-\x7e]/";

$url1 = isset($url1) ? preg_replace($pattern1, "", clean_xss_tags($url1, 1)) : '';
$url1 = preg_replace($pattern2, "", $url1);
$url2 = isset($url2) ? preg_replace($pattern1, "", clean_xss_tags($url2, 1)) : '';
$url2 = preg_replace($pattern2, "", $url2);
$url3 = isset($url3) ? preg_replace($pattern1, "", clean_xss_tags($url3, 1)) : '';
$url3 = preg_replace($pattern2, "", $url3);

$msg = isset($msg) ? $msg : '';
$header = isset($header) ? $msg : '';

// url 체크
check_url_host($url1);
check_url_host($url2);
check_url_host($url3);
?>

<style>
.rb-custom-alert-popup {
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 400px;
    background: #fff;
    color: #000;
    padding: 25px 25px;
    border-radius: 15px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.05);
    font-size: 15px;
    text-align: center;
    word-break: keep-all;
    line-height: 140%;
    animation: customAlertShow 0.22s cubic-bezier(.68,-0.55,.27,1.55);
    z-index: 12345678905;
}

.rb-custom-alert-popup svg {opacity: 0.2; margin-bottom: 10px;}

.rb-custom-alert-popup-bg {
    position: fixed;
    left: 0;
    top: 0;
    z-index: 12345678904;
    width: 100%;
    height:100%;
    background: rgba(0,0,0,0.2);
}

.rb-custom-alert-popup .rb-alert-btn {
    display:inline-block; padding:12px 25px; font-size:15px;
    color:#25282B; border:none; border-radius:10px; cursor:pointer; background-color: #ced3db !important;
}

.rb-custom-alert-popup .rb-alert-btn.rb-btn-ok {
    background-color: #25282B !important;
    color:#fff !important;
}


@keyframes customAlertShow {
    from { opacity:0; transform: translate(-50%, -46%) scale(0.97);}
    to   { opacity:1; transform: translate(-50%, -50%) scale(1);}
}

@media all and (max-width:512px) {
    .rb-custom-alert-popup {width: 90%;}
}
</style>

<script>
var conf = "<?php echo strip_tags($msg); ?>";

rb_confirm(conf).then(function(confirmed) {
    if (confirmed) {
        document.location.replace("<?php echo $url1; ?>");
    } else {
        document.location.replace("<?php echo $url2; ?>");
    }
});
</script>

<noscript>
<article id="confirm_check">
<header>
    <hgroup>
        <h1><?php echo get_text(strip_tags($header)); ?></h1> <!-- 수행 중이던 작업 내용 -->
        <h2>아래 내용을 확인해 주세요.</h2>
    </hgroup>
</header>
<p>
    <?php echo get_text(strip_tags($msg)); ?>
</p>

<a href="<?php echo $url1; ?>">확인</a>
<a href="<?php echo $url2; ?>">취소</a><br><br>
<a href="<?php echo $url3; ?>">돌아가기</a>
</article>
</noscript>

<?php
include_once(G5_PATH.'/tail.sub.php');
