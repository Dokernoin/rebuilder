<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$rb_skin = sql_fetch (" select * from {$rb_module_table} where md_id = '{$options}' "); //최신글 환경설정 테이블 조회 (삭제금지)

$thumb_width = 400;
$thumb_height = 333;
$list_count = (is_array($list) && $list) ? count($list) : 0;

//모듈 타이틀이 설정되지 않은 경우 게시판 제목을 보여줍니다.
if($rb_skin['md_title']) {
    $bo_subject = $rb_skin['md_title'];
} else { 
    $bo_subject = $rb_skin['md_title'];
}

//카테고리 출력옵션을 사용한 경우 카테고리 링크로 이동합니다.
if($rb_skin['md_sca']) { 
    $links_url = get_pretty_url($bo_table,'','sca='.urlencode($rb_skin['md_sca']));
} else {
    $links_url = get_pretty_url($bo_table);
}

/*
모듈설정 연동 변수
$rb_skin['md_id'] 설정ID
$rb_skin['md_layout'] 레이아웃 섹션ID
$rb_skin['md_layout_name'] 레이아웃 스킨명
$rb_skin['md_theme'] 테마명
$rb_skin['md_title'] 타이틀(제목)
$rb_skin['md_bo_table'] 게시판ID
$rb_skin['md_skin'] 스킨명
$rb_skin['md_cnt'] 출력갯수
$rb_skin['md_col'] 행갯수
$rb_skin['md_row'] 열갯수
$rb_skin['md_col_mo'] 행갯수(모바일)
$rb_skin['md_row_mo'] 열갯수(모바일)
$rb_skin['md_gap'] 게시물 간격(여백)
$rb_skin['md_gap_mo'] 모바일 게시물 간격(여백)
$rb_skin['md_width'] 가로사이즈
$rb_skin['md_height'] 세로사이즈
$rb_skin['md_auto_time'] 자동롤링 시간
$rb_skin['md_thumb_is'] 썸네일 출력여부(1,0)
$rb_skin['md_nick_is'] 닉네임 출력여부(1,0)
$rb_skin['md_date_is'] 작성일 출력여부(1,0)
$rb_skin['md_content_is'] 본문내용 출력여부(1,0)
$rb_skin['md_icon_is'] 아이콘 출력여부(1,0)
$rb_skin['md_comment_is'] 댓글수 출력여부(1,0)
$rb_skin['md_swiper_is'] 스와이프 여부(1,0)
$rb_skin['md_auto_is'] 자동롤링 여부(1,0)
*/

?>

<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css?ver=<?php echo G5_TIME_YMDHIS ?>">



            <div class="bbs_main">
               
                <!-- { -->
                <ul class="bbs_main_wrap_tit">

                    <li class="bbs_main_wrap_tit_l">
                        <!-- 타이틀 { -->
                        <a href="<?php echo $links_url; ?>"><h2 class="font-B"><?php echo $bo_subject ?></h2></a>
                        <!-- } -->
                    </li>
                    
                    
                    <li class="bbs_main_wrap_tit_r">
                        <button type="button" class="more_btn" onclick="location.href='<?php echo $links_url; ?>';">더보기</button>
                    </li>
                    
                    <div class="cb"></div>
                </ul>
                <!-- } -->
                
                <!-- { -->
                <ul class="bbs_main_wrap_thumb_top_con">
                  
                    <div class="rb_swiper" 
                       id="rb_swiper_<?php echo $rb_skin['md_id'] ?>" 
                       data-pc-w="<?php echo $rb_skin['md_col'] ?>" 
                       data-pc-h="<?php echo $rb_skin['md_row'] ?>" 
                       data-mo-w="<?php echo $rb_skin['md_col_mo'] ?>" 
                       data-mo-h="<?php echo $rb_skin['md_row_mo'] ?>" 
                       data-pc-gap="<?php echo $rb_skin['md_gap'] ?>" 
                       data-mo-gap="<?php echo $rb_skin['md_gap_mo'] ?>" 
                       data-autoplay="<?php echo $rb_skin['md_auto_is'] ?>" 
                       data-autoplay-time="<?php echo $rb_skin['md_auto_time'] ?>" 
                       data-pc-swap="<?php echo $rb_skin['md_swiper_is'] ?>" 
                       data-mo-swap="<?php echo $rb_skin['md_swiper_is'] ?>"
                    >
                    
                    <div class="rb_swiper_inner">
                        <div class="rb-swiper-wrapper swiper-wrapper">
                            
                            <?php
                                for ($i=0; $i<$list_count; $i++) {
                                    
                                //썸네일
                                $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

                                //썸네일여부 확인
                                if($thumb['src']) {
                                    if (strstr($list[$i]['wr_option'], 'secret')) {
                                        $img = G5_THEME_URL.'/rb.img/sec_image.png';
                                    } else { 
                                        $img = $thumb['src'];
                                    }
                                } else {
                                    $img = G5_THEME_URL.'/rb.img/no_image.png';
                                    $thumb['alt'] = '이미지가 없습니다.';
                                }
                                    
                                //썸네일 출력 class="skin_list_image" 필수 (높이값 설정용)
                                $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" class="skin_list_image">';
                                    
                                //게시물 링크
                                $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
                                    
                                $sec_txt = '<span style="opacity:0.6">작성자 및 관리자 외 열람할 수 없습니다.<br>비밀글 기능으로 보호된 글입니다.</span>';
                                
                                //본문출력 (class="cut" : 한줄자르기 / class="cut2" : 두줄자르기)
                                //$wr_content = preg_replace("/<(.*?)\>/","",$list[$i]['wr_content']);
                                //$wr_content = preg_replace("/&nbsp;/","",$wr_content);
                                //$wr_content = preg_replace("/&gt;/","",$wr_content);
                                $wr_content = strip_tags($list[$i]['wr_content']);
                            ?>
                            
                            <div class="rb_swiper_list">
                            
                            <!-- for { -->
                                
                                <div>
                                    
                                    <?php if($rb_skin['md_thumb_is'] == 1) { //모듈설정:썸네일 출력여부(1,0)?>
                                    <ul class="bbs_main_wrap_con_ul1">
                                        <a href="<?php echo $wr_href ?>"><?php echo run_replace('thumb_image_tag', $img_content, $thumb); ?></a>
                                        
                                        <?php if($rb_skin['md_icon_is'] == 1) { //모듈설정:아이콘 출력여부(1,0)?>
                                            <div class="icon_abs">
                                            <?php if ($list[$i]['icon_new']) echo "<span class=\"bbs_list_label label3\">새글</span>"; ?>
                                            <?php if ($list[$i]['icon_hot']) echo "<span class=\"bbs_list_label label1\">인기</span>"; ?>
                                            </div>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                    
                                    <ul class="bbs_main_wrap_con_ul2" <?php if($rb_skin['md_thumb_is'] != 1) { //모듈설정:썸네일 출력하지 않는경우 ?>style="width:100%"<?php } ?>>
                                        
                                        <?php if($rb_skin['md_subject_is'] == 1) { //모듈설정:제목 출력여부(1,0) ?>
                                        <li class="bbs_main_wrap_con_subj cut"><a href="<?php echo $wr_href ?>" class="font-B"><?php echo $list[$i]['subject'] ?></a></li>
                                        <?php } ?>
                                        
                                        <?php if($rb_skin['md_content_is'] == 1) { //모듈설정:본문 출력여부(1,0)?>
                                        
                                           <?php if (strstr($list[$i]['wr_option'], 'secret')) { ?>
                                                <li class="bbs_main_wrap_con_cont">
                                                    <?php echo $sec_txt; ?>
                                                </li>
                                            <?php } else { ?>
                                                <li class="bbs_main_wrap_con_cont cut2">
                                                    <a href="<?php echo $wr_href ?>"><?php echo $wr_content; ?></a>
                                                </li>
                                            <?php } ?>
                                           
                                        <?php } ?>
                                        
                                        <?php if($rb_skin['md_nick_is'] == 1 || $rb_skin['md_date_is'] == 1 || $rb_skin['md_ca_is'] == 1 || $rb_skin['md_comment_is'] == 1) {?>
                                            <li class="bbs_main_wrap_con_info">
                                               
                                                <?php if($rb_skin['md_nick_is'] == 1) { //모듈설정:작성자 출력여부(1,0)?>
                                                <span class="font-B"><?php echo $list[$i]['wr_name'] ?></span>　
                                                <?php } ?>
                                               
                                                <?php if($rb_skin['md_date_is'] == 1) { //모듈설정:작성일 출력여부(1,0)?>
                                                <?php echo passing_time($list[$i]['wr_datetime']) ?>　
                                                <?php } ?>

                                                <?php if($rb_skin['md_ca_is'] == 1 && $list[$i]['ca_name']) { //모듈설정:카테고리 출력여부(1,0) || 카테고리 있을때만?>
                                                <?php echo $list[$i]['ca_name'] ?>　
                                                <?php } ?>
                                                
                                                <?php if($rb_skin['md_comment_is'] == 1) { //모듈설정:댓글 출력여부(1,0 || 댓글이 0개 이상인 경우)?>
                                                    <?php if($list[$i]['comment_cnt']) { ?>
                                                        댓글 <?php echo number_format($list[$i]['wr_comment']); ?>　
                                                    <?php } ?>
                                                    조회 <?php echo number_format($list[$i]['wr_hit']); ?>　
                                                <?php } ?>

                                            </li>
                                        <?php } ?>
                                        

                                    </ul>
                                    <div class="cb"></div>
                                </div>
                            </div>
                            <!-- } -->
                            
                            <?php }  ?>
                            <?php if ($list_count == 0) { //게시물이 없을 때  ?>
                            <div class="no_data" style="width:100% !important;">데이터가 없습니다.</div>
                            <?php }  ?>
                            
                            </div>
                        </div>
                           
                        <?php if($rb_skin['md_swiper_is'] == 1) { //모듈설정:스와이프 사용여부(1,0)?>
                        <div class="rb_swiper_paging_btn">
                            <!-- 좌우 페이징 { -->
                            <button type="button" class="swiper-button-prev rb-swiper-prev">
                                <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_prev.svg">
                            </button>
                            <button type="button" class="swiper-button-next rb-swiper-next">
                                <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_next.svg">
                            </button>
                            <!-- } -->
                        </div>
                        <?php } ?> 
                        
                    </div>
                </ul>
                
            </div>
        