<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/naver_syndi.lib.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$return = ['res' => 'false', 'msg' => '오류', 'list' => []];

if (empty($_POST['act_type'])) {
    echo json_encode($return);
    exit;
}
if (empty($_POST['bo_table'])) {
    echo json_encode($return);
    exit;
}
if (empty($_POST['write_table'])) {
    echo json_encode($return);
    exit;
}

$bo_table = trim($_POST['bo_table']);
$write_table = trim($_POST['write_table']);
$wr_id = empty($_POST['wr_id']) ? 0 : intval($_POST['wr_id']);

// 파일 삭제시
if (trim($_POST['act_type']) == 'delete') {

    if (empty($_POST['bf_file'])) {
        echo json_encode($return);
        exit;
    }
    @unlink(G5_DATA_PATH . '/file/' . $bo_table . '/' . $_POST['bf_file']);
    if (isset($config['cf_image_extension']) && preg_match("/\.({$config['cf_image_extension']})$/i", $_POST['bf_file'])) {
        delete_board_thumbnail($bo_table, $_POST['bf_file']);
    }

    sql_query("DELETE FROM {$g5['board_file_table']} WHERE bo_table = '{$bo_table}' AND wr_id = '{$wr_id}' AND bf_file = '{$_POST['bf_file']}'");

    $return['res'] = 'true';
    $return['msg'] = '파일이 삭제 되었습니다.';
    echo json_encode($return);
    exit;
}

// 이하 파일 추가시
$chars_array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
// 디렉토리가 없으면 생성
@mkdir(G5_DATA_PATH . '/file/' . $bo_table, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH . '/file/' . $bo_table, G5_DIR_PERMISSION);

if (isset($_FILES['file']) && count($_FILES['file']['name']) > 0) {
    $list = [];
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        $tmp_file = $_FILES['file']['tmp_name'][$i];
        $filename = get_safe_filename($_FILES['file']['name'][$i]);
        $filename = preg_replace("/\.(php|pht|phtm|htm|cgi|pl|exe|jsp|asp|inc)/i", "$0-x", $filename);
        shuffle($chars_array);
        $shuffle = implode('', $chars_array);
        $filename = abs(ip2long($_SERVER['REMOTE_ADDR'])) . '_' . substr($shuffle, 0, 8) . '_' . replace_filename($filename);
        $filename = addslashes($filename);
        $timg = @getimagesize($tmp_file);
        if (is_array($timg) && (isset($config['cf_image_extension']) && preg_match("/\.({$config['cf_image_extension']})$/i", $filename) || isset($config['cf_flash_extension']) && preg_match("/\.({$config['cf_flash_extension']})$/i", $filename))) {
            if ($timg[2] < 1 || $timg[2] > 16) {
                continue;
            }
        }

        // 파일 확장자 체크
        $ext_arr = explode("|", (isset($config['cf_image_extension']) ? $config['cf_image_extension'] : '') . "|" . (isset($config['cf_movie_extension']) ? $config['cf_movie_extension'] : '') . "|hwp|xlsx|xls|zip|pdf|ppt|pptx|docx|doc|txt");
        $arr = explode('.', $filename);
        if (!in_array(end($arr), $ext_arr)) {
            @unlink(G5_DATA_PATH . '/file/' . $bo_table . '/' . $filename);
            delete_board_thumbnail($bo_table, $filename);
            $return['msg'] = '지원하지 않는 파일형식 입니다.';
            echo json_encode($return);
            exit;
        }

        $f = [];
        $f['bf_source'] = isset($_FILES['file']['name'][$i]) ? $_FILES['file']['name'][$i] : '';
        $f['bf_filesize'] = isset($_FILES['file']['size'][$i]) ? $_FILES['file']['size'][$i] : 0;
        $f['bf_datetime'] = G5_TIME_YMDHIS;
        $f['bf_file'] = $filename;
        $f['bf_width'] = is_array($timg) ? $timg[0] : 0;
        $f['bf_height'] = is_array($timg) ? $timg[1] : 0;
        $f['bf_type'] = is_array($timg) ? $timg[2] : 0;

        $pinfo = pathinfo($f['bf_source']);
        $f['extension'] = isset($pinfo['extension']) ? $pinfo['extension'] : '';

        if ($f['bf_width'] > 0) {
            $f['view'] = '<img src="' . G5_DATA_URL . '/file/' . $bo_table . '/' . $filename . '" style="max-width:100%;" />';
        } else {
            $f['view'] = "<div class=\"w_pd\"><a href=\"javascript:void(0);\" class=\"w_etc w_" . $f['extension'] . "\">" . $f['extension'] . "</a></div>";
        }

        $dest_file = G5_DATA_PATH . '/file/' . $bo_table . '/' . $filename;
        move_uploaded_file($tmp_file, $dest_file);
        chmod($dest_file, G5_FILE_PERMISSION);
        $list[] = $f;
    }
    $return['res'] = 'true';
    $return['msg'] = '업로드 완료';
    $return['list'] = $list;
    echo json_encode($return);
    exit;
} else {
    $return['msg'] = '파일을 선택하세요';
    echo json_encode($return);
    exit;
}
?>
