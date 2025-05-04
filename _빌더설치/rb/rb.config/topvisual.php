<?php
        if (
            (isset($rb_core['topvisual']) && in_array($rb_core['topvisual'], ['img', 'txt', 'imgtxt']))
        ) {
            $topvisual_class = isset($rb_core['topvisual']) ? 'rb_topvisual_' . $rb_core['topvisual'] : '';
            $topvisual_width = (!empty($rb_core['topvisual_width']) && $rb_core['topvisual_width'] > 0) ? $rb_core['topvisual_width'] . '%' : $rb_core['sub_width'] . 'px';
            $topvisual_height = !empty($rb_core['topvisual_height']) ? $rb_core['topvisual_height'] : '200';
            $topvisual_bg_color = !empty($rb_core['topvisual_bg_color']) ? $rb_core['topvisual_bg_color'] : '#f9f9f9';
            $topvisual_bl = isset($rb_core['topvisual_bl']) ? $rb_core['topvisual_bl'] : '0';

            if(isset($topvisual_width) && $topvisual_width == "100%") {
                $topvisual_padding = "padding-left:0px; padding-right:0px;";
            } else {
                $topvisual_padding = "padding-left:50px; padding-right:50px;";
            }

            function get_topvisual_key() {
                global $bo_table, $co_id, $ca_id;
                if (!empty($bo_table)) return preg_replace('/[^a-z0-9_]/', '', $bo_table);
                if (!empty($co_id))    return preg_replace('/[^a-zA-Z0-9_]/', '', $co_id);
                if (!empty($ca_id))    return preg_replace('/[^a-zA-Z0-9_]/', '', $ca_id);
                return '';
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
        ?>



            <div id="rb_topvisual" class="rb_topvisual <?php echo $topvisual_class; ?>" style="background-color:<?php echo $topvisual_bg_color ?>; width:<?php echo $topvisual_width; ?>; height:<?php echo $topvisual_height; ?>px; <?php if(isset($topvisual_width) && $topvisual_width == "100%") { ?>margin-top:0px; border-radius:0px; overflow:inherit<?php } else { ?>margin-top:50px; border-radius:10px; overflow:hidden<?php } ?>" data-layout="rb_topvisual">

                <?php if ($is_admin) { ?>
                    <input type="file" id="topvisual_file_input" accept="image/*" style="display:none;">
                <?php } ?>

                <!-- 텍스트 영역 -->
                <div id="rb_topvisual_txt">
                    <div id="rb_topvisual_txt_inner" style="width:<?php echo $rb_core['sub_width']; ?>px;">
                        <div class="main_wording" style="<?php echo $topvisual_padding ?> text-align:<?php echo isset($rb_core['topvisual_m_align']) ? $rb_core['topvisual_m_align'] : 'left'; ?>; font-size:<?php echo isset($rb_core['topvisual_m_size']) ? $rb_core['topvisual_m_size'] : '20'; ?>px; color:<?php echo isset($rb_core['topvisual_m_color']) ? $rb_core['topvisual_m_color'] : '#ffffff'; ?>; font-family:<?php echo isset($rb_core['topvisual_m_font']) ? $rb_core['topvisual_m_font'] : 'font-R'; ?>;" <?php if ($is_admin) echo 'contenteditable="true"'; ?>>
                            <?php echo $has_main ? nl2br(htmlspecialchars($main)) : ($is_admin ? nl2br("메인 워딩을 입력할 수 있어요.") : ''); ?>
                        </div>
                        <div class="sub_wording" style="<?php echo $topvisual_padding ?> text-align:<?php echo isset($rb_core['topvisual_s_align']) ? $rb_core['topvisual_s_align'] : 'left'; ?>; font-size:<?php echo isset($rb_core['topvisual_s_size']) ? $rb_core['topvisual_s_size'] : '16'; ?>px; color:<?php echo isset($rb_core['topvisual_s_color']) ? $rb_core['topvisual_s_color'] : '#ffffff'; ?>; font-family:<?php echo isset($rb_core['topvisual_s_font']) ? $rb_core['topvisual_s_font'] : 'font-R'; ?>;" <?php if ($is_admin) echo 'contenteditable="true"'; ?>>
                            <?php echo $has_sub ? nl2br(htmlspecialchars($sub)) : ($is_admin ? nl2br("서브 워딩을 입력할 수 있어요. 입력 하셨다면 저장해 주세요.\n이미지 드랍 및 스타일을 설정할 수 있어요.\n워딩 설정이 안되었다면 이 글은 관리자만 볼 수 있어요.") : ''); ?>
                        </div>
                    </div>
                </div>

                <!-- 블러 배경 -->
                <div id="rb_topvisual_bl" style="background-color:rgba(0,0,0,<?php echo $topvisual_bl / 100; ?>);"></div>
            </div>

            <?php if ($is_admin) { ?>
            <div id="topvisual_btn_wrap">
                <button type="button" id="save_topvisual_btn">워딩 저장</button>
                <button type="button" id="delete_topvisual_btn">이미지 삭제</button>
            </div>
            <script>
            const visual = document.getElementById('rb_topvisual');
            const fileInput = document.getElementById('topvisual_file_input');

            visual.addEventListener('click', (e) => {
                if (!e.target.closest('#rb_topvisual_txt')) fileInput.click();
            });

            visual.addEventListener('dragover', e => {
                e.preventDefault();
                visual.style.outline = '2px dashed #ccc';
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
                formData.append('bo_table', '<?php echo $bo_table; ?>');
                formData.append('co_id', '<?php echo $co_id; ?>');
                formData.append('ca_id', '<?php echo $ca_id; ?>');
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
                const sub = document.querySelector('.sub_wording').innerText.trim();

                const formData = new FormData();
                formData.append('main', main);
                formData.append('sub', sub);
                formData.append('bo_table', '<?php echo $bo_table; ?>');
                formData.append('co_id', '<?php echo $co_id; ?>');
                formData.append('ca_id', '<?php echo $ca_id; ?>');

                fetch('<?php echo G5_URL ?>/rb/rb.config/ajax.topvisual_save.php', {
                    method: 'POST',
                    body: formData
                }).then(res => res.text()).then(res => alert(res));
            });

            document.getElementById('delete_topvisual_btn').addEventListener('click', () => {
                if (!confirm('상단 백그라운드 이미지를 삭제 하시겠습니까?')) return;
                const formData = new FormData();
                formData.append('bo_table', '<?php echo $bo_table; ?>');
                formData.append('co_id', '<?php echo $co_id; ?>');
                formData.append('ca_id', '<?php echo $ca_id; ?>');
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
