<?php
$sub_menu = '000200';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '모듈관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

?>

<?php
#ff4081

if(isset($_GET['tables']) && $_GET['tables'] == "rb_module_shop") {
    $table_name = $_GET['tables'];
    $cr2 = 'style="background-color:#ff4081"';
    $cr1 = "";
} else { 
    $table_name = "rb_module";
    $cr1 = 'style="background-color:#ff4081"';
    $cr2 = "";
}

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall" '.$cr1.'>일반모듈</a>';
$listall2 = '<a href="'.$_SERVER['SCRIPT_NAME'].'?tables=rb_module_shop" class="ov_listall" '.$cr2.'>마켓모듈</a>';




$where = " where ";
$sql_search = "";

$sfl = in_array($sfl, array('md_title', 'md_theme', 'md_layout_name')) ? $sfl : '';

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
    $sst  = "md_id";
    $sod = "asc";
}
$sql_order = "order by $sst $sod";

// 출력할 레코드를 얻음
$sql  = " select *
             $sql_common
             $sql_order
             limit $from_record, $rows ";
$result = sql_query($sql);

?>

<div class="local_ov01 local_ov">
    <?php echo $listall; ?> <?php echo $listall2; ?>
    <span class="btn_ov01"><span class="ov_txt">생성된 모듈 수</span><span class="ov_num">  <?php echo number_format($total_count); ?>개</span></span>
</div>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
<input type="hidden" name="tables" value="<?php echo $table_name; ?>">

<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="md_title"<?php echo get_selected($sfl, "md_title", true); ?>>모듈명</option>
    <option value="md_theme"<?php echo get_selected($sfl, "md_theme", true); ?>>적용테마</option>
    <option value="md_layout_name"<?php echo get_selected($sfl, "md_layout_name", true); ?>>적용레이아웃</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="required frm_input">
<input type="submit" value="검색" class="btn_submit">

</form>

<form name="fmodulelist" method="post" action="./modulelistupdate.php" autocomplete="off">
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
        <th scope="col"><?php echo subject_sort_link("md_id"); ?>ID</a></th>
        <th scope="col"><?php echo subject_sort_link("md_title"); ?>모듈명</a></th>
        <th scope="col"><?php echo subject_sort_link("md_theme"); ?>테마</a></th>
        <th scope="col"><?php echo subject_sort_link("md_layout_name"); ?>레이아웃</a></th>
        <th scope="col"><?php echo subject_sort_link("md_layout"); ?>섹션</a></th>
        <th scope="col"><?php echo subject_sort_link("md_type"); ?>타입</a></th>
        <th scope="col"><?php echo subject_sort_link("md_order_id"); ?>진열순서</a></th>
        <th scope="col"><?php echo subject_sort_link("md_datetime"); ?>생성일시</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $s_add = $s_vie = $s_upd = $s_del = '';
    for ($i=0; $row=sql_fetch_array($result); $i++)
    {

        if ($is_admin == 'super')
            $s_del = '<a href="./moduleformupdate.php?tables='.$table_name.'&amp;w=d&amp;md_id='.$row['md_id'].'&amp;'.$qstr.'" onclick="return delete_confirm(this);" class="btn btn_02"><span class="sound_only">'.get_text($row['md_title']).' </span>삭제</a> ';

        if($row['md_type'] == "latest") {
            $md_type = "최신글";
        } else if($row['md_type'] == "widget") {
            $md_type = "위젯";
        } else if($row['md_type'] == "poll") {
            $md_type = "투표";
        } else if($row['md_type'] == "banner") {
            $md_type = "배너";
        } else if($row['md_type'] == "item") {
            $md_type = "상품";
        } else { 
            $md_type = "-";
        }

        $bg = 'bg'.($i%2);
    ?>
    <tr class="<?php echo $bg; ?>">
       

        <td class="td_code">
            <input type="hidden" name="md_id[<?php echo $i; ?>]" value="<?php echo $row['md_id']; ?>">
            <?php echo $row['md_id']; ?>
        </td>
       
        <td>
            <label for="md_title<?php echo $i; ?>" class="sound_only">모듈명</label>
            <input type="text" name="md_title[<?php echo $i; ?>]" value="<?php echo get_text($row['md_title']); ?>" id="md_title<?php echo $i; ?>" class="tbl_input">
        </td>
        
        <td>
            <label for="md_theme<?php echo $i; ?>" class="sound_only">테마</label>
            <input type="text" name="md_theme[<?php echo $i; ?>]" value="<?php echo get_text($row['md_theme']); ?>" id="md_theme<?php echo $i; ?>" class="tbl_input">
        </td>
        
        <td>
            <label for="md_layout_name<?php echo $i; ?>" class="sound_only">레이아웃</label>
            <input type="text" name="md_layout_name[<?php echo $i; ?>]" value="<?php echo get_text($row['md_layout_name']); ?>" id="md_layout_name<?php echo $i; ?>" class="tbl_input">
        </td>
        
        <td>
            <label for="md_layout<?php echo $i; ?>" class="sound_only">섹션</label>
            <input type="text" name="md_layout[<?php echo $i; ?>]" value="<?php echo get_text($row['md_layout']); ?>" id="md_layout<?php echo $i; ?>" class="tbl_input">
        </td>
        
        <td>
            <label for="md_type<?php echo $i; ?>" class="sound_only">타입</label>
            <?php echo $md_type ?>
        </td>
        
        <td>
            <label for="md_order_id<?php echo $i; ?>" class="sound_only">진열순서</label>
            <?php echo $row['md_order_id'] ?>
        </td>
        
        <td>
            <label for="md_datetime<?php echo $i; ?>" class="sound_only">생성일시</label>
            <?php echo $row['md_datetime'] ?>
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