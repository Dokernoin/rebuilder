<?php
include_once('../common.php');


if (!$member['mb_id']) {
    alert('회원만 이용하실 수 있습니다.', G5_URL);
}

if (!$member['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id) {
    alert('자신의 정보를 공개하지 않으면 다른분의 정보를 조회할 수 없습니다.\\n\\n정보공개 설정은 회원정보수정에서 하실 수 있습니다.', G5_URL);
}

$mb_id = isset($mb_id) ? $mb_id : '';

$mb = get_member($mb_id);

if (empty($mb['mb_id'])) {
    alert('회원정보가 존재하지 않습니다.\\n\\n탈퇴하였을 수 있습니다.');
}


if (!$mb['mb_open'] && $is_admin != 'super' && $member['mb_id'] != $mb_id) {
    alert('정보공개를 하지 않았습니다.', G5_URL);
}

$g5['title'] = $mb['mb_nick'].'님의 미니홈';
include_once(G5_BBS_PATH.'/_head.php');

//$mb_nick = get_sideview($mb['mb_id'], get_text($mb['mb_nick']), $mb['mb_email'], $mb['mb_homepage'], $mb['mb_open']);

// 회원가입후 몇일째인지? + 1 은 당일을 포함한다는 뜻
$sql = " select (TO_DAYS('".G5_TIME_YMDHIS."') - TO_DAYS('{$mb['mb_datetime']}') + 1) as days ";
$row = sql_fetch($sql);
$mb_reg_after = $row['days'];

$mb_homepage = set_http(get_text(clean_xss_tags($mb['mb_homepage'])));
$mb_profile = $mb['mb_profile'] ? conv_content($mb['mb_profile'],0) : '소개 내용이 없습니다.';
$mb_signature = $mb['mb_signature'] ? conv_content($mb['mb_signature'],0) : '서명이 없습니다.';


include_once($member_skin_path.'/home.skin.php');
include_once(G5_BBS_PATH.'/_tail.php');
