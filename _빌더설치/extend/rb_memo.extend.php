<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_replace('admin_menu', 'add_admin_bbs_menu_memo', 1, 1); // 관리자 메뉴를 추가함

function add_admin_bbs_menu_memo($admin_menu){ // 메뉴추가

    $admin_menu['menu000'][] = array(
        '000630', '쪽지 관리', G5_ADMIN_URL.'/rb/memo_form.php', 'rb_config',
    );
    return $admin_menu;
}