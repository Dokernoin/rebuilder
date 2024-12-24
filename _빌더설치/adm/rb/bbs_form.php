<?php
$sub_menu = '000400';
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check_menu($auth, $sub_menu, "w");


$bo_table = $_GET['bo_table'];
$write_table = $g5['write_prefix'] . $bo_table;

global $g5, $board;

if($w == "u") {
    $wr_id = isset($_REQUEST['wr_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['wr_id']) : 0;
    
    $sql = " select * from {$write_table} where wr_id = '$wr_id' and wr_is_comment = '0' ";
    $wr = sql_fetch($sql);
    if (! (isset($wr['wr_id']) && $wr['wr_id'])) alert('등록된 게시물이 없습니다.');
    
    $name = get_text($wr['wr_name']);
}



$g5['title'] = '게시물 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$qstr .= ($qstr ? '&amp;' : '').'sca='.$sca;

// 게시글에 첨부된 파일을 얻는다. (배열로 반환)
if($w == "u") {
    function get_file_qa($bo_table, $wr_id)
    {
        global $g5, $qstr, $board;

        $file['count'] = 0;
        $sql = " select * from {$g5['board_file_table']} where bo_table = '$bo_table' and wr_id = '$wr_id' order by bf_no ";
        $result = sql_query($sql);
        while ($row = sql_fetch_array($result))
        {
            $no = (int) $row['bf_no'];
            $bf_content = $row['bf_content'] ? html_purifier($row['bf_content']) : '';
            $file[$no]['href'] = G5_BBS_URL."/download.php?bo_table=$bo_table&amp;wr_id=$wr_id&amp;no=$no" . $qstr;
            $file[$no]['download'] = $row['bf_download'];
            // 4.00.11 - 파일 path 추가
            $file[$no]['path'] = G5_DATA_URL.'/file/'.$bo_table;
            $file[$no]['size'] = get_filesize($row['bf_filesize']);
            $file[$no]['datetime'] = $row['bf_datetime'];
            $file[$no]['source'] = addslashes($row['bf_source']);
            $file[$no]['bf_content'] = $bf_content;
            $file[$no]['content'] = get_text($bf_content);
            //$file[$no]['view'] = view_file_link($row['bf_file'], $file[$no]['content']);
            $file[$no]['view'] = view_file_link($row['bf_file'], $row['bf_width'], $row['bf_height'], $file[$no]['content']);
            $file[$no]['file'] = $row['bf_file'];
            $file[$no]['image_width'] = $row['bf_width'] ? $row['bf_width'] : 640;
            $file[$no]['image_height'] = $row['bf_height'] ? $row['bf_height'] : 480;
            $file[$no]['image_type'] = $row['bf_type'];
            $file[$no]['bf_fileurl'] = $row['bf_fileurl'];
            $file[$no]['bf_thumburl'] = $row['bf_thumburl'];
            $file[$no]['bf_storage'] = $row['bf_storage'];
            $file['count']++;
        }

        return run_replace('get_files', $file, $bo_table, $wr_id);
    }
    
    $file = get_file($bo_table, $wr_id);
    
    if (!isset($file_count)) {
        $file_count = 0;
    }

    if (isset($file['count']) && $file_count < $file['count']) {
        $file_count = $file['count'];
    }

    for($i=0;$i<$file_count;$i++){
        if(! isset($file[$i])) {
            $file[$i] = array('file'=>null, 'source'=>null, 'size'=>null, 'bf_content' => null);
        }
    }
}

//카테고리
$is_category = false;
$category_option = '';
if ($board['bo_use_category']) {
    $ca_name = "";
    if (isset($wr['ca_name']))
        $ca_name = $wr['ca_name'];
    $category_option = get_category_option($bo_table, $ca_name);
    $is_category = true;
}

//링크
$is_link = false;
if ($member['mb_level'] >= $board['bo_link_level']) {
    $is_link = true;
}

//파일
$is_file = false;
if ($member['mb_level'] >= $board['bo_upload_level']) {
    $is_file = true;
}

$is_file_content = false;
if ($board['bo_use_file_content']) {
    $is_file_content = true;
}

$file_count = (int)$board['bo_upload_count'];

//공지
$notice_array = explode(',', trim($board['bo_notice']));
$notice_checked = '';
if ($w == 'u') {
    if (in_array((int)$wr_id, $notice_array)) {
        $notice_checked = 'checked';
    }
}
?>

<form name="fitemqaform" method="post" action="./bbs_form_update.php" method="post" enctype="multipart/form-data" onsubmit="return fitemqaform_submit(this);">

<input type="hidden" name="w" value="<?php echo $w; ?>">
<input type="hidden" name="sca" value="<?php echo $sca; ?>">
<input type="hidden" name="sst" value="<?php echo $sst; ?>">
<input type="hidden" name="sod" value="<?php echo $sod; ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl; ?>">
<input type="hidden" name="stx" value="<?php echo $stx; ?>">
<input type="hidden" name="page" value="<?php echo $page; ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
<input type="hidden" value="html1" name="html">
    
<?php if($w == "u") { ?>
    <input type="hidden" name="wr_id" value="<?php echo $wr_id; ?>">
    <input type="hidden" name="mb_id" value="<?php echo $wr['mb_id']; ?>">
    <input type="hidden" name="wr_name" value="<?php echo $wr['wr_name']; ?>">
    <input type="hidden" name="wr_email" value="<?php echo $wr['wr_email']; ?>">
<?php } else { ?>
    <input type="hidden" name="mb_id" value="<?php echo $member['mb_id']; ?>">
    <input type="hidden" name="wr_name" value="<?php echo $member['mb_nick']; ?>">
    <input type="hidden" name="wr_email" value="<?php echo $member['mb_email']; ?>">
<?php } ?>


<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
        
    <?php if ($is_category) { ?>
    <tr>
        <th scope="row">분류</th>
        <td class="">
            <select name="ca_name" id="ca_name" required class="select">
                <option value="">분류를 선택하세요</option>
                <?php echo $category_option ?>
            </select>
        </td>
    </tr>
    <?php } ?>
        
    <tr>
        <th scope="row">옵션</th>
        <td class="">
            <input type="checkbox" id="notice" name="notice" value="1" <?php echo $notice_checked ?>><label for="notice"> 공지</label>
        </td>
    </tr>
        
    <?php if($w == "u") { ?>
    <tr>
        <th scope="row">작성자</th>
        <td>
            <a href="./member_form.php?w=u&mb_id=<?php echo $wr['mb_id'] ?>"><?php echo $name; ?></a>
        </td>
    </tr>
    <?php } ?>

    <tr>
        <th scope="row"><label for="wr_subject">제목</label></th>
        <td><input type="text" name="wr_subject" value="<?php echo isset($wr['wr_subject']) ? $wr['wr_subject'] : ''; ?>" id="wr_subject" required class="frm_input required" size="95"></td>
    </tr>
        
    <tr>
        <th scope="row"><label for="wr_content">내용</label></th>
        <td><?php echo editor_html('wr_content', get_text(html_purifier(isset($wr['wr_content']) ? $wr['wr_content'] : ''), 0)); ?></td>
    </tr>
        
    <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <tr>
            <th scope="row">링크 <?php echo $i ?></th>
            <td class="">
                <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $wr['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="frm_input" size="50" placeholder="링크 <?php echo $i ?>">
            </td>
        </tr>
    <?php } ?>
        
        
    <?php
        if($w == "u") {
            $file = get_file_qa($bo_table, $wr_id);
        }
        for ($i=0; $is_file && $i<$file_count; $i++) {
    ?>
    <tr>
        <th scope="row"><label for="mb_icon">첨부파일 <?php echo $i+1 ?></label></th>
        <td>
            <input type="file" name="bf_file[]" id="bf_file_<?php echo $i+1 ?>" title="파일첨부 <?php echo $i+1 ?>" class="frm_input">　
            <?php if ($w == "u" && isset($file[$i]['source']) && $file[$i]['source']) { ?>
            <a href="<?php echo $file[$i]['href']; ?>" style="font-weight:bold"><?php echo $file[$i]['source'] ?></a> (<?php echo $file[$i]['size'] ?>)　
            <?php } ?>
            <?php if ($w == 'u' && isset($file[$i]['file']) && $file[$i]['file']) { ?>
            <span class="file_del">
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"> 파일삭제</label>
            </span>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
    



    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./bbs_list.php?<?php echo $qstr; ?>&amp;bo_table=<?php echo $bo_table; ?>" class="btn btn_02">목록</a>
    <input type="submit" accesskey='s' value="확인" class="btn_submit btn">
</div>
</form>

<script>
function fitemqaform_submit(f)
{
    <?php echo get_editor_js('wr_content'); ?>

    return true;
}
</script>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');