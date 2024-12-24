<?php
$sub_menu = '000100';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");

$g5['title'] = '환경설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');


?>

메인페이지 > 우측 하단의 환경설정 버튼을 이용해주세요.<br>
(추후 업데이트 예정)

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');