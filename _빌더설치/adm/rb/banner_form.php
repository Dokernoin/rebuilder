<?php
$sub_menu = '000300';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");

$bn_id = isset($bn_id) ? preg_replace('/[^0-9]/', '', $bn_id) : '';

$html_title = '배너';
$g5['title'] = $html_title . ' 관리';

if (isset($w) && $w == "u") {
    $html_title .= ' 수정';
    $sql = "SELECT * FROM rb_banner WHERE bn_id = '$bn_id'";
    $bn = sql_fetch($sql);
} else {
    $html_title .= ' 입력';
    $bn = [
        'bn_url' => "http://",
        'bn_begin_time' => date("Y-m-d 00:00:00", time()),
        'bn_end_time' => date("Y-m-d 00:00:00", time() + (60 * 60 * 24 * 31)),
        'bn_id' => ''
    ];
}

// 접속기기 필드 추가
if (!sql_query("SELECT bn_device FROM rb_banner LIMIT 0, 1")) {
    sql_query("ALTER TABLE `rb_banner` ADD `bn_device` varchar(10) NOT NULL DEFAULT '' AFTER `bn_url`", true);
    sql_query("UPDATE rb_banner SET bn_device = 'pc'", true);
}

include_once(G5_ADMIN_PATH . '/admin.head.php');
?>

<form name="fbanner" action="./banner_form_update.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo isset($w) ? $w : ''; ?>">
<input type="hidden" name="bn_id" value="<?php echo $bn_id; ?>">

<div class="tbl_frm01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?></caption>
    <colgroup>
        <col class="grid_4">
        <col>
    </colgroup>
    <tbody>
    <tr>
        <th scope="row">이미지</th>
        <td>
            <input type="file" name="bn_bimg">
            <?php
            $bimg_str = "";
            $bimg = G5_DATA_PATH . "/banners/" . $bn['bn_id'];
            if (isset($bn['bn_id']) && file_exists($bimg)) {
                $size = @getimagesize($bimg);
                $width = (isset($size[0]) && $size[0] > 750) ? 750 : (isset($size[0]) ? $size[0] : 0);

                echo '<input type="checkbox" name="bn_bimg_del" value="1" id="bn_bimg_del"> <label for="bn_bimg_del">삭제</label>';
                $bimg_str = '<img src="' . G5_DATA_URL . '/banners/' . $bn['bn_id'] . '?ver=' . G5_SERVER_TIME . '" width="' . $width . '">';
            }
            if (isset($bn['bn_id']) && $bn['bn_id']) {
                echo '<div class="banner_or_img">';
                echo $bimg_str;
                echo '</div>';
            }
            ?>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_alt">이미지 설명</label></th>
        <td>
            <?php echo help("이미지 태그의 alt, title 에 해당되는 내용입니다."); ?>
            <input type="text" name="bn_alt" value="<?php echo isset($bn['bn_alt']) ? get_text($bn['bn_alt']) : ''; ?>" id="bn_alt" class="frm_input" size="80">
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_url">링크</label></th>
        <td>
            <?php echo help("배너이미지 클릭시 이동하는 Url입니다."); ?>
            <input type="text" name="bn_url" size="80" value="<?php echo isset($bn['bn_url']) ? $bn['bn_url'] : 'http://'; ?>" id="bn_url" class="frm_input">
        </td>
    </tr>

    <tr>
        <th scope="row"><label for="bn_position">출력그룹</label></th>
        <td>
            <select name="bn_position" id="bn_position">
                <?php echo rb_banner_group_list($bn['bn_position']) ?>
                <option value="개별출력" <?php echo get_selected(isset($bn['bn_position']) ? $bn['bn_position'] : '', '개별출력'); ?>>개별출력</option>
				<option value="" <?php echo get_selected(isset($bn['bn_position']) ? $bn['bn_position'] : '', ''); ?>>미출력</option>
			</select> <input type="text" name="bn_position_use" id="bn_position_use" class="frm_input" placeholder="그룹생성">
			<br><br>
			<?php echo help("개별출력의 경우 그룹화 되지 않습니다. 그룹이 없는 경우 그룹생성 항목에 직접 입력하시면 생성 됩니다.<br>생성되는 배너는 모두 모듈설정 패널에서 사용하실 수 있습니다."); ?>
			
			<?php echo htmlspecialchars("그룹별 출력 : <?php echo rb_banners('그룹명'); ?>"); ?><br>
			<?php echo htmlspecialchars("개별출력 : <?php echo rb_banners('개별출력', '배너ID'); ?>"); ?><br>
			<?php echo htmlspecialchars("미출력 : 배너를 출력하지 않습니다."); ?>
		   
        </td>
    </tr>
    
    
    <tr>
        <th scope="row"><label for="bn_device">출력기기</label></th>
        <td>
            <?php echo help('배너이미지를 출력할 기기를 선택할 수 있습니다.'); ?>
            <?php $bn_device = isset($bn['bn_device']) ? $bn['bn_device'] : null; ?>
            <select name="bn_device" id="bn_device">
                <option value="both"<?php echo get_selected($bn_device, 'both', true); ?>>PC와 모바일</option>
                <option value="pc"<?php echo get_selected($bn_device, 'pc', true); ?>>PC</option>
                <option value="mobile"<?php echo get_selected($bn_device, 'mobile', true); ?>>모바일</option>
        </select>
        </td>
    </tr>
    
    <tr>
        <th scope="row"><label for="bn_border">테두리</label></th>
        <td>
             <?php echo help("배너이미지에 테두리를 넣을지를 설정합니다.", 50); ?>
            <select name="bn_border" id="bn_border">
                <option value="0" <?php echo get_selected(isset($bn['bn_border']) ? $bn['bn_border'] : 0, 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected(isset($bn['bn_border']) ? $bn['bn_border'] : 1, 1); ?>>사용</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_radius">모서리</label></th>
        <td>
             <?php echo help("배너이미지에 모서리를 둥글게 처리할지를 설정 합니다.", 50); ?>
            <select name="bn_radius" id="bn_radius">
                <option value="0" <?php echo get_selected(isset($bn['bn_radius']) ? $bn['bn_radius'] : 0, 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected(isset($bn['bn_radius']) ? $bn['bn_radius'] : 1, 1); ?>>사용</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_ad_ico">AD아이콘</label></th>
        <td>
             <?php echo help("배너이미지에 AD 아이콘을 보여줄지 설정 합니다.", 50); ?>
            <select name="bn_ad_ico" id="bn_ad_ico">
                <option value="0" <?php echo get_selected(isset($bn['bn_ad_ico']) ? $bn['bn_ad_ico'] : 0, 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected(isset($bn['bn_ad_ico']) ? $bn['bn_ad_ico'] : 1, 1); ?>>사용</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_new_win">새창</label></th>
        <td>
            <?php echo help("배너이미지 클릭시 새창연결 여부를 선택할 수 있습니다.", 50); ?>
            <select name="bn_new_win" id="bn_new_win">
                <option value="0" <?php echo get_selected(isset($bn['bn_new_win']) ? $bn['bn_new_win'] : 0, 0); ?>>사용안함</option>
                <option value="1" <?php echo get_selected(isset($bn['bn_new_win']) ? $bn['bn_new_win'] : 1, 1); ?>>사용</option>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_begin_time">게시 시작일시</label></th>
        <td>
            <?php echo help("배너 게시 시작일시를 설정합니다."); ?>
            <input type="text" name="bn_begin_time" value="<?php echo isset($bn['bn_begin_time']) ? $bn['bn_begin_time'] : date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_time" class="frm_input" size="21" maxlength="19">
            <input type="checkbox" name="bn_begin_chk" value="<?php echo date("Y-m-d 00:00:00", time()); ?>" id="bn_begin_chk" onclick="if (this.checked == true) this.form.bn_begin_time.value=this.form.bn_begin_chk.value; else this.form.bn_begin_time.value = this.form.bn_begin_time.defaultValue;">
            <label for="bn_begin_chk">오늘</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_end_time">게시 종료일시</label></th>
        <td>
            <?php echo help("배너 게시 종료일시를 설정합니다."); ?>
            <input type="text" name="bn_end_time" value="<?php echo isset($bn['bn_end_time']) ? $bn['bn_end_time'] : date("Y-m-d 00:00:00", time() + 60 * 60 * 24 * 31); ?>" id="bn_end_time" class="frm_input" size=21 maxlength=19>
            <input type="checkbox" name="bn_end_chk" value="<?php echo date("Y-m-d 23:59:59", time() + 60 * 60 * 24 * 31); ?>" id="bn_end_chk" onclick="if (this.checked == true) this.form.bn_end_time.value=this.form.bn_end_chk.value; else this.form.bn_end_time.value = this.form.bn_end_time.defaultValue;">
            <label for="bn_end_chk">오늘+31일</label>
        </td>
    </tr>
    <tr>
        <th scope="row"><label for="bn_order">출력 순서</label></th>
        <td>
           <?php echo help("배너를 출력할 때 순서를 정합니다. 숫자가 작을수록 먼저 출력됩니다."); ?>
           <?php echo order_select("bn_order", isset($bn['bn_order']) ? $bn['bn_order'] : 0); ?>
        </td>
    </tr>

    </tbody>
    </table>
</div>

<div class="btn_fixed_top">
    <a href="./banner_list.php" class="btn_02 btn">목록</a>
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<?php
include_once(G5_ADMIN_PATH . '/admin.tail.php');
?>