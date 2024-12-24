<?php
$sub_menu = '000500';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");
add_stylesheet('<link rel="stylesheet" href="./css/style.css">', 0);

//테이블이 있는지 검사한다.
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

$sql = " select * from rb_seo limit 1";
$seo = sql_fetch($sql);

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_seo1">기본설정</a></li>
    <li><a href="#anc_seo2">검색엔진</a></li>
    <li><a href="#anc_seo3">오픈그래프</a></li>
    <li><a href="#anc_seo4">기타설정</a></li>
</ul>';

$g5['title'] = 'SEO 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>


<form name="seo_form" id="seo_form" action="./seo_form_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="" id="token">
    
    <section id="anc_seo1">
        <h2 class="h2_frm">기본설정</h2>
        <?php echo $pg_anchor ?>

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col class="grid_4">
                    <col>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">웹사이트 제목<strong class="sound_only">필수</strong></th>
                        <td colspan="3">
                            <?php echo help('검색결과와 브라우저 제목에 반영되는 대표 정보로,<br>웹사이트 이름과 함께 고유한 브랜드메시지를 짧게 입력하는 것도 좋습니다.') ?>
                            <input type="text" name="se_title" value="<?php echo isset($seo['se_title']) ? get_sanitize_input($seo['se_title']) : ''; ?>" id="se_title" required class="required frm_input" size="40">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">웹사이트 설명</th>
                        <td colspan="3">
                            <?php echo help('웹사이트 유형, 판매 상품 정보, 사용자의 클릭을 유도하는 설명 등을 요약하여 입력하세요.') ?>
                            <input type="text" name="se_description" value="<?php echo isset($seo['se_description']) ? get_sanitize_input($seo['se_description']) : ''; ?>" id="se_description" class="frm_input" size="100">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">키워드</th>
                        <td colspan="3">
                            <?php echo help('검색형 키워드를 콤마로 구분하여 입력하세요.') ?>
                            <input type="text" name="se_keywords" value="<?php echo isset($seo['se_keywords']) ? get_sanitize_input($seo['se_keywords']) : ''; ?>" id="se_keywords" class="frm_input" size="100">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">파비콘</th>
                        <td>
                            <div class="border_box_adm">
                                <img src="./img/bg_favicon_example.png"><br><br>
                                <?php echo help('파비콘은 주소창에 표시되는 웹사이트를 대표하는 아이콘입니다.<br>브라우저의 상단 탭과 북마크 영역에서 나타납니다.') ?>
                            </div>
                            <?php echo help('ico 파일만 업로드 가능합니다.') ?>
                            <input type="file" name="se_favicon">

                            <?php
                            $favimg = G5_DATA_PATH . "/seo/favicon";
                            if (file_exists($favimg)) {
                                echo '<input type="checkbox" name="se_favicon_del" value="1" id="se_favicon_del"> <label for="se_favicon_del">삭제</label>';

                                if (isset($seo['se_favicon'])) {
                                    echo '<div>' . G5_URL . '/data/seo/' . $seo['se_favicon'] . '</div>';
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </section>
    
    
    <section id="anc_seo2">
        <h2 class="h2_frm">검색엔진</h2>
        <?php echo $pg_anchor ?>

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col class="grid_4">
                    <col>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row">구글 서치 콘솔</th>
                        <td colspan="3">
                            <?php echo help('구글에 웹사이트를 등록하고 발급받은 HTML 태그를 입력하여 사이트 소유권을 확인합니다.') ?>
                            <input type="text" name="se_google_meta" value="<?php echo isset($seo['se_google_meta']) ? get_text($seo['se_google_meta']) : ''; ?>" id="se_google_meta" class="frm_input" size="50" placeholder="<meta name=...."> 
                            <a href="https://search.google.com/search-console/about" target="_blank" class="btn_frmline">바로가기</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">네이버 서치 어드바이저</th>
                        <td colspan="3">
                            <?php echo help('네이버에 웹사이트를 등록하고 발급받은 HTML 태그를 입력하여 사이트 소유권을 확인합니다.') ?>
                            <input type="text" name="se_naver_meta" value="<?php echo isset($seo['se_naver_meta']) ? get_text($seo['se_naver_meta']) : ''; ?>" id="se_naver_meta" class="frm_input" size="50" placeholder="<meta name=...."> 
                            <a href="https://searchadvisor.naver.com/" target="_blank" class="btn_frmline">바로가기</a>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </section>
    
    
    <section id="anc_seo3">
        <h2 class="h2_frm">오픈그래프</h2>
        <?php echo $pg_anchor ?>

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col class="grid_4">
                    <col>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>
                   
                    <tr>
                        <th scope="row">og:image</th>
                        <td>
                            <?php echo help('SNS에서 공유할 때 노출되는 이미지를 설정합니다.<br>게시판, 상품 등의 페이지는 자동적용 됩니다.') ?>
                            <input type="file" name="se_og_image">
                            <?php
                            $ogimg_str = "";
                            $ogimg = G5_DATA_PATH . "/seo/og_image";
                            if (file_exists($ogimg)) {
                                $size = @getimagesize($ogimg);
                                if ($size !== false) {
                                    if ($size[0] && $size[0] > 400) {
                                        $width = 400;
                                    } else {
                                        $width = $size[0];
                                    }

                                    echo '<input type="checkbox" name="se_og_image_del" value="1" id="se_og_image_del"> <label for="se_og_image_del">삭제</label>';
                                    $ogimg_str = '<img src="' . G5_DATA_URL . '/seo/og_image?ver=' . G5_SERVER_TIME . '" width="' . $width . '">';
                                }
                            }
        
                            if (isset($seo['se_og_image'])) {
                                echo '<div>' . G5_URL . '/data/seo/' . $seo['se_og_image'] . '</div>';
                            }

                            if (!empty($ogimg_str)) {
                                echo '<div style="margin-top:20px;">';
                                echo $ogimg_str;
                                echo '</div>';
                            }
        
                            
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">og:site_name</th>
                        <td colspan="3">
                            <?php echo help('SNS에서 공유할 때 노출되는 사이트이름을 설정합니다.<br>게시판, 상품 등의 페이지는 자동적용 됩니다.') ?>
                            <input type="text" name="se_og_site_name" value="<?php echo isset($seo['se_og_site_name']) ? get_sanitize_input($seo['se_og_site_name']) : ''; ?>" id="se_og_site_name" class="frm_input" size="30"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">og:title</th>
                        <td colspan="3">
                            <?php echo help('SNS에서 공유할 때 노출되는 페이지제목(사이트이름)을 설정합니다.<br>게시판, 상품 등의 페이지는 자동적용 됩니다.') ?>
                            <input type="text" name="se_og_title" value="<?php echo isset($seo['se_og_title']) ? get_sanitize_input($seo['se_og_title']) : ''; ?>" id="se_og_title" class="frm_input" size="50"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">og:description</th>
                        <td colspan="3">
                            <?php echo help('SNS에서 공유할 때 노출되는 페이지설명(사이트설명)을 설정합니다.<br>게시판, 상품 등의 페이지는 자동적용 됩니다.') ?>
                            <input type="text" name="se_og_description" value="<?php echo isset($seo['se_og_description']) ? get_sanitize_input($seo['se_og_description']) : ''; ?>" id="se_og_description" class="frm_input" size="100"> 
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </section>
    
    
    
    <section id="anc_seo4">
        <h2 class="h2_frm">기타설정</h2>
        <?php echo $pg_anchor ?>

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <colgroup>
                    <col class="grid_4">
                    <col>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>
                   
                    <tr>
                        <th scope="row">robots.txt</th>
                        <td>
                            <?php echo help('robots.txt 파일은 검색로봇에게 페이지를 수집할 수 있도록 허용하거나 제한하는 표준 규약입니다.') ?>
                            <textarea name="se_robots" id="se_robots"><?php echo isset($seo['se_robots']) ? get_text($seo['se_robots']) : ''; ?></textarea>
                            <?php
                            $r_files = G5_PATH."/robots.txt";
                            if (file_exists($r_files)) {
                                echo '<div>'.G5_URL.'/robots.txt</div>';
                            }
                            ?>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </section>
    
    <div class="btn_fixed_top">
        <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
    </div>
    
</form>

<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');