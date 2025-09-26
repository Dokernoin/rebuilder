<?php
include_once('../../common.php');

if (!defined('_GNUBOARD_')) exit;

$mod_type = !empty($_POST['mod_type']) ? $_POST['mod_type'] : '';
$v_code = isset($_POST['v_code']) ? trim($_POST['v_code']) : '';

// 조건: shop-list- 로 시작하고 ca_id가 붙은 구조일 때만 처리
if (preg_match('/^shop-list-(\d+)$/', $v_code, $matches)) {
    $ca_id = $matches[1];
    // 2자리씩 하이픈 삽입
    $formatted_ca_id = implode('-', str_split($ca_id, 2));
    $v_code = 'shop-list-' . $formatted_ca_id;
}

if (!$v_code) exit('페이지 코드가 없습니다.');

if(isset($mod_type) && $mod_type == 1) {

    $co_topvisual_mt = !empty($_POST['co_topvisual_mt']) ? $_POST['co_topvisual_mt'] : '0';
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
    $co_topvisual_style_all = !empty($_POST['co_topvisual_style_all']) ? $_POST['co_topvisual_style_all'] : '0';
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
        // 현재 노드 업데이트
        sql_query("UPDATE {$table} SET
            co_topvisual_mt = '{$co_topvisual_mt}',
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
            co_topvisual_style_all = '{$co_topvisual_style_all}',
            v_time = '{$v_time}'
            WHERE v_code = '{$v_code}'");

        // co_topvisual_style_all = 1 이면 하위 노드도 동일하게 스타일 동기화
        if ($co_topvisual_style_all == 1) {
            sql_query("UPDATE {$table} SET
                co_topvisual_mt = '{$co_topvisual_mt}',
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
                co_topvisual_bg_color = '{$co_topvisual_bg_color}'
                WHERE v_code LIKE '{$v_code}-%'");
        }

        // 응답
        $data = array(
            'co_topvisual_mt' => $co_topvisual_mt,
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
            'co_topvisual_style_all' => $co_topvisual_style_all,
            'status' => 'ok',
        );
        echo json_encode($data);

    } else {
        // 새로 등록되는 경우에는 스타일 정보가 없으므로 생략 그대로 OK
        sql_query("INSERT INTO {$table} (v_code, v_name, v_url, v_use, v_time)
                   VALUES ('{$v_code}', '', '{$v_url}', '{$v_use}', '{$v_time}')");

        $data = array(
            'v_use' => $v_use,
            'status' => 'ok',
        );
        echo json_encode($data);
    }

} else {

    if ($row['cnt'] > 0) {
        // 기존 항목이 존재하면 업데이트
        sql_query("UPDATE {$table} SET
            v_use = '{$v_use}',
            v_url = '{$v_url}',
            v_time = '{$v_time}'
            WHERE v_code = '{$v_code}'");

    } else {
        // 없으면 삽입
        sql_query("INSERT INTO {$table}
            (v_code, v_name, v_url, v_use, v_time)
            VALUES ('{$v_code}', '', '{$v_url}', '{$v_use}', '{$v_time}')");
    }

    // 추가 로직: 관련된 v_code의 하위/전체 처리
    if ($v_use == 2) {
        sql_query("UPDATE {$table} SET v_use = 1 WHERE v_code LIKE '{$v_code}-%'");
        sql_query("UPDATE {$table} SET v_use = '{$v_use}', co_topvisual_all = 1 WHERE v_code = '{$v_code}'");

    } else {
        sql_query("UPDATE {$table} SET v_use = 0 WHERE v_code LIKE '{$v_code}-%'");
        sql_query("UPDATE {$table} SET v_use = '{$v_use}', co_topvisual_all = 0 WHERE v_code = '{$v_code}'");

    }

    // 응답 반환
    $data = array(
        'v_use' => $v_use,
        'status' => 'ok',
    );
    echo json_encode($data);

}
