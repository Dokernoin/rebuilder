<?php
include_once('./_common.php');
include_once(G5_PATH.'/head.sub.php');
add_javascript('<script src="'.G5_URL.'/js/rb.common.js"></script>', 0);

$msg = isset($msg) ? strip_tags($msg) : '';

$msg2 = str_replace("\\n", "<br>", $msg);

if($error) {
    $header2 = "다음 항목에 오류가 있습니다.";
    $msg3 = "새창을 닫으시고 이전 작업을 다시 시도해 주세요.";
} else {
    $header2 = "다음 내용을 확인해 주세요.";
    $msg3 = "새창을 닫으신 후 서비스를 이용해 주세요.";
}
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
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: break-word;
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
alert("<?php echo $msg; ?>", function(){
    try {
        window.close();
    } catch(error) {
        history.back();
    }
    setTimeout(function() {
        if (window.history.length) {
            window.history.back();
        }
    }, 500);
});
</script>

<noscript>
<div id="validation_check">
    <h1><?php echo $header2 ?></h1>
    <p class="cbg">
        <?php echo $msg2 ?>
    </p>
    <p class="cbg">
        <?php echo $msg3 ?>
    </p>

</div>

<?php /*
<article id="validation_check">
<header>
    <hgroup>
        <!-- <h1>회원가입 정보 입력 확인</h1> --> <!-- 수행 중이던 작업 내용 -->
        <h1><?php echo $header ?></h1> <!-- 수행 중이던 작업 내용 -->
        <h2><?php echo $header2 ?></h2>
    </hgroup>
</header>
<p>
    <!-- <strong>항목</strong> 오류내역 -->
    <!--
    <strong>이름</strong> 필수 입력입니다. 한글만 입력할 수 있습니다.<br>
    <strong>이메일</strong> 올바르게 입력하지 않았습니다.<br>
    -->
    <?php echo $msg2 ?>
</p>
<p>
    <?php echo $msg3 ?>
</p>

</article>
*/ ?>

</noscript>

<?php
include_once(G5_PATH.'/tail.sub.php');
