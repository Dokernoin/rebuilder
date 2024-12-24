<?php
$sub_menu = '000500';
include_once('./_common.php');

check_demo();
auth_check_menu($auth, $sub_menu, "w");

check_admin_token();
@mkdir(G5_DATA_PATH . "/seo", G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH . "/seo", G5_DIR_PERMISSION);

$favimg = isset($_FILES['se_favicon']['tmp_name']) ? $_FILES['se_favicon']['tmp_name'] : null;
$favimg_name = isset($_FILES['se_favicon']['name']) ? $_FILES['se_favicon']['name'] : null;

$ogimg = isset($_FILES['se_og_image']['tmp_name']) ? $_FILES['se_og_image']['tmp_name'] : null;
$ogimg_name = isset($_FILES['se_og_image']['name']) ? $_FILES['se_og_image']['name'] : null;

$se_favicon_del = isset($_POST['se_favicon_del']) ? $_POST['se_favicon_del'] : null;
$se_og_image_del = isset($_POST['se_og_image_del']) ? $_POST['se_og_image_del'] : null;

if ($se_favicon_del) {
    @unlink(G5_DATA_PATH . "/seo/favicon");
}
if ($se_og_image_del) {
    @unlink(G5_DATA_PATH . "/seo/og_image");
}

// ico 파일인지 체크
if ($favimg || $favimg_name) {
    if (!preg_match('/\.(ico)$/i', $favimg_name)) {
        alert("ico 파일만 업로드 할수 있습니다.");
    }
}

// 파일이 이미지인지 체크
if ($ogimg || $ogimg_name) {
    if (!preg_match('/\.(gif|jpe?g|bmp|png)$/i', $ogimg_name)) {
        alert("이미지 파일만 업로드 할수 있습니다.");
    }

    $oimg = @getimagesize($ogimg);
    if ($oimg === false || $oimg[2] < 1 || $oimg[2] > 16) {
        alert("이미지 파일만 업로드 할수 있습니다.");
    }
}

// 컬럼이 있는지 검사한다.
$cnt = sql_fetch("SELECT COUNT(*) as cnt FROM rb_seo");

if ($cnt['cnt'] > 0) {
    $sql = "UPDATE rb_seo
            SET se_title = '{$_POST['se_title']}',
                se_description = '{$_POST['se_description']}',
                se_keywords = '{$_POST['se_keywords']}',
                se_google_meta = '{$_POST['se_google_meta']}',
                se_naver_meta = '{$_POST['se_naver_meta']}',
                se_robots = '{$_POST['se_robots']}',
                se_og_site_name = '{$_POST['se_og_site_name']}',
                se_og_title = '{$_POST['se_og_title']}',
                se_og_description = '{$_POST['se_og_description']}',
                se_datetime = '" . G5_TIME_YMDHIS . "'";
    sql_query($sql);
} else {
    $sql = "INSERT INTO rb_seo
            SET se_title = '{$_POST['se_title']}',
                se_description = '{$_POST['se_description']}',
                se_keywords = '{$_POST['se_keywords']}',
                se_google_meta = '{$_POST['se_google_meta']}',
                se_naver_meta = '{$_POST['se_naver_meta']}',
                se_robots = '{$_POST['se_robots']}',
                se_og_site_name = '{$_POST['se_og_site_name']}',
                se_og_title = '{$_POST['se_og_title']}',
                se_og_description = '{$_POST['se_og_description']}',
                se_datetime = '" . G5_TIME_YMDHIS . "'";
    sql_query($sql);
}

if ($favimg_name) {
    rb_upload_files($favimg, 'favicon', G5_DATA_PATH . "/seo");
}
if ($ogimg_name) {
    rb_upload_files($ogimg, 'og_image', G5_DATA_PATH . "/seo");
}

// 파일이 있는지 체크
$ogimg_in = G5_DATA_PATH . "/seo/og_image";
if (file_exists($ogimg_in)) {
    $sql = "UPDATE rb_seo SET se_og_image = 'og_image'";
    sql_query($sql);
}

$favimg_in = G5_DATA_PATH . "/seo/favicon";
if (file_exists($favimg_in)) {
    $sql = "UPDATE rb_seo SET se_favicon = 'favicon'";
    sql_query($sql);
}

// robots.txt 파일 생성
if (isset($_POST['se_robots'])) {
    // textarea에서 입력된 내용을 가져옴
    $robotsContent = $_POST['se_robots'];

    // robots.txt 파일의 경로를 정의함
    $filePath = G5_PATH . '/robots.txt';

    // 쓰기 모드로 파일을 오픈
    if ($fileHandle = fopen($filePath, 'w')) {
        // 파일에 내용을 저장함
        if (fwrite($fileHandle, $robotsContent) === false) {
            echo "robots.txt 파일 쓰기에 실패 했습니다.";
        }
        // 파일 핸들을 닫음
        fclose($fileHandle);
    } else {
        echo "robots.txt 파일을 쓰기 위해 여는 데 실패했습니다.";
    }
}

update_rewrite_rules();

goto_url('./seo_form.php', false);
?>