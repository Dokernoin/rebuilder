<!--
경로 : /rb/rb.widget/rb.new/
사용자코드를 입력하세요.
-->

<?php
//모듈정보 불러오기
$md_id = $row_mod['md_id']; //현재 모듈 ID
$rb_skin = sql_fetch (" select * from {$rb_module_table} where md_id = '{$md_id}' "); //환경설정 테이블 조회
$md_subject = $rb_skin['md_title']; //모듈 타이틀

$sql_commons = " from {$g5['board_new_table']} a, {$g5['board_table']} b where a.bo_table = b.bo_table and a.wr_id = a.wr_parent order by a.bn_id desc ";

$sqls = " select a.*, b.bo_subject, b.bo_mobile_subject {$sql_commons} limit 5 ";
$results = sql_query($sqls);

?>
<div class="bbs_main">
   
    <ul class="bbs_main_wrap_tit">
        <li class="bbs_main_wrap_tit_l"><a href="javascript:void(0);">
                <h2 class="font-B"><?php echo $md_subject ?></h2>
            </a></li>
        <li class="bbs_main_wrap_tit_r">
            <button type="button" class="arr_plus_btn" id="ovlay_tog">
                <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_plus.svg" id="ovlay_tog_img">
            </button>
            <script>
                $(document).ready(function() {
                    // 버튼 클릭 시 이벤트 핸들러 등록
                    $('#ovlay_tog').click(function() {
                        // ovlay_con의 클래스를 토글(active)합니다.
                        $('#ovlay_con').toggleClass('active');

                        var buttonImage = $('#ovlay_tog_img');

                        if (buttonImage.attr('src') === '<?php echo G5_THEME_URL ?>/rb.img/icon/arr_plus.svg') {
                            buttonImage.attr('src', '<?php echo G5_THEME_URL ?>/rb.img/icon/arr_minus.svg');
                        } else {
                            buttonImage.attr('src', '<?php echo G5_THEME_URL ?>/rb.img/icon/arr_plus.svg');
                        }
                    });
                });
            </script>
        </li>
        <div class="cb"></div>
    </ul>
    
    <ul class="bbs_main_wrap_con ovlay_wrap" style="height:114px;">
        <div class="ovlay" id="ovlay_con">
            <?php 
            for ($i=0; $rows=sql_fetch_array($results); $i++) { 
                $tmp_write_table = $g5['write_prefix'].$rows['bo_table'];
                $row2 = sql_fetch(" select * from {$tmp_write_table} where wr_id = '{$rows['wr_id']}' ");
                $hrefs = get_pretty_url($rows['bo_table'], $row2['wr_id']);
            ?>
            <dd>
                <div>
                    <ul class="bbs_main_wrap_con_ul1">
                        <span class="prof_image"><?php echo get_member_profile_img($row2['mb_id']); ?></span>
                    </ul>
                    <ul class="bbs_main_wrap_con_ul2">
                        <li class="bbs_main_wrap_con_info"><?php echo passing_time($row2['wr_datetime']); ?>　<span class="font-B"><?php echo $row2['wr_name'] ?></span></li>
                        <li class="bbs_main_wrap_con_info"><?php echo $rows['bo_subject'] ?></li>
                        <li class="bbs_main_wrap_con_cont cut">
                            <a href="<?php echo $hrefs ?>"><?php echo $row2['wr_subject'] ?></a>
                        </li>
                    </ul>
                    <div class="cb"></div>
                </div>
            </dd>
            <?php } ?>
        </div>
    </ul>     
         
                
</div>         
                