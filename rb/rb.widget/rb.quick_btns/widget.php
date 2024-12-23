<!--
경로 : /rb/rb.widget/rb.quick_btns/
사용자코드를 입력하세요.
-->
<div class="q_btns pc">
    <button type="button" class="arr_bg" onclick="location.href='#';">
        <i><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_btn1.svg"></i>
        <span>레벨링 가이드</span>
    </button>

    <button type="button" class="arr_bg" onclick="location.href='#';">
        <i><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_btn2.svg"></i>
        <span>배너광고 신청</span>
    </button>

    <button type="button" class="arr_bg" onclick="location.href='#';">
        <i><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_btn3.svg"></i>
        <span>포인트 충전</span>
    </button>
</div>


<script>
function openNewWindow(url) {
    var width = Math.min(window.screen.width, 1380);
    var height = Math.min(window.screen.height, 768);
    var left = (window.screen.width - width) / 2;
    var top = (window.screen.height - height) / 2;

    window.open(url, '_blank', `width=${width},height=${height},left=${left},top=${top},resizable=yes,scrollbars=yes`);
}
</script>
