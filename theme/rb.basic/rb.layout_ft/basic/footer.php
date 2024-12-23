<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 폴더내 style.css 파일
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/rb.layout_ft/'.$rb_core['layout_ft'].'/style.css">', 0);

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
                        <?php if (defined('G5_USE_SHOP') && G5_USE_SHOP) { ?>
                        <a href="<?php echo G5_SHOP_URL ?>/">마켓</a>
                        <?php } ?>
                    <?php } ?>

                    <a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1 문의</a>
                    <a href="<?php echo G5_BBS_URL ?>/faq.php">FAQ</a>
                    <a href="<?php echo G5_URL ?>/rb/new.php">새글</a>
                    <a href="<?php echo G5_BBS_URL ?>/current_connect.php">접속자 <?php echo connect("theme/rb.connect"); ?></a>
                </ul>
                <div class="cb"></div>
            </div>
        </div>
        <div class="footer_copy">
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
                <ul class="footer_copy_ul2" itemscope="" itemtype="http://schema.org/Organization">
                    <link itemprop="url" href="<?php echo G5_URL ?>">
                    <?php if (!empty($rb_builder['bu_sns1'])) { ?><a href="<?php echo $rb_builder['bu_sns1'] ?>" target="_blank" class="footer_sns_ico" title="카카오 공식채널 바로가기" alt="카카오 공식채널 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_kakaoch.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns2'])) { ?><a href="<?php echo $rb_builder['bu_sns2'] ?>" target="_blank" class="footer_sns_ico" title="카카오 채팅상담" alt="카카오 채팅상담" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_kakaoch_chat.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns3'])) { ?><a href="<?php echo $rb_builder['bu_sns3'] ?>" target="_blank" class="footer_sns_ico" title="유튜브 공식채널 바로가기" alt="유튜브 공식채널 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_youtube.png"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns4'])) { ?><a href="<?php echo $rb_builder['bu_sns4'] ?>" target="_blank" class="footer_sns_ico" title="인스타그램 공식채널 바로가기" alt="인스타그램 공식채널 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_instagram.png"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns5'])) { ?><a href="<?php echo $rb_builder['bu_sns5'] ?>" target="_blank" class="footer_sns_ico" title="페이스북 공식채널 바로가기" alt="페이스북 공식채널 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_facebook.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns6'])) { ?><a href="<?php echo $rb_builder['bu_sns6'] ?>" target="_blank" class="footer_sns_ico" title="트위터 공식채널 바로가기" alt="트위터 공식채널 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_twitter.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns7'])) { ?><a href="<?php echo $rb_builder['bu_sns7'] ?>" target="_blank" class="footer_sns_ico" title="네이버블로그 바로가기" alt="네이버블로그 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_naverblog.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns8'])) { ?><a href="<?php echo $rb_builder['bu_sns8'] ?>" target="_blank" class="footer_sns_ico" title="텔레그램 바로가기" alt="텔레그램 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_telegram.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns9'])) { ?><a href="<?php echo $rb_builder['bu_sns9'] ?>" target="_blank" class="footer_sns_ico" title="SIR 바로가기" alt="SIR 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_sir.svg"></a><?php } ?>
                    <?php if (!empty($rb_builder['bu_sns10'])) { ?><a href="<?php echo $rb_builder['bu_sns10'] ?>" target="_blank" class="footer_sns_ico" title="공식채널 바로가기" alt="공식채널 바로가기" itemprop="sameAs"><img src="<?php echo G5_THEME_URL ?>/rb.img/icon/sns_g/g_links.svg"></a><?php } ?>

                    <?php if(isset($app['ap_btn_is']) && $app['ap_btn_is'] == 1 && isset($app['ap_btn_url']) && $app['ap_btn_url']) { ?>
                    <link itemprop="sameAs" href="<?php echo isset($app['ap_btn_url']) ? $app['ap_btn_url'] : ''; ?>">
                    <?php } ?>



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

