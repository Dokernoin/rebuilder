<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['act'] === 'clear') {
    $cache_path = G5_DATA_PATH . '/cache';
    $removed = 0;

    if (is_dir($cache_path)) {
        foreach (glob($cache_path . '/*') as $file) {
            if (is_file($file)) {
                @unlink($file);
                $removed++;
            }
        }
        echo 'ok';
    } else {
        echo '캐시 폴더가 존재하지 않습니다.';
    }
    exit;
}

echo '잘못된 요청입니다.';
