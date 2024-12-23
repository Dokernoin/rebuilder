<?php
$sub_menu = '000400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

$g5['title'] = '게시물 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_ADMIN_URL.'/rb/css/style.css">', 1);

$bo_table = isset($_GET['bo_table']) ? $_GET['bo_table'] : '';
$write_table = isset($g5['write_prefix']) ? $g5['write_prefix'] . $bo_table : '';

global $board;

$where = " where wr_is_comment = 0 and ";
$sql_search = "";
if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if ($sca != "") {
    $sql_search .= " and ca_id like '$sca%' ";
}

//if ($sfl == "")  $sfl = "it_name";
if (!$sst) {
    $sst = "wr_id";
    $sod = "desc";
}

if ($stx) {
    $sql_common = " from {$write_table} ";
} else {
    $sql_common = " from {$write_table} where wr_is_comment = 0 ";
}
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = isset($row['cnt']) ? $row['cnt'] : 0;

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql  = " select *
          $sql_common
          order by $sst $sod, wr_id desc
          limit $from_record, $rows ";
$result = sql_query($sql);

//$qstr = 'page='.$page.'&amp;sst='.$sst.'&amp;sod='.$sod.'&amp;stx='.$stx;
$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca.'&amp;save_stx='.$stx;

$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'?bo_table='.$bo_table.'" class="ov_listall">전체목록</a>';


//제외할 게시판이 있다면 아래 예제와 같이 추가
//$sql_wheres = " where (1) ";
//$sql_wheres .= " and bo_table != 'aaa' ";
//$sql_wheres .= " and bo_table != 'bbb' ";
//$sql_wheres .= " and bo_table != 'ccc' ";

$sql_wheres = isset($sql_wheres) ? $sql_wheres : '';
$sql_b = "SELECT bo_table, bo_subject FROM " . (isset($g5['board_table']) ? $g5['board_table'] : '') . " " . $sql_wheres . " ORDER BY bo_mobile_subject";
$res_b = sql_query($sql_b);


//

?>
<form name="fcategory" method="get" class="local_sch01 local_sch">
<div class="local_ov01 local_ov">
        <select name="bo_table" onchange="this.form.submit();" class="select">
            <option value=''>게시판 선택</option>

            <?php
            for ($i = 0; $row_b = sql_fetch_array($res_b); $i++) {
                $bo_table_id = isset($row_b['bo_table']) ? $row_b['bo_table'] : '';
                $bo_table_tit = isset($row_b['bo_subject']) ? $row_b['bo_subject'] : '';
                $bo_table_partner_txt = isset($bo_table_partner_txt) ? $bo_table_partner_txt : '';
                ?>
                <option value="<?php echo $bo_table_id ?>" <?php if (isset($bo_table) && $bo_table == $bo_table_id) { ?>selected<?php } ?>><?php echo $bo_table_partner_txt; ?><?php echo $bo_table_tit; ?></option>
            <?php
            }
            ?>

        </select>
    <!--
    <?php echo $listall; ?>
    -->
    <?php if($bo_table) { ?>
    <span class="btn_ov01"><span class="ov_txt"> <?php echo $board['bo_mobile_subject']; ?> </span><span class="ov_num"> <?php echo $total_count; ?>건</span></span>
    <?php } else { ?>
    <span class="btn_ov01"><span class="ov_txt"> 미선택</span><span class="ov_num">게시판을 선택해주세요.</span></span>
    <?php } ?>

</div>
</form>



<!--
<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">


<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="wr_name" <?php echo get_selected($sfl, 'wr_name'); ?>>작성자</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input required">
<input type="submit" value="검색" class="btn_submit">

</form>
-->

<form name="fitemqalist" method="post" action="./bbs_list_update.php" onsubmit="return fitemqalist_submit(this);" autocomplete="off">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">

<div class="tbl_head01 tbl_wrap" id="itemqalist">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('wr_subject'); ?>제목</a></th>
        <th scope="col"><?php echo subject_sort_link('wr_datetime'); ?>작성일</a></th>
        <th scope="col"><?php echo subject_sort_link('wr_name'); ?>작성자</a></th>
        <th scope="col"><?php echo subject_sort_link('wr_hit'); ?>조회</a></th>
        <th scope="col">관리</th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $row=sql_fetch_array($result); $i++) {
        $row['wr_subject'] = $row['wr_subject'];

        $mb_info = get_member($row['mb_id']);
        $name = get_sideview($row['mb_id'], get_text($mb_info['mb_nick']), $mb_info['mb_email'], $mb_info['mb_homepage']);

        $bg = 'bg'.($i%2);
     ?>
    <tr class="<?php echo $bg; ?>">

        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo get_text($row['wr_subject']) ?></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $row['wr_id']; ?>">
        </td>


        <td class="td_left">
            <?php if($row['ca_name']) { ?>[<?php echo $row['ca_name']; ?>]<?php } ?> <a href="./bbs_form.php?w=u&amp;wr_id=<?php echo $row['wr_id']; ?>&amp;<?php echo $qstr; ?>&amp;bo_table=<?php echo $bo_table; ?>"><?php echo get_text($row['wr_subject']); ?></a>
        </td>
        <td class="td_datetime"><?php echo $row['wr_datetime']; ?></td>
        <td class="td_name sv_use" nowrap><div><?php echo $name ?></div></td>
        <td class="td_mng td_mng_s"><?php echo $row['wr_hit']; ?></td>
        <td class="td_mng td_mng_s">
            <a href="./bbs_form.php?w=u&amp;wr_id=<?php echo $row['wr_id']; ?>&amp;<?php echo $qstr; ?>&amp;bo_table=<?php echo $bo_table; ?>" class="btn btn_03"><span class="sound_only"><?php echo get_text($row['wr_subject']); ?> </span>수정</a>
        </td>
    </tr>
    <?php
    }
    if ($i == 0) {
        if($bo_table) {
            echo '<tr><td colspan="6" class="empty_table"><span>게시물이 없습니다.</span></td></tr>';
        } else {
            echo '<tr><td colspan="6" class="empty_table"><span>게시판을 선택해주세요.</span></td></tr>';
        }
    }
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    <?php if(!$bo_table) { ?>
    <a href="javascript:alert('게시판을 선택해주세요.');" id="bo_add" class="btn_01 btn">게시글 등록</a>
    <?php } else { ?>
    <a href="./bbs_form.php?bo_table=<?php echo $bo_table; ?>" id="bo_add" class="btn_01 btn">게시글 등록</a>
    <?php } ?>
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;bo_table=$bo_table&amp;page="); ?>

<script>
function fitemqalist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed  == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}


</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
