<?php
include_once('../../../common.php'); // 또는 경로에 맞게

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ca_id = isset($_POST['ca_id']) ? trim($_POST['ca_id']) : '';
$result = ['error' => 1, 'msg' => ''];

if ($ca_id) {
    $sql = "SELECT ca_level, ca_level_opt FROM {$g5['g5_shop_category_table']} WHERE ca_id = '{$ca_id}'";
    $row = sql_fetch($sql);

    if ($row) {
        $result = [
            'error' => 0,
            'ca_level' => $row['ca_level'],
            'ca_level_opt' => $row['ca_level_opt']
        ];
    } else {
        $result['msg'] = '카테고리 정보가 없습니다.';
    }
} else {
    $result['msg'] = 'ca_id 값이 없습니다.';
}

echo json_encode($result);
exit;
?>
