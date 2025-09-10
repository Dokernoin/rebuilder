<?php
$sub_menu = '000210';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "d");
check_admin_token();

// 입력값 정리
$sec_id = isset($_REQUEST['sec_id']) ? preg_replace('/[^0-9a-z]/i', '', $_REQUEST['sec_id']) : '';
$table_name = (isset($_REQUEST['tables']) && $_REQUEST['tables']) ? $_REQUEST['tables'] : 'rb_section';

// 임의 테이블 방지: 화이트리스트
$allowed_tables = array('rb_section','rb_section_shop');
if (!in_array($table_name, $allowed_tables, true)) {
    $table_name = 'rb_section';
}

if (!$sec_id) {
    alert('섹션 ID가 없습니다.');
}

if ($w == 'd' && $is_admin != 'super') {
    alert("최고관리자만 삭제할 수 있습니다.");
}

if ($w == "d") {

    $sec_id_esc = sql_escape_string($sec_id);

    // 1) 섹션의 sec_uid 조회
    $row = sql_fetch("SELECT sec_uid FROM {$table_name} WHERE sec_id = '{$sec_id_esc}' LIMIT 1");

    if ($row && ($row['sec_uid'] ?? '') !== '') {
        $sec_uid_esc = sql_escape_string($row['sec_uid']);

        // 2) 관련 모듈 삭제 (rb_module / rb_module_shop)
        //    모듈 테이블 키 컬럼은 mb_sec_uid 이므로 sec_uid = mb_sec_uid 매핑
        sql_query("DELETE FROM rb_module WHERE mb_sec_uid = '{$sec_uid_esc}'");
        sql_query("DELETE FROM rb_module_shop WHERE mb_sec_uid = '{$sec_uid_esc}'");
    }

    // 3) 섹션 삭제
    sql_query("DELETE FROM {$table_name} WHERE sec_id = '{$sec_id_esc}'");
}

goto_url("./section_list.php?tables={$table_name}&amp;{$qstr}");
