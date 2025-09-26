<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.G5_SHOP_CSS_URL.'/style.css">', 0);
?>

<script src="//developers.kakao.com/sdk/js/kakao.min.js" charset="utf-8"></script>
<script src="<?php echo G5_JS_URL; ?>/kakaolink.js" charset="utf-8"></script>
                        
<div id="sit_ov_from">
	<form name="fitem" method="post" action="<?php echo $action_url; ?>" onsubmit="return fitem_submit(this);">
	<input type="hidden" name="it_id[]" value="<?php echo $it_id; ?>">
	<input type="hidden" name="sw_direct">
	<input type="hidden" name="url">
	<input type="hidden" name="it_partner" value="<?php echo isset($it['it_partner']) ? $it['it_partner'] : ''; ?>">
	
	<div id="sit_ov_wrap">
	    
	
	    <!-- 상품 요약정보 및 구매 시작 { -->
	    <section id="sit_ov" class="2017_renewal_itemform">
            
            <div class="rb_wish_cnt_wrap">
                <li>
                    <dd><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></dd>
                    <dd class="font-B"><?php echo get_wishlist_count_by_item($it['it_id']); ?></dd>
                </li>
            </div>
        
	        <h2 id="sit_title"><?php echo stripslashes($it['it_name']); ?> <span class="sound_only">요약정보 및 구매</span></h2>
	        <p id="sit_desc"><?php echo $it['it_basic']; ?></p>
	        
	        <div class="rb_price_v_wrap">
                <?php if (!$it['it_use']) { // 판매가능이 아닐 경우 ?>
                    <span class="pri font-B">판매중지</span>
                <?php } else if ($it['it_tel_inq']) { // 전화문의일 경우 ?>
                    <span class="pri font-B0">전화문의</span>
                <?php } else { // 전화문의가 아닐 경우?>
                   
                    <?php
                        //할인율을 구함
                        if($it['it_cust_price']) {
                            $sale_per = ceil(((get_price($it)-$it['it_cust_price'])/$it['it_cust_price'])*100).'%';
                        }
                    ?>
                    <span class="pri font-B <?php if ($it['it_cust_price']) { ?>main_color<?php } ?>"><?php echo display_price(get_price($it)); ?></span> <?php if ($it['it_cust_price']) { ?><span class="pri_per font-B"><?php echo $sale_per ?></span> <strike><?php echo display_price($it['it_cust_price']); ?></strike><?php } ?>
                    <input type="hidden" id="it_price" value="<?php echo get_price($it); ?>">
                <?php } ?>
            </div>
                        
	        <?php if($is_orderable) { ?>
	        <p id="sit_opt_info">
	            상품 선택옵션 <?php echo $option_count; ?> 개, 추가옵션 <?php echo $supply_count; ?> 개
	        </p>
	        <?php } ?>
	        
	        
	        
	        <div id="sit_star_sns">
	            <?php if ($star_score) { ?>
	            <span class="sound_only">고객평점</span> 
	            <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star" width="100">
	            <span class="sound_only">별<?php echo $star_score?>개</span> 
	            <?php } ?>
	            
	            <span class="">구매후기 <?php echo $it['it_use_cnt']; ?> 개</span>
	            
	            
	            <div id="sit_btn_opt">
                    
	            	<button type="button" class="btn_sns_share">
	            	<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><title>share_2_line</title><g id="share_2_line" fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#09244BFF' d='M18.5 2a3.5 3.5 0 1 1-2.506 5.943L11.67 10.21c.213.555.33 1.16.33 1.79a4.99 4.99 0 0 1-.33 1.79l4.324 2.267a3.5 3.5 0 1 1-.93 1.771l-4.475-2.346a5 5 0 1 1 0-6.963l4.475-2.347A3.5 3.5 0 0 1 18.5 2Zm0 15a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3ZM7 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm11.5-5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3Z'/></g></svg></button>
	            	<div class="sns_area">
	            		<?php echo $sns_share_links; ?>
	            		<?php if($config['cf_kakao_js_apikey']) { ?>
	            		
                        
	            		<a href="javascript:Kakao_sendLink();" style="background-color:#fbe300;"><img src="<?php echo G5_THEME_URL ?>/skin/shop/basic/img/kakaotalk.png" title="카카오톡으로 공유"></a>
	            		<script type='text/javascript'>
                            //<![CDATA[
                            Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
                            
                            function Kakao_sendLink() {

                                var webUrl = location.protocol + "<?php echo '//'.$_SERVER['HTTP_HOST'].'/shop/item.php?it_id='.$it_id; ?>",
                                    imageUrl = $("#sit_pvi").find("img").attr("src") || $("#sit_ov_wrap").find("img").attr("src") || '';

                                Kakao.Link.sendDefault({
                                    objectType: 'feed',

                                    content: {
                                        title: "<?php echo str_replace(array('%27', '&#034;' , '\"'), '', stripslashes($it['it_name'])); ?>",
                                        description: "<?php echo str_replace(array('%27', '&#034;' , '\"'), '', stripslashes($it['it_basic'])); ?>",
                                        imageUrl: imageUrl,
                                        link: {
                                            mobileWebUrl: webUrl,
                                            webUrl: webUrl
                                        }
                                    },

                                    buttons: [{
                                        title: '상품보기',
                                        link: {
                                            mobileWebUrl: webUrl,
                                            webUrl: webUrl
                                        }
                                    }]
                                });
                            }
                            //]]>
                        </script>
	            		<?php } ?>
	            		<a href="javascript:void(0);" id="data-copy"><img src="<?php echo G5_THEME_URL ?>/skin/shop/basic/img/ico_sha.png" alt="공유링크 복사" width="32"></a>
	            		<?php
                        $currents_url = G5_URL.$_SERVER['REQUEST_URI'];
                        ?>
                        <input type="hidden" id="data-area" class="data-area" value="<?php echo $currents_url ?>">
                        <script>
                            $(document).ready(function() {

                                $('#data-copy').click(function() {
                                    $('#data-area').attr('type', 'text'); // 화면에서 hidden 처리한 input box type을 text로 일시 변환
                                    $('#data-area').select(); // input에 담긴 데이터를 선택
                                    var copy = document.execCommand('copy'); // clipboard에 데이터 복사
                                    $('#data-area').attr('type', 'hidden'); // input box를 다시 hidden 처리
                                    if (copy) {
                                        alert("공유 링크가 복사 되었습니다."); // 사용자 알림
                                    }
                                });

                            });
                        </script>
	            		<!--
	            		<a href="javascript:popup_item_recommend('<?php echo $it['it_id']; ?>');" id="sit_btn_rec"><i class="fa fa-envelope-o" aria-hidden="true"></i><span class="sound_only">추천하기</span></a>
	            		-->
	            	</div>
	        	</div>
	        </div>

	        <?php 
            if(isset($pa['pa_is']) && $pa['pa_is'] == 1) {
                include_once(G5_PATH.'/rb/rb.mod/partner/partner_info.php');
            } 
            ?>
	        

	        
	        <script>
	        $(".btn_sns_share").click(function(){
	            $(".sns_area").show();
	        });
	        $(document).mouseup(function (e){
	            var container = $(".sns_area");
	            if( container.has(e.target).length === 0)
	            container.hide();
	        });
	        </script>
	        
	        <div class="sit_info">
	            <table class="sit_ov_tbl">
	            <colgroup>
	                <col class="grid_3">
	                <col>
	            </colgroup>
	            <tbody>

	            	
	            <?php if ($it['it_maker']) { ?>
	            <tr>
	                <th scope="row">제조사</th>
	                <td><?php echo $it['it_maker']; ?></td>
	            </tr>
	            <?php } ?>
	
	            <?php if ($it['it_origin']) { ?>
	            <tr>
	                <th scope="row">원산지</th>
	                <td><?php echo $it['it_origin']; ?></td>
	            </tr>
	            <?php } ?>
	
	            <?php if ($it['it_brand']) { ?>
	            <tr>
	                <th scope="row">브랜드</th>
	                <td><?php echo $it['it_brand']; ?></td>
	            </tr>
	            <?php } ?>
	
	            <?php if ($it['it_model']) { ?>
	            <tr>
	                <th scope="row">모델</th>
	                <td><?php echo $it['it_model']; ?></td>
	            </tr>
	            <?php } ?>

	            <?php
	            /* 재고 표시하는 경우 주석 해제
	            <tr>
	                <th scope="row">재고수량</th>
	                <td><?php echo number_format(get_it_stock_qty($it_id)); ?> 개</td>
	            </tr>
	            */
	            ?>
	
	            <?php if ($config['cf_use_point'] && $it['it_point'] > 0) { // 포인트 사용한다면 ?>
	            <tr>
	                <th scope="row">포인트</th>
	                <td>
	                    <?php
	                    if($it['it_point_type'] == 2) {
	                        echo '구매금액(추가옵션 제외)의 '.$it['it_point'].'%';
	                    } else {
	                        $it_point = get_item_point($it);
	                        echo number_format($it_point).'P';
	                    }
	                    ?>
	                </td>
	            </tr>
	            <?php } ?>
	            <?php
	            $ct_send_cost_label = '배송비결제';
	
	            if($it['it_sc_type'] == 1)
	                $sc_method = '무료배송';
	            else {
	                if($it['it_sc_method'] == 1)
	                    $sc_method = '수령후 지불';
	                else if($it['it_sc_method'] == 2) {
	                    $ct_send_cost_label = '<label for="ct_send_cost">배송비결제</label>';
	                    $sc_method = '<select name="ct_send_cost" id="ct_send_cost" class="select input_tiny">
	                                      <option value="0">주문시 결제</option>
	                                      <option value="1">수령후 지불</option>
	                                  </select>';
	                }
	                else
	                    $sc_method = '주문시 결제';
	            }
	            ?>
	            <tr>
	                <th><?php echo $ct_send_cost_label; ?></th>
	                <td><?php echo $sc_method; ?></td>
	            </tr>
	            <?php if($it['it_buy_min_qty'] > 0) { ?>
	            <tr>
	                <th>최소구매수량</th>
	                <td><?php echo number_format($it['it_buy_min_qty']); ?> 개</td>
	            </tr>
	            <?php } ?>
	            <?php if($it['it_buy_max_qty'] > 0) { ?>
	            <tr>
	                <th>최대구매수량</th>
	                <td><?php echo number_format($it['it_buy_max_qty']); ?> 개</td>
	            </tr>
	            <?php } ?>
	            </tbody>
	            </table>
	        </div>
	        <?php
	        if($option_item) {
	        ?>
	        <!-- 선택옵션 시작 { -->
	        <section class="sit_option">
	            <h3>선택옵션</h3>
	 
	            <?php // 선택옵션
	            echo $option_item;
	            ?>
	        </section>
	        <!-- } 선택옵션 끝 -->
	        <?php
	        }
	        ?>
	
	        <?php
	        if($supply_item) {
	        ?>
	        <!-- 추가옵션 시작 { -->
	        <section  class="sit_option">
	            <h3>추가옵션</h3>
	            <?php // 추가옵션
	            echo $supply_item;
	            ?>
	        </section>
	        <!-- } 추가옵션 끝 -->
	        <?php
	        }
	        ?>
	
	        <?php if ($is_orderable) { ?>
	        <!-- 선택된 옵션 시작 { -->
	        <section id="sit_sel_option">
	            <h3>선택된 옵션</h3>
	            <?php
	            if(!$option_item) {
	                if(!$it['it_buy_min_qty'])
	                    $it['it_buy_min_qty'] = 1;
	            ?>
	            <ul id="sit_opt_added">
	                <li class="sit_opt_list">
	                    <input type="hidden" name="io_type[<?php echo $it_id; ?>][]" value="0">
	                    <input type="hidden" name="io_id[<?php echo $it_id; ?>][]" value="">
	                    <input type="hidden" name="io_value[<?php echo $it_id; ?>][]" value="<?php echo $it['it_name']; ?>">
	                    <input type="hidden" class="io_price" value="0">
	                    <input type="hidden" class="io_stock" value="<?php echo $it['it_stock_qty']; ?>">
	                    <div class="opt_name">
	                        <span class="sit_opt_subj"><?php echo $it['it_name']; ?></span>
	                    </div>
	                    <div class="opt_count">
	                        <label for="ct_qty_<?php echo $i; ?>" class="sound_only">수량</label>
							<button type="button" class="sit_qty_minus"><i class="fa fa-minus" aria-hidden="true"></i><span class="sound_only">감소</span></button>
	                        <input type="text" name="ct_qty[<?php echo $it_id; ?>][]" value="<?php echo $it['it_buy_min_qty']; ?>" id="ct_qty_<?php echo $i; ?>" class="num_input" size="5">
	                        <button type="button" class="sit_qty_plus"><i class="fa fa-plus" aria-hidden="true"></i><span class="sound_only">증가</span></button>
	                        <span class="sit_opt_prc">+0원</span>
	                    </div>
	                </li>
	            </ul>
	            <script>
	            $(function() {
	                price_calculate();
	            });
	            </script>
	            <?php } ?>
	        </section>
	        <!-- } 선택된 옵션 끝 -->
	
	        <!-- 총 구매액 -->
	        <div id="sit_tot_price"></div>
	        <?php } ?>
	
	        <?php if($is_soldout) { ?>
	        <p id="sit_ov_soldout">상품의 재고가 부족하여 구매할 수 없습니다.</p>
	        <?php } ?>
	
	        <div id="sit_ov_btn">
	            <?php if ($is_orderable) { ?>
	            <button type="submit" onclick="document.pressed=this.value;" value="바로구매" class="sit_btn_buy">바로구매</button>
	            <button type="submit" onclick="document.pressed=this.value;" value="장바구니" class="sit_btn_cart">장바구니</button>
	            <?php } ?>
	            <a href="javascript:item_wish(document.fitem, '<?php echo $it['it_id']; ?>');" class="sit_btn_wish"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></a>
	            	
	            <?php if(!$is_orderable && $it['it_soldout'] && $it['it_stock_sms']) { ?>
	            <a href="javascript:popup_stocksms('<?php echo $it['it_id']; ?>');" id="sit_btn_alm">재입고알림</a>
	            <?php } ?>
	            <?php if ($naverpay_button_js) { ?>
	            <div class="itemform-naverpay"><?php echo $naverpay_request_js.$naverpay_button_js; ?></div>
	            <?php } ?>
	        </div>
	
	        <script>
	        // 상품보관
	        function item_wish(f, it_id)
	        {
	            f.url.value = "<?php echo G5_SHOP_URL; ?>/wishupdate.php?it_id="+it_id;
	            f.action = "<?php echo G5_SHOP_URL; ?>/wishupdate.php";
	            f.submit();
	        }
	
	        // 추천메일
	        function popup_item_recommend(it_id)
	        {
	            if (!g5_is_member)
	            {
	                if (confirm("회원만 추천하실 수 있습니다."))
	                    document.location.href = "<?php echo G5_BBS_URL; ?>/login.php?url=<?php echo urlencode(shop_item_url($it_id)); ?>";
	            }
	            else
	            {
	                url = "./itemrecommend.php?it_id=" + it_id;
	                opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
	                popup_window(url, "itemrecommend", opt);
	            }
	        }
	
	        // 재입고 알림
	        function popup_stocksms(it_id)
	        {
	            url = "<?php echo G5_SHOP_URL; ?>/itemstocksms.php?it_id=" + it_id;
                opt = "scrollbars=yes,width=616,height=420,top=10,left=10";
	            popup_window(url, "itemstocksms", opt);
	        }
	        </script>
	    </section>
	    <!-- } 상품 요약정보 및 구매 끝 -->
	    
	    <!-- 상품이미지 미리보기 시작 { -->
	    <div id="sit_pvi">
        
            <!-- 이미지 { -->
            <div class="swiper-container gallery-top">
                <div class="swiper-wrapper">
                    <?php
                    $big_img_count = 0;
                    $thumbnails = array();
                    $count_img = 1;

                    for($i=$count_img; $i<=10; $i++) {
                        if(!$it['it_img'.$i])
                            continue;
                        
                            $img = rb_it_thumbnail($it['it_img'.$i], $default['de_mimg_width'], $default['de_mimg_height']);

                        if($img) {
                            // 썸네일
                            $thumb = rb_it_thumbnail($it['it_img'.$i], 150, 150);
                            $thumbnails[] = $thumb;
                            $big_img_count++;
                            
                            echo '<div class="swiper-slide">'.$img.'</div>';
                            //echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$i.'" target="_blank" class="popup_item_image">'.$img.'</a>';
                        }
                    }

                    if($big_img_count == 0) {
                        echo '<img src="'.G5_SHOP_URL.'/img/no_image.gif" alt="">';
                    }
                    ?>
                </div>
                <!-- Add Arrows -->
                <?php if($big_img_count == 0) { ?>
                <?php } else { ?>
                <div class="swiper-button-next swiper-button-next-bn swiper-button-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </div>
                <div class="swiper-button-prev swiper-button-prev-bn swiper-button-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </div>
                <?php } ?>

            </div>
            <!-- } -->

            <!-- 썸네일 { -->
                    <?php
                    // 썸네일
                    $thumb1 = true;
                    $thumb_count = 0;
                    $total_count = count($thumbnails);
                    if($total_count > 0) {
                        echo '<div class="swiper-container gallery-thumbs"><div class="swiper-wrapper">';
                        foreach($thumbnails as $val) {
                            $thumb_count++;
                            $sit_pvi_last ='';
                            if ($thumb_count % 5 == 0) $sit_pvi_last = 'class="li_last"';
                                echo '<div class="swiper-slide">'.$val.'</div>';
                            
                                //echo '<li '.$sit_pvi_last.'>';
                                //echo '<a href="'.G5_SHOP_URL.'/largeimage.php?it_id='.$it['it_id'].'&amp;no='.$thumb_count.'" target="_blank" class="popup_item_image img_thumb">'.$val.'<span class="sound_only"> '.$thumb_count.'번째 이미지 새창</span></a>';
                                //echo '</li>';
                        }
                        echo '</div></div>';
                    }
                    ?>
            <!-- } -->

            <!-- Initialize Swiper -->
            <script>
                var galleryThumbs = new Swiper('.gallery-thumbs', {
                    spaceBetween: 10,
                    slidesPerView: 7,
                    //freeMode: true,
                    watchSlidesVisibility: true,
                    watchSlidesProgress: true,
                    
                    breakpoints: { // 반응형 처리
                            768: {
                                slidesPerView: 7,
                            },
                            10: {
                                slidesPerView: 5,
                            }
                        }
                    
                });
                var galleryTop = new Swiper('.gallery-top', {
                    spaceBetween: 0,
                    autoHeight: true,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    thumbs: {
                        swiper: galleryThumbs
                    }
                });
            </script>
            <style>
                .gallery-thumbs .swiper-slide-thumb-active img {
                    border-color:#454545;
                }
            </style>
        

	        
	            <div class="cb"></div>
	        
	            <!-- 전체평점 { -->
                <?php if ($star_score) { 
            
                $sql_s1 = "select COUNT(*) as score_s1 from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and is_confirm = 1 and is_score = '5' ";
                $row_s1 = sql_fetch($sql_s1);
    
                $sql_s2 = "select COUNT(*) as score_s2 from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and is_confirm = 1 and is_score = '4' ";
                $row_s2 = sql_fetch($sql_s2);
    
                $sql_s3 = "select COUNT(*) as score_s3 from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and is_confirm = 1 and is_score = '3' ";
                $row_s3 = sql_fetch($sql_s3);
    
                $sql_s4 = "select COUNT(*) as score_s4 from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and is_confirm = 1 and is_score = '2' ";
                $row_s4 = sql_fetch($sql_s4);

                $sql_s5 = "select COUNT(*) as score_s5 from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and is_confirm = 1 and is_score = '1' ";
                $row_s5 = sql_fetch($sql_s5);
    
                $sql_all = "select COUNT(*) as score_all from {$g5['g5_shop_item_use_table']} where it_id = '$it_id' and is_confirm = 1 ";
                $row_all = sql_fetch($sql_all);
                
                $p1_count = $row_s1['score_s1']/$row_all['score_all']*100;
                $p2_count = $row_s2['score_s2']/$row_all['score_all']*100;
                $p3_count = $row_s3['score_s3']/$row_all['score_all']*100;
                $p4_count = $row_s4['score_s4']/$row_all['score_all']*100;
                $p5_count = $row_s5['score_s5']/$row_all['score_all']*100;
    
                $p1_mi = 100-$p1_count;
                $p2_mi = 100-$p2_count;
                $p3_mi = 100-$p3_count;
                $p4_mi = 100-$p4_count;
                $p5_mi = 100-$p5_count;
    
                $star_score2 = get_star_image2($it['it_id']);
                ?>

                <script src="<?php echo G5_THEME_URL ?>/shop/apexcharts/apexcharts.js"></script>
                <link type="text/css" href="<?php echo G5_THEME_URL ?>/shop/apexcharts/apexcharts.css" rel="stylesheet">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.0/moment.min.js"></script>

                <style>
                .apexcharts-toolbar {display: none; !important;}
                </style>

                <script>

                    $(function() {

                        var optionsBar = {
                            chart: {
                                type: 'bar',
                                height: 130,
                                width: '100%',
                                stacked: true,
                                foreColor: '#999',
                            },
                            plotOptions: {
                                bar: {
                                    dataLabels: {
                                        enabled: false
                                    },
                                    columnWidth: '62%',
                                    endingShape: 'rounded'
                                }
                            },
                            colors: ["#25282B", '#ddd'],

                            series: [{
                                name: "",
                                data: [<?php echo number_format($p1_count) ?>, <?php echo number_format($p2_count) ?>, <?php echo number_format($p3_count) ?>, <?php echo number_format($p4_count) ?>, <?php echo number_format($p5_count) ?>],
                            }, {
                                name: "",
                                data: [<?php echo number_format($p1_mi) ?>, <?php echo number_format($p2_mi) ?>, <?php echo number_format($p3_mi) ?>, <?php echo number_format($p4_mi) ?>, <?php echo number_format($p5_mi) ?>],
                            }],
                            dataLabels: {
                                enabled: false
                            },
                            labels: ["5점", "4점", "3점", "2점", "1점"],
                            xaxis: {
                                axisBorder: {
                                    show: false
                                },
                                axisTicks: {
                                    show: false
                                },
                                crosshairs: {
                                    show: false
                                },
                                labels: {
                                    show: true,
                                    style: {
                                        fontSize: '11px'
                                    }
                                },
                            },
                            grid: {
                                xaxis: {
                                    lines: {
                                        show: false
                                    },
                                },
                                yaxis: {
                                    lines: {
                                        show: false
                                    },
                                }
                            },
                            yaxis: {
                                axisBorder: {
                                    show: false
                                },
                                labels: {
                                    show: false
                                },
                            },
                            legend: {
                                floating: false,
                                position: 'bottom',
                                horizontalAlign: 'left',
                                offsetY: 0
                            },
                            states: {
                              hover: {
                               filter: {
                                  type: 'none'
                                }
                              }
                            },

                            tooltip: {
                                shared: false,
                                intersect: false,
                                y: {
                                    formatter: function (val) {
                                        return val+"%"
                                    }
                                }
                            },


                        }

                        var chartBar = new ApexCharts(document.querySelector('#bar'), optionsBar);
                        chartBar.render();
                    });
                </script>
                
                <div class="star_av_wrap">
                    
                    <ul class="star_av_wrap_ul1">
                        <li class="font-naver-H star_av_wrap_ul1_li1">구매 만족도</li>
                        <img src="<?php echo G5_SHOP_URL; ?>/img/s_star<?php echo $star_score?>.png" alt="" class="sit_star" width="100">
                        <li class="font-naver-EB star_av_wrap_ul1_li2 font-B"><?php echo $star_score2?></li>
                    </ul>
                    <ul class="star_av_wrap_ul2">
                        <li class="font-naver-H star_av_wrap_ul2_li1">만족도 비율</li>
                        <div id="bar"></div>
                    </ul>
                    <div class="cb"></div>
                    
                    
                </div>
                <!-- } -->
                <?php } ?>
                
                
                
	    </div>
	    <!-- } 상품이미지 미리보기 끝 -->
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	    
	</div>
	<!-- 다른 상품 보기 시작 { -->
    <div id="sit_siblings">
	    <?php
	    if ($prev_href || $next_href) {
	        echo $prev_href.$prev_title.$prev_href2;
	        echo $next_href.$next_title.$next_href2;
	    } else {
	        echo '<span class="sound_only">이 분류에 등록된 다른 상품이 없습니다.</span>';
	    }
	    ?>
	</div>   
    <!-- } 다른 상품 보기 끝 -->
	</form>
</div>

<script>
$(function(){
    // 상품이미지 첫번째 링크
    $("#sit_pvi_big a:first").addClass("visible");

    // 상품이미지 미리보기 (썸네일에 마우스 오버시)
    $("#sit_pvi .img_thumb").bind("mouseover focus", function(){
        var idx = $("#sit_pvi .img_thumb").index($(this));
        $("#sit_pvi_big a.visible").removeClass("visible");
        $("#sit_pvi_big a:eq("+idx+")").addClass("visible");
    });

    // 상품이미지 크게보기
    $(".popup_item_image").click(function() {
        var url = $(this).attr("href");
        var top = 10;
        var left = 10;
        var opt = 'scrollbars=yes,top='+top+',left='+left;
        popup_window(url, "largeimage", opt);

        return false;
    });
});

function fsubmit_check(f)
{
    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").length < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}

// 바로구매, 장바구니 폼 전송
function fitem_submit(f)
{
    f.action = "<?php echo $action_url; ?>";
    f.target = "";

    if (document.pressed == "장바구니") {
        f.sw_direct.value = 0;
    } else { // 바로구매
        f.sw_direct.value = 1;
    }

    // 판매가격이 0 보다 작다면
    if (document.getElementById("it_price").value < 0) {
        alert("전화로 문의해 주시면 감사하겠습니다.");
        return false;
    }

    if($(".sit_opt_list").length < 1) {
        alert("상품의 선택옵션을 선택해 주십시오.");
        return false;
    }

    var val, io_type, result = true;
    var sum_qty = 0;
    var min_qty = parseInt(<?php echo $it['it_buy_min_qty']; ?>);
    var max_qty = parseInt(<?php echo $it['it_buy_max_qty']; ?>);
    var $el_type = $("input[name^=io_type]");

    $("input[name^=ct_qty]").each(function(index) {
        val = $(this).val();

        if(val.length < 1) {
            alert("수량을 입력해 주십시오.");
            result = false;
            return false;
        }

        if(val.replace(/[0-9]/g, "").length > 0) {
            alert("수량은 숫자로 입력해 주십시오.");
            result = false;
            return false;
        }

        if(parseInt(val.replace(/[^0-9]/g, "")) < 1) {
            alert("수량은 1이상 입력해 주십시오.");
            result = false;
            return false;
        }

        io_type = $el_type.eq(index).val();
        if(io_type == "0")
            sum_qty += parseInt(val);
    });

    if(!result) {
        return false;
    }

    if(min_qty > 0 && sum_qty < min_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(min_qty))+"개 이상 주문해 주십시오.");
        return false;
    }

    if(max_qty > 0 && sum_qty > max_qty) {
        alert("선택옵션 개수 총합 "+number_format(String(max_qty))+"개 이하로 주문해 주십시오.");
        return false;
    }

    return true;
}
</script>
<?php /* 2017 리뉴얼한 테마 적용 스크립트입니다. 기존 스크립트를 오버라이드 합니다. */ ?>
<script src="<?php echo G5_JS_URL; ?>/shop.override.js"></script>
