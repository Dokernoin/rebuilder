<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 폴더내 style.css 파일
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_SHOP_URL.'/rb.layout_ft/'.$rb_core['layout_ft_shop'].'/style.css">', 0);

?>


    <!--
    <footer>내용</footer>
    <footer>는 반드시 포함해주세요.
    -->
    
    <footer>
        <div class="footer_gnb">
            <div class="inner" style="width:<?php echo $tb_width_inner ?>; <?php echo $tb_width_padding ?>">
                <ul class="footer_gnb_ul1 pc">
                    <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스 이용약관</a>
                    <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보 처리방침</a>
                </ul>
                <ul class="footer_gnb_ul2">
                    <?php if(defined('G5_COMMUNITY_USE') == false || G5_COMMUNITY_USE) { ?>
                    <a href="<?php echo G5_URL ?>">커뮤니티</a>
                    <?php } ?>
                    <a href="<?php echo G5_SHOP_URL ?>/personalpay.php">개인결제</a>
                    <a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1 문의</a>
                    <a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a>
                    <a href="<?php echo G5_URL ?>/rb/new.php">새글</a>
                    <a href="<?php echo G5_BBS_URL ?>/current_connect.php">접속자 <?php echo connect("theme/rb.connect"); ?></a>
                </ul>
                <div class="cb"></div>
            </div>
        </div>
        <div class="footer_copy" style="padding-bottom:120px;">
            <div class="inner" style="width:<?php echo $tb_width_inner ?>; <?php echo $tb_width_padding ?>">
                <ul class="footer_copy_ul1">
                    <li class="footer_copy_ul1_li1">
                       
                        <?php if (!empty($rb_builder['bu_logo_pc_w'])) { ?>
                            <a href="#"><img src="<?php echo G5_URL ?>/data/logos/pc_w?ver=<?php echo G5_SERVER_TIME ?>"></a>
                        <?php } else { ?>
                            <a href="#"><img src="<?php echo G5_THEME_URL ?>/rb.img/logos/pc_w.png?ver=<?php echo G5_SERVER_TIME ?>"></a>
                        <?php } ?>
                        
                        <div class="mobile">
                            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스 이용약관</a>
                            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보 처리방침</a>
                        </div>

                    </li>
                    <li class="footer_copy_ul1_li2">
                        <?php if (!empty($rb_builder['bu_1'])) { ?><dd><?php echo $rb_builder['bu_1'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_2'])) { ?><dd>대표자 : <?php echo $rb_builder['bu_2'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_3'])) { ?><dd>대표전화 : <?php echo $rb_builder['bu_3'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_4'])) { ?><dd>팩스 : <?php echo $rb_builder['bu_4'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_5'])) { ?><dd>사업자등록번호 : <?php echo $rb_builder['bu_5'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_6'])) { ?><dd>통신판매업신고번호 : <?php echo $rb_builder['bu_6'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_7'])) { ?><dd>부가통신사업자번호 : <?php echo $rb_builder['bu_7'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_8'])) { ?><dd><?php echo $rb_builder['bu_8'] ?><?php } ?></dd>
                        <?php if (!empty($rb_builder['bu_10'])) { ?><dd>주소 : <?php if (!empty($rb_builder['bu_9'])) { ?>(<?php echo $rb_builder['bu_9'] ?>) <?php } ?> <?php echo $rb_builder['bu_10'] ?></dd><?php } ?>
                        <?php if (!empty($rb_builder['bu_11'])) { ?><dd>개인정보책임자(이메일) : <?php echo $rb_builder['bu_11'] ?></dd><?php } ?>
                        <div class="cb"></div>
                    </li>
                    
                    <?php if (!empty($rb_builder['bu_12'])) { ?>
                    <li class="footer_copy_ul1_li3">
                       <?php echo $rb_builder['bu_12'] ?>
                    </li>
                    <?php } ?>
                    
                </ul>
                <ul class="footer_copy_ul2">
                   
                    <?php if (!empty($rb_builder['bu_sns1'])) { ?><a href="<?php echo $rb_builder['bu_sns1'] ?>" target="_blank" class="footer_sns_ico" title="카카오 공식채널 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_kakaoch.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns2'])) { ?><a href="<?php echo $rb_builder['bu_sns2'] ?>" target="_blank" class="footer_sns_ico" title="카카오 채팅상담"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_kakaoch_chat.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns3'])) { ?><a href="<?php echo $rb_builder['bu_sns3'] ?>" target="_blank" class="footer_sns_ico" title="유튜브 공식채널 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_youtube.png"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns4'])) { ?><a href="<?php echo $rb_builder['bu_sns4'] ?>" target="_blank" class="footer_sns_ico" title="인스타그램 공식채널 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_instagram.png"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns5'])) { ?><a href="<?php echo $rb_builder['bu_sns5'] ?>" target="_blank" class="footer_sns_ico" title="페이스북 공식채널 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_facebook.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns6'])) { ?><a href="<?php echo $rb_builder['bu_sns6'] ?>" target="_blank" class="footer_sns_ico" title="트위터 공식채널 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_twitter.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns7'])) { ?><a href="<?php echo $rb_builder['bu_sns7'] ?>" target="_blank" class="footer_sns_ico" title="네이버블로그 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_naverblog.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns8'])) { ?><a href="<?php echo $rb_builder['bu_sns8'] ?>" target="_blank" class="footer_sns_ico" title="텔레그램 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_telegram.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns9'])) { ?><a href="<?php echo $rb_builder['bu_sns9'] ?>" target="_blank" class="footer_sns_ico" title="SIR 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_sir.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns10'])) { ?><a href="<?php echo $rb_builder['bu_sns10'] ?>" target="_blank" class="footer_sns_ico" title="공식채널 바로가기"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_links.svg"></a><?php } ?>

                   
                   
         
                    <?php if(isset($app['ap_btn_is']) && $app['ap_btn_is'] == 1 && isset($app['ap_title']) && $app['ap_title']) { ?>
                    <br><br><br>
                    
                    <?php if(isset($app['ap_btn_url']) && $app['ap_btn_url']) { ?>
                    <button type="button" class="footer_btn" onclick="window.open('<?php echo isset($app['ap_btn_url']) ? $app['ap_btn_url'] : ''; ?>');">
                        <i><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_android.svg"></i>
                        <span>공식 앱 다운로드</span>
                        <div class="cb"></div>
                    </button>
                    <?php } else { ?>
                    
                        <?php if(isset($config['cf_kakao_js_apikey']) && $config['cf_kakao_js_apikey']) { ?>
                        <button type="button" class="footer_btn" onclick="javascript:appLink()">
                            <i><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_android.svg"></i>
                            <span>공식 앱 다운로드</span>
                            <div class="cb"></div>
                        </button>
                        <?php } else { ?>
                        <button type="button" class="footer_btn" onclick="javascript:alert('관리자모드 > 환경설정 > 카카오자바스크립트키가 없습니다.');">
                            <i><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/icon_android.svg"></i>
                            <span>공식 앱 다운로드</span>
                            <div class="cb"></div>
                        </button>
                        <?php } ?>
                        
                    <?php } ?>
                   
                    <script src="//developers.kakao.com/sdk/js/kakao.min.js" charset="utf-8"></script>
                    <script src="<?php echo G5_JS_URL; ?>/kakaolink.js" charset="utf-8"></script>
                    <script>
                        //카카오 javascript 키를 넣어주세요.
                        //완경설정 > 기본환경설정 > SNS > 카카오 JavaScript 키
                        Kakao.init("<?php echo $config['cf_kakao_js_apikey']; ?>");
                    </script>
                    

                    
                    <script type='text/javascript'>
                        //<![CDATA[
                        function appLink() {

                            var webUrl = location.protocol + "<?php echo '//'.$_SERVER['HTTP_HOST'].'/app/app.apk'; ?>",
                                imageUrl = '<?php echo G5_URL ?>/data/seo/og_image' || '';

                            Kakao.Link.sendDefault({
                                objectType: 'feed',

                                content: {
                                    title: "공식 앱 다운로드",
                                    description: "공식앱으로 다양한 혜택과 알림, 놓치지마세요!",
                                    imageUrl: imageUrl,
                                    link: {
                                        mobileWebUrl: webUrl,
                                        webUrl: webUrl
                                    }
                                },

                                buttons: [{
                                    title: '다운로드 받기',
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
             
                    
                    
                    
                </ul>
                <div class="cb"></div>
            </div>
        </div>
    </footer>



    <div class="tail_fixed_gnb mobile main_rb_bg">
        <button type="button" onclick="location.href='<?php echo G5_SHOP_URL ?>/cart.php';" title="장바구니">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_526_6)">
            <path d="M7.5 19C7.89782 19 8.27936 19.158 8.56066 19.4393C8.84196 19.7206 9 20.1022 9 20.5C9 20.8978 8.84196 21.2794 8.56066 21.5607C8.27936 21.842 7.89782 22 7.5 22C7.10218 22 6.72064 21.842 6.43934 21.5607C6.15804 21.2794 6 20.8978 6 20.5C6 20.1022 6.15804 19.7206 6.43934 19.4393C6.72064 19.158 7.10218 19 7.5 19ZM17.5 19C17.8978 19 18.2794 19.158 18.5607 19.4393C18.842 19.7206 19 20.1022 19 20.5C19 20.8978 18.842 21.2794 18.5607 21.5607C18.2794 21.842 17.8978 22 17.5 22C17.1022 22 16.7206 21.842 16.4393 21.5607C16.158 21.2794 16 20.8978 16 20.5C16 20.1022 16.158 19.7206 16.4393 19.4393C16.7206 19.158 17.1022 19 17.5 19ZM3 2C4.726 2 6.023 3.283 6.145 5H19.802C20.095 4.99996 20.3844 5.06429 20.6498 5.18844C20.9152 5.31259 21.15 5.49354 21.3378 5.71848C21.5255 5.94342 21.6615 6.20686 21.7362 6.49017C21.8109 6.77348 21.8224 7.06974 21.77 7.358L20.133 16.358C20.0492 16.8188 19.8062 17.2356 19.4466 17.5357C19.0869 17.8357 18.6334 18.0001 18.165 18H6.931C6.42514 18 5.93807 17.8083 5.56789 17.4636C5.1977 17.1188 4.97192 16.6466 4.936 16.142L4.136 4.929C4.09 4.31 3.564 4 3 4C2.73478 4 2.48043 3.89464 2.29289 3.70711C2.10536 3.51957 2 3.26522 2 3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2Z" fill="white"/>
            </g>
            <defs>
            <clipPath id="clip0_526_6">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
        </button>
        
        <button type="button" onclick="location.href='<?php echo G5_SHOP_URL ?>/orderinquiry.php';" title="주문조회">

            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_655_31)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 3.586C6.37499 3.2109 6.88361 3.00011 7.414 3H16.586C17.1164 3.00011 17.625 3.2109 18 3.586L20.414 6C20.7891 6.37499 20.9999 6.88361 21 7.414V19C21 19.7956 20.6839 20.5587 20.1213 21.1213C19.5587 21.6839 18.7956 22 18 22H6C5.20435 22 4.44129 21.6839 3.87868 21.1213C3.31607 20.5587 3 19.7956 3 19V7.414C3.00011 6.88361 3.2109 6.37499 3.586 6L6 3.586ZM16.586 5H7.414L5.414 7H18.586L16.586 5ZM10 12C10 11.7348 9.89464 11.4804 9.70711 11.2929C9.51957 11.1054 9.26522 11 9 11C8.73478 11 8.48043 11.1054 8.29289 11.2929C8.10536 11.4804 8 11.7348 8 12C8 13.0609 8.42143 14.0783 9.17157 14.8284C9.92172 15.5786 10.9391 16 12 16C13.0609 16 14.0783 15.5786 14.8284 14.8284C15.5786 14.0783 16 13.0609 16 12C16 11.7348 15.8946 11.4804 15.7071 11.2929C15.5196 11.1054 15.2652 11 15 11C14.7348 11 14.4804 11.1054 14.2929 11.2929C14.1054 11.4804 14 11.7348 14 12C14 12.5304 13.7893 13.0391 13.4142 13.4142C13.0391 13.7893 12.5304 14 12 14C11.4696 14 10.9609 13.7893 10.5858 13.4142C10.2107 13.0391 10 12.5304 10 12Z" fill="white"/>
            </g>
            <defs>
            <clipPath id="clip0_655_31">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>

        </button>
        <button type="button" onclick="location.href='<?php echo G5_SHOP_URL ?>';">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" title="홈">
            <g clip-path="url(#clip0_526_18)">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.772 2.68799C11.1231 2.41488 11.5552 2.2666 12 2.2666C12.4448 2.2666 12.8769 2.41488 13.228 2.68799L21.612 9.20799C22.365 9.79499 21.949 11 20.997 11H20V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21H5.99998C5.46955 21 4.96084 20.7893 4.58577 20.4142C4.2107 20.0391 3.99998 19.5304 3.99998 19V11H3.00298C2.04998 11 1.63598 9.79399 2.38798 9.20899L10.772 2.68799Z" fill="white"/>
            </g>
            <defs>
            <clipPath id="clip0_526_18">
            <rect width="24" height="24" fill="white"/>
            </clipPath>
            </defs>
            </svg>
        </button>
        
        
        <button type="button" onclick="location.href='<?php echo G5_SHOP_URL ?>/wishlist.php';" title="위시리스트">   
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.0004 2C13.0612 2 14.0787 2.42143 14.8288 3.17157C15.5789 3.92172 16.0004 4.93913 16.0004 6H18.0354C18.5536 5.99993 19.0515 6.20099 19.4244 6.56081C19.7973 6.92064 20.016 7.41114 20.0344 7.929L20.4624 19.929C20.4719 20.1974 20.4273 20.4649 20.3312 20.7157C20.2351 20.9665 20.0894 21.1953 19.903 21.3886C19.7165 21.5819 19.493 21.7356 19.2459 21.8407C18.9987 21.9457 18.7329 21.9999 18.4644 22H5.53637C5.26781 21.9999 5.00202 21.9457 4.75486 21.8407C4.5077 21.7356 4.28422 21.5819 4.09776 21.3886C3.91129 21.1953 3.76567 20.9665 3.66956 20.7157C3.57345 20.4649 3.52884 20.1974 3.53837 19.929L3.96637 7.929C3.98477 7.41114 4.20344 6.92064 4.57632 6.56081C4.9492 6.20099 5.44719 5.99993 5.96537 6H8.00037C8.00037 4.93913 8.4218 3.92172 9.17194 3.17157C9.92209 2.42143 10.9395 2 12.0004 2ZM10.0004 8H8.00037V9C8.00065 9.25488 8.09825 9.50003 8.27322 9.68537C8.44819 9.8707 8.68732 9.98224 8.94176 9.99717C9.19621 10.0121 9.44675 9.92933 9.6422 9.76574C9.83766 9.60215 9.96327 9.3701 9.99337 9.117L10.0004 9V8ZM16.0004 8H14.0004V9C14.0004 9.26522 14.1057 9.51957 14.2933 9.70711C14.4808 9.89464 14.7352 10 15.0004 10C15.2656 10 15.5199 9.89464 15.7075 9.70711C15.895 9.51957 16.0004 9.26522 16.0004 9V8ZM12.0004 4C11.4958 3.99984 11.0098 4.19041 10.6398 4.5335C10.2698 4.87659 10.0432 5.34684 10.0054 5.85L10.0004 6H14.0004C14.0004 5.46957 13.7897 4.96086 13.4146 4.58579C13.0395 4.21071 12.5308 4 12.0004 4Z" fill="white"/>
            </svg>
        </button>

        
        <button type="button" onclick="location.href='<?php echo G5_SHOP_URL ?>/couponzone.php';" title="쿠폰존">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.537 2.16395C10.9407 2.12722 11.3477 2.1727 11.7334 2.29765C12.1191 2.4226 12.4755 2.62443 12.781 2.89095L12.931 3.03095L20.753 10.854C21.2913 11.3924 21.6048 12.1153 21.6298 12.8763C21.6549 13.6372 21.3897 14.3793 20.888 14.952L20.753 15.096L15.096 20.753C14.5576 21.2913 13.8346 21.6047 13.0736 21.6298C12.3127 21.6549 11.5707 21.3897 10.998 20.888L10.854 20.753L3.02998 12.93C2.74346 12.6434 2.51795 12.3019 2.36705 11.9258C2.21615 11.5498 2.14299 11.147 2.15198 10.742L2.16299 10.537L2.63498 5.35195C2.69558 4.68374 2.97844 4.05512 3.43834 3.56658C3.89824 3.07803 4.50864 2.75776 5.17198 2.65695L5.35098 2.63595L10.537 2.16395ZM8.02399 8.02495C7.83823 8.21071 7.69088 8.43123 7.59035 8.67393C7.48982 8.91663 7.43808 9.17676 7.43808 9.43945C7.43808 9.70215 7.48982 9.96227 7.59035 10.205C7.69088 10.4477 7.83823 10.6682 8.02399 10.854C8.20974 11.0397 8.43026 11.1871 8.67296 11.2876C8.91566 11.3881 9.17579 11.4399 9.43849 11.4399C9.70118 11.4399 9.96131 11.3881 10.204 11.2876C10.4467 11.1871 10.6672 11.0397 10.853 10.854C11.2281 10.4788 11.4389 9.96999 11.4389 9.43945C11.4389 8.90891 11.2281 8.4001 10.853 8.02495C10.4778 7.6498 9.96903 7.43905 9.43849 7.43905C8.90795 7.43905 8.39913 7.6498 8.02399 8.02495Z" fill="white"/>
            </svg>
        </button>
        <!--
        <button type="button" onclick="javascript:history.back();">
            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_526_22)">
            <path d="M4.13605 11.2931C3.94858 11.4806 3.84326 11.7349 3.84326 12.0001C3.84326 12.2652 3.94858 12.5195 4.13605 12.7071L9.79305 18.3641C9.98165 18.5462 10.2343 18.647 10.4964 18.6447C10.7586 18.6425 11.0095 18.5373 11.1949 18.3519C11.3803 18.1665 11.4854 17.9157 11.4877 17.6535C11.49 17.3913 11.3892 17.1387 11.207 16.9501L7.25705 13.0001H20.5C20.7653 13.0001 21.0196 12.8947 21.2072 12.7072C21.3947 12.5196 21.5 12.2653 21.5 12.0001C21.5 11.7348 21.3947 11.4805 21.2072 11.293C21.0196 11.1054 20.7653 11.0001 20.5 11.0001H7.25705L11.207 7.05006C11.3892 6.86146 11.49 6.60885 11.4877 6.34666C11.4854 6.08446 11.3803 5.83365 11.1949 5.64824C11.0095 5.46283 10.7586 5.35766 10.4964 5.35538C10.2343 5.35311 9.98165 5.4539 9.79305 5.63606L4.13605 11.2931Z" fill="white"/>
            </g>
            <defs>
            <clipPath id="clip0_526_22">
            <rect width="24" height="24" fill="white" transform="translate(0.5)"/>
            </clipPath>
            </defs>
            </svg>
        </button>
        -->
    </div>
