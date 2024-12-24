$(document).ready(function () {
    // flex_box 클래스를 가진 모든 요소를 선택
    var flexBoxes = $('.flex_box');

    // flex_box 요소와 data-layout 매핑
    flexBoxes.each(function (index) {
        $(this).attr('data-layout', index + 1);
    });

    // AJAX 요청 배열 생성
    var ajaxRequests = flexBoxes.map(function (index, element) {
        var layoutIndex = index + 1; // 1부터 시작하도록 설정
        var $element = $(element); // jQuery 캐싱

        return $.ajax({
            url: g5_url + '/rb/rb.config/ajax.layout_set.shop.php',
            method: 'POST',
            dataType: 'html',
            data: {
                layout: layoutIndex,
            }
        }).done(function (data) {
            // 성공적으로 데이터를 가져온 경우
            $element.html(data);

            // 필요한 경우 추가 초기화 실행
            if (typeof initializeCalendar === "function") {
                initializeCalendar();
            }
        }).fail(function () {
            // 요청 실패
            console.error('레이아웃 ' + layoutIndex + ' 로드 중 오류가 발생했습니다.');
        });
    }).get();

    // 모든 AJAX 요청 완료 후 실행
    $.when.apply($, ajaxRequests).then(function () {
        console.log('모든 레이아웃 데이터 로드 완료');
    });
});
