<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/naver_syndi.lib.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$return = ['res' => 'false', 'msg' => '오류', 'list' => []];

if (empty($_POST['act_type']) || empty($_POST['bo_table']) || empty($_POST['write_table'])) {
    echo json_encode($return);
    exit;
}

$bo_table = preg_replace('/[^a-z0-9_]/i', '', $_POST['bo_table']);
$write_table = preg_replace('/[^a-z0-9_]/i', '', $_POST['write_table']);
$wr_id = isset($_POST['wr_id']) ? intval($_POST['wr_id']) : 0;

// 삭제 처리
if ($_POST['act_type'] === 'delete') {
    if (empty($_POST['bf_file'])) {
        echo json_encode($return);
        exit;
    }
    $bf_file = basename($_POST['bf_file']);
    $file_path = G5_DATA_PATH . "/file/{$bo_table}/{$bf_file}";

    if (is_file($file_path)) {
        @unlink($file_path);
        if (isset($config['cf_image_extension']) && preg_match("/\.({$config['cf_image_extension']})$/i", $bf_file)) {
            delete_board_thumbnail($bo_table, $bf_file);
        }
    }

    sql_query("DELETE FROM {$g5['board_file_table']} WHERE bo_table = '" . sql_real_escape_string($bo_table) . "' AND wr_id = '{$wr_id}' AND bf_file = '" . sql_real_escape_string($bf_file) . "'");

    $return['res'] = 'true';
    $return['msg'] = '파일이 삭제 되었습니다.';
    echo json_encode($return);
    exit;
}

// 업로드 처리
@mkdir(G5_DATA_PATH . "/file/{$bo_table}", G5_DIR_PERMISSION, true);
@chmod(G5_DATA_PATH . "/file/{$bo_table}", G5_DIR_PERMISSION);

$allowed_extensions = explode('|', $config['cf_image_extension'] . '|' . $config['cf_movie_extension'] . '|webp|hwp|xlsx|xls|zip|pdf|ppt|pptx|docx|doc|txt');
$allowed_mimes = [
    // 이미지
    'image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/webp', 'image/svg+xml',

    // 동영상
    'video/mp4', 'video/mpeg', 'video/ogg', 'video/webm', 'video/x-msvideo', 'video/quicktime', 'video/x-flv',

    // 오디오
    'audio/mpeg', 'audio/wav', 'audio/ogg', 'audio/mp4', 'audio/webm', 'audio/x-ms-wma',

    // 문서
    'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/rtf', 'text/plain', 'application/vnd.hancom.hwp',

    // 압축파일
    'application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar', 'application/gzip',

    // 코드 및 기타
    'text/html', 'application/javascript', 'text/css', 'application/json', 'application/xml', 'text/csv',

    // 기타 가능성 있는 MIME
    'application/octet-stream'
];

function get_mime_type_fallback($file) {
    // 1. finfo
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file);
        finfo_close($finfo);
        return $mime;
    }
    // 2. mime_content_type
    elseif (function_exists('mime_content_type')) {
        return mime_content_type($file);
    }
    // 3. shell_exec file 명령 (리눅스 서버)
    elseif (function_exists('shell_exec')) {
        $mime = trim(@shell_exec('file -b --mime-type ' . escapeshellarg($file)));
        if ($mime) return $mime;
    }
    // 4. 모두 실패: false 반환 (확장자 검사만 가능)
    return false;
}

if (isset($_FILES['file']) && count($_FILES['file']['name']) > 0) {
    $list = [];
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        $tmp_file = $_FILES['file']['tmp_name'][$i];
        $orig_name = $_FILES['file']['name'][$i];
        $safe_name = preg_replace("/[^a-zA-Z0-9._-]/", "_", $orig_name);

        // 이중 확장자 검사 (ex. test.php.jpg)
        if (preg_match("/\.(php|pht|phtml|cgi|pl|exe|jsp|asp|inc|sh|js|html|htm|xml)(\.[a-z0-9]+)?$/i", $safe_name)) {
            $return['msg'] = '이중 확장자 또는 금지된 확장자가 포함되어 있습니다.';
            echo json_encode($return);
            exit;
        }

        // 확장자 추출
        $ext = strtolower(pathinfo($safe_name, PATHINFO_EXTENSION));
        // MIME 타입 추출 (환경별로 자동 fallback)
        $mime = get_mime_type_fallback($tmp_file);

        // 검증 로직
        $pass = false;
        if ($mime !== false) {
            // MIME 타입까지 모두 체크
            if (in_array($ext, $allowed_extensions) && in_array($mime, $allowed_mimes)) {
                $pass = true;
            }
        } else {
            // MIME 타입 체크 불가 환경: 확장자만 체크 (주의 안내)
            if (in_array($ext, $allowed_extensions)) {
                $pass = true;
            }
        }

        if (!$pass) {
            $return['msg'] = '허용되지 않는 파일 형식입니다.';
            echo json_encode($return);
            exit;
        }

        // 저장 파일명 생성
        $unique = abs(ip2long($_SERVER['REMOTE_ADDR'])) . '_' . uniqid();
        $new_filename = $unique . '_' . $safe_name;
        $dest_file = G5_DATA_PATH . "/file/{$bo_table}/{$new_filename}";

        if (move_uploaded_file($tmp_file, $dest_file)) {
            chmod($dest_file, G5_FILE_PERMISSION);

            $f = [
                'bf_source' => htmlspecialchars($orig_name, ENT_QUOTES, 'UTF-8'),
                'bf_file' => $new_filename,
                'bf_filesize' => filesize($dest_file),
                'bf_datetime' => G5_TIME_YMDHIS,
                'extension' => $ext,
                'view' => '',
            ];

            $timg = @getimagesize($dest_file);
            if ($timg) {
                $f['bf_width'] = $timg[0];
                $f['bf_height'] = $timg[1];
                $f['bf_type'] = $timg[2];
                $f['view'] = '<img src="' . G5_DATA_URL . '/file/' . $bo_table . '/' . $new_filename . '" style="max-width:100%;" />';
            } else {
                $f['view'] = "<div class=\"w_pd\"><a href=\"javascript:void(0);\" class=\"w_etc w_{$ext}\">{$ext}</a></div>";
            }

            $list[] = $f;
        }
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
