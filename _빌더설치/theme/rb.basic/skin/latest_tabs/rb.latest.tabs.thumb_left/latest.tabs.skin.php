<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$rb_skin = sql_fetch (" select * from {$rb_module_table} where md_id = '{$options}' "); //최신글 환경설정 테이블 조회 (삭제금지)
$thumb_width = 180;
$thumb_height = 150;

if(isset($rb_skin['md_title']) && $rb_skin['md_title']) {
    $bo_subjects = $rb_skin['md_title'];
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
$rb_skin['md_tab_skin'] 탭 스킨명
$rb_skin['md_tab_list'] 탭 설정
*/

?>

<link rel="stylesheet" href="<?php echo $latest_skin_url ?>/style.css?ver=<?php echo G5_SERVER_TIME ?>">



<div class="bbs_main rb_latest_tabs_left">
    <!-- 제목 영역 -->
    <ul class="bbs_main_wrap_tit" style="display:<?php echo (isset($rb_skin['md_title_hide']) && $rb_skin['md_title_hide'] == '1') ? 'none' : 'block'; ?>">
        <li class="bbs_main_wrap_tit_l">
            <a href="javascript:void(0);">
                <h2 class="<?php echo isset($rb_skin['md_title_font']) ? $rb_skin['md_title_font'] : 'font-B'; ?>" style="color:<?php echo isset($rb_skin['md_title_color']) ? $rb_skin['md_title_color'] : '#25282b'; ?>; font-size:<?php echo isset($rb_skin['md_title_size']) ? $rb_skin['md_title_size'] : '20'; ?>px; "><?php echo $bo_subjects ?></h2>
            </a>
        </li>
        <li class="cb"></li>
    </ul>

    <div class="latest-tabs-wrap">

        <!-- 탭 { -->
        <?php if (count($tabs) > 1): ?>
        <nav class="bo_tab swiper-container swiper-container-tab-<?php echo $rb_skin['md_id']; ?>">
            <ul class="bo_tab_ul swiper-wrapper swiper-wrapper-tab-<?php echo $rb_skin['md_id']; ?>">
                <?php foreach ($tabs as $i => $tab): ?>
                <li class="swiper-slide swiper-slide-tab-<?php echo $rb_skin['md_id']; ?>">
                    <a href="javascript:void(0);" data-tab="tab-<?php echo $rb_skin['md_id'].'-'.$i; ?>" class="<?php echo $i == 0 ? 'active' : ''; ?>">
                        <?php echo $tab['bo_subject']; ?><?php if ($tab['sca']) echo ' / ' . $tab['sca']; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </nav>

        <script>
            $(document).ready(function() {
                setTimeout(function() {

                    var swiper = new Swiper('.swiper-container-tab-<?php echo $rb_skin['md_id']; ?>', {
                        slidesPerView: 'auto',
                        spaceBetween: 0,
                        touchRatio: 1,
                        observer: true,
                        observeParents: true
                    });

                }, 50);
            });
        </script>
        <?php endif; ?>

        <!-- } -->

        <div class="latest-tab-wrap">

            <!-- 탭별 콘텐츠 -->
            <?php foreach ($tabs as $i => $tab): ?>
            <?php
        $list = $tab['list'];
        $list_count = count($list);
        $bo_table = $tab['bo_table'];
        $cate = $tab['sca'];
      ?>

            <div class="latest-tab-content<?php echo $i == 0 ? ' active' : ''; ?>" id="tab-<?php echo $rb_skin['md_id'].'-'.$i; ?>">

                <?php
                if(isset($cate) && $cate) {
                    $links_url = get_pretty_url($bo_table,'','sca='.urlencode($cate));
                } else {
                    $links_url = get_pretty_url($bo_table);
                }
                ?>
                <button type="button" class="more_btn" onclick="location.href='<?php echo $links_url ?>';" style="display:<?php echo (isset($rb_skin['md_title_hide']) && $rb_skin['md_title_hide'] == '1') ? 'none' : 'block'; ?>">더보기</button>

                <div class="rb_swiper" id="rb_swiper_<?php echo $rb_skin['md_id'].'_'.$i ?>" data-pc-w="<?php echo $rb_skin['md_col'] ?>" data-pc-h="<?php echo $rb_skin['md_row'] ?>" data-mo-w="<?php echo $rb_skin['md_col_mo'] ?>" data-mo-h="<?php echo $rb_skin['md_row_mo'] ?>" data-pc-gap="<?php echo $rb_skin['md_gap'] ?>" data-mo-gap="<?php echo $rb_skin['md_gap_mo'] ?>" data-autoplay="<?php echo $rb_skin['md_auto_is'] ?>" data-autoplay-time="<?php echo $rb_skin['md_auto_time'] ?>" data-pc-swap="<?php echo $rb_skin['md_swiper_is'] ?>" data-mo-swap="<?php echo $rb_skin['md_swiper_is'] ?>">

                    <div class="rb_swiper_inner">
                        <div class="rb-swiper-wrapper swiper-wrapper">
                            <?php foreach ($list as $row): ?>
                            <?php
                              $thumb = get_list_thumbnail($bo_table, $row['wr_id'], $thumb_width, $thumb_height, false, true);
                              $img = ($thumb['src'] && !strstr($row['wr_option'], 'secret')) ? $thumb['src'] : (strstr($row['wr_option'], 'secret') ? G5_THEME_URL.'/rb.img/sec_image.png' : G5_THEME_URL.'/rb.img/no_image.png');
                              $thumb_alt = $thumb['alt'] ?: '이미지';
                              $wr_href = get_pretty_url($bo_table, $row['wr_id']);
                              $wr_content = trim(strip_tags((string)($row['wr_content'] ?? '')));
                              $is_secret = strstr($row['wr_option'], 'secret');
                            ?>
                            <div class="rb_swiper_list">
                                <div>
                                    <?php if ($rb_skin['md_thumb_is']): ?>
                                    <ul class="bbs_main_wrap_con_ul1">
                                        <a href="<?php echo $wr_href ?>">
                                            <img src="<?php echo $img ?>" alt="<?php echo $thumb_alt ?>" class="skin_list_image">
                                        </a>
                                    </ul>
                                    <?php endif; ?>

                                    <ul class="bbs_main_wrap_con_ul2" style="<?php echo !$rb_skin['md_thumb_is'] ? 'padding-left:0px !important; min-height:36px;' : '' ?>">


                                        <?php if($rb_skin['md_subject_is'] == 1 || $rb_skin['md_icon_is'] == 1 || $rb_skin['md_comment_is'] == 1) { ?>
                                        <li class="bbs_main_wrap_con_subj">
                                            <?php if($rb_skin['md_subject_is'] == 1) { //모듈설정:제목 출력여부(1,0) ?>
                                            <a href="<?php echo $wr_href ?>" class="font-B cut_subj"><?php echo $row['subject'] ?></a>
                                            <?php } ?>

                                            <?php if($rb_skin['md_comment_is'] == 1) { //모듈설정:댓글 출력여부(1,0 || 댓글이 0개 이상인 경우)?>
                                                <?php if($row['comment_cnt']) { ?>
                                                <span class="comments_span font-B main_color">+<?php echo number_format($row['wr_comment']); ?></span>
                                                <?php } ?>
                                            <?php } ?>

                                            <?php if($rb_skin['md_icon_is'] == 1) { //모듈설정:아이콘 출력여부(1,0)?>

                                                <?php if ($row['icon_new']) echo "<span class=\"bbs_list_label bbs_list_label_inline label3\">N</span>"; ?>
                                                <?php if ($row['icon_hot']) echo "<span class=\"bbs_list_label bbs_list_label_inline label1\">H</span>"; ?>

                                            <?php } ?>

                                            <div class="cb"></div>

                                        </li>
                                        <?php } ?>


                                        <?php if($rb_skin['md_content_is'] == 1) { //모듈설정:본문 출력여부(1,0)?>
                                            <?php if ($is_secret) { ?>
                                                <li class="bbs_main_wrap_con_cont">
                                                    <a href="<?php echo $wr_href ?>" style="opacity:0.6" class="cut2">작성자 및 관리자 외 열람할 수 없습니다.<br>비밀글 기능으로 보호된 글입니다.</a>
                                                </li>
                                            <?php } else { ?>
                                                <li class="bbs_main_wrap_con_cont cut2">
                                                    <a href="<?php echo $wr_href ?>" class="cut2"><?php echo $wr_content ?></a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>


                                        <?php if($rb_skin['md_date_is'] == 1 || $rb_skin['md_ca_is'] == 1) { //모듈설정:작성일 출력여부(1,0) || 모듈설정:카테고리명 출력여부(1,0)?>
                                            <li class="bbs_main_wrap_con_info">

                                                <?php if($rb_skin['md_nick_is'] == 1) { //모듈설정:작성자 출력여부(1,0)?>
                                                <span class="prof_tiny_name font-B"><?php echo $row['wr_name'] ?></span>
                                                <?php } ?>

                                                <?php if($rb_skin['md_ca_is'] == 1 && $row['ca_name']) { //모듈설정:카테고리 출력여부(1,0) || 카테고리 있을때만?>
                                                <?php echo $row['ca_name'] ?>
                                                <?php } ?>

                                                <?php if($rb_skin['md_date_is'] == 1) { //모듈설정:작성일 출력여부(1,0)?>
                                                <?php echo passing_time($row['wr_datetime']) ?>
                                                조회 <?php echo number_format($row['wr_hit']); ?>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>



                                    </ul>
                                    <div class="cb"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <?php if ($list_count == 0): ?>
                            <div class="no_data" style="width:100% !important;">데이터가 없습니다.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($rb_skin['md_swiper_is']): ?>
                    <div class="rb_swiper_paging_btn" style="display:<?php echo (isset($rb_skin['md_title_hide']) && $rb_skin['md_title_hide'] == '1') ? 'none' : 'block'; ?>">
                        <button type="button" class="swiper-button-prev rb-swiper-prev">
                            <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_prev.svg">
                        </button>
                        <button type="button" class="swiper-button-next rb-swiper-next">
                            <img src="<?php echo G5_THEME_URL ?>/rb.img/icon/arr_next.svg">
                        </button>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.swiper-slide-tab-<?php echo $rb_skin['md_id']; ?> a', function(e) {
        e.preventDefault();

        const $this = $(this);
        const targetId = $this.data('tab');
        const $wrap = $this.closest('.latest-tabs-wrap');

        // 탭 버튼 상태 변경
        $wrap.find('.swiper-slide-tab-<?php echo $rb_skin['md_id']; ?> a')
            .removeClass('active');
        $this.addClass('active');

        // 탭 콘텐츠 전환
        $wrap.find('.latest-tab-content').removeClass('active');
        const $targetTab = $wrap.find('#' + targetId).addClass('active');

        // 탭 콘텐츠가 보이도록 된 후 슬라이더 초기화
        setTimeout(() => {
            // Swiper 초기화는 보이는 상태에서만 실행
            $targetTab.find('.rb_swiper').each(function() {
                if (!$(this).hasClass('swiper-initialized')) {
                    // 이미 초기화된 게 아니면 실행
                    setupResponsiveSlider($(this));
                }
            });
        }, 10);
    });
</script>
