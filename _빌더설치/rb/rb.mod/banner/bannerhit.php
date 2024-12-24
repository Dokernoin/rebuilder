<?php
include_once("../_common.php");

$bn_id = isset($bn_id) ? (int)$bn_id : 0;

$sql = "SELECT bn_id, bn_url FROM rb_banner WHERE bn_id = '$bn_id'";
$row = sql_fetch($sql);

if (!isset($row['bn_id']) || !$row['bn_id']) {
    alert('등록된 배너가 없습니다.', G5_URL);
}

if (!isset($_COOKIE['ck_bn_id']) || $_COOKIE['ck_bn_id'] != $bn_id) {
    $sql = "UPDATE rb_banner SET bn_hit = bn_hit + 1 WHERE bn_id = '$bn_id'";
    sql_query($sql);
    // 하루 동안
    set_cookie("ck_bn_id", $bn_id, 60*60*24);
}

$url = isset($row['bn_url']) ? clean_xss_tags($row['bn_url']) : G5_URL;

goto_url($url);
?>