<?php
$sub_menu = '000630';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");
add_stylesheet('<link rel="stylesheet" href="./css/style.css">', 0);

$g5['title'] = '쪽지 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 메세지 목록처리
$where = " where me_recv_mb_id != '' and ";
$sql_search = "";

if ($stx != "") {
    if ($sfl != "") {
        $sql_search .= " $where $sfl like '%$stx%' ";
        $where = " and ";
    }
    if ($save_stx != $stx)
        $page = 1;
}

if (!$sst) {
    $sst = "me_id";
    $sod = "desc";
}


$sql_common = " from {$g5['memo_table']} ";
$sql_common .= $sql_search;

// 테이블의 전체 레코드수만 얻음
$sql_list = " select count(*) as cnt " . $sql_common;
$list = sql_fetch($sql_list);
$total_count = isset($list['cnt']) ? $list['cnt'] : 0;

$rows = 10;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql_is  = " select *
          $sql_common
          order by $sst $sod
          limit $from_record, $rows ";
$result_is = sql_query($sql_is);

$qstr .= ($qstr ? '&amp;' : '').'save_stx='.$stx;
$listall = '<a href="'.$_SERVER['SCRIPT_NAME'].'" class="ov_listall">전체목록</a>';

?>



<style>
    .chat_list_image img {height: 40px; width: auto; border-radius: 8px;}
    .view_image img {height: 40px; width: auto; border-radius: 8px;}
    .chat_list_video {border-radius: 8px;}
    .chat_list_audio {height:40px;}
    .chat_file_icos {margin-right: 5px;}
</style>

<form name="flist" class="local_sch01 local_sch">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="save_stx" value="<?php echo $stx; ?>">


<label for="sfl" class="sound_only">검색대상</label>
<select name="sfl" id="sfl">
    <option value="me_send_mb_id" <?php echo get_selected($sfl, 'me_send_mb_id'); ?>>발송인(ID)</option>
    <option value="me_recv_mb_id" <?php echo get_selected($sfl, 'me_recv_mb_id'); ?>>수신인(ID)</option>
    <option value="me_send_ip" <?php echo get_selected($sfl, 'me_send_ip'); ?>>발송 IP</option>
</select>

<label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
<input type="text" name="stx" value="<?php echo $stx; ?>" id="stx" required class="frm_input required">
<input type="submit" value="검색" class="btn_submit"> <?php echo $listall ?>  <span class="btn_ov01"><span class="ov_txt">총 </span><span class="ov_num"> <?php echo number_format($total_count) ?>건 </span></span>
</form>

<form name="fitemqalist" method="post" action="./memo_list_update.php" onsubmit="return fitemqalist_submit(this);" autocomplete="off">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">

<div class="tbl_head01 tbl_wrap" id="itemqalist">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col">
            <label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col"><?php echo subject_sort_link('me_send_mb_id'); ?>보냄</a></th>
        <th scope="col"><?php echo subject_sort_link('me_recv_mb_id'); ?>받음</a></th>
        <th scope="col"><?php echo subject_sort_link('me_memo'); ?>내용</a></th>
        <th scope="col"><?php echo subject_sort_link('me_send_datetime'); ?>발송시간</a></th>
        <th scope="col"><?php echo subject_sort_link('me_read_datetime'); ?>수신시간</a></th>
        <th scope="col"><?php echo subject_sort_link('me_send_ip'); ?>발송IP</a></th>
    </tr>
    </thead>
    <tbody>
    <?php
    for ($i=0; $rowss=sql_fetch_array($result_is); $i++) {

        $mbx1 = isset($rowss['me_send_mb_id']) ? get_member($rowss['me_send_mb_id']) : '';
        $mbx2 = isset($rowss['me_recv_mb_id']) ? get_member($rowss['me_recv_mb_id']) : '';
        $name1 = isset($mbx1['mb_nick']) ? get_text($mbx1['mb_nick']) : '';
        $name2 = isset($mbx2['mb_nick']) ? get_text($mbx2['mb_nick']) : '';

        $bg = 'bg'.($i%2);
     ?>
    <tr style="background-color:#fff;">

        <td class="td_chk">
            <label for="chk_<?php echo $i; ?>"></label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i; ?>">
            <input type="hidden" name="me_id[<?php echo $i; ?>]" value="<?php echo $rowss['me_id']; ?>">
            <input type="hidden" name="mb_id[<?php echo $i; ?>]" value="<?php echo $mbx2['mb_id']; ?>">
        </td>
        <td class="td_datetime" nowrap>
        <?php if(isset($name1) && $name1) { ?>
        <a href="../member_form.php?w=u&mb_id=<?php echo $rowss['me_send_mb_id'] ?>"><?php echo $name1; ?></a>
        <?php } else { ?>
        <span style="color:#ff4081">시스템</span>
        <?php } ?>
        </td>
        <td class="td_datetime" nowrap><a href="../member_form.php?w=u&mb_id=<?php echo $rowss['me_recv_mb_id'] ?>"><?php echo $name2; ?></a></td>
        <td class="td_left">
            <?php echo $rowss['me_memo']; ?>
        </td>

        <td class="td_datetime" nowrap><?php echo $rowss['me_send_datetime']; ?></td>
        <td class="td_datetime" nowrap><?php echo $rowss['me_read_datetime']; ?></td>
        <td class="td_datetime" nowrap>
        <?php if(isset($rowss['me_send_ip']) && $rowss['me_send_ip']) { ?>
        <?php echo $rowss['me_send_ip']; ?>
        <?php } else { ?>
        -
        <?php } ?>
        </td>

    </tr>
    <?php
    }
    if ($i == 0) {
            echo '<tr><td colspan="7" class="empty_table"><span>메세지가 없습니다.</span></td></tr>';
    }
    ?>
    </tbody>
    </table>
</div>

<div class="btn_fixed_top" style="right:60px;">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_02">
    <input type="submit" name="act_button" value="전체삭제" onclick="document.pressed=this.value" class="btn btn_02">
</div>
</form>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>

<script>
function fitemqalist_submit(f)
{

    if(document.pressed == "선택삭제") {
        if (!is_checked("chk[]")) {
            alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
            return false;
        }
    }

    if(document.pressed  == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    if(document.pressed  == "전체삭제") {
        if(!confirm("전체 데이터를 삭제하시겠습니까?\n삭제된 데이터는 복구되지 않습니다.")) {
            return false;
        }
    }

    return true;
}


</script>









<form name="fmemoform" id="fmemoform" action="./memo_update.php" onsubmit="return fmemoform_submit(this);" method="post">

    <section>
    <h2 class="h2_frm">시스템메세지 전체 발송</h2>

    <div class="local_desc01 local_desc">
        <p>
            쪽지미수신(정보비공개) 회원을 포함하여 발송 됩니다.<br>
            10레벨 발송의 경우 최고 관리자는 제외합니다.
        </p>
    </div>

    <div class="tbl_frm01 tbl_wrap">
        <table>

        <colgroup>
            <col class="grid_4">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="de_admin_company_name">수신그룹</label></th>
            <td>
                <input type="checkbox" id="all_check" onclick="check_alls(this.form)">
                <label for="all_check">전체회원</label>

                <?php for ($i=2; $i<=10; $i++) { ?>
                <input type="checkbox" name="mb_level[]" id="mb_level_<?php echo $i ?>" value="<?php echo $i ?>">
                <label for="mb_level_<?php echo $i ?>"><?php echo $i ?> 레벨</label>
                <?php } ?>

            </td>

        </tr>
        <tr>
            <th scope="row"><label for="de_admin_company_name">시스템메세지</label></th>
            <td>
                <textarea name="me_memo" id="me_memo" required></textarea>
            </td>
        </tr>
        </tbody>
        </table>
    </div>
    </section>



    <div class="btn_fixed_top">
        <input type="submit" name="act_button" value="발송" onclick="document.pressed=this.value" class="btn btn_01">
    </div>
</form>

<script>
function check_alls(f)
{
    var chk = document.getElementsByName("mb_level[]");

    for (i=0; i<chk.length; i++)
        chk[i].checked = f.all_check.checked;
}

function fmemoform_submit(f)
{
    var chk = document.getElementsByName("mb_level[]");
    var isChecked = false;

    for (i=0; i<chk.length; i++) {
        if (chk[i].checked) {
            isChecked = true;
            break;
        }
    }

    if (!isChecked) {
        alert("수신그룹을 선택해주세요.");
        return false;
    }

    return true;
}
</script>



<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
