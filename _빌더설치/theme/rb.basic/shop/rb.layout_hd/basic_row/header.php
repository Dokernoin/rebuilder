<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 폴더내 style.css 파일
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_SHOP_URL.'/rb.layout_hd/'.$rb_core['layout_hd_shop'].'/style.css?ver='.G5_TIME_YMDHIS.'">', 0);

?>
    <!--
    <header id="header">내용</header>
    <header>는 반드시 포함해주세요.
    -->

    <!-- 헤더 { -->
    <header id="header">
       
        <!-- GNB { -->
        <div class="gnb_wrap">
            
            <div class="inner" style="width:<?php echo $tb_width_inner ?>; <?php echo $tb_width_padding ?>">
               
                <!-- 토글메뉴 { -->
                <ul class="tog_wrap mobile">
                    <li>
                        <button type="button" alt="메뉴열기" id="tog_gnb_mobile">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 14C17.2549 14.0003 17.5 14.0979 17.6854 14.2728C17.8707 14.4478 17.9822 14.687 17.9972 14.9414C18.0121 15.1958 17.9293 15.4464 17.7657 15.6418C17.6021 15.8373 17.3701 15.9629 17.117 15.993L17 16H1C0.74512 15.9997 0.499968 15.9021 0.314632 15.7272C0.129296 15.5522 0.017765 15.313 0.00282788 15.0586C-0.0121092 14.8042 0.0706746 14.5536 0.234265 14.3582C0.397855 14.1627 0.629904 14.0371 0.883 14.007L1 14H17ZM17 7C17.2652 7 17.5196 7.10536 17.7071 7.29289C17.8946 7.48043 18 7.73478 18 8C18 8.26522 17.8946 8.51957 17.7071 8.70711C17.5196 8.89464 17.2652 9 17 9H1C0.734784 9 0.48043 8.89464 0.292893 8.70711C0.105357 8.51957 0 8.26522 0 8C0 7.73478 0.105357 7.48043 0.292893 7.29289C0.48043 7.10536 0.734784 7 1 7H17ZM17 0C17.2652 0 17.5196 0.105357 17.7071 0.292893C17.8946 0.48043 18 0.734784 18 1C18 1.26522 17.8946 1.51957 17.7071 1.70711C17.5196 1.89464 17.2652 2 17 2H1C0.734784 2 0.48043 1.89464 0.292893 1.70711C0.105357 1.51957 0 1.26522 0 1C0 0.734784 0.105357 0.48043 0.292893 0.292893C0.48043 0.105357 0.734784 0 1 0H17Z" fill="#09244B"/>
                            </svg>
                        </button>
                        
                        <script>
                            $(document).ready(function() {
                                $('#tog_gnb_mobile').click(function() {
                                    $('#cbp-hrmenu-btm').addClass('active');
                                    $('#m_gnb_close_btn').addClass('active');
                                    $('main').addClass('moves');
                                    $('header').addClass('moves');
                                });
                            });
                        </script>
                    </li>
                </ul>
                <!-- } -->
                
                <!-- 로고 { -->
                <ul class="logo_wrap">
                    <li>
                        <a href="<?php echo G5_SHOP_URL ?>" alt="<?php echo $config['cf_title']; ?>">
                           
                            <picture id="logo_img">
                               
                                <?php if (!empty($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w'])) { ?>
                                    <source id="sourceSmall" srcset="<?php echo G5_URL ?>/data/logos/mo?ver=<?php echo G5_SERVER_TIME ?>" media="(max-width: 1024px)">
                                <?php } else { ?>
                                    <source id="sourceSmall" srcset="<?php echo G5_THEME_URL ?>/rb.img/logos/mo.png?ver=<?php echo G5_SERVER_TIME ?>" media="(max-width: 1024px)">
                                <?php } ?>
                                
                                <?php if (!empty($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w'])) { ?>
                                    <source id="sourceLarge" srcset="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" media="(min-width: 1025px)">
                                <?php } else { ?>
                                    <source id="sourceLarge" srcset="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" media="(max-width: 1024px)">
                                <?php } ?>
                                
                                <?php if (!empty($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w'])) { ?>
                                    <img id="fallbackImage" src="<?php echo G5_URL ?>/data/logos/pc?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" class="responsive-image">
                                <?php } else { ?>
                                    <img id="fallbackImage" src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc.png?ver=<?php echo G5_SERVER_TIME ?>" alt="<?php echo $config['cf_title']; ?>" class="responsive-image">
                                <?php } ?>
                                
                            </picture>
                            <!--
                            <span class="font-B font-16">마켓</span>
                            -->
                        </a>
                        
                    </li>
                </ul>
                <!-- } -->
                

                <!-- 퀵메뉴 { -->
                <ul class="snb_wrap">
                    <li class="qm_wrap">
                      
                        <button type="button" alt="검색" class="mobile" onclick="location.href='<?php echo G5_SHOP_URL ?>/search.php';" style="padding-left:0px;" title="검색">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B"/>
                            </svg>
                        </button>
                        


                        
                        <a href="<?php echo G5_SHOP_URL ?>/cart.php" alt="장바구니" class="top_cart_svg pc" title="장바구니">
                            
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 17C5.89782 17 6.27936 17.158 6.56066 17.4393C6.84196 17.7206 7 18.1022 7 18.5C7 18.8978 6.84196 19.2794 6.56066 19.5607C6.27936 19.842 5.89782 20 5.5 20C5.10218 20 4.72064 19.842 4.43934 19.5607C4.15804 19.2794 4 18.8978 4 18.5C4 18.1022 4.15804 17.7206 4.43934 17.4393C4.72064 17.158 5.10218 17 5.5 17ZM15.5 17C15.8978 17 16.2794 17.158 16.5607 17.4393C16.842 17.7206 17 18.1022 17 18.5C17 18.8978 16.842 19.2794 16.5607 19.5607C16.2794 19.842 15.8978 20 15.5 20C15.1022 20 14.7206 19.842 14.4393 19.5607C14.158 19.2794 14 18.8978 14 18.5C14 18.1022 14.158 17.7206 14.4393 17.4393C14.7206 17.158 15.1022 17 15.5 17ZM1.138 0C1.89654 9.04185e-05 2.62689 0.287525 3.18203 0.804444C3.73717 1.32136 4.07589 2.02939 4.13 2.786L4.145 3H17.802C18.095 2.99996 18.3844 3.06429 18.6498 3.18844C18.9152 3.31259 19.15 3.49354 19.3378 3.71848C19.5255 3.94342 19.6615 4.20686 19.7362 4.49017C19.8109 4.77348 19.8224 5.06974 19.77 5.358L18.133 14.358C18.0492 14.8188 17.8062 15.2356 17.4466 15.5357C17.0869 15.8357 16.6334 16.0001 16.165 16H4.931C4.42514 16 3.93807 15.8083 3.56789 15.4636C3.1977 15.1188 2.97192 14.6466 2.936 14.142L2.136 2.929C2.11802 2.67645 2.00492 2.44012 1.81951 2.2677C1.6341 2.09528 1.39019 1.99961 1.137 2H1C0.734784 2 0.48043 1.89464 0.292893 1.70711C0.105357 1.51957 0 1.26522 0 1C0 0.734784 0.105357 0.48043 0.292893 0.292893C0.48043 0.105357 0.734784 0 1 0H1.138ZM17.802 5H4.288L4.931 14H16.165L17.802 5Z" fill="#09244B"/>
                            </svg>

                        </a>
                        
                        <a href="<?php echo G5_SHOP_URL ?>/orderinquiry.php" alt="주문조회" class="pc" title="주문조회">
                            
                            
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13.586 0C14.1164 0.000113275 14.625 0.210901 15 0.586L17.414 3C17.7891 3.37499 17.9999 3.88361 18 4.414V16C18 16.7956 17.6839 17.5587 17.1213 18.1213C16.5587 18.6839 15.7956 19 15 19H3C2.20435 19 1.44129 18.6839 0.87868 18.1213C0.316071 17.5587 0 16.7956 0 16V4.414C0.000113275 3.88361 0.210901 3.37499 0.586 3L3 0.586C3.37499 0.210901 3.88361 0.000113275 4.414 0H13.586ZM16 6H2V16C2 16.2652 2.10536 16.5196 2.29289 16.7071C2.48043 16.8946 2.73478 17 3 17H15C15.2652 17 15.5196 16.8946 15.7071 16.7071C15.8946 16.5196 16 16.2652 16 16V6ZM12 8C12.2652 8 12.5196 8.10536 12.7071 8.29289C12.8946 8.48043 13 8.73478 13 9C13 10.0609 12.5786 11.0783 11.8284 11.8284C11.0783 12.5786 10.0609 13 9 13C7.93913 13 6.92172 12.5786 6.17157 11.8284C5.42143 11.0783 5 10.0609 5 9C5 8.73478 5.10536 8.48043 5.29289 8.29289C5.48043 8.10536 5.73478 8 6 8C6.26522 8 6.51957 8.10536 6.70711 8.29289C6.89464 8.48043 7 8.73478 7 9C6.99768 9.51898 7.19719 10.0185 7.55638 10.3932C7.91557 10.7678 8.40632 10.9881 8.92494 11.0075C9.44356 11.027 9.94945 10.8441 10.3357 10.4975C10.722 10.1509 10.9584 9.6677 10.995 9.15L11 9C11 8.73478 11.1054 8.48043 11.2929 8.29289C11.4804 8.10536 11.7348 8 12 8ZM13.586 2H4.414L2.414 4H15.586L13.586 2Z" fill="#09244B"/>
                            </svg>


                        </a>
                        
                        <a href="<?php echo G5_SHOP_URL ?>/wishlist.php" alt="위시리스트" class="top_cart_svg pc" title="위시리스트">
                            <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.00037 0C10.0612 0 11.0787 0.421427 11.8288 1.17157C12.5789 1.92172 13.0004 2.93913 13.0004 4H15.0354C15.5536 3.99993 16.0515 4.20099 16.4244 4.56081C16.7973 4.92064 17.016 5.41114 17.0344 5.929L17.4624 17.929C17.4719 18.1974 17.4273 18.4649 17.3312 18.7157C17.2351 18.9665 17.0894 19.1953 16.903 19.3886C16.7165 19.5819 16.493 19.7356 16.2459 19.8407C15.9987 19.9457 15.7329 19.9999 15.4644 20H2.53637C2.26781 19.9999 2.00202 19.9457 1.75486 19.8407C1.5077 19.7356 1.28422 19.5819 1.09776 19.3886C0.911293 19.1953 0.765666 18.9665 0.669559 18.7157C0.573453 18.4649 0.528836 18.1974 0.53837 17.929L0.96637 5.929C0.984766 5.41114 1.20344 4.92064 1.57632 4.56081C1.9492 4.20099 2.44719 3.99993 2.96537 4H5.00037C5.00037 2.93913 5.4218 1.92172 6.17194 1.17157C6.92209 0.421427 7.9395 0 9.00037 0ZM5.00037 6H2.96537L2.53637 18H15.4644L15.0354 6H13.0004V7C13.0001 7.25488 12.9025 7.50003 12.7275 7.68537C12.5526 7.8707 12.3134 7.98224 12.059 7.99717C11.8045 8.01211 11.554 7.92933 11.3585 7.76574C11.1631 7.60215 11.0375 7.3701 11.0074 7.117L11.0004 7V6H7.00037V7C7.00009 7.25488 6.90249 7.50003 6.72752 7.68537C6.55255 7.8707 6.31342 7.98224 6.05898 7.99717C5.80453 8.01211 5.55399 7.92933 5.35854 7.76574C5.16308 7.60215 5.03747 7.3701 5.00737 7.117L5.00037 7V6ZM9.00037 2C8.49579 1.99984 8.0098 2.19041 7.63982 2.5335C7.26984 2.87659 7.04321 3.34684 7.00537 3.85L7.00037 4H11.0004C11.0004 3.46957 10.7897 2.96086 10.4146 2.58579C10.0395 2.21071 9.5308 2 9.00037 2Z" fill="#09244B"/>
                            </svg>
                        </a>
                        
                        <a href="<?php echo G5_SHOP_URL ?>/couponzone.php" alt="쿠폰존" class="top_cart_svg pc" title="쿠폰존">
                            
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.85022 0.356702C9.25397 0.319966 9.66098 0.365447 10.0467 0.4904C10.4324 0.615352 10.7887 0.817183 11.0942 1.0837L11.2442 1.2237L19.0662 9.0467C19.6045 9.58512 19.918 10.3081 19.9431 11.069C19.9681 11.83 19.7029 12.572 19.2012 13.1447L19.0662 13.2887L13.4092 18.9457C12.8708 19.484 12.1478 19.7975 11.3869 19.8225C10.6259 19.8476 9.8839 19.5824 9.31122 19.0807L9.16722 18.9457L1.34322 11.1227C1.05669 10.8362 0.831178 10.4946 0.680278 10.1186C0.529377 9.74252 0.456219 9.3398 0.465217 8.9347L0.476218 8.7297L0.948217 3.5447C1.00882 2.87649 1.29167 2.24787 1.75157 1.75933C2.21147 1.27078 2.82187 0.950511 3.48522 0.849702L3.66422 0.828702L8.85022 0.356702ZM9.15822 2.3457L9.03122 2.3487L3.84622 2.8207C3.63358 2.8399 3.43266 2.92665 3.27288 3.06827C3.1131 3.20988 3.00283 3.39891 2.95822 3.6077L2.94122 3.7257L2.46922 8.9107C2.44649 9.16266 2.5201 9.41386 2.67522 9.6137L2.75822 9.7087L10.5812 17.5317C10.7534 17.7039 10.9825 17.8073 11.2255 17.8226C11.4686 17.8379 11.7088 17.764 11.9012 17.6147L11.9952 17.5317L17.6522 11.8747C17.8244 11.7025 17.9278 11.4734 17.9431 11.2304C17.9584 10.9874 17.8845 10.7471 17.7352 10.5547L17.6522 10.4607L9.82922 2.6377C9.65048 2.45909 9.41074 2.35476 9.15822 2.3457ZM5.63022 5.5107C5.90882 5.2321 6.23956 5.01111 6.60357 4.86033C6.96758 4.70955 7.35772 4.63195 7.75172 4.63195C8.14572 4.63195 8.53586 4.70955 8.89987 4.86033C9.26387 5.01111 9.59462 5.2321 9.87322 5.5107C10.1518 5.7893 10.3728 6.12005 10.5236 6.48405C10.6744 6.84806 10.752 7.2382 10.752 7.6322C10.752 8.0262 10.6744 8.41634 10.5236 8.78035C10.3728 9.14436 10.1518 9.4751 9.87322 9.7537C9.31056 10.3164 8.54743 10.6325 7.75172 10.6325C6.956 10.6325 6.19287 10.3164 5.63022 9.7537C5.06756 9.19105 4.75146 8.42792 4.75146 7.6322C4.75146 6.83648 5.06756 6.07336 5.63022 5.5107ZM8.45922 6.9247C8.36637 6.83179 8.25614 6.75808 8.13481 6.70777C8.01347 6.65746 7.88342 6.63155 7.75207 6.6315C7.62072 6.63145 7.49065 6.65728 7.36928 6.7075C7.24792 6.75772 7.13763 6.83136 7.04472 6.9242C6.95181 7.01705 6.87809 7.12728 6.82779 7.24861C6.77748 7.36995 6.75156 7.5 6.75151 7.63135C6.75147 7.7627 6.77729 7.89277 6.82752 8.01414C6.87774 8.1355 6.95137 8.24579 7.04422 8.3387C7.23173 8.52634 7.48609 8.63181 7.75136 8.6319C8.01663 8.632 8.27108 8.52671 8.45872 8.3392C8.64636 8.15169 8.75183 7.89733 8.75192 7.63206C8.75201 7.36679 8.64673 7.11234 8.45922 6.9247Z" fill="#09244B"/>
                            </svg>

                        </a>
                        
                        <?php if($is_member) { ?>
                        <a href="<?php echo G5_BBS_URL ?>/memo.php" alt="쪽지" onclick="win_memo(this.href); return false;" title="쪽지">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2715 2.33675L2.67946 6.88975L6.87446 9.31775L10.5735 5.61775C10.7611 5.43024 11.0155 5.32495 11.2808 5.32505C11.5461 5.32514 11.8005 5.43061 11.988 5.61825C12.1755 5.80589 12.2808 6.06033 12.2807 6.3256C12.2806 6.59087 12.1751 6.84524 11.9875 7.03275L8.28746 10.7328L10.7175 14.9268L15.2715 2.33675ZM15.5945 0.0927503C16.7895 -0.34025 17.9475 0.81775 17.5145 2.01275L12.2325 16.6178C11.7985 17.8158 10.1625 17.9618 9.52346 16.8587L6.30646 11.3008L0.748462 8.08375C-0.354538 7.44475 -0.208537 5.80875 0.989463 5.37475L15.5945 0.0927503Z" fill="#09244B"/>
                            </svg>
                            <?php if($memo_not_read > 0) { ?>
                            <span class="font-H"><?php echo $memo_not_read ?></span>
                            <?php } ?>
                        </a>
                        <?php } ?>

                        <div class="cb"></div>
                    </li>
                    
                    <li class="member_info_wrap">
                        <?php if($is_member) { ?>
                        <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php" class="font-B notranslate"><?php echo $member['mb_nick'] ?></a>　<a href="<?php echo G5_BBS_URL; ?>/point.php" target="_blank" class="win_point"><span class="font-H"><?php echo number_format($member['mb_point']); ?> P</span></a> 
                        <?php } ?>
                    </li>
                    <li class="my_btn_wrap">
                        <?php if($is_member) { ?>
                            <button type="button" alt="로그아웃" class="btn_round" onclick="location.href='<?php echo G5_BBS_URL ?>/logout.php';">로그아웃</button>
                            <button type="button" alt="마이페이지" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_SHOP_URL; ?>/mypage.php';">My</button>
                        <?php } else { ?>
                            <button type="button" alt="로그인" class="btn_round"  onclick="location.href='<?php echo G5_BBS_URL ?>/login.php';">로그인</button>
                            <button type="button" alt="회원가입" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_BBS_URL ?>/register.php';">회원가입</button>
                        <?php } ?>
                    </li>
                    
                    <div class="cb"></li>
                </ul>
                <!-- } -->
                
                <div class="mobile_cb"></div>
                
                <!-- 검색 { -->
                <ul class="search_top_wrap">
                   
                    <form name="frmsearch1" action="<?php echo G5_SHOP_URL; ?>/search.php" onsubmit="return search_submit(this);">
                        <div class="search_top_wrap_inner">

                        <input type="text" value="<?php echo stripslashes(get_text(get_search_string($q))); ?>" name="q" class="font-B" placeholder="상품검색" required>
                        <button type="submit">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B"/>
                            </svg>
                        </button>
                        </div>
                    </form>
                    
                        <script>
                        function search_submit(f) {
                            if (f.q.value.length < 2) {
                                alert("검색어는 두글자 이상 입력하십시오.");
                                f.q.select();
                                f.q.focus();
                                return false;
                            }
                            return true;
                        }
                        </script>
                </ul>
                <!-- } -->
                
                <div class="cb"></div>
            </div>
            
            <?php
            function get_mshop_category($ca_id, $len)
            {
                global $g5;

                $sql = " select ca_id, ca_name from {$g5['g5_shop_category_table']}
                            where ca_use = '1' ";
                if($ca_id)
                    $sql .= " and ca_id like '$ca_id%' ";
                $sql .= " and length(ca_id) = '$len' order by ca_order, ca_id ";

                return $sql;
            }
            
            $mshop_categories = get_shop_category_array(true);
            
            ?>
            
            <div class="rows_gnb_wrap">
                <div class="inner row_gnbs" style="width:<?php echo $tb_width_inner ?>; <?php echo $tb_width_padding ?>">
                    <nav id="cbp-hrmenu" class="cbp-hrmenu pc">


                        <ul>

                        <?php if (isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == 1 || isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == 2) { ?>

                            <?php
                            $mshop_ca_res1 = sql_query(get_mshop_category('', 2));
                            for($j=0; $mshop_ca_row1=sql_fetch_array($mshop_ca_res1); $j++) {
                            ?>
                                <li>
                                    <a href="<?php echo shop_category_url($mshop_ca_row1['ca_id']); ?>" class="font-B"><?php echo get_text($mshop_ca_row1['ca_name']); ?></a>
                                    <?php
                                    $mshop_ca_res2 = sql_query(get_mshop_category($mshop_ca_row1['ca_id'], 4));

                                    for($k=0; $mshop_ca_row2=sql_fetch_array($mshop_ca_res2); $k++) {
                                        if($k == 0)
                                            echo '<div class="cbp-hrsub"><div class="cbp-hrsub-inner"><div><!--<h4 class="font-B">그룹</h4>--><ul>'.PHP_EOL;
                                    ?>
                                        <li><a href="<?php echo shop_category_url($mshop_ca_row2['ca_id']); ?>"><?php echo get_text($mshop_ca_row2['ca_name']); ?></a></li>
                                    <?php
                                    }

                                    if($k > 0)
                                        echo '</div></div></div>'.PHP_EOL;
                                    ?>
                                </li>
                            <?php } ?>

                            <?php if ($j == 0) {  ?>
                            <li><a href="javascript:void(0);">등록된 카테고리가 없습니다.</a></li>
                            <?php } ?>

                        <?php } ?>



                        <?php if (isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == 2 || isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == 0 || isset($rb_core['menu_shop']) && $rb_core['menu_shop'] == "") { ?>

                            <?php
                            if(IS_MOBILE()) {
                                $menu_datas = get_menu_db(1, true);
                            } else {
                                $menu_datas = get_menu_db(0, true);
                            }

                            $gnb_zindex = 999; // gnb_1dli z-index 값 설정용
                            $i = 0;
                            foreach ($menu_datas as $row) {
                                if (empty($row)) continue;

                                // 1차 메뉴 권한 체크
                                if (!$is_admin && isset($row['me_level']) && $row['me_level'] > 0) {
                                    if (isset($row['me_level_opt']) && $row['me_level_opt'] == 2) {
                                        if ($row['me_level'] != $member['mb_level']) continue;
                                    } else {
                                        if ($row['me_level'] > $member['mb_level']) continue;
                                    }
                                }
                            ?>
                                <li>
                                    <a href="<?php echo $row['me_link']; ?>" target="_<?php echo $row['me_target']; ?>" class="font-B"><?php echo $row['me_name'] ?></a>
                                    <?php
                                    $k = 0;
                                    foreach ((array) $row['sub'] as $row2) {
                                        if (empty($row2)) continue;

                                        // 2차 메뉴 권한 체크
                                        if (!$is_admin && isset($row2['me_level']) && $row2['me_level'] > 0) {
                                            if (isset($row2['me_level_opt']) && $row2['me_level_opt'] == 2) {
                                                if ($row2['me_level'] != $member['mb_level']) continue;
                                            } else {
                                                if ($row2['me_level'] > $member['mb_level']) continue;
                                            }
                                        }

                                        if ($k == 0)
                                            echo '<div class="cbp-hrsub"><div class="cbp-hrsub-inner"><div><!--<h4 class="font-B">그룹</h4>--><ul>' . PHP_EOL;
                                    ?>
                                        <li><a href="<?php echo $row2['me_link']; ?>" target="_<?php echo $row2['me_target']; ?>"><?php echo $row2['me_name'] ?></a></li>
                                    <?php
                                        $k++;
                                    }

                                    if ($k > 0)
                                        echo '</ul></div></div></div>' . PHP_EOL;
                                    ?>
                                </li>
                            <?php
                                $i++;
                            }

                            if ($i == 0) {
                            ?>
                                <li><a href="javascript:void(0);">메뉴 준비 중입니다.</a></li>
                            <?php } ?>

                        <?php } ?>
                        

                        <li class="gnb_all_menu">
                            <a href="#" class="font-R">전체분류 보기</a>
                            <div class="cbp-hrsub">
                                <div class="cbp-hrsub-inner">
                                    <?php
                                    $k = 0;
                                    foreach($mshop_categories as $cate1){
                                        if( empty($cate1) ) continue;

                                        $mshop_ca_row1 = $cate1['text'];
                                        //if($i == 0)
                                            //echo '<ul class="cate">'.PHP_EOL;
                                    ?>
                                    <div>
                                        <h4 class="font-B" onclick="location.href='<?php echo $mshop_ca_row1['url']; ?>';"><?php echo get_text($mshop_ca_row1['ca_name']); ?></h4>
                                        <?php
                                        $h=0;
                                        foreach($cate1 as $key=>$cate2){
                                            if( empty($cate2) || $key === 'text' ) continue;

                                            $mshop_ca_row2 = $cate2['text'];
                                            if($h == 0)
                                                echo '<ul>'.PHP_EOL;
                                        ?>
                                        
                                            <li>
                                            <a href="<?php echo $mshop_ca_row2['url']; ?>" class="<?php if($ca_id == $mshop_ca_row2['ca_id']) { ?>dp2_active<?php } ?>"><?php echo get_text($mshop_ca_row2['ca_name']); ?></a>
                                                <?php
                                                $s=0;
                                                foreach($cate2 as $key=>$cate3){
                                                    if( empty($cate3) || $key === 'text' ) continue;

                                                    $mshop_ca_row3 = $cate3['text'];
                                                    if($s == 0)
                                                        echo '<dl>'.PHP_EOL;
                                                ?>
                                                <dd><a href="<?php echo $mshop_ca_row3['url']; ?>" class="font-R <?php if($ca_id == $mshop_ca_row3['ca_id']) { ?>dp3_active<?php } ?>"><?php echo get_text($mshop_ca_row3['ca_name']); ?></a></dd>
                                                <?php
                                                $s++;
                                                }

                                                if($s > 0)
                                                    echo '<dd class="dp3_none"><a href="javascript:void(0);" class="font-R"></a></dd></dl>'.PHP_EOL;
                                                ?>
                                            </li>
                                        <?php
                                        $h++;
                                        }

                                        if($h > 0)
                                            echo '</ul>'.PHP_EOL;
                                        ?>
                                    </div>
                                    <?php
                                    $k++;
                                    }   // end for

                                    if($k == 0)
                                        echo '등록된 분류가 없습니다.'.PHP_EOL;
                                    ?>
                                </div>


                            </div>
                        </li>

                        
                        </ul>
                        
                        
                    </nav>
                </div>
            </div>
            
        </div>
        <!-- } -->
    </header>
    <!-- } -->
