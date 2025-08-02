//alert 오버라이드
window.alert = function (msg, callback) {
    $('.rb-custom-alert-popup, .rb-custom-alert-popup-bg').remove();

    var rb_alert_svg = "<svg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 24 24'><g fill='none'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#09244BFF' d='m13.299 3.148 8.634 14.954a1.5 1.5 0 0 1-1.299 2.25H3.366a1.5 1.5 0 0 1-1.299-2.25l8.634-14.954c.577-1 2.02-1 2.598 0M12 15a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-7a1 1 0 0 0-.993.883L11 9v4a1 1 0 0 0 1.993.117L13 13V9a1 1 0 0 0-1-1'/></g></svg>";

    var rb_alert_bg = $("<div class='rb-custom-alert-popup-bg'></div>");
    var rb_alert_popup = $(`
        <div class='rb-custom-alert-popup' role='alert'>
            ${rb_alert_svg}
            <div style='margin-bottom:18px'>${msg}</div>
            <button type='button' class='rb-alert-btn main_rb_bg font-R rb-btn-ok' autofocus>확인</button>
        </div>
    `);

    $('body').append(rb_alert_bg).append(rb_alert_popup);

    function closeAlert() {
        rb_alert_bg.fadeOut(220, function () {
            rb_alert_bg.remove();
        });
        rb_alert_popup.fadeOut(220, function () {
            rb_alert_popup.remove();
        });
        $(document).off('keydown.rbAlert');
        if (typeof callback === 'function') callback();
    }
    rb_alert_popup.find('.rb-btn-ok').on('click', closeAlert);
    rb_alert_bg.on('click', closeAlert);
    $(document).on('keydown.rbAlert', function (e) {
        if (e.key === 'Escape') {
            closeAlert();
            $(document).off('keydown.rbAlert');
        }
    });
};

// confirm 재정의
function rb_confirm(msg) {
    return new Promise((resolve) => {
        $('.rb-custom-alert-popup, .rb-custom-alert-popup-bg').remove();

        var rb_alert_svg = "<svg xmlns='http://www.w3.org/2000/svg' width='36' height='36' viewBox='0 0 24 24'><g fill='none'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#09244BFF' d='m13.299 3.148 8.634 14.954a1.5 1.5 0 0 1-1.299 2.25H3.366a1.5 1.5 0 0 1-1.299-2.25l8.634-14.954c.577-1 2.02-1 2.598 0M12 15a1 1 0 1 0 0 2 1 1 0 0 0 0-2m0-7a1 1 0 0 0-.993.883L11 9v4a1 1 0 0 0 1.993.117L13 13V9a1 1 0 0 0-1-1'/></g></svg>";

        var rb_confirm_bg = $("<div class='rb-custom-alert-popup-bg'></div>");
        var rb_confirm_popup = $(`
      <div class='rb-custom-alert-popup' role='alert'>
        ${rb_alert_svg}
        <div style='margin-bottom:18px'>${msg}</div>
        <div style="display:flex; justify-content:center; gap:4px;">
          <button type='button' class='rb-alert-btn main_rb_bg font-R rb-btn-ok' autofocus>확인</button>
          <button type='button' class='rb-alert-btn font-R'>취소</button>
        </div>
      </div>
    `);

        $('body').append(rb_confirm_bg).append(rb_confirm_popup);

        function closeConfirm(result) {
            rb_confirm_bg.fadeOut(220, () => rb_confirm_bg.remove());
            rb_confirm_popup.fadeOut(220, () => rb_confirm_popup.remove());
            $(document).off('keydown.rbConfirm');
            resolve(result);
        }

        rb_confirm_popup.find('.rb-btn-ok').on('click', () => closeConfirm(true));
        rb_confirm_popup.find('button:not(.rb-btn-ok)').on('click', () => closeConfirm(false));
        rb_confirm_bg.on('click', () => closeConfirm(false));
        $(document).on('keydown.rbConfirm', (e) => {
            if (e.key === 'Escape') {
                closeConfirm(false);
                // $(document).off('keydown.rbConfirm'); // 위에서 이미 정리됨
            }
        });

        // 접근성 개선: 확인 버튼에 포커스
        setTimeout(() => rb_confirm_popup.find('.rb-btn-ok').focus(), 10);
    });
}

// del 함수 오버라이드
function del(href) {
    rb_confirm("삭제한 데이터는 복구할 수 없습니다.\n정말 삭제 하시겠습니까?")
        .then(function (result) {
            if (result) {
                window.location.href = href;
            }
        });
}
