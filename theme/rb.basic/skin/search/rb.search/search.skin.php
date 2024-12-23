<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);
?>


<div class="rb_serch_skin">

    <form name="fsearch" onsubmit="return fsearch_submit(this);" method="get">
    <input type="hidden" name="srows" value="<?php echo $srows ?>">
    <ul>
        <div class="faq_ser_wrap">
            <input type="text" name="stx" value="<?php echo $text_stx;?>" required id="stx" class="ser_inps font-B">
            <button type="submit" value="검색" class="ser_btns">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B" />
                </svg>
            </button>
        </div>
    </ul>

    <ul class="rb_faq_sub_tit">
        <select name="sfl" id="sfl" class="select">
            <option value="wr_subject||wr_content"<?php echo get_selected($sfl, "wr_subject||wr_content") ?>>제목+내용</option>
            <option value="wr_subject"<?php echo get_selected($sfl, "wr_subject") ?>>제목</option>
            <option value="wr_content"<?php echo get_selected($sfl, "wr_content") ?>>내용</option>
            <option value="mb_id"<?php echo get_selected($sfl, "mb_id") ?>>회원아이디</option>
            <option value="wr_name"<?php echo get_selected($sfl, "wr_name") ?>>이름</option>
        </select>

        <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and_inner" name="sop">
        <label for="sop_and_inner">and</label>
        <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or_inner" name="sop">
        <label for="sop_or_inner">or</label>
    </ul>
    </form>

    <script>
    function fsearch_submit(f)
    {
        var stx = f.stx.value.trim();
        if (stx.length < 2) {
            alert("검색어는 두글자 이상 입력하십시오.");
            f.stx.select();
            f.stx.focus();
            return false;
        }

        // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
        var cnt = 0;
        for (var i = 0; i < stx.length; i++) {
            if (stx.charAt(i) == ' ')
                cnt++;
        }

        if (cnt > 1) {
            alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
            f.stx.select();
            f.stx.focus();
            return false;
        }
        f.stx.value = stx;

        f.action = "";
        return true;
    }
    </script>





    <?php
    if ($stx) {
        if ($board_count) {
    ?>

    <nav id="bo_cate" class="swiper-container swiper-container-category">
        <ul id="sch_res_board" class="swiper-wrapper swiper-wrapper-category">
            <li><a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" <?php echo $sch_all ?>>전체</a></li>
            <?php echo $str_board_list; ?>
        </ul>
    </nav>

    <script>
        $(document).ready(function(){
            $("#sch_res_board li").addClass("swiper-slide swiper-slide-category");
        });

        var swiper = new Swiper('.swiper-container-category', {
            slidesPerView: 'auto', //가로갯수
            spaceBetween: 0, // 간격
            //slidesOffsetBefore: 40, //좌측여백
            //slidesOffsetAfter: 40, // 우측여백
            observer: true, //리셋
            observeParents: true, //리셋
            touchRatio: 1, // 드래그 가능여부

        });

    </script>






    <?php
        } else {
     ?>
    <div class="no_data mt-50">검색결과가 없어요.<br>검색조건을 다르게 설정 해보세요.</div>
    <?php } }  ?>

    <?php if(!$stx) { ?>
    <div class="no_data mt-50">검색 키워드를 입력해주세요.</div>
    <?php } ?>









    <div id="sch_result">
        <?php
        if ($stx) {
            if ($board_count) {
        ?>
        <section id="sch_res_ov">
            <h2><strong><?php echo $stx ?></strong> 전체검색 결과</h2>
            <ul>
                <li>게시판 <?php echo $board_count ?>개</li>
                <li>게시물 <?php echo number_format($total_count) ?>개</li>
            </ul>
        </section>
        <?php
            }
        }
        ?>




        <?php if ($stx && $board_count) { ?><section class="sch_res_list"><?php }  ?>
        <?php
        $k=0;
        for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
         ?>
            <div class="search_board_result">
            <h2><a href="<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>" class="font-B"><?php echo $bo_subject[$idx] ?></a></h2>
            <button type="button" class="more_btn" onclick="location.href='<?php echo get_pretty_url($search_table[$idx], '', $search_query); ?>';">전체보기</button>
            <ul>
            <?php
            for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
                if ($list[$idx][$i]['wr_is_comment'])
                {
                    $comment_def = '<span class="cmt_def">댓글</span> ';
                    $comment_href = '#c_'.$list[$idx][$i]['wr_id'];
                }
                else
                {
                    $comment_def = '';
                    $comment_href = '';
                }
             ?>

                <li>
                    <div class="sch_tit">
                        <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="sch_res_title font-B"><?php echo $comment_def ?><?php echo $list[$idx][$i]['subject'] ?></a>
                        <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="pop_a_blank">　[새창]</a>
                    </div>
                    <p><?php echo $list[$idx][$i]['content'] ?></p>
                    <div class="sch_info">
                        <?php echo $list[$idx][$i]['name'] ?>
                        <span class="sch_datetime"><?php echo $list[$idx][$i]['wr_datetime'] ?></span>
                    </div>
                </li>
            <?php }  ?>
            </ul>
            </div>
        <?php }		//end for?>
        <?php if ($stx && $board_count) {  ?></section><?php }  ?>

        <?php echo $write_pages ?>

    </div>

</div>
