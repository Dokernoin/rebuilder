<?php
$sub_menu = '000210';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '섹션관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

?>

<?php
#ff4081

if(isset($_GET['tables']) && $_GET['tables'] == "rb_section_shop") {
    $table_name = $_GET['tables'];
    $cr2 = 'style="background-color:#ff4081"';
    $cr1 = "";
} else {
    $table_name = "rb_section";
    $cr1 = 'style="background-color:#ff4081"';
    $cr2 = "";
}

$module_table = ($table_name === 'rb_section_shop') ? 'rb_module_shop' : 'rb_module';

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall" '.$cr1.'>일반섹션</a>';
$listall2 = '<a href="'.$_SERVER['SCRIPT_NAME'].'?tables=rb_section_shop" class="ov_listall" '.$cr2.'>마켓섹션</a>';




$where = " where ";
$sql_search = "";

$sfl = in_array($sfl, array('sec_title', 'sec_theme', 'sec_layout_name')) ? $sfl : '';

if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if (isset($save_stx) && $save_stx && ($save_stx != $stx))
        $page = 1;
}

$sql_common = " from {$table_name} ";
$sql_common .= $sql_search;


// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if (!$sst)
{
    $sst  = "sec_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
             $sql_common
             $sql_order
             limit $from_record, $rows ";
$result = sql_query($sql);

/* 추가: 현재 페이지 섹션들 먼저 배열에 담고 sec_uid 수집 */
$rows_data = array();
$sec_uids  = array();

for ($i = 0; $row = sql_fetch_array($result); $i++) {
    $rows_data[] = $row;
    if (!empty($row['sec_uid'])) {
        $sec_uids[] = $row['sec_uid'];
    }
}

/* 추가: 모듈 개수 한 번에 GROUP BY로 가져오기 */
$module_counts = array();
if (!empty($sec_uids)) {
    // IN 절 구성 (DB 안전)
    $esc = array();
    foreach ($sec_uids as $u) $esc[] = "'".sql_escape_string($u)."'";
    $in = implode(',', $esc);

    $sql_cnt = "SELECT md_sec_uid, COUNT(*) AS cnt
                  FROM {$module_table}
                 WHERE md_sec_uid IN ({$in})
              GROUP BY md_sec_uid";
    $res_cnt = sql_query($sql_cnt);
    while ($r = sql_fetch_array($res_cnt)) {
        $module_counts[$r['md_sec_uid']] = (int)$r['cnt'];
    }
}

/* 기존 루프를 rows_data 기반으로 다시 돌 준비 */
$i = 0;

?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?> <?php echo $listall2; ?>
    <span class="btn_ov01"><span class="ov_txt">생성된 섹션 수</span><span class="ov_num">  <?php echo number_format($total_count); ?>개</span></span>
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
<input type="hidden" name="tables" value="<?php echo $table_name; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="sec_title"<?php echo get_selected($sfl, "sec_title", true); ?>>섹션명</option>
    <option value="sec_theme"<?php echo get_selected($sfl, "sec_theme", true); ?>>적용테마</option>
    <option value="sec_layout_name"<?php echo get_selected($sfl, "sec_layout_name", true); ?>>적용레이아웃</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<div class="local_desc01 local_desc">
    <p>
        섹션 삭제시 섹션 내부에 있는 모듈도 함께 삭제 됩니다.
    </p>
</div>

<form name="fsectionlist" method="post" action="./sectionlistupdate.php" autocomplete="off">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="tables" value="<?php echo $table_name; ?>">

<div id="sct" class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col"><?php echo subject_sort_link("sec_id"); ?>ID</a></th>
        <th scope="col"><?php echo subject_sort_link("sec_title"); ?>섹션명</a></th>
        <th scope="col"><?php echo subject_sort_link("secd_theme"); ?>테마</a></th>
        <th scope="col"><?php echo subject_sort_link("sec_layout_name"); ?>레이아웃</a></th>
        <th scope="col"><?php echo subject_sort_link("sec_layout"); ?>영역</a></th>
        <th scope="col"><?php echo subject_sort_link("sec_uid"); ?>고유키</a></th>
        <th scope="col">내부모듈</th>
        <th scope="col"><?php echo subject_sort_link("sec_order_id"); ?>진열순서</a></th>
        <th scope="col"><?php echo subject_sort_link("sec_datetime"); ?>생성일시</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $s_add = $s_vie = $s_upd = $s_del = '';
    for ($i = 0; $i < count($rows_data); $i++) {
        $row = $rows_data[$i];

        if ($is_admin == 'super')
            $s_del = '<a href="./sectionformupdate.php?tables='.$table_name.'&amp;w=d&amp;sec_id='.$row['sec_id'].'&amp;'.$qstr.'" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only">'.get_text($row['sec_title']).' </span>삭제</a> ';

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">


        <td class="td_code">
            <input type="hidden" name="sec_id[<?php echo $i; ?>]" value="<?php echo $row['sec_id']; ?>">
            <?php echo $row['sec_id']; ?>
        </td>

        <td>
            <label for="msec_title<?php echo $i; ?>" class="sound_only">섹션명</label>
            <input type="text" name="sec_title[<?php echo $i; ?>]" value="<?php echo get_text($row['sec_title']); ?>" id="sec_title<?php echo $i; ?>" class="tbl_input">
        </td>

        <td>
            <label for="sec_theme<?php echo $i; ?>" class="sound_only">테마</label>
            <input type="text" name="sec_theme[<?php echo $i; ?>]" value="<?php echo get_text($row['sec_theme']); ?>" id="sec_theme<?php echo $i; ?>" class="tbl_input">
        </td>

        <td>
            <label for="sec_layout_name<?php echo $i; ?>" class="sound_only">레이아웃</label>
            <input type="text" name="sec_layout_name[<?php echo $i; ?>]" value="<?php echo get_text($row['sec_layout_name']); ?>" id="sec_layout_name<?php echo $i; ?>" class="tbl_input">
        </td>

        <td>
            <label for="sec_layout<?php echo $i; ?>" class="sound_only">영역</label>
            <input type="text" name="sec_layout[<?php echo $i; ?>]" value="<?php echo get_text($row['sec_layout']); ?>" id="sec_layout<?php echo $i; ?>" class="tbl_input">
        </td>

        <td>
            <label for="sec_type<?php echo $i; ?>" class="sound_only">고유키</label>
            <?php echo get_text($row['sec_uid']) ?>
        </td>

        <td>
            <?php
            $n = isset($module_counts[$row['sec_uid']]) ? (int)$module_counts[$row['sec_uid']] : 0;
            echo number_format($n) . '개';
            ?>
        </td>

        <td>
            <label for="sec_order_id<?php echo $i; ?>" class="sound_only">진열순서</label>
            <?php echo $row['sec_order_id'] ?>
        </td>

        <td>
            <label for="sec_datetime<?php echo $i; ?>" class="sound_only">생성일시</label>
            <?php echo $row['sec_datetime'] ?>
        </td>

        <td class="td_mng td_mng_s">
            <?php echo $s_del; ?>
        </td>
    </tr>


    <?php }
    if ($i == 0) echo "<tr><td colspan=\"9\" class=\"empty_table\">데이터가 없습니다.</td></tr>\n";
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" value="일괄수정" class="btn_submit btn">
</div>

</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?tables=$table_name&amp;$qstr&amp;page="); ?>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
