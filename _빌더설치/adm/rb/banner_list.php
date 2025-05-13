<?php
$sub_menu = '000300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "r");

//배너 테이블이 있는지 검사한다.
if(!sql_query(" DESCRIBE rb_banner ", false)) {
       $query_cp = sql_query(" CREATE TABLE IF NOT EXISTS `rb_banner` (
        `bn_id` int(11) NOT NULL AUTO_INCREMENT,
        `bn_alt` varchar(255) NOT NULL DEFAULT '',
        `bn_url` varchar(255) NOT NULL DEFAULT '',
        `bn_device` varchar(10) NOT NULL DEFAULT '',
        `bn_position` varchar(255) NOT NULL DEFAULT '',
        `bn_border` tinyint(4) NOT NULL DEFAULT '0',
        `bn_radius` tinyint(4) NOT NULL DEFAULT '0',
        `bn_ad_ico` tinyint(4) NOT NULL DEFAULT '0',
        `bn_new_win` tinyint(4) NOT NULL DEFAULT '0',
        `bn_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `bn_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `bn_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `bn_hit` int(11) NOT NULL DEFAULT '0',
        `bn_order` int(11) NOT NULL DEFAULT '0',
        PRIMARY KEY (`bn_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
      sql_query(" ALTER TABLE `rb_banner` ADD PRIMARY KEY (`bn_id`) ", false);
      sql_query(" ALTER TABLE `rb_banner` MODIFY `bn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;COMMIT ", false);
}

$g5['title'] = '배너관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$sql_common = " from rb_banner ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt"> 등록된 배너 </span><span class="ov_num"> <?php echo $total_count; ?>개</span></span>
</div>

<div class="btn_fixed_top">
    <a href="./banner_form.php" class="btn_01 btn">배너추가</a>
</div>

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" id="th_id">ID</th>
        <th scope="col" id="th_dvc">배너 Url</th>
		<th scope="col" id="th_inf">배너설명</th>
        <th scope="col" id="th_loc">출력그룹</th>
        <th scope="col" id="th_dev">출력기기</th>
        <th scope="col" id="th_st">시작일시</th>
        <th scope="col" id="th_end">종료일시</th>
        <th scope="col" id="th_odr">출력순서</th>
        <th scope="col" id="th_hit">클릭</th>
        <th scope="col" id="th_mng">관리</th>
    </tr>

    </thead>
    <tbody>
    <?php
    $sql = " select * from rb_banner
          order by bn_position, bn_id desc
          limit $from_record, $rows  ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {

        $bn_border  = $row['bn_border'];
        $bn_radius  = $row['bn_radius'];
        $bn_ad_ico  = $row['bn_ad_ico'];
        // 새창 띄우기인지
        $bn_new_win = ($row['bn_new_win']) ? 'target="_blank"' : '';

        $bimg = G5_DATA_PATH.'/banners/'.$row['bn_id'];
        if(file_exists($bimg)) {
            $size = @getimagesize($bimg);
            if($size[0] && $size[0] > 800)
                $width = 800;
            else
                $width = $size[0];

            $bn_img = "";

            $bn_img .= G5_DATA_URL."/banners/".$row['bn_id'];
        }

        switch($row['bn_device']) {
            case 'pc':
                $bn_device = 'PC';
                break;
            case 'mobile':
                $bn_device = '모바일';
                break;
            default:
                $bn_device = 'PC와 모바일';
                break;
        }

        $bn_begin_time = substr($row['bn_begin_time'], 0, 19);
        $bn_end_time   = substr($row['bn_end_time'], 0, 19);

        $bg = 'bg'.($i%2);
    ?>

    <tr class="<?php echo $bg; ?>">
        <td headers="th_id" class="td_num"><?php echo $row['bn_id']; ?></td>
        <td headers="th_dvc"><a href="<?php echo !empty($bn_img) ? $bn_img : '#'; ?>" target="_blank"><?php echo !empty($bn_img) ? $bn_img : '이미지 없음'; ?></a></td>
		<td headers="th_loc"><?php echo !empty($row['bn_alt']) ? $row['bn_alt'] : '-'; ?></td>
        <td headers="th_loc">
		<?php if($row['bn_position'] == "") {
			echo "-";
		} else {
			echo $row['bn_position'];
		}
		?>
		</td>
        <td headers="th_loc">
		<?php echo $bn_device; ?>
		</td>
        <td headers="th_st" class="td_datetime"><?php echo $bn_begin_time; ?></td>
        <td headers="th_end" class="td_datetime"><?php echo $bn_end_time; ?></td>
        <td headers="th_odr" class="td_num"><?php echo $row['bn_order']; ?></td>
        <td headers="th_hit" class="td_num"><?php echo number_format($row['bn_hit']); ?></td>
        <td headers="th_mng" class="td_mng td_mns_m">
            <a href="./banner_form.php?w=u&amp;bn_id=<?php echo $row['bn_id']; ?>" class="btn btn_03">수정</a>
            <a href="./banner_form_update.php?w=d&amp;bn_id=<?php echo $row['bn_id']; ?>" onclick="return delete_confirm(this);" class="btn btn_02">삭제</a>
        </td>
    </tr>

    <?php
    }
    if ($i == 0) {
    echo '<tr><td colspan="10" class="empty_table">자료가 없습니다.</td></tr>';
    }
    ?>
    </tbody>
    </table>

</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page="); ?>


<div class="local_desc01 local_desc">
    <p>
        배너를 등록하시면 모듈설정에서 추가하실 수 있습니다.

    </p>
</div>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
?>
