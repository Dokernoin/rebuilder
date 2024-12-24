<?php
$sub_menu = '000000';
include_once('./_common.php');

check_demo();
auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

if (isset($_POST['install']) && $_POST['install'] == 1) {

    @mkdir(G5_DATA_PATH."/logos", G5_DIR_PERMISSION);
    @chmod(G5_DATA_PATH."/logos", G5_DIR_PERMISSION);
    
    $lpimg = isset($_FILES['bu_logo_pc']['tmp_name']) ? $_FILES['bu_logo_pc']['tmp_name'] : null;
    $lpimg_name = isset($_FILES['bu_logo_pc']['name']) ? $_FILES['bu_logo_pc']['name'] : null;

    $lpwimg = isset($_FILES['bu_logo_pc_w']['tmp_name']) ? $_FILES['bu_logo_pc_w']['tmp_name'] : null;
    $lpwimg_name = isset($_FILES['bu_logo_pc_w']['name']) ? $_FILES['bu_logo_pc_w']['name'] : null;

    $lmimg = isset($_FILES['bu_logo_mo']['tmp_name']) ? $_FILES['bu_logo_mo']['tmp_name'] : null;
    $lmimg_name = isset($_FILES['bu_logo_mo']['name']) ? $_FILES['bu_logo_mo']['name'] : null;

    $lmwimg = isset($_FILES['bu_logo_mo_w']['tmp_name']) ? $_FILES['bu_logo_mo_w']['tmp_name'] : null;
    $lmwimg_name = isset($_FILES['bu_logo_mo_w']['name']) ? $_FILES['bu_logo_mo_w']['name'] : null;
    
    if (isset($bu_logo_pc_del) && $bu_logo_pc_del) @unlink(G5_DATA_PATH."/logos/pc");
    if (isset($bu_logo_pc_w_del) && $bu_logo_pc_w_del) @unlink(G5_DATA_PATH."/logos/pc_w");
    if (isset($bu_logo_mo_del) && $bu_logo_mo_del) @unlink(G5_DATA_PATH."/logos/mo");
    if (isset($bu_logo_mo_w_del) && $bu_logo_mo_w_del) @unlink(G5_DATA_PATH."/logos/mo_w");

    //이미지인지 체크
    if( $lpimg || $lpimg_name){
        if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $lpimg_name) ){
            alert("이미지 파일만 업로드 할수 있습니다.");
        }
    }
    
    //이미지인지 체크
    if( $lpwimg || $lpwimg_name ){
        if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $lpwimg_name) ){
            alert("이미지 파일만 업로드 할수 있습니다.");
        }
    }
    
    //이미지인지 체크
    if( $lmimg || $lmimg_name ){
        if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $lmimg_name) ){
            alert("이미지 파일만 업로드 할수 있습니다.");
        }
    }
    
    //이미지인지 체크
    if( $lmwimg || $lmwimg_name ){
        if( !preg_match('/\.(gif|jpe?g|bmp|png)$/i', $lmwimg_name) ){
            alert("이미지 파일만 업로드 할수 있습니다.");
        }
    }
    
    //컬럼이 있는지 검사한다.
    $cnt = sql_fetch (" select COUNT(*) as cnt from rb_builder ");

    if($cnt['cnt'] > 0) {
            $sql = " update rb_builder
                set bu_load = '{$_POST['bu_load']}',
                    bu_1 = '{$_POST['bu_1']}',
                    bu_2 = '{$_POST['bu_2']}',
                    bu_3 = '{$_POST['bu_3']}',
                    bu_4 = '{$_POST['bu_4']}',
                    bu_5 = '{$_POST['bu_5']}',
                    bu_6 = '{$_POST['bu_6']}',
                    bu_7 = '{$_POST['bu_7']}',
                    bu_8 = '{$_POST['bu_8']}',
                    bu_9 = '{$_POST['bu_9']}',
                    bu_10 = '{$_POST['bu_10']}',
                    bu_11 = '{$_POST['bu_11']}',
                    bu_12 = '{$_POST['bu_12']}',
                    bu_13 = '{$_POST['bu_13']}',
                    bu_14 = '{$_POST['bu_14']}',
                    bu_15 = '{$_POST['bu_15']}',
                    bu_16 = '{$_POST['bu_16']}',
                    bu_17 = '{$_POST['bu_17']}',
                    bu_18 = '{$_POST['bu_18']}',
                    bu_19 = '{$_POST['bu_19']}',
                    bu_20 = '{$_POST['bu_20']}',
                    bu_sns1 = '{$_POST['bu_sns1']}',
                    bu_sns2 = '{$_POST['bu_sns2']}',
                    bu_sns3 = '{$_POST['bu_sns3']}',
                    bu_sns4 = '{$_POST['bu_sns4']}',
                    bu_sns5 = '{$_POST['bu_sns5']}',
                    bu_sns6 = '{$_POST['bu_sns6']}',
                    bu_sns7 = '{$_POST['bu_sns7']}',
                    bu_sns8 = '{$_POST['bu_sns8']}',
                    bu_sns9 = '{$_POST['bu_sns9']}',
                    bu_sns10 = '{$_POST['bu_sns10']}',
                    bu_viewport = '{$_POST['bu_viewport']}',
                    bu_systemmsg_use = '{$_POST['bu_systemmsg_use']}', 
                    bu_datetime = '".G5_TIME_YMDHIS."' ";
            sql_query($sql);
    } else { 

            $sql = " insert rb_builder
                set bu_load = '{$_POST['bu_load']}',
                    bu_1 = '{$_POST['bu_1']}',
                    bu_2 = '{$_POST['bu_2']}',
                    bu_3 = '{$_POST['bu_3']}',
                    bu_4 = '{$_POST['bu_4']}',
                    bu_5 = '{$_POST['bu_5']}',
                    bu_6 = '{$_POST['bu_6']}',
                    bu_7 = '{$_POST['bu_7']}',
                    bu_8 = '{$_POST['bu_8']}',
                    bu_9 = '{$_POST['bu_9']}',
                    bu_10 = '{$_POST['bu_10']}',
                    bu_11 = '{$_POST['bu_11']}',
                    bu_12 = '{$_POST['bu_12']}',
                    bu_13 = '{$_POST['bu_13']}',
                    bu_14 = '{$_POST['bu_14']}',
                    bu_15 = '{$_POST['bu_15']}',
                    bu_16 = '{$_POST['bu_16']}',
                    bu_17 = '{$_POST['bu_17']}',
                    bu_18 = '{$_POST['bu_18']}',
                    bu_19 = '{$_POST['bu_19']}',
                    bu_20 = '{$_POST['bu_20']}',
                    bu_sns1 = '{$_POST['bu_sns1']}',
                    bu_sns2 = '{$_POST['bu_sns2']}',
                    bu_sns3 = '{$_POST['bu_sns3']}',
                    bu_sns4 = '{$_POST['bu_sns4']}',
                    bu_sns5 = '{$_POST['bu_sns5']}',
                    bu_sns6 = '{$_POST['bu_sns6']}',
                    bu_sns7 = '{$_POST['bu_sns7']}',
                    bu_sns8 = '{$_POST['bu_sns8']}',
                    bu_sns9 = '{$_POST['bu_sns9']}',
                    bu_sns10 = '{$_POST['bu_sns10']}',
                    bu_viewport = '{$_POST['bu_viewport']}',
                    bu_systemmsg_use = '{$_POST['bu_systemmsg_use']}', 
                    bu_datetime = '".G5_TIME_YMDHIS."' ";
            sql_query($sql);
    }
    
    if ($lpimg_name) rb_upload_files($lpimg, 'pc', G5_DATA_PATH."/logos");
    if ($lpwimg_name) rb_upload_files($lpwimg, 'pc_w', G5_DATA_PATH."/logos");
    if ($lmimg_name) rb_upload_files($lmimg, 'mo', G5_DATA_PATH."/logos");
    if ($lmwimg_name) rb_upload_files($lmwimg, 'mo_w', G5_DATA_PATH."/logos");
    
    $lpimg_in = G5_DATA_PATH."/logos/pc";
    if (file_exists($lpimg_in)) {
        $sql = " update rb_builder set bu_logo_pc = 'pc' ";
        sql_query($sql);
    }
    
    $lpwimg_in = G5_DATA_PATH."/logos/pc_w";
    if (file_exists($lpwimg_in)) {
        $sql = " update rb_builder set bu_logo_pc_w = 'pc_w' ";
        sql_query($sql);
    }
    
    $lmimg_in = G5_DATA_PATH."/logos/mo";
    if (file_exists($lmimg_in)) {
        $sql = " update rb_builder set bu_logo_mo = 'mo' ";
        sql_query($sql);
    }
    
    $lmwimg_in = G5_DATA_PATH."/logos/mo_w";
    if (file_exists($lmwimg_in)) {
        $sql = " update rb_builder set bu_logo_mo_w = 'mo_w' ";
        sql_query($sql);
    }
    
} else {

    //폴더생성
    @mkdir(G5_DATA_PATH."/seo", G5_DIR_PERMISSION);
    @chmod(G5_DATA_PATH."/seo", G5_DIR_PERMISSION);

    //폴더생성
    @mkdir(G5_DATA_PATH."/banners", G5_DIR_PERMISSION);
    @chmod(G5_DATA_PATH."/banners", G5_DIR_PERMISSION);

    //폴더생성
    @mkdir(G5_DATA_PATH."/logos", G5_DIR_PERMISSION);
    @chmod(G5_DATA_PATH."/logos", G5_DIR_PERMISSION);
    

    //빌더설정 테이블
    if(!sql_query(" DESCRIBE rb_builder ", false)) {
           $query_cp = sql_query(" CREATE TABLE IF NOT EXISTS `rb_builder` (
            `bu_logo_pc` varchar(255) NOT NULL DEFAULT '' COMMENT '로고 PC',
            `bu_logo_pc_w` varchar(255) NOT NULL DEFAULT '' COMMENT '로고 PC W',
            `bu_logo_mo` varchar(255) NOT NULL DEFAULT '' COMMENT '로고 MO',
            `bu_logo_mo_w` varchar(255) NOT NULL DEFAULT '' COMMENT '로고 MO W',
            `bu_load` int(4) NOT NULL DEFAULT 1 COMMENT '로딩인디케이터',
            `bu_systemmsg_use` int(4) NOT NULL DEFAULT 1 COMMENT '시스템메세지 관리자수신여부',
            `bu_1` varchar(255) NOT NULL DEFAULT '' COMMENT '회사명',
            `bu_2` varchar(255) NOT NULL DEFAULT '' COMMENT '대표자명',
            `bu_3` varchar(255) NOT NULL DEFAULT '' COMMENT '전화번호',
            `bu_4` varchar(255) NOT NULL DEFAULT '' COMMENT '팩스번호',
            `bu_5` varchar(255) NOT NULL DEFAULT '' COMMENT '사업자등록번호',
            `bu_6` varchar(255) NOT NULL DEFAULT '' COMMENT '통신판매업신고번호',
            `bu_7` varchar(255) NOT NULL DEFAULT '' COMMENT '부가통신사업자번호',
            `bu_8` varchar(255) NOT NULL DEFAULT '' COMMENT '기타등록번호1',
            `bu_9` varchar(255) NOT NULL DEFAULT '' COMMENT '우편번호',
            `bu_10` varchar(255) NOT NULL DEFAULT '' COMMENT '사업장주소',
            `bu_11` varchar(255) NOT NULL DEFAULT '' COMMENT '개인정보책임자',
            `bu_12` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_13` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_14` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_15` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_16` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_17` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_18` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_19` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_20` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns1` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns2` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns3` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns4` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns5` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns6` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns7` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns8` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns9` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_sns10` varchar(255) NOT NULL DEFAULT '' COMMENT '',
            `bu_viewport` varchar(10) NOT NULL,
            `bu_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시(변경일시)' 
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    }

    //환경설정 테이블
    if(!sql_query(" DESCRIBE rb_config ", false)) {
           $query_cp = sql_query(" CREATE TABLE IF NOT EXISTS `rb_config` (
            `co_id` int(11) NOT NULL AUTO_INCREMENT,
            `co_color` varchar(20) NOT NULL DEFAULT '#aa20ff' COMMENT '강조 컬러',
            `co_dark` varchar(20) NOT NULL DEFAULT '' COMMENT '다크모드',
            `co_layout` varchar(20) NOT NULL DEFAULT '' COMMENT '레이아웃',
            `co_layout_hd` varchar(20) NOT NULL DEFAULT '' COMMENT '레이아웃(헤더)',
            `co_layout_ft` varchar(20) NOT NULL DEFAULT '' COMMENT '레이아웃(푸더)',
            `co_sub_width` varchar(20) NOT NULL COMMENT '서브가로폭',
            `co_main_width` varchar(20) NOT NULL COMMENT '메인가로폭',
            `co_tb_width` varchar(20) NOT NULL COMMENT '상/하단가로폭',
            `co_header` varchar(20) NOT NULL DEFAULT '#ffffff' COMMENT '헤더',
            `co_footer` varchar(20) NOT NULL COMMENT '풋터',
            `co_font` varchar(20) NOT NULL DEFAULT '' COMMENT '폰트',
            `co_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시(변경일시)',
            `co_ip` varchar(100) NOT NULL DEFAULT '' COMMENT '등록자IP',
            PRIMARY KEY (`co_id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    }

    $sql = " insert rb_config
                set co_color = '#aa20ff',
                    co_dark = '',
                    co_layout = 'basic',
                    co_layout_hd = 'basic',
                    co_layout_ft = 'basic',
                    co_sub_width = '960',
                    co_main_width = '1400',
                    co_tb_width = '1400',
                    co_header = '#ffffff',
                    co_footer = '0',
                    co_font = 'Pretendard',
                    co_datetime = '".G5_TIME_YMDHIS."',
                    co_ip = '' ";
    sql_query($sql);


    //모듈설정 테이블
    if(!sql_query(" DESCRIBE rb_module ", false)) {
           $query_cp = sql_query(" CREATE TABLE IF NOT EXISTS `rb_module` (
            `md_id` int(11) NOT NULL AUTO_INCREMENT,
            `md_layout` varchar(20) NOT NULL DEFAULT '' COMMENT '레이아웃 아이디',
            `md_layout_name` varchar(255) NOT NULL DEFAULT '' COMMENT '레이아웃이름',
            `md_theme` varchar(255) NOT NULL DEFAULT '' COMMENT '테마명',
            `md_title` varchar(255) NOT NULL DEFAULT '' COMMENT '모듈타이틀',
            `md_type` varchar(255) NOT NULL DEFAULT '' COMMENT '모듈타입',
            `md_bo_table` varchar(255) NOT NULL DEFAULT '' COMMENT '연결 게시판',
            `md_sca` varchar(255) NOT NULL DEFAULT '' COMMENT '연결 카테고리',
            `md_widget` varchar(255) NOT NULL DEFAULT '' COMMENT '프로그램',
            `md_poll` varchar(255) NOT NULL DEFAULT '' COMMENT '투표',
            `md_poll_id` varchar(20) NOT NULL DEFAULT '' COMMENT '투표ID',
            `md_banner` varchar(255) NOT NULL DEFAULT '' COMMENT '배너',
            `md_banner_id` varchar(20) NOT NULL DEFAULT '' COMMENT '배너ID',
            `md_banner_skin` varchar(255) NOT NULL DEFAULT '' COMMENT '배너스킨',
            `md_module` varchar(255) NOT NULL DEFAULT '' COMMENT '출력모듈',
            `md_skin` varchar(255) NOT NULL DEFAULT '' COMMENT '출력스킨',
            `md_cnt` int(10) NOT NULL DEFAULT 1 COMMENT '출력갯수',
            `md_auto_time` int(10) NOT NULL DEFAULT 3000 COMMENT '오토플레이타임',
            `md_gap` int(10) NOT NULL DEFAULT 40 COMMENT '여백(간격)',
            `md_gap_mo` int(10) NOT NULL DEFAULT 20 COMMENT '모바일 여백(간격)',
            `md_col` int(10) NOT NULL DEFAULT 1 COMMENT '출력갯수(열/가로)',
            `md_row` int(10) NOT NULL DEFAULT 1 COMMENT '출력갯수(행/세로)',
            `md_col_mo` int(10) NOT NULL DEFAULT 1 COMMENT '모바일 출력갯수(열/가로)',
            `md_row_mo` int(10) NOT NULL DEFAULT 1 COMMENT '모바일 출력갯수(행/세로)',
            `md_width` varchar(20) NOT NULL DEFAULT '100%' COMMENT '가로사이즈',
            `md_height` varchar(20) NOT NULL DEFAULT 'auto' COMMENT '세로사이즈',
            `md_subject_is` int(4) NOT NULL COMMENT '출력항목(제목)',
            `md_thumb_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(썸네일)',
            `md_nick_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(닉네임)',
            `md_date_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(작성일시)',
            `md_content_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(본문)',
            `md_icon_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(아이콘)',
            `md_comment_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(코멘트)',
            `md_ca_is` int(4) NOT NULL DEFAULT 1 COMMENT '출력항목(카테고리)',
            `md_swiper_is` int(4) NOT NULL DEFAULT 0 COMMENT '스와이프여부',
            `md_auto_is` int(4) NOT NULL DEFAULT 0 COMMENT '오토플레이 여부',
            `md_order` varchar(255) NOT NULL DEFAULT 'wr_num' COMMENT '출력순서',
            `md_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시(변경일시)',
            `md_ip` varchar(100) NOT NULL DEFAULT '' COMMENT '등록자IP',
            `md_order_id` int(4) NOT NULL DEFAULT 0 COMMENT '모듈순서',
            PRIMARY KEY (`md_id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);

    }


    //배너관리 테이블
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


    //SEO설정 테이블
    if(!sql_query(" DESCRIBE rb_seo ", false)) {
           $query_cp = sql_query(" CREATE TABLE IF NOT EXISTS `rb_seo` (
            `se_title` varchar(255) NOT NULL COMMENT '사이트명',
            `se_description` mediumtext NOT NULL COMMENT '사이트설명',
            `se_keywords` mediumtext NOT NULL COMMENT '키워드',
            `se_favicon` varchar(255) NOT NULL COMMENT '파비콘',
            `se_google_meta` varchar(255) NOT NULL COMMENT '구글 소유권 메타',
            `se_naver_meta` varchar(255) NOT NULL COMMENT '네이버 소유권 메타',
            `se_robots` mediumtext NOT NULL COMMENT '로봇접근제어',
            `se_og_image` varchar(255) NOT NULL COMMENT '오픈그래프 이미지',
            `se_og_site_name` varchar(255) NOT NULL COMMENT '오픈그래프 사이트명',
            `se_og_title` varchar(255) NOT NULL COMMENT '오픈그래프 사이트명',
            `se_og_description` varchar(255) NOT NULL COMMENT '오픈그래프 사이트 설명',
            `se_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '등록일시(변경일시)'
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    }


    // 빌더설정 테이블 설치여부
    $chk0 = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'rb_builder' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
    $chk0_is = $chk0['cnt'];

    // 환경설정 테이블 설치여부
    $chk1 = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'rb_config' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
    $chk1_is = $chk1['cnt'];

    // 모듈설정 테이블 설치여부
    $chk2 = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'rb_module' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
    $chk2_is = $chk2['cnt'];

    // 배너관리 테이블 설치여부
    $chk3 = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'rb_banner' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
    $chk3_is = $chk3['cnt'];

    // SEO설정 테이블 설치여부
    $chk4 = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'rb_seo' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
    $chk4_is = $chk4['cnt'];

    if($chk0_is > 0 && $chk1_is > 0 && $chk2_is > 0 && $chk3_is > 0 && $chk4_is > 0) {
        alert('DB 테이블 설치가 완료 되었습니다.\n[DB 업데이트] 를 반드시 실행해주세요.\n테이블 설치 후 환경설정 > 테마설정 메뉴에서\nRebuilder Basic 테마를 적용해주세요.');
    } else { 
        alert('설치가 누락된 테이블이 있습니다.\nDB 테이블을 확인해주세요.');
    }
    
}

update_rewrite_rules();
goto_url('./rb_form.php', false);

?>
