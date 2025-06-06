<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// 코드출처 @트리플 님 https://sir.kr/bbs/board.php?bo_table=g5_skin&wr_id=46819

add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>

<?php

// 관리자모드 > 내용관리 에서 생성한 co_id 와 파일명을 동일하게 맞춰주시면 연결 됩니다.
// co_id 와 동일한 파일이 없다면 내용관리의 에디터에서 입력한 내용이 보여집니다.
// 별도파일을 사용하는 경우 추가된 파일을 theme/rb.basic/rb.page/ 에 넣어주세요.

		if(is_file(G5_THEME_PATH.'/rb.page/'.$co_id.'.php')) {

			$page_path = G5_THEME_PATH.'/rb.page';
			$page_url = G5_THEME_URL.'/rb.page';
			@include_once($page_path.'/'.$co_id.'.php');

		} else {

			echo $str;

		}
?>
