<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<?php if ($is_admin == 'super') {  ?>
<!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<?php run_event('tail_sub'); ?>

</main>

<?php // 앱 토큰을 위한 처리
    if (!isset($app)) {
        $app = []; // $app 변수를 배열로 초기화
    }

    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && isset($app['ap_title']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == $app['ap_title']) {
        if(isset($member['mb_id']) && $member['mb_id']) {
    ?>

<script>
    function setMsg(msg) {
        //alert(msg); // 토큰 확인을 위해 alert 추가
        $.post("<?php echo G5_URL ?>/rb/rb.lib/ajax.token_update.php", {
            user_idx: "<?php echo $member['mb_id'] ?>",
            token: msg
        }, function(result) {
            console.log("Token update result: " + result);
        });
    }

    // 초기화 및 토큰 요청
    window.onload = function() {
        setTimeout(function() {
            window.Android.call_log('token');
        }, 2000); // 일정 시간 후에 호출하여 토큰을 전달받도록 합니다.
    }
</script>
<?php
        }
    }
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // PHP 데이터를 JavaScript 객체로 전달
        const rbConfig = {
            headerColor: "<?php echo isset($rb_config['co_header']) ? $rb_config['co_header'] : ''; ?>",
            headerSet: "<?php echo isset($rb_core['header']) ? $rb_core['header'] : ''; ?>",
            logoMo: "<?php echo !empty($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w']) ? G5_URL . '/data/logos/mo' : G5_THEME_URL . '/rb.img/logos/mo.png' ?>",
            logoMoWhite: "<?php echo !empty($rb_builder['bu_logo_mo']) && !empty($rb_builder['bu_logo_mo_w']) ? G5_URL . '/data/logos/mo_w' : G5_THEME_URL . '/rb.img/logos/mo_w.png' ?>",
            logoPc: "<?php echo !empty($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w']) ? G5_URL . '/data/logos/pc' : G5_THEME_URL . '/rb.img/logos/pc.png' ?>",
            logoPcWhite: "<?php echo !empty($rb_builder['bu_logo_pc']) && !empty($rb_builder['bu_logo_pc_w']) ? G5_URL . '/data/logos/pc_w' : G5_THEME_URL . '/rb.img/logos/pc_w.png' ?>",
            serverTime: "<?php echo G5_SERVER_TIME ?>"
        };

        // 밝기 계산 함수
        function isLightColor(hex) {
            const r = parseInt(hex.slice(1, 3), 16);
            const g = parseInt(hex.slice(3, 5), 16);
            const b = parseInt(hex.slice(5, 7), 16);
            const yiq = (r * 299 + g * 587 + b * 114) / 1000;
            return yiq >= 210;
        }

        // 밝기와 텍스트 색상 결정
        const isLight = isLightColor(rbConfig.headerColor);
        const newTextCode = isLight ? 'black' : 'white';

        // 링크 태그 업데이트
        const headerHref = `<?php echo G5_URL ?>/rb/rb.css/set.header.php?rb_header_set=${rbConfig.headerSet}&rb_header_code=${encodeURIComponent(rbConfig.headerColor)}&rb_header_txt=${newTextCode}`;
        const headerLink = document.querySelector('link[href*="set.header.php"]');
        if (headerLink) {
            headerLink.setAttribute('href', headerHref);
        }

        // 로고 이미지 업데이트
        const newSrcset1 = isLight ? rbConfig.logoMo : rbConfig.logoMoWhite;
        const newSrcset2 = isLight ? rbConfig.logoPc : rbConfig.logoPcWhite;

        const sourceSmall = document.getElementById('sourceSmall');
        const sourceLarge = document.getElementById('sourceLarge');
        const fallbackImage = document.getElementById('fallbackImage');

        if (sourceSmall) {
            sourceSmall.setAttribute('srcset', `${newSrcset1}?ver=${rbConfig.serverTime}`);
        }
        if (sourceLarge) {
            sourceLarge.setAttribute('srcset', `${newSrcset2}?ver=${rbConfig.serverTime}`);
        }
        if (fallbackImage) {
            fallbackImage.setAttribute('src', `${newSrcset2}?ver=${rbConfig.serverTime}`);
        }
    });
</script>

<script>
    $(function() {
        $('.content_box.rb_module_wide, .content_box.rb_module_mid, .rb_section_box.rb_sec_wide').each(function() {
            var parentWidth = $(this).parent().width();
            $(this).css('min-width', parentWidth + 'px');
        });
    });
</script>

<?php if($is_admin) { ?>
<script>
    // jQuery 필요
    (function($) {
        'use strict';

        // 교체할 SVG
        var ADD_ICON_SVG = `
<svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><g fill='none'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#FFFFFFFF' d='M11 20a1 1 0 1 0 2 0v-7h7a1 1 0 1 0 0-2h-7V4a1 1 0 1 0-2 0v7H4a1 1 0 1 0 0 2h7z'/></g></svg>
  `.trim();

        // 적용 함수
        function applyAddIcon(ctx) {
            (ctx || $(document))
            .find('.rb_layout_box .add_module_wrap .add_module_btns')
                .each(function() {
                    var $btn = $(this);
                    if ($btn.data('rbAddIconApplied')) return; // 중복 방지
                    $btn.empty().append(ADD_ICON_SVG);
                    $btn.attr({
                        'aria-label': '',
                        'title': '',
                        'data-tooltip': '현재 모듈에 하위 모듈을 추가할 수 있어요. 하위 모듈은 서로 상하 이동이 가능해요.',
                        'data-tooltip-pos': 'bottom'
                    });
                    $btn.css({
                        display: 'inline-flex',
                        alignItems: 'center',
                        justifyContent: 'center'
                    });
                    $btn.data('rbAddIconApplied', true);
                });
        }

        function applyAddIcon2(ctx) {
            (ctx || $(document))
            .find('.rb_section_box .add_module_wrap .add_module_btns')
                .each(function() {
                    var $btn = $(this);
                    if ($btn.data('rbAddIconApplied')) return; // 중복 방지
                    $btn.empty().append(ADD_ICON_SVG);
                    $btn.attr({
                        'aria-label': '',
                        'title': '',
                        'data-tooltip': '섹션 내부에 자유롭게 이동이 가능한 모듈을 추가할 수 있어요.',
                        'data-tooltip-pos': 'bottom'
                    });
                    $btn.css({
                        display: 'inline-flex',
                        alignItems: 'center',
                        justifyContent: 'center'
                    });
                    $btn.data('rbAddIconApplied', true);
                });
        }

        // DOM 준비 시 1차 적용 + 동적 추가 감지
        $(function() {
            if (!window.jQuery) return;
            applyAddIcon();
            applyAddIcon2();
            var target = document.querySelector('.rb_layout_box') || document.body;
            var mo = new MutationObserver(function(muts) {
                for (var i = 0; i < muts.length; i++) {
                    if (muts[i].addedNodes && muts[i].addedNodes.length) {
                        applyAddIcon($(target));
                        applyAddIcon2($(target));
                        break;
                    }
                }
            });
            mo.observe(target, {
                childList: true,
                subtree: true
            });

            // 수동 재적용용 헬퍼 (ajax 이후 등)
            window.rbApplyAddModuleBtnIcon = function(ctx) {
                applyAddIcon($(ctx || document));
                applyAddIcon2($(ctx || document));
            };
        });
    })(window.jQuery);
</script>
<?php } ?>

<script>
    // jQuery 필요
    (function($) {
        'use strict';

        // === Singleton tooltip element ===
        var $tip = $('<div class="rb-tooltip" role="tooltip" aria-hidden="true"></div>').appendTo(document.body);
        var current = null; // 현재 타깃 요소
        var cfg = {
            gap: 8
        }; // 타깃과 툴팁 간격(px)

        // 위치 계산
        function place(el, pos) {
            var rect = el.getBoundingClientRect();
            $tip.removeClass('rb-tip-top rb-tip-right rb-tip-bottom rb-tip-left');

            // 먼저 보이게 해서 실제 크기 측정
            $tip.attr('data-show', '1').css({
                left: 0,
                top: 0,
                visibility: 'hidden'
            });
            var tRect = $tip[0].getBoundingClientRect();

            // auto: 가장 여유 있는 방향 선택
            if (!pos || pos === 'auto') {
                var vw = window.innerWidth,
                    vh = window.innerHeight;
                var space = {
                    top: rect.top,
                    right: vw - rect.right,
                    bottom: vh - rect.bottom,
                    left: rect.left
                };
                pos = Object.keys(space).sort(function(a, b) {
                    return space[b] - space[a];
                })[0];
            }

            var top = 0,
                left = 0;
            switch (pos) {
                case 'top':
                    top = rect.top - tRect.height - cfg.gap;
                    left = rect.left + (rect.width - tRect.width) / 2;
                    $tip.addClass('rb-tip-top');
                    break;
                case 'bottom':
                    top = rect.bottom + cfg.gap;
                    left = rect.left + (rect.width - tRect.width) / 2;
                    $tip.addClass('rb-tip-bottom');
                    break;
                case 'left':
                    top = rect.top + (rect.height - tRect.height) / 2;
                    left = rect.left - tRect.width - cfg.gap;
                    $tip.addClass('rb-tip-left');
                    break;
                default: // right
                    top = rect.top + (rect.height - tRect.height) / 2;
                    left = rect.right + cfg.gap;
                    $tip.addClass('rb-tip-right');
                    break;
            }

            // 뷰포트 살짝 보정(간단 클램프)
            var pad = 6;
            left = Math.max(pad, Math.min(left, window.innerWidth - tRect.width - pad));
            top = Math.max(pad, Math.min(top, window.innerHeight - tRect.height - pad));

            $tip.css({
                left: Math.round(left) + 'px',
                top: Math.round(top) + 'px',
                visibility: 'visible'
            });
        }

        // 보여주기
        function showTip($el, text, pos) {
            if (!text) return;
            current = $el[0];
            var id = 'rb-tip-' + Math.random().toString(36).slice(2, 8);
            $tip.text(text).attr({
                'id': id,
                'aria-hidden': 'false'
            }).attr('data-show', '1');
            $el.attr('aria-describedby', id);
            place(current, pos);
        }

        // 숨기기
        function hideTip() {
            if (!current) return;
            $(current).removeAttr('aria-describedby');
            current = null;
            $tip.attr({
                'data-show': '0',
                'aria-hidden': 'true'
            }).css('visibility', 'hidden');
        }

        // 문서 위임 이벤트: hover/focus
        $(document)
            .on('mouseenter focusin', '[data-tooltip]', function() {
                var $t = $(this);
                showTip($t, ($t.attr('data-tooltip') || '').trim(), ($t.attr('data-tooltip-pos') || 'right').trim());
            })
            .on('mouseleave focusout', '[data-tooltip]', function() {
                if (this === current) hideTip();
            })
            .on('keydown', function(e) {
                if (e.key === 'Escape') hideTip();
            })
            .on('scroll', function() {
                if (current) place(current, ($(current).attr('data-tooltip-pos') || 'right'));
            })
            .on('mousemove', function() {
                if (current) place(current, ($(current).attr('data-tooltip-pos') || 'right'));
            });

        // 터치: 탭 시 잠깐 표시(1.5s)
        $(document).on('touchstart', '[data-tooltip]', function() {
            var $t = $(this);
            showTip($t, ($t.attr('data-tooltip') || '').trim(), ($t.attr('data-tooltip-pos') || 'right').trim());
            setTimeout(hideTip, 1500);
        });

        // 전역 API (필요 시 직접 제어)
        window.RBTooltip = {
            show: function(el, text, opts) {
                var $el = $(el);
                showTip($el, text || $el.attr('data-tooltip'), (opts && opts.pos) || $el.attr('data-tooltip-pos') || 'right');
            },
            hide: hideTip,
            place: function() {
                if (current) place(current, ($(current).attr('data-tooltip-pos') || 'right'));
            }
        };
    })(jQuery);
</script>

<script>
    window.RBHelp = (function() {

        // 안전한 선택자
        function q(root, sel) {
            return root && root.querySelector ? root.querySelector(sel) : null;
        }

        // 안전한 closest: jQuery/NodeList/텍스트노드/구형 브라우저까지 대응
        function closestHelp(el) {
            // jQuery 객체면 첫 엘리먼트로
            if (el && el.jquery) el = el[0];
            // NodeList/HTMLCollection/배열이면 첫 엘리먼트로
            if (Array.isArray(el) || (el && typeof el.length === 'number' && el.item)) el = el[0];
            // 텍스트 노드면 부모로
            if (el && el.nodeType === 3) el = el.parentNode;

            if (!el || el.nodeType !== 1) return null; // Element만 허용

            if (typeof el.closest === 'function') return el.closest('.rb-help');

            // 폴백(아주 구형)
            for (var cur = el; cur && cur.nodeType === 1; cur = cur.parentElement) {
                if (cur.matches ? cur.matches('.rb-help') :
                    cur.msMatchesSelector && cur.msMatchesSelector('.rb-help')) {
                    return cur;
                }
            }
            return null;
        }

        function ensureBuilt(root) {
            var btn = q(root, '.rb-help-btn'),
                pop = q(root, '.rb-help-pop');
            if (!btn || !pop || pop.dataset.built === '1') return pop;

            var imgSrc = btn.getAttribute('data-img') || '';
            var txt = btn.getAttribute('data-txt') || '';
            var title = btn.getAttribute('data-title') || '';
            var alt = btn.getAttribute('data-alt') || '';
            var wHint = btn.getAttribute('data-img-w') || ''; // 있으면 공간 예약
            var hHint = btn.getAttribute('data-img-h') || '';

            var wrap = document.createElement('div');
            wrap.className = 'rb-help-pop-inner';

            if (imgSrc) {
                var img = new Image();
                img.className = 'rb-help-pop-img';
                img.src = imgSrc;
                img.alt = alt || '';
                if (wHint) img.width = parseInt(wHint, 10) || undefined; // 공간 예약
                if (hHint) img.height = parseInt(hHint, 10) || undefined;

                // ★ 이미지 로드 후 위치 재판단(첫 롤오버 튐 방지)
                var reAuto = function() {
                    requestAnimationFrame(function() {
                        autoFlip(pop);
                    });
                };
                if (img.complete) {
                    reAuto();
                } else {
                    img.addEventListener('load', reAuto, {
                        once: true
                    });
                    img.addEventListener('error', reAuto, {
                        once: true
                    });
                }

                wrap.appendChild(img);
            }

            var box = document.createElement('div');
            if (title) {
                var s = document.createElement('strong');
                s.className = 'rb-help-pop-title';
                s.textContent = title;
                box.appendChild(s);
            }
            if (txt) {
                var p = document.createElement('div');
                p.className = 'rb-help-pop-desc font-R';
                p.textContent = txt;
                box.appendChild(p);
            }
            wrap.appendChild(box);

            pop.innerHTML = '';
            pop.appendChild(wrap);
            pop.dataset.built = '1';
            return pop;
        }

        function setOpen(root, open) {
            var btn = q(root, '.rb-help-btn'),
                pop = q(root, '.rb-help-pop');
            if (!btn || !pop) return;

            // 열기 전 지연 구성 보장
            ensureBuilt(root);

            root.dataset.open = open ? 'true' : 'false';
            btn.setAttribute('aria-expanded', String(open));
            pop.setAttribute('aria-hidden', String(!open));

            if (open) {
                // ★ 첫 표시 프레임 숨김 → 측정/반영 → 보이기 (위치 튐 방지)
                var prevVis = pop.style.visibility;
                pop.style.visibility = 'hidden';
                requestAnimationFrame(function() {
                    autoFlip(pop);
                    pop.style.visibility = prevVis || '';
                });
            }
        }

        function autoFlip(pop) {
            pop.classList.remove('rb-flip-right');
            // 측정 중 애니메이션 간섭 방지
            var prevTransition = pop.style.transition;
            pop.style.transition = 'none';

            var rect = pop.getBoundingClientRect();
            if (rect.left < 8 || rect.right > window.innerWidth - 8) {
                pop.classList.add('rb-flip-right');
            }

            // 다음 프레임에 원복
            requestAnimationFrame(function() {
                pop.style.transition = prevTransition;
            });
        }

        // ===== 이벤트 바인딩 =====
        document.addEventListener('click', function(e) {
            // 버튼 클릭 토글
            var tgt = e.target && e.target.nodeType === 3 ? e.target.parentNode : e.target; // 텍스트노드 보정
            var btn = tgt && typeof tgt.closest === 'function' ? tgt.closest('.rb-help-btn') : null;
            if (btn) {
                e.preventDefault();
                var root = closestHelp(btn);
                setOpen(root, !(root && root.dataset.open === 'true'));
                return;
            }

            // 바깥 클릭 → 모두 닫기
            var h = closestHelp(tgt);
            if (!h) {
                document.querySelectorAll('.rb-help[data-open="true"]').forEach(function(x) {
                    setOpen(x, false);
                });
            }
        });

        // 마우스 진입/키보드 포커스 시 지연 구성
        document.addEventListener('mouseenter', function(e) {
            var h = closestHelp(e.target);
            if (h) ensureBuilt(h);
        }, true);

        document.addEventListener('focusin', function(e) {
            var h = closestHelp(e.target);
            if (h) {
                ensureBuilt(h);
                setOpen(h, true);
            }
        });

        // ESC 닫기
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.rb-help[data-open="true"]').forEach(function(x) {
                    setOpen(x, false);
                });
            }
        });

        // 리사이즈 시 위치 재판단
        window.addEventListener('resize', function() {
            document.querySelectorAll('.rb-help[data-open="true"] .rb-help-pop').forEach(autoFlip);
        });

        // 외부에서 필요 시: 특정 컨테이너 하위 프리빌드
        function rebind(container) {
            (container || document).querySelectorAll('.rb-help').forEach(ensureBuilt);
        }

        // 선택 사항: 페이지 로드 후 미리 구성(첫 롤오버 튐 더 줄이기)
        // document.addEventListener('DOMContentLoaded', function(){ rebind(document); });

        return {
            rebind: rebind
        };
    })();
</script>

<script>
    // 섹션 추가 버튼 상태 갱신
    function updateSectionButtons(root) {
        var $scope = root ? $(root) : $(document);
        $scope = $scope.addBack ? $scope : $(document); // 안전장치

        $scope.find('.add_section_wrap').addBack('.add_section_wrap').each(function() {
            var $wrap = $(this);
            var $btn = $wrap.children('button.add_section_btns');
            if (!$btn.length) return;

            var inNoneSection = $wrap.closest('.rb-none-section, #rb_sidemenu, #rb_sidemenu_float, #rb_sidemenu_shop, #rb_sidemenu_float_shop').length > 0;


            if (inNoneSection) {
                // 비활성 모드: 반투명 + 클릭 시 경고
                $btn
                    .css('opacity', 0.3)
                    .attr('onclick', "javascript:alert('섹션을 사용할 수 없어요.\\n섹션은 가로 100% 영역에만 사용이 가능해요.');");
            } else {
                // 정상 모드: 불투명 + 원래 핸들러
                $btn
                    .css('opacity', '')
                    .attr('onclick', 'set_section_send(this);');
            }
        });
    }

    // 초기 1회 실행
    $(function() {
        updateSectionButtons(document);

        // DOM 변화(추가/이동/클래스 변경)에도 자동 반영
        var observer = new MutationObserver(function(mutations) {
            var need = false;
            for (var i = 0; i < mutations.length; i++) {
                var m = mutations[i];
                if (m.type === 'childList') {
                    // .add_section_wrap가 추가/이동되면
                    if ([].some.call(m.addedNodes || [], function(n) {
                            return n.nodeType === 1 && (n.matches?.('.add_section_wrap') || n.querySelector?.('.add_section_wrap'));
                        })) {
                        need = true;
                        break;
                    }
                } else if (m.type === 'attributes' && m.attributeName === 'class') {
                    // 조상/자신의 클래스 변동 (rb-none-section 토글 등)
                    need = true;
                    break;
                }
            }
            if (need) updateSectionButtons(document);
        });

        observer.observe(document.body, {
            subtree: true,
            childList: true,
            attributes: true,
            attributeFilter: ['class']
        });

        // 필요하면 전역으로 노출
        window.updateSectionButtons = updateSectionButtons;
    });

    // 이미 있는 토글 함수들 끝부분에서도 한 번 호출해 주면 더 안전
    // 예) toggleSideOptions_open_mod() 마지막에:
    try {
        updateSectionButtons(document);
    } catch (e) {}
</script>


<?php
    $rb_core_colors = isset($rb_core['color']) ? $rb_core['color'] : '';
    $rb_core_headers = isset($rb_core['header']) ? $rb_core['header'] : '';
    $rb_config_colors = isset($rb_config['co_color']) ? $rb_config['co_color'] : '';
    $rb_config_headers = isset($rb_config['co_header']) ? $rb_config['co_header'] : '';

    $index_css = '';
    $shop_css = '';
    if (defined('_INDEX_')) $index_css = '1';
    if (defined('_SHOP_')) $shop_css = '1';


    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.color.php?rb_color_set=' . urlencode($rb_core_colors) . '&rb_color_code=' . urlencode($rb_config_colors) . '" />', 0);
    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.header.php?rb_header_set=' . urlencode($rb_core_headers) . '&rb_header_code=' . urlencode($rb_config_headers) . '" />', 0);
    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.style.php?ver='.G5_SERVER_TIME.'&rb_color_set=' . urlencode($rb_core_colors) . '&rb_color_code=' . urlencode($rb_config_colors) . '&rb_is_index='.$index_css.'&rb_is_shop='.$shop_css.'" />', 0);
    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.css/set.style.css?ver='.G5_SERVER_TIME.'" />', 0);
?>
</body>

</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.
