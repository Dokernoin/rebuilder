<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

    <!-- 카테고리 { -->
    <?php if ($is_category) { ?>
    <div class="rb_inp_wrap">
        <ul>
            <select name="ca_name" id="ca_name" required class="select ca_name">
                <option value="">분류를 선택하세요</option>
                <?php echo $category_option ?>
            </select>
        </ul>
    </div>
    <?php } ?>
    <!-- } -->

    <!-- 제목 { -->
    <div class="rb_inp_wrap">
        <ul>
            <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="input required full_input" maxlength="255" placeholder="제목을 입력하세요.">
        </ul>
    </div>
    <!-- } -->

    <?php
        $option = '';
        $option_hidden = '';
        if ($is_notice || $is_html || $is_secret || $is_mail) {
            $option = '';
            if ($is_notice) {
                $option .= PHP_EOL.'<input type="checkbox" id="notice" name="notice"  class="selec_chk" value="1" '.$notice_checked.'>'.PHP_EOL.'<label for="notice"><span></span>공지</label>　';
            }
            if ($is_html) {
                if ($is_dhtml_editor) {
                    $option_hidden .= '<input type="hidden" value="html1" name="html">';
                } else {
                    $option .= PHP_EOL.'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" class="selec_chk" value="'.$html_value.'" '.$html_checked.'>'.PHP_EOL.'<label for="html"><span></span>html</label>　';
                }
            }
            if ($is_secret) {
                if ($is_admin || $is_secret==1) {
                    $option .= PHP_EOL.'<input type="checkbox" id="secret" name="secret"  class="selec_chk" value="secret" '.$secret_checked.'>'.PHP_EOL.'<label for="secret"><span></span>비밀글</label>　';
                } else {
                    $option_hidden .= '<input type="hidden" name="secret" value="secret">';
                }
            }
            if ($is_mail) {
                $option .= PHP_EOL.'<input type="checkbox" id="mail" name="mail"  class="selec_chk" value="mail" '.$recv_email_checked.'>'.PHP_EOL.'<label for="mail"><span></span>답변메일받기</label>　';
            }
        }
        echo $option_hidden;
    ?>


    <?php if ($option) { ?>
    <div class="rb_inp_wrap">
        <ul>
        <div class="write_div">
            <span class="sound_only">옵션</span>
            <ul class="bo_v_option">
                <?php echo $option ?>
            </ul>
        </div>
        </ul>
    </div>
    <?php } ?>



    <!-- 내용 { -->
    <div class="rb_inp_wrap">
        <ul>
            <div class="wr_content <?php echo $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
                <?php if($board['bo_write_min'] || $board['bo_write_max']) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc" class="help_text">이 게시판은 최소 <strong><?php echo $board['bo_write_min']; ?></strong>글자 이상, 최대 <strong><?php echo $board['bo_write_max']; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

                <?php if($board['bo_write_min'] || $board['bo_write_max']) { ?>
                        <?php if(!$is_dhtml_editor) { ?>
                        <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                        <?php } ?>
                <?php } ?>

            </div>

            <?php if(!$is_dhtml_editor) { ?>
            <style>
                .wr_content>textarea {
                    overflow: hidden;
                }
            </style>
            <script>
                //에디터가 아닌경우 textarea의 높이 자동설정
                $(document).ready(function() {
                    $('.wr_content > textarea').on('input', function() {
                        this.style.height = 'auto'; /* 높이를 자동으로 설정합니다. */
                        this.style.height = (this.scrollHeight) + 'px'; /* 스크롤 높이를 textarea에 적용합니다. */
                        this.style.minHeight = '300px';
                    });
                });
            </script>
            <?php } ?>
        </ul>
    </div>
    <!-- } -->


    <!-- 비회원 { -->
    <?php if ($is_name) { ?>
    <div class="rb_inp_wrap">
        <ul class="guest_inp_wrap">

            <lebel class="help_text">작성자 정보를 입력해주세요. 비밀번호는 게시글 수정 시 사용됩니다.</lebel>
            <li>

                <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="input_tiny required" placeholder="성함">


                <?php if ($is_password) { ?>
                <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="input_tiny <?php echo $password_required ?>" placeholder="비밀번호">
                <?php } ?>
            </li>


            <li>
                <?php if ($is_email) { ?>
                <input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="input_tiny email " placeholder="이메일">
                <?php } ?>
            </li>

        </ul>
    </div>
    <!-- } -->
    <?php } ?>

    <?php if(isset($is_link) && $is_link) { ?>
    <!-- 링크 { -->
    <div class="rb_inp_wrap rb_inp_wrap_gap">
        <label class="help_text">링크 주소를 입력할 수 있어요.</label>
        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <ul class="rb_inp_wrap_link">
            <i><img src="<?php echo $board_skin_url ?>/img/ico_link.svg"></i>
            <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i]; } ?>" id="wr_link<?php echo $i ?>" class="input full_input">
        </ul>
        <?php } ?>

        </ul>
    </div>
    <!-- } -->
    <?php } ?>

                    <?php if(isset($board['bo_upload_count']) && $board['bo_upload_count'] > 0) { ?>
                    <?php
                        $wr_file = isset($wr_file) ? $wr_file : [];
                        $wf_cnt = count((array)$wr_file) + 1;
                        ?>
                    <?php if (isset($is_file) && $is_file && $wf_cnt > 0): ?>

                    <!-- 파일 { -->
                    <div class="rb_inp_wrap rb_inp_wrap_gap">
                        <label class="help_text">
                        최대 <?php echo $board['bo_upload_count']; ?>개 / 이미지 및 일반 파일을 첨부할 수 있어요.<br>
                        파일은 [삭제] 를 클릭하는경우 즉시 삭제되며, 첫번째 이미지가 대표이미지로 설정되요.
                        </label>

                        <div class="">


                          <?php
                          $new_files = [];
                          if (isset($w) && $w == 'u') {
                            // 파일이 존재하는지 확인
                            if (isset($file) && is_array($file)) {
                              foreach ($file as $k => $v) {
                                // 등록된 파일에는 삭제시 필요한 bf_file 필드 추가
                                if (empty($v['file'])) {
                                  continue;
                                }
                                $new_files[] = $v;
                              }
                            }
                          } else {
                            $new_files = [];
                          }
                          ?>
                          <input type="file" name="bf_file[]" style="display:none;" />


                        <div class="divmb-10">
                            <input type="hidden" id="ajax_files" name="ajax_files" value="" />
                            <div style="position:relative;">
                                <input type="file" id="pic" name="pic" onchange="upload_start()" multiple="multiple" class="au_input" />
                                <div class="au_btn_search_file font-b">파일을 여기에 끌어놓으세요.</div>
                            </div>


                            <div class="swiper-container swiper-wfile" style="overflow: inherit; padding-bottom:15px; font-size:11px;">
                            <div class="swiper-wrapper" id="file_list">
                                <?php foreach($new_files as $v): ?>
                                <div class="swiper-slide swiper-slide_lists">
                                    <div class="au_file_list">
                                        <div class="au_file_list_img_wrap">
                                            <?php if($v['view']) { ?>
                                            <?php echo $v['view']?>
                                            <?php } else { ?>
                                            <?php $pinfo = pathinfo($v['source']); ?>
                                            <div class="w_pd">
                                            <a href="<?php echo $v['href']?>" class="w_etc w_<?php echo $pinfo['extension']?>" download><?php echo $pinfo['extension']?></a>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <dd class="au_btn_del2 font-r">대표</dd>
                                        <div class="au_btn_del font-r" onclick="delete_file('<?php echo $v['file']?>',this)">삭제</div>
                                        <div class="cut" style="margin-top:5px;"><?php echo $v['source'] ?></div>
                                    </div>

                                </div>
                                <?php endforeach; ?>
                            </div>
                            </div>

                            <script>
                                var swiper_file = new Swiper('.swiper-wfile', {
                                    slidesPerColumnFill: 'row',
                                    slidesPerView: 10, // 가로갯수
                                    slidesPerColumn: 1, // 세로갯수
                                    spaceBetween: 7, // 간격
                                    touchRatio: 0, // 드래그 가능여부(1, 0)

                                    breakpoints: { // 반응형 처리
                                        1024: {
                                            slidesPerView: 10, // 가로갯수
                                            slidesPerColumn: 1, // 세로갯수
                                            touchRatio: 0,
                                        },
                                        10: {
                                            slidesPerView: 3.5, // 가로갯수
                                            slidesPerColumn: 1, // 세로갯수
                                            touchRatio: 1,
                                        }
                                    }
                                });
                            </script>

                            <div class="au_progress">
                                <div id="son" class="font-R au_bars"></div>
                            </div>
                        </div>

                        <script type="text/javascript">
                            var ajax_files = {
                                'files': <?php echo empty($new_files) ? '[]' : json_encode($new_files)?>,
                                'del': []
                            };
                            var xhr = new XMLHttpRequest();

                            function upload_start() {
                                var cnts = $("#file_list .swiper-slide_lists").length;
                                var maxUploadCount = <?php echo $board['bo_upload_count']; ?>;
                                var picFileList = $("#pic").get(0).files;

                                if (cnts + picFileList.length > maxUploadCount) {
                                    alert("첨부파일은 " + maxUploadCount + "개 이하만 업로드 가능합니다.");
                                    return false;
                                }

                                var formData = new FormData();
                                formData.append("act_type", "upload");
                                formData.append("write_table", "<?php echo $write_table ?>");
                                formData.append("bo_table", "<?php echo $bo_table ?>");
                                formData.append("wr_id", "<?php echo $wr_id ?>");
                                for (var i = 0; i < picFileList.length; i++) {
                                    formData.append("file[]", picFileList[i]);
                                }

                                var xhr = new XMLHttpRequest();
                                xhr.upload.addEventListener("progress", onprogress, false);
                                xhr.addEventListener("error", upload_failed, false);
                                xhr.addEventListener("load", upload_success, false);
                                xhr.open("POST", "<?php echo G5_URL ?>/rb/rb.lib/ajax.upload.php");
                                xhr.send(formData);
                            }

                            function onprogress(evt) {
                                var loaded = evt.loaded;
                                var tot = evt.total;
                                var per = Math.floor(100 * loaded / tot);
                                $("#son").parent().css("display", "block");
                                //$("#son").html(per + "%");
                                $("#son").css("width", per + "%");
                                if(per > 99) {
                                    $("#son").parent().css("display", "none");
                                }
                            }

                            function upload_failed(evt) {
                                alert("업로드에 실패하였습니다.");
                            }

                            function upload_success(evt) {
                                var res = JSON.parse(evt.target.response);
                                if (res.res == 'true') {
                                    for (var i = 0; i < res.list.length; i++) {
                                        var str = '<div class="swiper-slide swiper-slide_lists">';
                                        str += '<div class="au_file_list">';
                                        str += '<div class="au_file_list_img_wrap">';
                                        str += '' + res.list[i].view + '';
                                        str += '</div>';
                                        str += '</div>';
                                        str += '<div class="au_btn_del" onclick="delete_file(\'' + res.list[i].bf_file + '\',this)">삭제</div>';
                                        str += '<div class="cut" style="margin-top:5px;">' + res.list[i].bf_source + '</div>';
                                        str += '</div>';



                                        $("#file_list").append(str);
                                        ajax_files.files.push(res.list[i]);
                                        swiper_file.update();
                                    }
                                    $("#ajax_files").val(JSON.stringify(ajax_files));
                                } else {
                                    alert(res.msg);
                                }

                            }

                            function delete_file(file, obj) {
                                var formData = new FormData();
                                formData.append("act_type", "delete");
                                formData.append("write_table", "<?php echo $write_table ?>");
                                formData.append("bo_table", "<?php echo $bo_table ?>");
                                formData.append("wr_id", "<?php echo $wr_id ?>");
                                formData.append("bf_file", file);
                                xhr.open("POST", "<?php echo G5_URL ?>/rb/rb.lib/ajax.upload.php");
                                xhr.send(formData);
                                $(obj).closest('.swiper-slide').remove();
                                ajax_files.del.push(file);
                                $("#ajax_files").val(JSON.stringify(ajax_files));
                            }


                        </script>





                        </div>
                    </div>
                    <?php endif; ?>
                    <?php } ?>
                <!-- } -->


    <?php if ($is_use_captcha) { //자동등록방지  ?>
    <div class="rb_inp_wrap">
        <ul>
        <?php echo $captcha_html ?>
        </ul>
    </div>
    <?php } ?>


    <div class="rb_inp_wrap_confirm">
        <a href="<?php echo get_pretty_url($bo_table); ?>" class="btn_cancel btn font-B">취소</a>
        <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn font-B">작성완료</button>
    </div>
