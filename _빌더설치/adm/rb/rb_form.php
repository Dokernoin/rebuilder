<?php
$sub_menu = '000000';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");
add_stylesheet('<link rel="stylesheet" href="./css/style.css">', 0);


$g5['title'] = '빌더설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');

// 설치여부 (테이블조회)
$rbx = sql_fetch(" select COUNT(*) AS cnt FROM information_schema.TABLES WHERE `TABLE_NAME` = 'rb_builder' AND TABLE_SCHEMA = '".G5_MYSQL_DB."' ");
$is_rb = $rbx['cnt'];
?>

<?php if($rbx['cnt'] > 0) { ?>

<?php
$sql = " select * from rb_builder limit 1";
$bu = sql_fetch($sql);
                           
$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_rb0">빌더정보</a></li>
    <li><a href="#anc_rb1">로고설정</a></li>
    <li><a href="#anc_rb2">회사정보</a></li>
    <li><a href="#anc_rb3">로딩인디케이터</a></li>
    <li><a href="#anc_rb6">시스템메세지</a></li>
    <li><a href="#anc_rb5">모바일설정</a></li>
    <li><a href="#anc_rb4">운영채널</a></li>
</ul>';            
?>


<section id="anc_rb0">
        <h2 class="h2_frm">빌더정보</h2>
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
                        <th scope="row">빌더버전</th>
                        <td colspan="3">
                            <?php echo RB_VER ?>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">라이선스키</th>
                        <td colspan="3">
                            <?php echo help('최초설치 > DB 업데이트시에 자동 생성 됩니다.<br>라이선스키를 공식홈페이지 > 마이페이지 에서 등록해주세요.<br>키 등록이 되지않았거나, 키를 임의로 변경하시는 경우 빌더 업데이트가 불가능 합니다.') ?>
                            <?php
                            $key_info = sql_fetch (" select key_no from rb_key limit 1 ");
                            ?>
                            <?php echo !empty($key_info['key_no']) ? $key_info['key_no'] : '라이선스키가 없습니다. DB업데이트를 진행해주세요.'; ?>
                            <?php if(!empty($key_info['key_no'])) { ?>
                            　<a href="javascript:void(0);" class="btn_frmline" style="height:25px; line-height:25px;" id="data-copy">복사하기</a>
                             <a href="https://rebuilder.co.kr" target="_blank" class="btn_frmline" style="height:25px; line-height:25px;">라이선스키 등록</a>
                             
                            <input type="hidden" id="data-area" class="data-area" value="<?php echo !empty($key_info['key_no']) ? $key_info['key_no'] : ''; ?>">
                            <script>
                                $(document).ready(function() {

                                    $('#data-copy').click(function() {
                                        $('#data-area').attr('type', 'text'); // 화면에서 hidden 처리한 input box type을 text로 일시 변환
                                        $('#data-area').select(); // input에 담긴 데이터를 선택
                                        var copy = document.execCommand('copy'); // clipboard에 데이터 복사
                                        $('#data-area').attr('type', 'hidden'); // input box를 다시 hidden 처리
                                        if (copy) {
                                            alert("라이선스키가 클립보드에 복사 되었습니다."); // 사용자 알림
                                        }
                                    });

                                });
                            </script>
                            <?php } ?>
                        </td>

                    </tr>
                    <tr>
                        <th scope="row">DB업데이트</th>
                        <td colspan="3">
                            <?php echo help('업데이트된 DB가 있는지 확인합니다.') ?>
                            <a href="./rb_db_update.php" class="btn_frmline">DB 업데이트 실행</a>
                        </td>

                    </tr>
                    
                </tbody>
            </table>
    </div>
</section>

<form name="bu_form" id="bu_form" action="./rb_form_update.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="token" value="" id="token">
    <input type="hidden" name="install" value="1" id="install">
    
    <section id="anc_rb1">
        <h2 class="h2_frm">로고설정</h2>
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
                        <th scope="row">로고 PC</th>
                        <td>
                            <?php echo help('PC 버전 로고이미지를 등록하세요.') ?>
                            <input type="file" name="bu_logo_pc">
                            <?php
                            $lp_str = "";
                            $lpimg = G5_DATA_PATH."/logos/pc";
                            if (file_exists($lpimg)) {
                                $size = @getimagesize($lpimg);
                                if($size[0] && $size[0] > 400)
                                    $width = 400;
                                else
                                    $width = $size[0];

                                echo '<input type="checkbox" name="bu_logo_pc_del" value="1" id="bu_logo_pc_del"> <label for="bu_logo_pc_del">삭제</label>';
                                $lpimg_str = '<img src="'.G5_DATA_URL.'/logos/pc?ver='.G5_SERVER_TIME.'" width="'.$width.'">';
                            }
                            if (isset($lpimg_str) && $lpimg_str) {
                                echo '<br><span style="margin-top:20px; background-color:#f1f1f1; padding:10px 20px 10px 20px; display:inline-block; box-sizing:border-box;">';
                                echo $lpimg_str;
                                echo '</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">로고 PC (화이트)</th>
                        <td>
                            <?php echo help('PC 버전 로고이미지(화이트)를 등록하세요.<br>어두운 백그라운드가 사용될 때 변경 됩니다.') ?>
                            <input type="file" name="bu_logo_pc_w">
                            <?php
                            $lpw_str = "";
                            $lpwimg = G5_DATA_PATH."/logos/pc_w";
                            if (file_exists($lpwimg)) {
                                $size = @getimagesize($lpwimg);
                                if($size[0] && $size[0] > 400)
                                    $width = 400;
                                else
                                    $width = $size[0];

                                echo '<input type="checkbox" name="bu_logo_pc_w_del" value="1" id="bu_logo_pc_w_del"> <label for="bu_logo_pc_w_del">삭제</label>';
                                $lpwimg_str = '<img src="'.G5_DATA_URL.'/logos/pc_w?ver='.G5_SERVER_TIME.'" width="'.$width.'">';
                            }
                            if (isset($lpwimg_str) && $lpwimg_str) {
                                echo '<br><span style="margin-top:20px; background-color:#f1f1f1; padding:10px 20px 10px 20px; display:inline-block; box-sizing:border-box;">';
                                echo $lpwimg_str;
                                echo '</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">로고 Mobile</th>
                        <td>
                            <?php echo help('Mobile 버전 로고이미지를 등록하세요.') ?>
                            <input type="file" name="bu_logo_mo">
                            <?php
                            $lm_str = "";
                            $lmimg = G5_DATA_PATH."/logos/mo";
                            if (file_exists($lmimg)) {
                                $size = @getimagesize($lmimg);
                                if($size[0] && $size[0] > 400)
                                    $width = 400;
                                else
                                    $width = $size[0];

                                echo '<input type="checkbox" name="bu_logo_mo_del" value="1" id="bu_logo_mo_del"> <label for="bu_logo_mo_del">삭제</label>';
                                $lmimg_str = '<img src="'.G5_DATA_URL.'/logos/mo?ver='.G5_SERVER_TIME.'" width="'.$width.'">';
                            }
                            if (isset($lmimg_str) && $lmimg_str) {
                                echo '<br><span style="margin-top:20px; background-color:#f1f1f1; padding:10px 20px 10px 20px; display:inline-block; box-sizing:border-box;">';
                                echo $lmimg_str;
                                echo '</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <th scope="row">로고 Mobile (화이트)</th>
                        <td>
                            <?php echo help('Mobile 버전 로고이미지(화이트)를 등록하세요.<br>어두운 백그라운드가 사용될 때 변경 됩니다.') ?>
                            <input type="file" name="bu_logo_mo_w">
                            <?php
                            $lmw_str = "";
                            $lmwimg = G5_DATA_PATH."/logos/mo_w";
                            if (file_exists($lmwimg)) {
                                $size = @getimagesize($lmwimg);
                                if($size[0] && $size[0] > 400)
                                    $width = 400;
                                else
                                    $width = $size[0];

                                echo '<input type="checkbox" name="bu_logo_mo_w_del" value="1" id="bu_logo_mo_w_del"> <label for="bu_logo_mo_w_del">삭제</label>';
                                $lmwimg_str = '<img src="'.G5_DATA_URL.'/logos/mo_w?ver='.G5_SERVER_TIME.'" width="'.$width.'">';
                            }
                            if (isset($lmwimg_str) && $lmwimg_str) {
                                echo '<br><span style="margin-top:20px; background-color:#f1f1f1; padding:10px 20px 10px 20px; display:inline-block; box-sizing:border-box;">';
                                echo $lmwimg_str;
                                echo '</span>';
                            }
                            ?>
                        </td>
                    </tr>
                    
                    
                </tbody>
            </table>
        </div>
    </section>
    
    
    
    <section id="anc_rb2">
        <h2 class="h2_frm">하단 회사정보</h2>
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
                        <th scope="row">회사명(사이트명)</th>
                        <td>
                            <input type="text" name="bu_1" value="<?php echo isset($bu['bu_1']) ? get_sanitize_input($bu['bu_1']) : ''; ?>" id="bu_1" class="frm_input" size="40"> 
                        </td>
                        <th scope="row">대표자명</th>
                        <td>
                            <input type="text" name="bu_2" value="<?php echo isset($bu['bu_2']) ? get_sanitize_input($bu['bu_2']) : ''; ?>" id="bu_2" class="frm_input" size="40"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">전화번호</th>
                        <td>
                            <input type="text" name="bu_3" value="<?php echo isset($bu['bu_3']) ? get_sanitize_input($bu['bu_3']) : ''; ?>" id="bu_3" class="frm_input" size="40"> 
                        </td>
                        <th scope="row">팩스번호</th>
                        <td>
                            <input type="text" name="bu_4" value="<?php echo isset($bu['bu_4']) ? get_sanitize_input($bu['bu_4']) : ''; ?>" id="bu_4" class="frm_input" size="40"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">사업자등록번호</th>
                        <td>
                            <input type="text" name="bu_5" value="<?php echo isset($bu['bu_5']) ? get_sanitize_input($bu['bu_5']) : ''; ?>" id="bu_5" class="frm_input" size="40"> 
                        </td>
                        <th scope="row">통신판매업신고번호</th>
                        <td>
                            <input type="text" name="bu_6" value="<?php echo isset($bu['bu_6']) ? get_sanitize_input($bu['bu_6']) : ''; ?>" id="bu_6" class="frm_input" size="40"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">부가통신사업자번호</th>
                        <td>
                            <input type="text" name="bu_7" value="<?php echo isset($bu['bu_7']) ? get_sanitize_input($bu['bu_7']) : ''; ?>" id="bu_7" class="frm_input" size="40"> 
                        </td>
                        <th scope="row">기타등록번호</th>
                        <td>
                            <input type="text" name="bu_8" value="<?php echo isset($bu['bu_8']) ? get_sanitize_input($bu['bu_8']) : ''; ?>" id="bu_8" class="frm_input" size="40"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">우편번호</th>
                        <td>
                            <input type="text" name="bu_9" value="<?php echo isset($bu['bu_9']) ? get_sanitize_input($bu['bu_9']) : ''; ?>" id="bu_9" class="frm_input" size="40"> 
                        </td>
                        <th scope="row">사업장주소</th>
                        <td>
                            <input type="text" name="bu_10" value="<?php echo isset($bu['bu_10']) ? get_sanitize_input($bu['bu_10']) : ''; ?>" id="bu_10" class="frm_input" size="40"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">개인정보책임자(이메일)</th>
                        <td>
                            <input type="text" name="bu_11" value="<?php echo isset($bu['bu_11']) ? get_sanitize_input($bu['bu_11']) : ''; ?>" id="bu_11" class="frm_input" size="40"> 
                        </td>
                        <th scope="row">카피라이트</th>
                        <td>
                            <input type="text" name="bu_12" value="<?php echo isset($bu['bu_12']) ? get_sanitize_input($bu['bu_12']) : ''; ?>" id="bu_12" class="frm_input" size="40"> 
                        </td>
                    </tr>

                    

                </tbody>
            </table>
        </div>
    </section>
    
    
    <section id="anc_rb3">
        <h2 class="h2_frm">로딩인디케이터</h2>
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
                        <th scope="row">사용여부</th>
                        <td colspan="3">
                        <?php echo help('사용시 로딩 스피너를 표기하며<br>DOM을 포함한 모든 페이지가 준비 되면 사라집니다.') ?>
                        <input type="checkbox" name="bu_load" value="1" id="bu_load" <?php echo isset($bu['bu_load']) && $bu['bu_load'] ? 'checked' : ''; ?>> <label for="bu_load">사용</label>
                        </td>
                    </tr>
                    

                </tbody>
            </table>
        </div>
    </section>
    
    
    <section id="anc_rb6">
        <h2 class="h2_frm">시스템메세지</h2>
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
                        <th scope="row">수신여부</th>
                        <td colspan="3">
                        <?php echo help('시스템메세지 관리자 수신 여부를 설정할 수 있습니다.<br>신규 게시물등록, 주문접수, 회원가입 등 웹사이트에서 일어나는 주요 활동에 대한 알림 입니다.') ?>
                        <input type="checkbox" name="bu_systemmsg_use" value="1" id="bu_systemmsg_use" <?php echo isset($bu['bu_systemmsg_use']) && $bu['bu_systemmsg_use'] ? 'checked' : ''; ?>> <label for="bu_systemmsg_use">수신함</label>
                        </td>
                    </tr>
                    

                </tbody>
            </table>
        </div>
    </section>
    
    
    <section id="anc_rb5">
        <h2 class="h2_frm">모바일설정</h2>
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
                        <th scope="row">Viewport</th>
                        <td colspan="3">
                        <?php echo help('빌더의 기본 뷰포트 값은 0.9 입니다. 값이 없으면 0.9 로 적용되며,<br>/theme/테마폴더/head.sub.php 파일의 meta name="viewport" 값이 변경 됩니다.<br>숫자가 작을수록 오브젝트의 크기가 축소되며, 1이 정비율 입니다.<br>커스텀 테마를 사용하시는 경우 적용이 되지않을 수 있습니다.') ?>
                        <input type="text" name="bu_viewport" value="<?php echo isset($bu['bu_viewport']) ? get_sanitize_input($bu['bu_viewport']) : ''; ?>" id="bu_viewport" class="frm_input" size="10">
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </section>
    
    
    
    <section id="anc_rb4">
        <h2 class="h2_frm">운영채널</h2>
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
                        <th scope="row">카카오채널 URL</th>
                        <td>
                            <input type="text" name="bu_sns1" value="<?php echo isset($bu['bu_sns1']) ? get_sanitize_input($bu['bu_sns1']) : ''; ?>" id="bu_sns1" class="frm_input" size="70"> 
                        </td>
                        <th scope="row">카카오채널 상담 URL</th>
                        <td>
                            <input type="text" name="bu_sns2" value="<?php echo isset($bu['bu_sns2']) ? get_sanitize_input($bu['bu_sns2']) : ''; ?>" id="bu_sns2" class="frm_input" size="70"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">유튜브 URL</th>
                        <td>
                            <input type="text" name="bu_sns3" value="<?php echo isset($bu['bu_sns3']) ? get_sanitize_input($bu['bu_sns3']) : ''; ?>" id="bu_sns3" class="frm_input" size="70"> 
                        </td>
                        <th scope="row">인스타그램 URL</th>
                        <td>
                            <input type="text" name="bu_sns4" value="<?php echo isset($bu['bu_sns4']) ? get_sanitize_input($bu['bu_sns4']) : ''; ?>" id="bu_sns4" class="frm_input" size="70"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">페이스북 URL</th>
                        <td>
                            <input type="text" name="bu_sns5" value="<?php echo isset($bu['bu_sns5']) ? get_sanitize_input($bu['bu_sns5']) : ''; ?>" id="bu_sns5" class="frm_input" size="70"> 
                        </td>
                        <th scope="row">트위터 URL</th>
                        <td>
                            <input type="text" name="bu_sns6" value="<?php echo isset($bu['bu_sns6']) ? get_sanitize_input($bu['bu_sns6']) : ''; ?>" id="bu_sns6" class="frm_input" size="70"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">네이버블로그 URL</th>
                        <td>
                            <input type="text" name="bu_sns7" value="<?php echo isset($bu['bu_sns7']) ? get_sanitize_input($bu['bu_sns7']) : ''; ?>" id="bu_sns7" class="frm_input" size="70"> 
                        </td>
                        <th scope="row">텔레그램 URL</th>
                        <td>
                            <input type="text" name="bu_sns8" value="<?php echo isset($bu['bu_sns8']) ? get_sanitize_input($bu['bu_sns8']) : ''; ?>" id="bu_sns8" class="frm_input" size="70"> 
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">SIR URL</th>
                        <td>
                            <input type="text" name="bu_sns9" value="<?php echo isset($bu['bu_sns9']) ? get_sanitize_input($bu['bu_sns9']) : ''; ?>" id="bu_sns9" class="frm_input" size="70"> 
                        </td>
                        <th scope="row">기타 URL</th>
                        <td>
                            <input type="text" name="bu_sns10" value="<?php echo isset($bu['bu_sns10']) ? get_sanitize_input($bu['bu_sns10']) : ''; ?>" id="bu_sns10" class="frm_input" size="70"> 
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

<?php } else { ?>
<section>
    <h2 class="h2_frm">그누보드 리빌더</h2>
    <div class="local_desc01 local_desc">
      
        그누보드 리빌더를 사용해주셔서 고맙습니다.<br><br>
        리빌더는 그누보드의 기능을 모두 그대로 사용하면서 폴더의 추가만으로<br>
        손쉽게 웹사이트를 완성하고 다양한 편의기능을 사용할 수 있습니다.<br><br>

        <b>본 페이지는 테이블이 설치되면 더이상 볼 수 없습니다.</b>
    </div>
</section>

<section>
    
    <h2 class="h2_frm">빌더 설치안내 및 주의사항</h2>

    <div class="local_desc01 local_desc">
       
        빌더 구동에 필요한 테이블이 설치 됩니다.<br><br>
        rb_ 로 시작하는 동일한 테이블명 있는경우 테이블 생성이 되지 않을 수 있으며<br>
        성능 보장을 위해 가급적 PHP7.X ~ PHP8.X 버전을 사용해주세요.<br>
        <strong>DB 테이블 설치 후 빌더설정 > [DB 업데이트 실행] 를 반드시 클릭해주세요.</strong><br><br>
        
        테이블 설치 후 <b>환경설정 > 테마설정</b> 메뉴에서<br>
        <b>Rebuilder Basic 테마를 적용</b> 해주시고<br>
        테마적용 직후 뜨는 팝업창에서 <b>[확인]</b> 을 클릭합니다.<br><br>
        
        [확인] 을 클릭하지 못하였다면 <b>환경설정 > 기본환경설정</b> 메뉴에서<br>
        <b>[테마 스킨설정 가져오기], [테마 회원스킨설정 가져오기]</b> 를 클릭하신 후<br>
        반드시 <b>[확인]</b> 을 클릭 해주세요.<br><br>
        
        설치가 완료 되었다면, <b>관리자모드 > 게시판관리</b> 에서<br>
        게시판의 스킨을 <b>rb.XXX 로 변경</b> 합니다.<br><br>
        
        메인페이지로 이동 후 <b>[모듈추가]</b> 버튼을 통해 메인페이지에 출력될 모듈을 구성 합니다.



    </div>

</section>

<section>
    <form name="rb_form" id="rb_form" action="./rb_form_update.php" method="post">
        <h2 class="h2_frm">라이선스 정책</h2>

        <div class="local_desc01 local_desc">
            본 빌더는 납품물 제작의 용도나 자사운영 목적의 용도로 사용할 수 있습니다.<br>
            빌더 및 빌더를 구성하는 디자인, 스킨, 프로그램 등을 웹사이트에 게재(전시) 하여 판매 하는 행위 또는<br>
            배포 (타인이 다운로드 할 수 있도록 게재하는 행위) 는 불가능 합니다.<br><br>

            기타 문의사항 및 기술지원은<br>
            공식홈페이지 <a href="https://rebuilder.co.kr" target="_blank"><strong>https://rebuilder.co.kr</strong></a> 를 이용해주세요.<br><br>

            <input type="checkbox" value="1" id="agrees">
            <label for="agrees">상기 내용을 모두 확인하였으며, 라이선스 정책에 동의 합니다.</label>
        </div>

        <div class="btn_confirm01 btn_confirm">
            <input type="submit" value="DB 테이블 설치하기" class="btn_submit btn">
        </div>
    </form>
</section>

<script>
        $(document).ready(function() {
            $("#rb_form").on("submit", function(event) {
                if (confirm("상기 주의사항 및 라이선스 정책을 확인해주세요.\nDB 테이블을 설치 하시겠습니까?")) {
                    if (!$("#agrees").is(":checked")) {
                        alert("라이선스 정책에 동의 하셔야 빌더를 사용할 수 있습니다.");
                        event.preventDefault();
                    }
                } else {
                    event.preventDefault();
                }
            });
        });
</script>
<?php } ?>


<?php
include_once (G5_ADMIN_PATH.'/admin.tail.php');
