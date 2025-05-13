<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['act'] === 'top_clear') {
    $v_path = G5_DATA_PATH . '/topvisual';
    $removed = 0;

    // 1. 캐시 파일 삭제
    if (is_dir($v_path)) {
        foreach (glob($v_path . '/*') as $file) {
            if (is_file($file)) {
                @unlink($file);
                $removed++;
            }
        }
    }

    // 2. rb_topvisual 테이블 전체 삭제
    sql_query("DELETE FROM rb_topvisual");

    echo 'ok';
    exit;
}

echo '잘못된 요청입니다.';
