<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 폴더내 style.css 파일
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/rb.layout_hd/'.$rb_core['layout_hd'].'/style.css?ver='.G5_TIME_YMDHIS.'">', 0);

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
                        <a href="<?php echo G5_URL ?>" alt="<?php echo $config['cf_title']; ?>">
                           
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

                        </a>
                        
                    </li>
                </ul>
                <!-- } -->
                

                <!-- 퀵메뉴 { -->
                <ul class="snb_wrap">
                    <li class="qm_wrap">
                      
                        <?php if($is_member) { ?>
                        
                        <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" id="ol_after_scrap" class="win_scrap" alt="스크랩">
                            
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12.8683 0.586248C12.5278 0.245586 12.0759 0.0392126 11.5955 0.00504274C11.1151 -0.0291271 10.6385 0.111202 10.2533 0.400248L7.34029 2.58525C6.13019 3.49303 4.7108 4.08115 3.21329 4.29525L1.03629 4.60525C0.306288 4.71025 -0.228712 5.49625 0.123288 6.26725C0.454288 6.99025 1.50829 8.89625 4.48329 11.9872L0.305288 16.1652C0.209778 16.2575 0.133596 16.3678 0.0811869 16.4898C0.0287779 16.6118 0.00119157 16.7431 3.77567e-05 16.8758C-0.00111606 17.0086 0.0241857 17.1403 0.0744666 17.2632C0.124747 17.3861 0.199001 17.4977 0.292893 17.5916C0.386786 17.6855 0.498438 17.7598 0.621334 17.8101C0.744231 17.8604 0.87591 17.8857 1.00869 17.8845C1.14147 17.8833 1.27269 17.8558 1.39469 17.8033C1.5167 17.7509 1.62704 17.6748 1.71929 17.5792L5.89729 13.4012C8.98829 16.3762 10.8943 17.4302 11.6173 17.7612C12.3873 18.1132 13.1743 17.5782 13.2783 16.8482L13.5893 14.6712C13.8034 13.1737 14.3915 11.7543 15.2993 10.5442L17.4833 7.63125C17.7723 7.24602 17.9127 6.76942 17.8785 6.28902C17.8443 5.80862 17.6379 5.35669 17.2973 5.01625L12.8673 0.586248H12.8683ZM11.4533 2.00125L15.8833 6.43125L13.6993 9.34525C12.5898 10.8242 11.871 12.559 11.6093 14.3892L11.4663 15.3902C10.4863 14.7662 8.86329 13.5532 6.59729 11.2872C4.33329 9.02125 3.11929 7.39925 2.49529 6.41925L3.49529 6.27625C5.3259 6.01471 7.06103 5.29589 8.54029 4.18625L11.4533 2.00125Z" fill="black"/>
                            </svg>

                        </a>
                        
                        
                        <a href="<?php echo G5_BBS_URL ?>/memo.php" alt="쪽지" onclick="win_memo(this.href); return false;">
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
                            <button type="button" alt="마이페이지" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_URL; ?>/rb/home.php?mb_id=<?php echo $member['mb_id']; ?>';">My</button>
                        <?php } else { ?>
                            <button type="button" alt="로그인" class="btn_round"  onclick="location.href='<?php echo G5_BBS_URL ?>/login.php?url=<?php echo urlencode(getCurrentUrl()); ?>';">로그인</button>
                            <button type="button" alt="회원가입" class="btn_round arr_bg font-B" onclick="location.href='<?php echo G5_BBS_URL ?>/register.php';">회원가입</button>
                        <?php } ?>
                    </li>
                    
                    <div class="cb"></li>
                </ul>
                <!-- } -->
                
                <div class="mobile_cb"></div>
                
                <!-- 검색 { -->
                <ul class="search_top_wrap">
                    <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
                        <div class="search_top_wrap_inner">
                        <input type="hidden" name="sfl" value="wr_subject||wr_content">
                        <input type="hidden" name="sop" value="and">

                        <input type="text" value="" name="stx" class="font-B" placeholder="통합검색" maxlength="20">
                        <button type="submit">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.49928 1.91687e-08C7.14387 0.000115492 5.80814 0.324364 4.60353 0.945694C3.39893 1.56702 2.36037 2.46742 1.57451 3.57175C0.788656 4.67609 0.278287 5.95235 0.0859852 7.29404C-0.106316 8.63574 0.0250263 10.004 0.469055 11.2846C0.913084 12.5652 1.65692 13.7211 2.63851 14.6557C3.6201 15.5904 4.81098 16.2768 6.11179 16.6576C7.4126 17.0384 8.78562 17.1026 10.1163 16.8449C11.447 16.5872 12.6967 16.015 13.7613 15.176L17.4133 18.828C17.6019 19.0102 17.8545 19.111 18.1167 19.1087C18.3789 19.1064 18.6297 19.0012 18.8151 18.8158C19.0005 18.6304 19.1057 18.3796 19.108 18.1174C19.1102 17.8552 19.0094 17.6026 18.8273 17.414L15.1753 13.762C16.1633 12.5086 16.7784 11.0024 16.9504 9.41573C17.1223 7.82905 16.8441 6.22602 16.1475 4.79009C15.4509 3.35417 14.3642 2.14336 13.0116 1.29623C11.659 0.449106 10.0952 -0.000107143 8.49928 1.91687e-08ZM1.99928 8.5C1.99928 6.77609 2.6841 5.12279 3.90308 3.90381C5.12207 2.68482 6.77537 2 8.49928 2C10.2232 2 11.8765 2.68482 13.0955 3.90381C14.3145 5.12279 14.9993 6.77609 14.9993 8.5C14.9993 10.2239 14.3145 11.8772 13.0955 13.0962C11.8765 14.3152 10.2232 15 8.49928 15C6.77537 15 5.12207 14.3152 3.90308 13.0962C2.6841 11.8772 1.99928 10.2239 1.99928 8.5Z" fill="#09244B"/>
                            </svg>
                        </button>
                        </div>
                    </form>
                    
                        <script>
                            function fsearchbox_submit(f) //검색
                            {
                                var stx = f.stx.value.trim();
                                if (stx.length < 2) {
                                    alert("검색어는 두글자 이상 입력해주세요.");
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
                                    alert("빠른 검색을 위해 공백은 한번만 입력할 수 있어요.");
                                    f.stx.select();
                                    f.stx.focus();
                                    return false;
                                }
                                f.stx.value = stx;

                                return true;
                            }
                            
                            
                        </script>
                </ul>
                <!-- } -->
                
                <div class="cb"></div>
            </div>
            
            <div class="rows_gnb_wrap">
                <div class="inner row_gnbs" style="width:<?php echo $tb_width_inner ?>; <?php echo $tb_width_padding ?>">
                    <nav id="cbp-hrmenu" class="cbp-hrmenu pc">
                        <ul>
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
                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>
        <!-- } -->
    </header>
    <!-- } -->
