<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<link rel="stylesheet" href="<?php echo G5_THEME_SHOP_URL ?>/rangeSlider/ion.rangeSlider.min.css"/>
<script type="text/javascript" src="<?php echo G5_THEME_SHOP_URL ?>/rangeSlider/ion.rangeSlider.min.js"></script>


<!-- 검색 시작 { -->
<div id="ssch">
	<h2><span class="ssch_result_total">총 <?php echo $total_count; ?>건</span></h2>
    <!-- 상세검색 항목 시작 { -->
    
    
    
		
	        <form name="frmdetailsearch">
	        <input type="hidden" name="qsort" id="qsort" value="<?php echo $qsort ?>">
	        <input type="hidden" name="qorder" id="qorder" value="<?php echo $qorder ?>">
	        <input type="hidden" name="qcaid" id="qcaid" value="<?php echo $qcaid ?>">
	        
	        
	        <div id="ssch_frm">
	        
	        <div class="ssch_frm_inner">
	        
	        <div class="ssch_option">
            
                <div class="mb-15">
                    <input type="checkbox" name="qname" id="ssch_qname" value="1" <?php echo $qname_check?'checked="checked"':'';?>> <label for="ssch_qname"><span></span>상품명</label>　
                    <input type="checkbox" name="qexplan" id="ssch_qexplan" value="1" <?php echo $qexplan_check?'checked="checked"':'';?>> <label for="ssch_qexplan"><span></span>상품설명</label>　
                    <!--
                    <input type="checkbox" name="qbasic" id="ssch_qbasic" value="1" <?php echo $qbasic_check?'checked="checked"':'';?>> <label for="ssch_qbasic"><span></span>기본설명</label>　
                    -->
                    <input type="checkbox" name="qid" id="ssch_qid" value="1" <?php echo $qid_check?'checked="checked"':'';?>> <label for="ssch_qid"><span></span>상품코드</label>
                </div>
	            
	            <div class="ul_pri_div">
                    <ul class="ul_left_chk">
                        <input type="text" name="qfrom" value="<?php echo $qfrom; ?>" id="ssch_qfrom" class="select_inp" size="10" placeholder="최소금액" autocomplete="off"> 원 ~ 
                        <input type="text" name="qto" value="<?php echo $qto; ?>" id="ssch_qto" class="select_inp" size="10" placeholder="최대금액" autocomplete="off"> 원
                    </ul>
                    <ul class="ul_left_slider">
                        <div class="range-slider" id="fill_bar1">
                            <input type="text" class="js-range-slider" value="" />
                        </div>
                        <script>
                        var $d1 = $("#fill_bar1"); //input 을 감싸고 있는 부모 ID가 있어야 실행 됩니다.

                        $d1.ionRangeSlider({
                            skin: "flat",
                            type: "double",
                            postfix: "", // 단위표기
                            prettify_enabled: true, //숫자포맷 true/false
                            prettify_separator: ",", //숫자포맷의 구분 표기
                            step: 1000, //드래그시 증가값
                            min: 1000, //최저제한
                            max: 1000000, //최대제한
                            <?php if(isset($_GET['qfrom']) && $_GET['qfrom']) { ?>
                            from: <?php echo $_GET['qfrom'] ?>, //선택된값 불러오기
                            to: <?php echo $_GET['qto'] ?> //선택된값 불러오기
                            <?php } else { ?>
                            from: 20000, 
                            to: 100000 
                            <?php } ?>
                        });

                        $d1.on("change", function() {
                            var $inp = $(this);
                            var from = $inp.data("from");
                            var to = $inp.data("to");

                            // 드래그된 값이 들어갈 input의 ID
                            document.getElementById('ssch_qfrom').value = from;
                            document.getElementById('ssch_qto').value = to;
                        });
                    </script>
                    </ul>
                    <div class="cb"></div>
                </div>
                
                
	        </div>
	        </div>
	        
	        
	        <div class="rb_search_wraps">
                <div class="rb_search_wraps_inner">
	            <input type="text" name="q" value="<?php echo $q; ?>" id="ssch_q" class="ssch_input ser_inps font-B" size="40" maxlength="30" placeholder="검색어를 입력하세요.">
	            <button type="submit"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B"></path>
                    </svg>
                </button>
	            </div>
	        </div>
	        
	        </div>
	        
        	</form>
        	
        	
        <div class="ss_list_wraps">
        	
        <?php if($total_count > 0) { ?>
		<!-- 검색된 분류 시작 { -->
	    <div id="ssch_cate">

            <div class="swiper-container swiper-container-ss">
                <ul class="swiper-wrapper swiper-wrapper-ss">
                    <?php
                    //echo '<li class="swiper-slide swiper-slide-ss"><a href="#" onclick="set_ca_id(\'\'); return false;" class="font-naver-EB">전체보기</a></li>'.PHP_EOL;
                    $total_cnt = 0;
                    foreach((array) $categorys as $row){
                        if( empty($row) ) continue;
                        echo "<li class=\"swiper-slide swiper-slide-ss\"><a href=\"#\" onclick=\"set_ca_id('{$row['ca_id']}'); return false;\" class=\"font-naver-B\">{$row['ca_name']} (".$row['cnt'].")</a></li>\n";
                        $total_cnt += $row['cnt'];
                    }
                    ?>
                    <?php if(isset($_GET['qcaid']) && $_GET['qcaid'] || isset($_GET['qitemtype']) && $_GET['qitemtype']) { ?>
                    <li class="swiper-slide swiper-slide-ss"><a href="#" onclick="set_ca_id(''); return false;" style="color:#888;">전체보기</a></li>
                    <?php } ?>
                </ul>
            </div>

            <script>
                var swiper = new Swiper('.swiper-container-ss', {
                    slidesPerView: 'auto', //가로갯수
                    spaceBetween: 25, // 간격
                    touchRatio: 1, // 드래그 가능여부(1, 0)
                    slidesOffsetBefore: 20, //좌측여백 px
                    slidesOffsetAfter: 20, // 우측여백 px

                    breakpoints: { // 반응형 처리
                        1024: {
                            slidesPerView: 'auto',
                            touchRatio: 1,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 'auto',
                            touchRatio: 1,
                            spaceBetween: 20,
                        },
                        10: {
                            slidesPerView: 'auto',
                            touchRatio: 1,
                            spaceBetween: 20,
                        }
                    }

                });
            </script>

        </div>
	    <!-- } 검색된 분류 끝 -->
        <?php } ?>
        
            <div class="sort_wrpas">
                <select id="ssch_sort_all" onchange="set_sort(this.value.split(',')[0], this.value.split(',')[1])" class="select">
                    <option value="">상품정렬</option>
                    <option value="it_sum_qty,desc" <?php if(isset($_GET['qsort']) && $_GET['qsort'] == "it_sum_qty") { ?>selected<?php } ?>>판매순</option>
                    <option value="it_price,asc" <?php if(isset($_GET['qsort']) && $_GET['qsort'] == "it_price" && $_GET['qorder'] == "asc") { ?>selected<?php } ?>>낮은가격순</option>
                    <option value="it_price,desc" <?php if(isset($_GET['qsort']) && $_GET['qsort'] == "it_price" && $_GET['qorder'] == "desc") { ?>selected<?php } ?>>높은가격순</option>
                    <option value="it_use_avg,desc" <?php if(isset($_GET['qsort']) && $_GET['qsort'] == "it_use_avg") { ?>selected<?php } ?>>평점순</option>
                    <option value="it_use_cnt,desc" <?php if(isset($_GET['qsort']) && $_GET['qsort'] == "it_use_cnt") { ?>selected<?php } ?>>후기순</option>
                    <option value="it_update_time,desc" <?php if(isset($_GET['qsort']) && $_GET['qsort'] == "it_update_time") { ?>selected<?php } ?>>등록일순</option>
                </select>
            </div>
            
            <div class="cb"></div>
            
        </div>
		
    <!-- 검색결과 시작 { -->
    <div>
        <?php
        // 리스트 유형별로 출력
        if (isset($list) && is_object($list) && method_exists($list, 'run')) {
            $list->set_is_page(true);
            $list->set_view('it_img', true);
            $list->set_view('it_name', true);
            $list->set_view('it_basic', true);
            $list->set_view('it_cust_price', false);
            $list->set_view('it_price', true);
            $list->set_view('it_icon', true);
            $list->set_view('sns', true);
            $list->set_view('star', true);
            echo $list->run();
        }
        else
        {
            $i = 0;
            $error = '<p class="sct_nofile">'.$list_file.' 파일을 찾을 수 없습니다.<br>관리자에게 알려주시면 감사하겠습니다.</p>';
        }

        if ($i==0)
        {
            echo '<div>'.$error.'</div>';
        }

        $query_string = 'qname='.$qname.'&amp;qexplan='.$qexplan.'&amp;qid='.$qid;
        if($qfrom && $qto) $query_string .= '&amp;qfrom='.$qfrom.'&amp;qto='.$qto;
        $query_string .= '&amp;qcaid='.$qcaid.'&amp;q='.urlencode($q);
        $query_string .='&amp;qsort='.$qsort.'&amp;qorder='.$qorder;
        echo get_paging($config['cf_write_pages'], $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$query_string.'&amp;page=');
        ?>
    </div>
    <!-- } 검색결과 끝 -->
</div>
<!-- } 검색 끝 -->

<style>
        
    /* 바 { */
    .irs--flat .irs-line {
        top: 25px;
        height: 3px;
        background-color: #f3f3f3;
        border-radius: 4px;
    }

    .irs--flat .irs-bar {
        top: 25px;
        height: 3px;
        background-color: #25282B;
    }

    .irs--flat.irs-with-grid {
        height: 45px;
    }
    /* } */



    /* 셀렉터 { */
    .irs--flat .irs-handle {
        top: 22px;
        width: 16px;
        height: 18px;
        background-color: transparent;
    }

    .irs--flat .irs-handle>i:first-child {
        position: absolute;
        display: block;
        top: 0;
        left: 50%;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        margin-left: -8px;
        margin-top: -3px;
        background-color: #fff;
        box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.5);
    }

    .irs-handle.type_last {
        z-index: 2;
    }

    .irs--flat .irs-handle.state_hover>i:first-child,
    .irs--flat .irs-handle:hover>i:first-child {
        background-color: #fff;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.5);
    }
    /* } */

    /* 뱃지 { */ 
    .irs--flat .irs-from,
    .irs--flat .irs-to,
    .irs--flat .irs-single {
        color: #000;
        font-size: 10px;
        line-height: 1.333;
        text-shadow: none;
        padding: 1px 5px;
        background-color: transparent;
        border-radius: 4px;
        font-family:'font-B',sans-serif; font-weight:800;
    }

    .irs--flat .irs-from:before,
    .irs--flat .irs-to:before,
    .irs--flat .irs-single:before {
        position: absolute;
        display: block;
        content: "";
        bottom: -6px;
        left: 50%;
        width: 0;
        height: 0;
        margin-left: -3px;
        overflow: hidden;
        border: 3px solid transparent;
        border-top-color: #transparent;
    }
    /* } */

    /* 단위 { */
    .irs--flat .irs-min,
    .irs--flat .irs-max {
        /* 상단 */
        top: 0;
        padding: 1px 3px;
        color: rgba(0, 0, 0, 0.3);
        font-size: 10px;
        line-height: 1.333;
        text-shadow: none;
        background-color: #f9f9f9;
        border-radius: 4px;
        font-family:'font-B',sans-serif; font-weight:800;

    }

    .js-grid-text-1 {
        padding-right: 14px;
        display: none;
    }

    .irs-grid-text {
        padding-top: -20px;
        display: none;
    }
    /* } */
    

    /* 그리드 { */
    .irs-grid-pol {}

    .irs-grid {
        top: 23px;
        margin-left: -5px;
    }
    /* } */
    
</style>

<script>
function set_sort(qsort, qorder)
{
    var f = document.frmdetailsearch;
    f.qsort.value = qsort;
    f.qorder.value = qorder;
    f.submit();
}

function set_ca_id(qcaid)
{
    var f = document.frmdetailsearch;
    f.qcaid.value = qcaid;
    f.submit();
}

$(function(){
	//tooltip
    $(".tooltip_icon").click(function(){
        $(this).next(".tooltip").fadeIn(400);
    }).mouseout(function(){
        $(this).next(".tooltip").fadeOut();
    });
});

</script>