<?php
include_once('../../common.php');
include_once(G5_LIB_PATH.'/naver_syndi.lib.php');
include_once(G5_CAPTCHA_PATH.'/captcha.lib.php');

$return = ['res' => 'false', 'msg' => '오류', 'list' => []];

if (empty($_POST['act_type']) || empty($_POST['bo_table']) || empty($_POST['write_table'])) {
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    exit;
}

$bo_table   = preg_replace('/[^a-z0-9_]/i', '', $_POST['bo_table']);
$write_table= preg_replace('/[^a-z0-9_]/i', '', $_POST['write_table']);
$wr_id      = isset($_POST['wr_id']) ? intval($_POST['wr_id']) : 0;

// // 삭제 처리
if ($_POST['act_type'] === 'delete') {
    if (empty($_POST['bf_file'])) {
        echo json_encode($return, JSON_UNESCAPED_UNICODE);
        exit;
    }
    $bf_file   = basename($_POST['bf_file']);
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
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    exit;
}

// // 업로드 처리
@mkdir(G5_DATA_PATH . "/file/{$bo_table}", G5_DIR_PERMISSION, true);
@chmod(G5_DATA_PATH . "/file/{$bo_table}", G5_DIR_PERMISSION);

// // 허용 확장자
$allowed_extensions = explode('|', $config['cf_image_extension'] . '|' . $config['cf_movie_extension'] . '|webp|hwp|xlsx|xls|zip|pdf|ppt|pptx|docx|doc|txt');
$allowed_extensions = array_values(array_filter(array_map(function($s){
    return strtolower(trim($s)); // // 공백 제거 + 소문자 + 빈값 제거
}, $allowed_extensions)));

// // 허용 MIME
$allowed_mimes = [
    // 이미지
    'image/jpeg','image/png','image/gif','image/bmp','image/webp','image/svg+xml',

    // 동영상
    'video/mp4','video/mpeg','video/ogg','video/webm','video/x-msvideo','video/quicktime','video/x-flv',

    // 오디오
    'audio/mpeg','audio/wav','audio/ogg','audio/mp4','audio/webm','audio/x-ms-wma',

    // 문서
    'application/pdf',
    'application/msword','application/x-msword',
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'application/rtf','text/plain',
    'application/vnd.hancom.hwp','application/x-hwp','application/hwp','application/haansofthwp',
    'application/vnd.ms-office','application/x-hwp-v5',

    // 압축
    'application/zip','application/x-zip-compressed','application/x-zip',
    'application/x-rar-compressed','application/x-7z-compressed','application/x-tar','application/gzip',

    // 코드/기타
    'text/html','application/javascript','text/css','application/json','application/xml','text/csv',

    // 기타
    'application/octet-stream'
];

// // MIME 검출
function get_mime_type_fallback($file) {
    $mime = '';

    if (function_exists('finfo_open')) {
        $finfo = @finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime = @finfo_file($finfo, $file) ?: '';
            @finfo_close($finfo);
        }
    }
    if (!$mime && function_exists('mime_content_type')) {
        $mime = @mime_content_type($file) ?: '';
    }
    if (!$mime && function_exists('shell_exec')) {
        $mime = trim((string)@shell_exec('file -b --mime-type ' . escapeshellarg($file)));
    }
    if ($mime !== '') {
        $mime = strtolower(trim(explode(';', $mime)[0]));
        return $mime;
    }
    return false;
}

// // 보안: 파일 시그니처 검사
function rb_is_valid_docx($file) {
    // // ZIP 매직 'PK'
    $fh = @fopen($file, 'rb');
    if (!$fh) return false;
    $sig = @fread($fh, 2);
    @fclose($fh);
    if ($sig !== "PK") return false;

    // // 엔트리 체크 가능 시 확인
    if (class_exists('ZipArchive')) {
        $zip = new ZipArchive();
        if ($zip->open($file) === true) {
            $ok = ($zip->locateName('word/document.xml') !== false) || ($zip->locateName('[Content_Types].xml') !== false);
            $zip->close();
            return $ok;
        }
    }
    return true;
}

function rb_is_valid_hwp($file) {
    // // OLE Compound File 매직: D0 CF 11 E0 A1 B1 1A E1
    $fh = @fopen($file, 'rb');
    if ($fh) {
        $sig8 = @fread($fh, 8);
        @fclose($fh);
        $ole = "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1";
        if ($sig8 === $ole) return true;
    }

    // // 일부 환경: ZIP(HWPX) 형태
    $fh2 = @fopen($file, 'rb');
    if ($fh2) {
        $sig2 = @fread($fh2, 2);
        @fclose($fh2);
        if ($sig2 === "PK") {
            if (class_exists('ZipArchive')) {
                $zip = new ZipArchive();
                if ($zip->open($file) === true) {
                    $ok = (
                        $zip->locateName('[Content_Types].xml') !== false ||
                        $zip->locateName('AppManifest.xml') !== false ||
                        $zip->locateName('docProps/') !== false
                    );
                    $zip->close();
                    if ($ok) return true;
                }
            }
            return true;
        }
    }
    return false;
}

if (isset($_FILES['file']) && count($_FILES['file']['name']) > 0) {
    $list = [];
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        $tmp_file  = $_FILES['file']['tmp_name'][$i];
        $orig_name = $_FILES['file']['name'][$i];
        $safe_name = preg_replace("/[^a-zA-Z0-9._-]/", "_", $orig_name);

        // // 이중 확장자 차단
        if (preg_match("/\.(php|pht|phtml|cgi|pl|exe|jsp|asp|inc|sh|js|html|htm|xml)(\.[a-z0-9]+)?$/i", $safe_name)) {
            $return['msg'] = '이중 확장자 또는 금지된 확장자가 포함되어 있습니다.';
            echo json_encode($return, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // // 확장자 / MIME / 파일크기
        $ext   = strtolower(pathinfo($safe_name, PATHINFO_EXTENSION));
        $mime  = get_mime_type_fallback($tmp_file);
        $mime  = ($mime !== false) ? strtolower(trim(explode(';', (string)$mime)[0])) : '';
        $fsize = (int) @filesize($tmp_file);

        // // 0바이트 파일 조기 차단
        if ($fsize === 0 || ($mime === 'application/x-empty' && $fsize === 0)) {
            $return['res']   = 'false';
            $return['msg']   = '업로드 실패 : 파일이 비어있거나(0바이트) 업로드에 실패했습니다.';
            $return['ext']   = $ext;
            $return['mime']  = ($mime === '' ? '(empty)' : (string)$mime);
            $return['name']  = (string)$orig_name;
            $return['size']  = $fsize;
            $return['error'] = isset($_FILES['file']['error'][$i]) ? (int)$_FILES['file']['error'][$i] : null;
            echo json_encode($return, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // // 기본 검증
        $pass = false;
        if ($mime) {
            if (in_array($ext, $allowed_extensions, true) && in_array($mime, $allowed_mimes, true)) {
                $pass = true;
            }
        } else {
            if (in_array($ext, $allowed_extensions, true)) {
                $pass = true;
            }
        }

        // // 예외 허용: docx (MIME 편차 + 시그니처 필수)
        if (!$pass && $ext === 'docx' && in_array('docx', $allowed_extensions, true)) {
            $mime_ok = in_array($mime, [
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-office',
                'application/zip','application/x-zip-compressed','application/x-zip',
                'application/msword','application/x-msword',
                'application/octet-stream','application/x-empty',''
            ], true) || preg_match('/zip|officedocument|ms\-office/i', (string)$mime);
            if ($mime_ok && rb_is_valid_docx($tmp_file)) {
                $pass = true;
            }
        }

        // // 예외 허용: hwp (OLE 또는 ZIP 계열 + 시그니처 필수)
        if (!$pass && $ext === 'hwp' && in_array('hwp', $allowed_extensions, true)) {
            $mime_ok = in_array($mime, [
                'application/vnd.hancom.hwp','application/x-hwp','application/hwp',
                'application/haansofthwp','application/x-hwp-v5',
                'application/zip','application/x-zip-compressed','application/x-zip',
                'application/octet-stream','application/x-empty',''
            ], true) || preg_match('/hwp/i', (string)$mime);
            if ($mime_ok && rb_is_valid_hwp($tmp_file)) {
                $pass = true;
            }
        }

        // // 최종 실패 응답(디버그 포함)
        if (!$pass) {
            $return['res']  = 'false';
            $return['msg']  = '허용되지 않는 파일 형식입니다.';
            $return['ext']  = $ext;
            $return['mime'] = ($mime === '' ? '(empty)' : (string)$mime);
            $return['name'] = (string)$orig_name;
            echo json_encode($return, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // // 저장
        $unique       = abs(ip2long($_SERVER['REMOTE_ADDR'])) . '_' . uniqid();
        $new_filename = $unique . '_' . $safe_name;
        $dest_file    = G5_DATA_PATH . "/file/{$bo_table}/{$new_filename}";

        if (move_uploaded_file($tmp_file, $dest_file)) {
            chmod($dest_file, G5_FILE_PERMISSION);

            $f = [
                'bf_source'   => htmlspecialchars($orig_name, ENT_QUOTES, 'UTF-8'),
                'bf_file'     => $new_filename,
                'bf_filesize' => filesize($dest_file),
                'bf_datetime' => G5_TIME_YMDHIS,
                'extension'   => $ext,
                'view'        => '',
            ];

            $timg = @getimagesize($dest_file);
            if ($timg) {
                $f['bf_width']  = $timg[0];
                $f['bf_height'] = $timg[1];
                $f['bf_type']   = $timg[2];
                $f['view']      = '<img src="' . G5_DATA_URL . '/file/' . $bo_table . '/' . $new_filename . '" style="max-width:100%;" />';
            } else {
                $f['view'] = "<div class=\"w_pd\"><a href=\"javascript:void(0);\" class=\"w_etc w_{$ext}\">{$ext}</a></div>";
            }

            $list[] = $f;
        }
    }
    $return['res']  = 'true';
    $return['msg']  = '업로드 완료';
    $return['list'] = $list;
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    exit;
} else {
    $return['msg'] = '파일을 선택하세요';
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    exit;
}

?>
