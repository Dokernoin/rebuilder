<?php
include_once('./_common.php');

$preview_id = isset($_GET['pr_id']) ? htmlspecialchars2($_GET['pr_id']) : '';

if(!$preview_id)
    alert('올바른 경로로 접근해 주세요.');

if(!isset($preview_config)) {
    alert('프리뷰 설정을 불러올 수 없습니다.');
}

include_once(G5_PATH.'/index.php');