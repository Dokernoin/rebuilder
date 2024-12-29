<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

    <div class="btns_gr_wrap">

       <!-- $rb_core['sub_width'] 는 반드시 포함해주세요 (환경설정 > 서브가로폭에 따른 버튼의 위치 설정) -->
       <div class="sub" style="width:<?php echo $rb_core['sub_width'] ?>px;">

            <?php if(!$wr_id) { //목록보기를 했을 경우 노출되는 부분 방지?>

            <div class="btns_gr">
               <?php if ($admin_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $admin_href ?>');">
               <img src="<?php echo $board_skin_url ?>/img/ico_set.svg">
               <span class="tooltips">관리</span>
               </button>
               <?php } ?>

               <button type="button" class="fl_btns btn_bo_sch">
               <img src="<?php echo $board_skin_url ?>/img/ico_ser.svg">
               <span class="tooltips">검색</span>
               </button>


               <?php if ($rss_href) { ?>
               <button type="button" class="fl_btns" onclick="window.open('<?php echo $rss_href ?>');">
               <img src="<?php echo $board_skin_url ?>/img/ico_rss.svg">
               <span class="tooltips">RSS</span>
               </button>
               <?php } ?>


               <?php if ($write_href) { ?>
               <button type="button" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
               <img src="<?php echo $board_skin_url ?>/img/ico_write.svg">
               <span class="tooltips">글 등록</span>
               </button>
               <?php } ?>

            </div>
            <?php } ?>

            <div class="cb"></div>
        </div>
    </div>

    <!-- 갯수, 전체선택 { -->
    <ul class="rb_bbs_top">

        <?php if($is_admin) { ?>
        <li class="point_info_btns_wrap">
            <button type="button" class="point_info_btns rb_bbs_set_btn" id="rb_bbs_set_btn">
            <i><svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24'><g fill='none' fill-rule='evenodd'><path d='M24 0v24H0V0zM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018m.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022m-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01z'/><path fill='#09244BFF' d='M10.586 2.1a2 2 0 0 1 2.7-.116l.128.117L15.314 4H18a2 2 0 0 1 1.994 1.85L20 6v2.686l1.9 1.9a2 2 0 0 1 .116 2.701l-.117.127-1.9 1.9V18a2 2 0 0 1-1.85 1.995L18 20h-2.685l-1.9 1.9a2 2 0 0 1-2.701.116l-.127-.116-1.9-1.9H6a2 2 0 0 1-1.995-1.85L4 18v-2.686l-1.9-1.9a2 2 0 0 1-.116-2.701l.116-.127 1.9-1.9V6a2 2 0 0 1 1.85-1.994L6 4h2.686zM12 9a3 3 0 1 0 0 6 3 3 0 0 0 0-6'/></g></svg></i>
            <span class="pc">설정</span></button>

            <div class="rb_bbs_set_opens">
                <div class="adm_bbs_set_wrap">
                    <h6 class=""><?php echo $board['bo_subject'] ?> 스킨설정</h6>

                    <dl class="rb_bbs_set_select_wrap">
                        <dd class="po_rel">
                            <label>상단</label>
                            <?php
                            $path = $board_skin_path.'/skin/top';
                            echo get_folder_list_select($path, 'bo_rb_skin_top', 'bo_rb_skin_top', $board['bo_rb_skin_top']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>카테고리</label>
                            <?php
                            $path = $board_skin_path.'/skin/category';
                            echo get_folder_list_select($path, 'bo_rb_skin_category', 'bo_rb_skin_category', $board['bo_rb_skin_category']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>검색</label>
                            <?php
                            $path = $board_skin_path.'/skin/search';
                            echo get_folder_list_select($path, 'bo_rb_skin_search', 'bo_rb_skin_search', $board['bo_rb_skin_search']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>목록</label>
                            <?php
                            $path = $board_skin_path.'/skin/list';
                            echo get_folder_list_select($path, 'bo_rb_skin_list', 'bo_rb_skin_list', $board['bo_rb_skin_list']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>보기</label>
                            <?php
                            $path = $board_skin_path.'/skin/view';
                            echo get_folder_list_select($path, 'bo_rb_skin_view', 'bo_rb_skin_view', $board['bo_rb_skin_view']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>쓰기</label>
                            <?php
                            $path = $board_skin_path.'/skin/write';
                            echo get_folder_list_select($path, 'bo_rb_skin_write', 'bo_rb_skin_write', $board['bo_rb_skin_write']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>코멘트</label>
                            <?php
                            $path = $board_skin_path.'/skin/cmt';
                            echo get_folder_list_select($path, 'bo_rb_skin_cmt', 'bo_rb_skin_cmt', $board['bo_rb_skin_cmt']);
                            ?>
                        </dd>
                        <dd class="po_rel">
                            <label>저장</label>
                            <?php
                            $path = $board_skin_path.'/skin/update';
                            echo get_folder_list_select($path, 'bo_rb_skin_update', 'bo_rb_skin_update', $board['bo_rb_skin_update']);
                            ?>
                        </dd>
                    </dl>

                    <h6 class="mt-20"><?php echo $board['bo_subject'] ?> 출력옵션 설정</h6>

                    <dl class="rb_bbs_set_select_wrap">
                        <dd class="po_rel">
                            <label>가로(PC)</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_gallery_cols" id="bo_gallery_cols" value="<?php echo $board['bo_gallery_cols'] ?>">
                        </dd>
                        <dd class="po_rel">
                            <label>가로(M)</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_mobile_gallery_cols" id="bo_mobile_gallery_cols" value="<?php echo $board['bo_mobile_gallery_cols'] ?>">
                        </dd>
                        <dd class="po_rel w100">
                            <label>페이지당 목록 수</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_page_rows" id="bo_page_rows" value="<?php echo $board['bo_page_rows'] ?>">
                        </dd>
                    </dl>

                    <ul class="w100">
                        PC와 Mobile의 페이지당 목록 수는 공용입니다. 가로 갯수는 스킨에 따라 작동하지 않을 수 있습니다.
                    </ul>

                    <h6 class="mt-20"><?php echo $board['bo_subject'] ?> 썸네일 설정</h6>

                    <dl class="rb_bbs_set_select_wrap">
                        <dd class="po_rel">
                            <label>폭</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_gallery_width" id="bo_gallery_width" value="<?php echo $board['bo_gallery_width'] ?>">
                        </dd>
                        <dd class="po_rel">
                            <label>높이</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_gallery_height" id="bo_gallery_height" value="<?php echo $board['bo_gallery_height'] ?>">
                        </dd>
                        <dd class="po_rel">
                            <label>간격(PC)</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_gap_pc" id="bo_gap_pc" value="<?php echo $board['bo_gap_pc'] ?>">
                        </dd>
                        <dd class="po_rel">
                            <label>간격(M)</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_gap_mo" id="bo_gap_mo" value="<?php echo $board['bo_gap_mo'] ?>">
                        </dd>
                        <dd class="po_rel">
                            <label>테두리</label>
                            <select name="bo_border" id="bo_border" class="select input_tiny w100">
                                <option value="" <?php if($board['bo_border'] == "") { ?>selected<?php } ?>>없음</option>
                                <option value="1" <?php if($board['bo_border'] == 1) { ?>selected<?php } ?>>점선</option>
                                <option value="2" <?php if($board['bo_border'] == 2) { ?>selected<?php } ?>>실선</option>
                            </select>
                        </dd>
                        <dd class="po_rel">
                            <label>모서리</label>
                            <input type="number" class="iuput tiny_input w100" name="bo_radius" id="bo_radius" value="<?php echo $board['bo_radius'] ?>">
                        </dd>
                    </dl>

                    <ul class="w100">
                        썸네일 이미지는 높이 또는 폭의 값에 따라 영역이 결정되며 목록 스킨에 따라 설정된 비율대로 cover 처리 됩니다.
                    </ul>


                    <h6 class="mt-20"><?php echo $board['bo_subject'] ?> 파일 미리보기 설정</h6>
                    <?php
                        $viewer_values = explode('|', $board['bo_viewer']);
                        $is_checked_img = in_array('IMG', $viewer_values) ? 'checked' : '';
                        $is_checked_mp4 = in_array('MP4', $viewer_values) ? 'checked' : '';
                        $is_checked_mp3 = in_array('MP3', $viewer_values) ? 'checked' : '';
                        $is_checked_pdf = in_array('PDF', $viewer_values) ? 'checked' : '';
                    ?>
                    <dl class="rb_bbs_set_select_wrap">
                        <div class="">
                            <input type="checkbox" name="bo_viewer" id="bo_viewer1" value="IMG" <?php echo $is_checked_img; ?>>
                            <label for="bo_viewer1">이미지(JPG, PNG, GIF)</label>
                        </div>
                        <div class="">
                            <input type="checkbox" name="bo_viewer" id="bo_viewer2" value="MP4" <?php echo $is_checked_mp4; ?>>
                            <label for="bo_viewer2">동영상(MP4)</label>
                            <input type="checkbox" name="bo_viewer" id="bo_viewer3" value="PDF" <?php echo $is_checked_pdf; ?>>
                            <label for="bo_viewer3">PDF</label>
                        </div>
                        <div class="">
                            <input type="checkbox" name="bo_viewer" id="bo_viewer4" value="MP3" <?php echo $is_checked_mp3; ?>>
                            <label for="bo_viewer4">오디오(MP3/M4A)</label>
                        </div>
                        <div class="mt-10">
                            <input type="checkbox" name="bo_lightbox" id="bo_lightbox" value="1" <?php if(isset($board['bo_lightbox']) && $board['bo_lightbox'] == 1) { ?>checked<?php } ?>>
                            <label for="bo_lightbox">본문 이미지 Lightbox 적용</label>
                        </div>
                    </dl>

                    <ul class="w100">
                        첨부파일의 파일 확장자에 따라 미리보기를 출력할 수 있습니다.
                    </ul>


                    <dl class="rb_bbs_set_select_wrap">
                        <dd class="adm_set_btn_wrap w100"><button type="button" class="adm_set_btn" id="adm_set" onclick="adm_settings();">저장하기</button></dd>
                    </dl>

                        <script>
                            function adm_settings() {
                                var bo_rb_skin_top = $('#bo_rb_skin_top').val();
                                var bo_rb_skin_list = $('#bo_rb_skin_list').val();
                                var bo_rb_skin_view = $('#bo_rb_skin_view').val();
                                var bo_rb_skin_write = $('#bo_rb_skin_write').val();
                                var bo_rb_skin_cmt = $('#bo_rb_skin_cmt').val();
                                var bo_rb_skin_category = $('#bo_rb_skin_category').val();
                                var bo_rb_skin_search = $('#bo_rb_skin_search').val();
                                var bo_rb_skin_update = $('#bo_rb_skin_update').val();
                                var bo_gallery_cols = $('#bo_gallery_cols').val();
                                var bo_mobile_gallery_cols = $('#bo_mobile_gallery_cols').val();
                                var bo_page_rows = $('#bo_page_rows').val();
                                var bo_gap_pc = $('#bo_gap_pc').val();
                                var bo_gap_mo = $('#bo_gap_mo').val();
                                var bo_border = $('#bo_border').val();
                                var bo_radius = $('#bo_radius').val();
                                var bo_viewer1 = $('#bo_viewer1:checked').val();
                                var bo_viewer2 = $('#bo_viewer2:checked').val();
                                var bo_viewer3 = $('#bo_viewer3:checked').val();
                                var bo_viewer4 = $('#bo_viewer4:checked').val();
                                var bo_lightbox = $('#bo_lightbox:checked').val();
                                var bo_gallery_width = $('#bo_gallery_width').val();
                                var bo_gallery_height = $('#bo_gallery_height').val();

                                $.ajax({
                                    url: '<?php echo $board_skin_url ?>/ajax.update.php',
                                    type: 'post',
                                    dataType: 'json',
                                    data: {
                                        "bo_rb_skin_top": bo_rb_skin_top,
                                        "bo_rb_skin_list": bo_rb_skin_list,
                                        "bo_rb_skin_view": bo_rb_skin_view,
                                        "bo_rb_skin_write": bo_rb_skin_write,
                                        "bo_rb_skin_cmt": bo_rb_skin_cmt,
                                        "bo_rb_skin_category": bo_rb_skin_category,
                                        "bo_rb_skin_search": bo_rb_skin_search,
                                        "bo_rb_skin_update": bo_rb_skin_update,
                                        "bo_gallery_cols": bo_gallery_cols,
                                        "bo_mobile_gallery_cols": bo_mobile_gallery_cols,
                                        "bo_page_rows": bo_page_rows,
                                        "bo_gap_pc": bo_gap_pc,
                                        "bo_gap_mo": bo_gap_mo,
                                        "bo_border": bo_border,
                                        "bo_radius": bo_radius,
                                        "bo_viewer1": bo_viewer1,
                                        "bo_viewer2": bo_viewer2,
                                        "bo_viewer3": bo_viewer3,
                                        "bo_viewer4": bo_viewer4,
                                        "bo_lightbox": bo_lightbox,
                                        "bo_gallery_width": bo_gallery_width,
                                        "bo_gallery_height": bo_gallery_height,
                                        "bo_table": "<?php echo $bo_table ?>"
                                    },
                                    success: function(data) {

                                        if (data.status === 'ok') {
                                            alert('설정이 저장 되었습니다.');
                                            location.reload();
                                        } else if (data.status === 'no') {
                                            alert('설정 저장에 문제가 있습니다.');
                                        }

                                    },
                                    error: function(err) {
                                        alert('오류가 발생했습니다. 잠시 후 다시 시도해주세요.');
                                    }
                                });
                            }
                        </script>
                </div>


            </div>

            <script>
                $(document).ready(function() {
                    $(document).click(function(event) {
                        if (!$(event.target).closest('#rb_bbs_set_btn, .rb_bbs_set_opens').length) {
                            if ($('.rb_bbs_set_opens').is(':visible')) {
                                $('.rb_bbs_set_opens').hide();
                                $('.point_info_opens').hide();
                                $('#rb_bbs_set_btn').removeClass('act');
                                $('#point_info_opens_btn').removeClass('act');
                            }
                        }
                    });

                    $('#rb_bbs_set_btn').click(function(event) {
                        event.stopPropagation();
                        $('.rb_bbs_set_opens').toggle();
                        $('.point_info_opens').hide();
                        $('#point_info_opens_btn').removeClass('act');
                        $(this).toggleClass('act');
                    });
                });
            </script>

        </li>
        <?php } ?>

        <?php if($board['bo_read_point'] || $board['bo_write_point'] || $board['bo_comment_point'] || $board['bo_download_point']) { ?>
        <li class="point_info_btns_wrap">
            <button type="button" class="point_info_btns" id="point_info_opens_btn">
            <i><svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10 0C15.523 0 20 4.477 20 10C20 15.523 15.523 20 10 20C4.477 20 0 15.523 0 10C0 4.477 4.477 0 10 0ZM11.5 5H9C8.46957 5 7.96086 5.21071 7.58579 5.58579C7.21071 5.96086 7 6.46957 7 7V14C7 14.2652 7.10536 14.5196 7.29289 14.7071C7.48043 14.8946 7.73478 15 8 15C8.26522 15 8.51957 14.8946 8.70711 14.7071C8.89464 14.5196 9 14.2652 9 14V12H11.5C12.4283 12 13.3185 11.6313 13.9749 10.9749C14.6313 10.3185 15 9.42826 15 8.5C15 7.57174 14.6313 6.6815 13.9749 6.02513C13.3185 5.36875 12.4283 5 11.5 5ZM11.5 7C11.8978 7 12.2794 7.15804 12.5607 7.43934C12.842 7.72064 13 8.10218 13 8.5C13 8.89782 12.842 9.27936 12.5607 9.56066C12.2794 9.84196 11.8978 10 11.5 10H9V7H11.5Z" fill="#09244B"/></svg></i>
            <span class="pc">포인트정책</span></button>

            <div class="point_info_opens">
                <h6><?php echo $board['bo_subject'] ?> 포인트 정책</h6>
                <ul>
                    <?php if($board['bo_read_point']) { ?>
                    <dl>
                        <dd>글읽기</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_read_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                    <?php if($board['bo_write_point']) { ?>
                    <dl>
                        <dd>글쓰기</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_write_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                    <?php if($board['bo_comment_point']) { ?>
                    <dl>
                        <dd>댓글</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_comment_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                    <?php if($board['bo_download_point']) { ?>
                    <dl>
                        <dd>다운로드</dd>
                        <dd class="font-B"><?php echo number_format($board['bo_download_point']); ?>P</dd>
                    </dl>
                    <?php } ?>
                </ul>
            </div>

            <script>
                $(document).ready(function() {
                    $(document).click(function(event) {
                        if (!$(event.target).closest('#point_info_opens_btn, .point_info_opens').length) {
                            if ($('.point_info_opens').is(':visible')) {
                                $('.point_info_opens').hide();
                                $('.rb_bbs_set_opens').hide();
                                $('#point_info_opens_btn').removeClass('act');
                                $('#rb_bbs_set_btn').removeClass('act');
                            }
                        }
                    });

                    $('#point_info_opens_btn').click(function(event) {
                        event.stopPropagation();
                        $('.point_info_opens').toggle();
                        $('.rb_bbs_set_opens').hide();
                        $('#rb_bbs_set_btn').removeClass('act');
                        $(this).toggleClass('act');
                    });
                });
            </script>


        </li>
        <?php } ?>



        <?php if ($is_checkbox) { ?>
        <li>
            <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
            <label for="chkall"></label>
        </li>
        <?php } ?>

        <li class="cnts">
            전체 <?php echo number_format($total_count) ?>건 / <?php echo $page ?> 페이지
        </li>

        <div class="cb"></div>
    </ul>
    <!-- } -->
