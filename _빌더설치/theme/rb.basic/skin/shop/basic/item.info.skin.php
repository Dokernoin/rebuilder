<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<?php if ($default['de_rel_list_use']) { ?>
<!-- 관련상품 시작 { -->
<section id="sit_rel" class="<?php if(!$default['de_mobile_rel_list_use']) { ?>pc<?php } ?>">
    <h2>관련상품</h2>
    <?php
    $rel_skin_file = $skin_dir.'/'.$default['de_rel_list_skin'];
    if(!is_file($rel_skin_file))
        $rel_skin_file = G5_SHOP_SKIN_PATH.'/'.$default['de_rel_list_skin'];

    $sql = " select b.* from {$g5['g5_shop_item_relation_table']} a left join {$g5['g5_shop_item_table']} b on (a.it_id2=b.it_id) where a.it_id = '{$it['it_id']}' and b.it_use='1' ";
    $list = new item_list($rel_skin_file, $default['de_rel_list_mod'], 0, $default['de_rel_img_width'], $default['de_rel_img_height']);
    $list->set_query($sql);
    echo $list->run();
    ?>
</section>
<!-- } 관련상품 끝 -->
<?php } ?>


<section id="sit_info">
	<div id="sit_tab">
	    <ul class="tab_tit">
	        <li><button type="button" id="btn_sit_inf" rel="#sit_inf" class="selected">상품정보</button></li>
	        <li><button type="button" id="btn_sit_use" rel="#sit_use">구매후기 <span class="item_use_count"><?php echo $item_use_count; ?></span></button></li>
	        <li><button type="button" id="btn_sit_qa" rel="#sit_qa">상품문의  <span class="item_qa_count"><?php echo $item_qa_count; ?></span></button></li>
	        <li><button type="button" id="btn_sit_dvex" rel="#sit_dex">배송/교환</button></li>
	    </ul>
	    <ul class="tab_con">
	
	        <!-- 상품 정보 시작 { -->
	        <li id="sit_inf">
	            <h2 class="contents_tit"><span>상품 정보</span></h2>
	
	            <?php if ($it['it_explan']) { // 상품 상세설명 ?>
	            <h3>상품 상세설명</h3>
	            <div id="sit_inf_explan">
	                <?php echo conv_content($it['it_explan'], 1); ?>
	            </div>
	            <?php } ?>
	
	            <?php
	            if ($it['it_info_value']) { // 상품 정보 고시
	                $info_data = unserialize(stripslashes($it['it_info_value']));
	                if(is_array($info_data)) {
	                    $gubun = $it['it_info_gubun'];
	                    $info_array = $item_info[$gubun]['article'];
	            ?>
	            <h3>상품 정보 고시</h3>
	            <table id="sit_inf_open">
	            <tbody>
	            <?php
	            foreach($info_data as $key=>$val) {
	                $ii_title = $info_array[$key][0];
	                $ii_value = $val;
	            ?>
	            <tr>
	                <th scope="row"><?php echo $ii_title; ?></th>
	                <td><?php echo $ii_value; ?></td>
	            </tr>
	            <?php } //foreach?>
	            </tbody>
	            </table>
	            <!-- 상품정보고시 end -->
	            <?php
	                } else {
	                    if($is_admin) {
	                        echo '<p>상품 정보 고시 정보가 올바르게 저장되지 않았습니다.<br>config.php 파일의 G5_ESCAPE_FUNCTION 설정을 addslashes 로<br>변경하신 후 관리자 &gt; 상품정보 수정에서 상품 정보를 다시 저장해주세요. </p>';
	                    }
	                }
	            } //if
	            ?>
	
	        </li>
	        <!-- 구매후기 시작 { -->
	        <li id="sit_use">
	            <h2>구매후기</h2>
	            <div id="itemuse"><?php include_once(G5_SHOP_PATH.'/itemuse.php'); ?></div>
	        </li>
	        <!-- } 구매후기 끝 -->
	
	        <!-- 상품문의 시작 { -->
	        <li id="sit_qa">
	            <h2>상품문의</h2>
	            <div id="itemqa"><?php include_once(G5_SHOP_PATH.'/itemqa.php'); ?></div>
	        </li>
	        <!-- } 상품문의 끝 -->
	        
	        <!-- 배송/교환 시작 { -->
	        <li id="sit_dex">
	            <h2>배송/교환정보</h2>
	            
	            <?php if ($default['de_baesong_content']) { // 배송정보 내용이 있다면 ?>
	            <!-- 배송 시작 { -->
	            <div id="sit_dvr">
	                <h3>배송</h3>
	                <?php echo conv_content($default['de_baesong_content'], 1); ?>
	            </div>
	            <!-- } 배송 끝 -->
	            <?php } ?>
	
	            <?php if ($default['de_change_content']) { // 교환/반품 내용이 있다면 ?>
	            <!-- 교환 시작 { -->
	            <div id="sit_ex" >
	                <h3>교환</h3>
	                <?php echo conv_content($default['de_change_content'], 1); ?>
	            </div>
	            <!-- } 교환 끝 -->
	            <?php } ?>
	            
	        </li>
	        <!-- } 배송/교환  끝 -->
	    </ul>
	</div>
	<script>
	$(function (){
	    $(".tab_con>li").hide();
	    $(".tab_con>li:first").show();   
	    $(".tab_tit li button").click(function(){
	        $(".tab_tit li button").removeClass("selected");
	        $(this).addClass("selected");
	        $(".tab_con>li").hide();
	        $($(this).attr("rel")).show();
	    });
	});
	</script>
	
	<div class="sit_buy_tog" id="sit_buy_tog">
	
        <button type="button" class="sit_buy_tog_btn_down"><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'><title>down_line</title><g id="down_line" fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#09244BFF' d='M12.707 15.707a1 1 0 0 1-1.414 0L5.636 10.05A1 1 0 1 1 7.05 8.636l4.95 4.95 4.95-4.95a1 1 0 0 1 1.414 1.414l-5.657 5.657Z'/></g></svg></button>

        <button type="button" class="sit_buy_tog_btn_up"><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24'><title>up_line</title><g id="up_line" fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#09244BFF' d='M11.293 8.293a1 1 0 0 1 1.414 0l5.657 5.657a1 1 0 0 1-1.414 1.414L12 10.414l-4.95 4.95a1 1 0 0 1-1.414-1.414l5.657-5.657Z'/></g></svg></button>
   
    </div>
    
	<div id="sit_buy" class="fix">
	    
		<div class="sit_buy_inner" id="sit_buy_inner">
	        <?php if($option_item) {    // 선택옵션이 있다면 ?>
	        <!-- 선택옵션 시작 { -->
	        <section class="sit_side_option">
	            <h3>선택옵션</h3>
	            <?php // 선택옵션
	            echo str_replace(array('class="get_item_options"', 'id="it_option_', 'class="it_option"'), array('class="get_side_item_options"', 'id="it_side_option_', 'class="it_side_option"'), $option_item);
	            ?>
	        </section>
	        <!-- } 선택옵션 끝 -->
	        <?php } // end if?>

            <?php if($supply_item) {    // 추가옵션이 있다면 ?>
	        <!-- 추가옵션 시작 { -->
	        <section class="sit_side_option">
	            <h3>추가옵션</h3>
	            <?php // 추가옵션
	            echo str_replace(array('id="it_supply_', 'class="it_supply"'), array('id="it_side_supply_', 'class="it_side_supply"'), $supply_item);
	            ?>
	        </section>
	        <!-- } 추가옵션 끝 -->
	        <?php } // end if?>
            
            <?php if ($is_orderable) { ?>
	        <!-- 선택된 옵션 시작 { -->
	        <section class="sit_sel_option">
	            <h3>선택된 옵션</h3>
	            <ul class="sit_opt_added">
                    <?php if( !$option_item ){ ?>
                    <li>
                        <div class="opt_name">
                            <span class="sit_opt_subj"><?php echo $it['it_name']; ?></span>
                        </div>
                        <div class="opt_count">
                            <label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
                            <button type="button" class="sit_qty_minus"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
                            <input type="text" name="ct_copy_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="num_input" size="5">
                            <button type="button" class="sit_qty_plus"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
                            <span class="sit_opt_prc">+0원</span>
                        </div>
                    </li>
                    <?php } ?>
                </ul>
	        </section>
	        <!-- } 선택된 옵션 끝 -->

			<div class="sum_section" id="sum_section">        
		        <div class="sit_tot_price"></div>
				
				<div class="sit_order_btn">
					<button type="submit" onclick="document.pressed=this.value;" value="장바구니" class="sit_btn_cart">장바구니</button>
		            <button type="submit" onclick="document.pressed=this.value;" value="바로구매" class="sit_btn_buy">바로구매</button> 
		       </div>
			</div>

            <?php if(IS_MOBILE()) { ?>
             <script>
                $(document).ready(function() {
                    function adjustTop() {
                        var headerHeight = document.querySelector('.sum_section').getBoundingClientRect().height + 67;
                        $('#sit_buy').css('padding-bottom', headerHeight + 'px');
                    }

                    // 처음 로딩 시 top 값 조정
                    adjustTop();

                    // 윈도우 리사이즈 시 top 값 재조정
                    $(window).resize(adjustTop);

                    // sum_section의 변화를 감지하여 adjustTop 함수 호출
                    var sumSection = document.querySelector('.sum_section');
                    var observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            adjustTop();
                        });
                    });

                    observer.observe(sumSection, {
                        attributes: true,
                        childList: true,
                        subtree: true,
                        characterData: true
                    });
                });
            </script>
             <?php } else { ?>
             <script>
                $(document).ready(function() {
                    function adjustTop() {
                        var headerHeight = $('#header').outerHeight(true);
                        $('#sit_buy_inner').css('top', headerHeight + 'px');
                        document.getElementById('sit_buy_inner').style.setProperty('top', headerHeight + 'px');
                    }

                    // 처음 로딩 시 top 값 조정
                    adjustTop();

                    // 윈도우 리사이즈 시 top 값 재조정
                    $(window).resize(adjustTop);
                });
            </script>
            <?php } ?>

            <?php } else { ?>
            <div class="no_data">구매할 수 없는 상품 입니다.</div>
            <?php } ?>
			
	    </div>   
	</div>
	    

	
	<script>
        
    $(function() {
        // 페이지 로드 시 localStorage 값을 확인하여 초기 상태 설정
        if (localStorage.getItem('isDivOpen') === 'false') {
            // "올리기" 버튼을 표시하고, "내리기" 버튼을 숨김
            $(".sit_buy_tog_btn_down").hide();
            $(".sit_buy_tog_btn_up").show();
            // div를 내려가 있는 상태로 설정
            $(".sit_buy_tog").addClass("ch_tog_btn");
            $("#sit_buy").addClass("ch_tog_wrap");
            $("#sum_section").addClass("ch_tog_wrap2");
            $("#sit_buy_tog").addClass("ch_tog_wrap3");
        } else {
            // "내리기" 버튼을 표시하고, "올리기" 버튼을 숨김
            $(".sit_buy_tog_btn_down").show();
            $(".sit_buy_tog_btn_up").hide();
            // div를 올라가 있는 상태로 설정
            $(".sit_buy_tog").removeClass("ch_tog_btn");
            $("#sit_buy").removeClass("ch_tog_wrap");
            $("#sum_section").removeClass("ch_tog_wrap2");
            $("#sit_buy_tog").removeClass("ch_tog_wrap3");
        }

        function toggleElements() {
            // 클릭 시 transition 속성을 추가
            $("#sit_buy, #sum_section").css("transition", "all 600ms cubic-bezier(0.86, 0, 0.07, 1)");
            $("#sit_buy_tog").css("transition", "all 600ms cubic-bezier(0.84, 0, 0.07, 1)");
            
            $(".sit_buy_tog").toggleClass("ch_tog_btn");
            $("#sit_buy").toggleClass("ch_tog_wrap");
            $("#sum_section").toggleClass("ch_tog_wrap2");
            $("#sit_buy_tog").toggleClass("ch_tog_wrap3");
            $(".sit_buy_tog_btn_up, .sit_buy_tog_btn_down").toggle();

            // 애니메이션이 끝난 후 transition 속성을 제거
            setTimeout(function() {
                $("#sit_buy, #sum_section").css("transition", "");
                $("#sit_buy_tog").css("transition", "");
            }, 600);

            // div가 열려 있는지 닫혀 있는지 localStorage에 저장
            const isDivOpen = $(".sit_buy_tog_btn_up").is(":visible");
            localStorage.setItem('isDivOpen', !isDivOpen);
        }

        $(".sit_buy_tog_btn_down, .sit_buy_tog_btn_up").click(toggleElements);
    });
    </script>

</section>

<script>
jQuery(function($){
    var change_name = "ct_copy_qty";

    $(document).on("select_it_option_change", "select.it_option", function(e, $othis) {
        var value = $othis.val(),
            change_id = $othis.attr("id").replace("it_option_", "it_side_option_");
        
        if( $("#"+change_id).length ){
            $("#"+change_id).val(value).attr("selected", "selected");
        }
    });

    $(document).on("select_it_option_post", "select.it_option", function(e, $othis, idx, sel_count, data) {
        var value = $othis.val(),
            change_id = $othis.attr("id").replace("it_option_", "it_side_option_");
        
        $("select.it_side_option").eq(idx+1).empty().html(data).attr("disabled", false);

        // select의 옵션이 변경됐을 경우 하위 옵션 disabled
        if( (idx+1) < sel_count) {
            $("select.it_side_option:gt("+(idx+1)+")").val("").attr("disabled", true);
        }
    });

    $(document).on("add_sit_sel_option", "#sit_sel_option", function(e, opt) {
        
        opt = opt.replace('name="ct_qty[', 'name="'+change_name+'[');

        var $opt = $(opt);
        $opt.removeClass("sit_opt_list");
        $("input[type=hidden]", $opt).remove();

        $(".sit_sel_option .sit_opt_added").append($opt);

    });

    $(document).on("price_calculate", "#sit_tot_price", function(e, total) {

        $(".sum_section .sit_tot_price").empty().html("<span>총 금액 </span><strong>"+number_format(String(total))+"</strong> 원");

    });

    $(".sit_side_option").on("change", "select.it_side_option", function(e) {
        var idx = $("select.it_side_option").index($(this)),
            value = $(this).val();

        if( value ){
            if (typeof(option_add) != "undefined"){
                option_add = true;
            }

            $("select.it_option").eq(idx).val(value).attr("selected", "selected").trigger("change");
        }
    });

    $(".sit_side_option").on("change", "select.it_side_supply", function(e) {
        var value = $(this).val();

        if( value ){
            if (typeof(supply_add) != "undefined"){
                supply_add = true;
            }

            // 현재 변경된 select.it_side_supply와 동일한 인덱스의 select.it_supply 요소 선택
            var idx = $("select.it_side_supply").index($(this));
            var targetSelect = $("select.it_supply").eq(idx);

            // 해당 select 요소의 모든 option에서 selected 속성 제거
            targetSelect.find('option').prop("selected", false);

            // 선택된 값에 해당하는 option에만 selected 속성 부여
            targetSelect.find('option[value="' + value + '"]').prop("selected", true);

            // 변경 사항 반영을 위해 change 이벤트 트리거
            targetSelect.trigger("change");
        }
    });

    $(".sit_opt_added").on("click", "button", function(e){
        e.preventDefault();

        var $this = $(this),
            mode = $this.text(),
            $sit_sel_el = $("#sit_sel_option"),
            li_parent_index = $this.closest('li').index();
        
        if( ! $sit_sel_el.length ){
            alert("el 에러");
            return false;
        }

        switch(mode) {
            case "증가":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_qty_plus").trigger("click");
                break;
            case "감소":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_qty_minus").trigger("click");
                break;
            case "삭제":
                $sit_sel_el.find("li").eq(li_parent_index).find(".sit_opt_del").trigger("click");
                break;
        }

    });

    $(document).on("sit_sel_option_success", "#sit_sel_option li button", function(e, $othis, mode, this_qty) {
        var ori_index = $othis.closest('li').index();

        switch(mode) {
            case "증가":
            case "감소":
                $(".sit_opt_added li").eq(ori_index).find("input[name^=ct_copy_qty]").val(this_qty);
                break;
            case "삭제":
                $(".sit_opt_added li").eq(ori_index).remove();
                break;
        }
    });

    $(document).on("change_option_qty", "input[name^=ct_qty]", function(e, $othis, val, force_val) {
        var $this = $(this),
            ori_index = $othis.closest('li').index(),
            this_val = force_val ? force_val : val;

        $(".sit_opt_added").find("li").eq(ori_index).find("input[name^="+change_name+"]").val(this_val);
    });

    $(".sit_opt_added").on("keyup paste", "input[name^="+change_name+"]", function(e) {
         var $this = $(this),
             val= $this.val(),
             this_index = $("input[name^="+change_name+"]").index(this);

         $("input[name^=ct_qty]").eq(this_index).val(val).trigger("keyup");
    });

    $(".sit_order_btn").on("click", "button", function(e){
        e.preventDefault();

        var $this = $(this);

        if( $this.hasClass("sit_btn_cart") ){
            $("#sit_ov_btn .sit_btn_cart").trigger("click");
        } else if ( $this.hasClass("sit_btn_buy") ) {
            $("#sit_ov_btn .sit_btn_buy").trigger("click");
        }
    });

	if (window.location.href.split("#").length > 1) {
		let id = window.location.href.split("#")[1];
		$("#btn_" + id).trigger("click");
	};
});
</script>
