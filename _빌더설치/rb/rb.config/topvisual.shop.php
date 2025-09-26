<?php
if (!defined('_GNUBOARD_')) exit;


            if (isset($rb_v_info['v_use']) && intval($rb_v_info['v_use']) === 1 || isset($rb_v_info['v_use']) && intval($rb_v_info['v_use']) === 2) {

            $topvisual_class = !empty($rb_v_info['v_code']) ? $rb_v_info['v_code'] : '';
            $topvisual_width = (!empty($rb_v_info['topvisual_width']) && $rb_v_info['topvisual_width'] > 0) ? $rb_v_info['topvisual_width'] . '%' : $rb_core['sub_width'] . 'px';
            $topvisual_mt = !empty($rb_v_info['topvisual_mt']) ? $rb_v_info['topvisual_mt'] : '0';
            $topvisual_height = !empty($rb_v_info['topvisual_height']) ? $rb_v_info['topvisual_height'] : '200';
            $topvisual_radius = isset($rb_v_info['topvisual_radius']) ? $rb_v_info['topvisual_radius'] : '0';
            $topvisual_border = isset($rb_v_info['topvisual_border']) ? $rb_v_info['topvisual_border'] : '0';
            $topvisual_bg_color = !empty($rb_v_info['topvisual_bg_color']) ? $rb_v_info['topvisual_bg_color'] : '#f9f9f9';
            $topvisual_bl = isset($rb_v_info['topvisual_bl']) ? $rb_v_info['topvisual_bl'] : '0';

            if(isset($topvisual_width) && $topvisual_width == "100%") {
                $topvisual_padding = "padding-left:0px; padding-right:0px;";
            } else {
                $topvisual_padding = "padding-left:50px; padding-right:50px;";
            }

            function get_topvisual_key() {
                global $rb_v_info;
                return isset($rb_v_info['v_code']) ? $rb_v_info['v_code'] : '';
            }

            $key = get_topvisual_key();
            $img = G5_DATA_URL.'/topvisual/'.$key.'.jpg';
            $txt = G5_DATA_PATH.'/topvisual/'.$key.'.txt';

            $main = '';
            $sub = '';

            if (file_exists($txt)) {
                $lines = file($txt, FILE_IGNORE_NEW_LINES);
                $split = array_search('[SUB]', $lines);
                if ($split !== false) {
                    $main = implode("\n", array_slice($lines, 0, $split));
                    $sub  = implode("\n", array_slice($lines, $split + 1));
                } else {
                    $main = implode("\n", $lines);
                }
            }
            $has_main = trim($main) !== '';
            $has_sub = trim($sub) !== '';

            if($topvisual_border == 0) {
                $topvisual_border_in = "border:0px;";
            } else if($topvisual_border == 1) {
                $topvisual_border_in = "border:1px dashed rgba(0,0,0,0.1);";
            } else if($topvisual_border == 2) {
                $topvisual_border_in = "border:1px solid rgba(0,0,0,0.1);";
            } else {
                $topvisual_border_in = "";
            }
        ?>

            <div id="rb_topvisual" class="rb_topvisual <?php echo $topvisual_class; ?>" style="background-color:<?php echo $topvisual_bg_color ?>; width:<?php echo $topvisual_width; ?>; height:<?php echo $topvisual_height; ?>px; border-radius:<?php echo $topvisual_radius ?>px; overflow:hidden; margin-top:<?php echo $topvisual_mt ?>px; <?php echo $topvisual_border_in ?>" data-layout="rb_topvisual">

                <?php if ($is_admin) { ?>
                    <input type="file" id="topvisual_file_input" accept="image/*" style="display:none;">
                <?php } ?>

                <!-- 텍스트 영역 -->
                <div id="rb_topvisual_txt">
                    <div id="rb_topvisual_txt_inner" style="width:<?php echo $rb_core['sub_width']; ?>px;">

                        <div class="main_wording <?php if(!$has_main) { ?>main_wording_none <?php if($is_admin) { ?>main_wording_block_adm<?php } ?><?php } ?>" style="<?php echo $topvisual_padding ?> text-align:<?php echo !empty($rb_v_info['topvisual_m_align']) ? $rb_v_info['topvisual_m_align'] : 'left'; ?>; font-size:<?php echo !empty($rb_v_info['topvisual_m_size']) ? $rb_v_info['topvisual_m_size'] : '20'; ?>px; color:<?php echo !empty($rb_v_info['topvisual_m_color']) ? $rb_v_info['topvisual_m_color'] : '#ffffff'; ?>; font-family:<?php echo !empty($rb_v_info['topvisual_m_font']) ? $rb_v_info['topvisual_m_font'] : 'font-R'; ?>;" <?php if ($is_admin) echo 'contenteditable="true"'; ?>>
                            <?php echo $has_main ? nl2br(htmlspecialchars($main)) : ($is_admin ? nl2br("메인 워딩을 입력할 수 있어요.") : ''); ?>
                        </div>

                        <div class="sub_wording <?php if(empty($has_sub)) { ?>sub_wording_none <?php if($is_admin) { ?>sub_wording_block_adm<?php } ?><?php } ?>" style="<?php echo $topvisual_padding ?> text-align:<?php echo !empty($rb_v_info['topvisual_s_align']) ? $rb_v_info['topvisual_s_align'] : 'left'; ?>; font-size:<?php echo !empty($rb_v_info['topvisual_s_size']) ? $rb_v_info['topvisual_s_size'] : '16'; ?>px; color:<?php echo !empty($rb_v_info['topvisual_s_color']) ? $rb_v_info['topvisual_s_color'] : '#ffffff'; ?>; font-family:<?php echo !empty($rb_v_info['topvisual_s_font']) ? $rb_v_info['topvisual_s_font'] : 'font-R'; ?>;" <?php if ($is_admin) echo 'contenteditable="true"'; ?>>
                            <?php echo $has_sub ? nl2br(htmlspecialchars($sub)) : ($is_admin ? nl2br("이미지 드랍 및 서브 워딩을 입력할 수 있어요.<br>이 글은 관리자만 볼 수 있어요.") : ''); ?>
                        </div>


                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const container = document.querySelector('#rb_topvisual_txt');
                    if (!container) return;

                    const editableElements = container.querySelectorAll('[contenteditable="true"]');

                    editableElements.forEach(el => {
                        el.addEventListener('paste', function (e) {
                            e.preventDefault();

                            // 클립보드에서 순수 텍스트만 추출
                            const text = (e.clipboardData || window.clipboardData).getData('text');

                            // 현재 커서 위치에 삽입
                            if (document.queryCommandSupported('insertText')) {
                                document.execCommand('insertText', false, text);
                            } else {
                                this.innerText += text;
                            }
                        });
                    });
                });
                </script>

                <!-- 블러 배경 -->
                <div id="rb_topvisual_bl" style="border-radius:<?php echo $topvisual_radius ?>px; overflow:hidden; background-color:rgba(0,0,0,<?php echo $topvisual_bl / 100; ?>);"></div>
                <?php if ($is_admin) { ?>
                <div id="topvisual_btn_wrap">
                    <button type="button" id="save_topvisual_btn">워딩 저장</button>
                    <button type="button" id="delete_topvisual_btn">이미지 삭제</button>
                </div>
                <?php } ?>
            </div>

            <?php if ($is_admin) { ?>

            <script>
            const visual = document.getElementById('rb_topvisual');
            const fileInput = document.getElementById('topvisual_file_input');

            visual.addEventListener('click', (e) => {
              // 텍스트 영역/컨트롤/버튼 등은 업로드 금지
              const isCtrl  = e.target.closest('[contenteditable="true"]');
              const isBtns  = e.target.closest('#topvisual_btn_wrap'); // 혹시 시각적으로 겹치는 경우 대비

              if (isCtrl || isBtns) return;

              // 배경/블러 층을 클릭했을 때만 파일 선택
              const isBg = (e.target === visual) || e.target.id === 'rb_topvisual_bl';
              if (isBg) fileInput.click();
            });


            visual.addEventListener('dragover', e => {
                e.preventDefault();
                visual.style.outline = '2px dashed #00d6ee';
            });
            visual.addEventListener('dragleave', () => visual.style.outline = 'none');
            visual.addEventListener('drop', e => {
                e.preventDefault();
                visual.style.outline = 'none';
                const file = e.dataTransfer.files[0];
                if (file) uploadImage(file);
            });

            fileInput.addEventListener('change', e => {
                const file = e.target.files[0];
                if (file) uploadImage(file);
            });

            function uploadImage(file) {
                if (!file.type.match('image.*')) return alert('이미지 파일만 업로드 할 수 있습니다.');
                const formData = new FormData();
                formData.append('image', file);
                formData.append('me_code', '<?php echo $rb_v_info['v_code']; ?>');

                fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.topvisual_upload.php', {
                    method: 'POST', body: formData
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        const now = new Date().getTime();
                        visual.style.backgroundImage = `url('${data.url}?v=${now}')`;
                    } else alert('업로드 오류 : ' + data.error);
                });
            }

           document.getElementById('save_topvisual_btn').addEventListener('click', () => {
                const main = document.querySelector('.main_wording').innerText.trim();
                const sub  = document.querySelector('.sub_wording').innerText.trim();

                const formData = new FormData();
                formData.append('main', main);
                formData.append('sub', sub);
                formData.append('me_code', '<?php echo $rb_v_info['v_code']; ?>');

                fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.topvisual_save.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(text => {
                    location.reload();
                })
                .catch(err => {
                    alert('저장 중 오류가 발생했습니다.\n' + err);
                });
            });

            document.getElementById('delete_topvisual_btn').addEventListener('click', () => {
                if (!confirm('상단 백그라운드 이미지를 삭제 하시겠습니까?')) return;
                const formData = new FormData();
                formData.append('me_code', '<?php echo $rb_v_info['v_code']; ?>');

                fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.topvisual_delete.php', {
                    method: 'POST', body: formData
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        visual.style.backgroundImage = 'none';
                        alert('이미지가 삭제 되었습니다.');
                    } else alert('삭제 오류 : ' + data.error);
                });
            });
            </script>

            <?php } ?>

            <script>
            document.addEventListener("DOMContentLoaded", function() {
                const visual = document.getElementById('rb_topvisual');
                const main = document.querySelector('.main_wording');
                const sub  = document.querySelector('.sub_wording');

                <?php if (file_exists(G5_DATA_PATH.'/topvisual/'.$key.'.jpg')) { ?>
                    visual.style.backgroundImage = "url('<?php echo $img . '?v=' . time(); ?>')";
                <?php } ?>

                <?php if (!$is_admin) { ?>
                    main.setAttribute('contenteditable', 'false');
                    sub.setAttribute('contenteditable', 'false');
                <?php } ?>
            });
            </script>
            <?php } ?>
