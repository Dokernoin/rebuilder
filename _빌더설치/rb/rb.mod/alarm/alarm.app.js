var show_alarm_exist=false;

function check_alarm(){
    $.ajax({
        type: 'POST',
        data: { act: 'alarm' },
        url: memo_alarm_url + '/get-events.php',
        dataType: 'json',
        async: true,
        cache: false,
        success: function(result) {
            if(result.msg == 'SUCCESS') {
                // URL을 추출하는 정규식
                const urlRegex = /(https?:\/\/[^\s]+)/g;
                const urlMatches = result.content.match(urlRegex);
                // 추출된 URL이 있으면 그 값을 사용하고, 없으면 me_id 사용
                const urlOrMeId = urlMatches ? urlMatches[0] : result.me_id;
                // 추출된 값을 show_alarm으로 전달
                show_alarm(result.title, result.content, result.url, urlOrMeId, result.me_send_datetime, result.me_id);
            } else {
                // 오류 처리
            }
        }
    });
}

function show_alarm(title, content, url, urlOrMeId, me_send_datetime, me_id) {
    if(show_alarm_exist) hide_alarm();
    show_alarm_exist = true;
    var html = "";
    // audio.play(); // 알림 소리 재생
    html = "<div id='alarm_layer' class='wrapper-notification bottom right side' style='display:none'>";
    html += "<div class='notification notification-primary notification-msg animated bounceInUp' id='" + me_id + "'>";
    
    // 알림 옵션 부분 (닫기 버튼, 읽음 처리 버튼 등)
    html += "<div class='notification-option'>";
    

    html += "<button class='notification-check' data-toggle='tooltip' data-trigger='hover' data-html='true' data-placement='top' data-original-title='읽음' onclick='set_recv_memo(\"" + me_id + "\")'>";
    
    html += "<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-x'><line x1='18' y1='6' x2='6' y2='18'></line><line x1='6' y1='6' x2='18' y2='18'></line></svg></button>";
    html += "</div>";
    
    html += "<a href='../bbs/memo_view.php?me_id=" + me_id + "&kind=recv' onclick='win_memo(this.href); return false;'>";

    html += "<div class='notification-heading'><span class='font-B'>새 알림</span>　<span class='al_date'>" + me_send_datetime + "</span></div>";
    html += "<div class='notification-content cut2 cursor'>" + content + "</div>";
    html += "</a>";
    html += "</div>";
    html += "</div>";

    $('body').prepend(html);
    $('#alarm_layer').fadeIn();
    setTimeout(function(){ hide_alarm(); }, 30000);
}


function hide_alarm(){
	if(show_alarm_exist){
		show_alarm_exist=false;
		$("#alarm_layer").fadeOut(400,function(){
			$('#alarm_layer').remove();
		});
		
	}
}
function set_recv_memo(me_id){
	$.ajax({
		type:'POST',
		data : ({act : 'recv_memo', me_id : me_id}),
		url: memo_alarm_url + '/get-events.php',
		dataType:'json',
		async:true,
		cache:false,
		success:function(result){
			if(result.msg=='SUCCESS'){
				hide_alarm();
			}else{
			}				
		}
	});
}
function RemoveTag(s){
	var tmp = '';
	tmp = s;
	tmp = tmp.replace('<','&lt;');
	tmp = tmp.replace('>','&gt;');
	tmp = tmp.replace('"','&quot;');

	return tmp;
}