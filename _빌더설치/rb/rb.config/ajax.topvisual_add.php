<?php
include_once('../../common.php');

$mod_type = !empty($_POST['mod_type']) ? $_POST['mod_type'] : '';
$v_code = isset($_POST['v_code']) ? trim($_POST['v_code']) : '';
if (!$v_code) exit('페이지 코드가 없습니다.');

if(isset($mod_type) && $mod_type == 1) {

    $co_topvisual_height = !empty($_POST['co_topvisual_height']) ? $_POST['co_topvisual_height'] : '200';
    $co_topvisual_width = !empty($_POST['co_topvisual_width']) ? $_POST['co_topvisual_width'] : '';
    $co_topvisual_bl = isset($_POST['co_topvisual_bl']) ? $_POST['co_topvisual_bl'] : '10';
    $co_topvisual_border = isset($_POST['co_topvisual_border']) ? $_POST['co_topvisual_border'] : '0';
    $co_topvisual_radius = isset($_POST['co_topvisual_radius']) ? $_POST['co_topvisual_radius'] : '0';
    $co_topvisual_m_color = !empty($_POST['co_topvisual_m_color']) ? $_POST['co_topvisual_m_color'] : '#ffffff';
    $co_topvisual_m_size = !empty($_POST['co_topvisual_m_size']) ? $_POST['co_topvisual_m_size'] : '20';
    $co_topvisual_m_font = !empty($_POST['co_topvisual_m_font']) ? $_POST['co_topvisual_m_font'] : 'font-B';
    $co_topvisual_m_align = !empty($_POST['co_topvisual_m_align']) ? $_POST['co_topvisual_m_align'] : 'left';
    $co_topvisual_s_color = !empty($_POST['co_topvisual_s_color']) ? $_POST['co_topvisual_s_color'] : '#ffffff';
    $co_topvisual_s_size = !empty($_POST['co_topvisual_s_size']) ? $_POST['co_topvisual_s_size'] : '16';
    $co_topvisual_s_font = !empty($_POST['co_topvisual_s_font']) ? $_POST['co_topvisual_s_font'] : 'font-R';
    $co_topvisual_s_align = !empty($_POST['co_topvisual_s_align']) ? $_POST['co_topvisual_s_align'] : 'left';
    $co_topvisual_bg_color = !empty($_POST['co_topvisual_bg_color']) ? $_POST['co_topvisual_bg_color'] : '#f9f9f9';
    $v_time = G5_TIME_YMDHIS;

} else {
    $v_use  = isset($_POST['v_use']) ? intval($_POST['v_use']) : 0;
    $v_url  = isset($_POST['v_url']) ? trim($_POST['v_url']) : '';
    $v_time = G5_TIME_YMDHIS;
}

$table = "rb_topvisual";
$row = sql_fetch("SELECT COUNT(*) as cnt FROM {$table} WHERE v_code = '{$v_code}'");

if(isset($mod_type) && $mod_type == 1) {

    if ($row['cnt'] > 0) {
        sql_query("UPDATE {$table} SET
        co_topvisual_height = '{$co_topvisual_height}',
        co_topvisual_width = '{$co_topvisual_width}',
        co_topvisual_bl = '{$co_topvisual_bl}',
        co_topvisual_border = '{$co_topvisual_border}',
        co_topvisual_radius = '{$co_topvisual_radius}',
        co_topvisual_m_color = '{$co_topvisual_m_color}',
        co_topvisual_m_size = '{$co_topvisual_m_size}',
        co_topvisual_m_font = '{$co_topvisual_m_font}',
        co_topvisual_m_align = '{$co_topvisual_m_align}',
        co_topvisual_s_color = '{$co_topvisual_s_color}',
        co_topvisual_s_size = '{$co_topvisual_s_size}',
        co_topvisual_s_font = '{$co_topvisual_s_font}',
        co_topvisual_s_align = '{$co_topvisual_s_align}',
        co_topvisual_bg_color = '{$co_topvisual_bg_color}',
        v_time = '{$v_time}'
        WHERE v_code = '{$v_code}'");

        $data = array(
            'co_topvisual_height' => $co_topvisual_height,
            'co_topvisual_width' => $co_topvisual_width,
            'co_topvisual_bl' => $co_topvisual_bl,
            'co_topvisual_border' => $co_topvisual_border,
            'co_topvisual_radius' => $co_topvisual_radius,
            'co_topvisual_m_color' => $co_topvisual_m_color,
            'co_topvisual_m_size' => $co_topvisual_m_size,
            'co_topvisual_m_font' => $co_topvisual_m_font,
            'co_topvisual_m_align' => $co_topvisual_m_align,
            'co_topvisual_s_color' => $co_topvisual_s_color,
            'co_topvisual_s_size' => $co_topvisual_s_size,
            'co_topvisual_s_font' => $co_topvisual_s_font,
            'co_topvisual_s_align' => $co_topvisual_s_align,
            'co_topvisual_bg_color' => $co_topvisual_bg_color,
            'status' => 'ok',
        );
        echo json_encode($data);

    } else {
        sql_query("INSERT INTO {$table} (v_code, v_name, v_url, v_use, v_time) VALUES ('{$v_code}', '', '{$v_url}', '{$v_use}', '{$v_time}')");

        $data = array(
            'v_use' => $v_use,
            'status' => 'ok',
        );
        echo json_encode($data);
    }

} else {

    if ($row['cnt'] > 0) {
        sql_query("UPDATE {$table} SET
        v_use = '{$v_use}',
        v_url = '{$v_url}',
        v_time = '{$v_time}'
        WHERE v_code = '{$v_code}'");

        $data = array(
            'v_use' => $v_use,
            'status' => 'ok',
        );
        echo json_encode($data);

    } else {
        sql_query("INSERT INTO {$table} (v_code, v_name, v_url, v_use, v_time) VALUES ('{$v_code}', '', '{$v_url}', '{$v_use}', '{$v_time}')");

        $data = array(
            'v_use' => $v_use,
            'status' => 'ok',
        );
        echo json_encode($data);
    }

}
