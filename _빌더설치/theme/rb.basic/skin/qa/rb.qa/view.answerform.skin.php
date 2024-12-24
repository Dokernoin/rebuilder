<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>


<?php
    if($is_admin) // 관리자이면 답변등록
    {
?>
<div class="rb_bbs_wrap rb_bbs_write_wrap rb_bbs_write_wrap_qa">
    
    <form name="fanswer" method="post" action="./qawrite_update.php" onsubmit="return fwrite_submit(this);" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="qa_id" value="<?php echo $view['qa_id']; ?>">
    <input type="hidden" name="w" value="a">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="stx" value="<?php echo $stx; ?>">
    <input type="hidden" name="page" value="<?php echo $page; ?>">
    <input type="hidden" name="token" value="<?php echo $token ?>">


    <!-- 제목 { -->
    <div class="rb_inp_wrap">
        <ul>
            <input type="text" name="qa_subject" value="" id="qa_subject" required class="input required full_input" maxlength="255" placeholder="답변 제목">  
        </ul>
    </div>
    <!-- } -->
    
    <?php
    $option = '';
    $option_hidden = '';
    $option = '';

    if ($is_dhtml_editor) {
        $option_hidden .= '<input type="hidden" name="qa_html" value="1">';
    } else {
        $option .= "\n".'<input type="checkbox" id="qa_html" name="qa_html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="qa_html">html</label>　';
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
                
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>

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
    
    

    <!-- 파일 { -->
    <div class="rb_inp_wrap rb_inp_wrap_gap">
        <label class="help_text">파일 업로드</label>

        <ul class="rb_inp_wrap_link">
            <input type="file" name="bf_file[1]" id="bf_file_1" title="파일첨부 1 :  용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="input file_inp">　
        </ul>
        
        <ul class="rb_inp_wrap_link">
            <input type="file" name="bf_file[2]" id="bf_file_2" title="파일첨부 2 :  용량 <?php echo $upload_max_filesize; ?> 이하만 업로드 가능" class="input file_inp">　
        </ul>


        </ul>
    </div>
    <!-- } -->
    
    


    
    <div class="rb_inp_wrap_confirm">
        <button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn font-B">답변등록</button>
    </div>


    </form>
</div>

<script>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "2";
            else
                obj.value = "1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
        <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.qa_subject.value,
                "content": f.qa_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.qa_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_qa_content) != "undefined")
                ed_qa_content.returnFalse();
            else
                f.qa_content.focus();
            return false;
        }

        $.ajax({
            type: "POST",
            url: g5_bbs_url+"/ajax.write.token.php",
            data: { 'token_case' : 'qa_write' },
            cache: false,
            async: false,
            dataType: "json",
            success: function(data) {
                if (typeof data.token !== "undefined") {
                    token = data.token;
                    if(typeof f.token === "undefined")
                        $(f).prepend('<input type="hidden" name="token" value="">');
                    $(f).find("input[name=token]").val(token);
                }
            }
        });

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
</script>

<?php } else { ?>
<div class="no_data mt-30">답변을 준비 중입니다.</div>
<?php } ?>




