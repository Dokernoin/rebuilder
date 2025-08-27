<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

$s_code = isset($_POST['s_code']) ? trim($_POST['s_code']) : '';
$s_use = isset($_POST['s_use']) ? trim($_POST['s_use']) : '';

if($s_use == 1) {
    $sql = " insert into `rb_sidebar_hide` (`s_code`) VALUES ('$s_code') ";
    sql_query($sql);
} else {
    $sql = " delete from `rb_sidebar_hide` where `s_code` = '$s_code' ";
    sql_query($sql);
}