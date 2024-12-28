<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

    <span class="view_info_span mobile"><?php echo date("Y.m.d H:i", strtotime($view['wr_datetime'])) ?></span>
    <h2><?php echo get_text($view['wr_subject']);?></h2>

    <!-- 게시물 정보 { -->
    <ul class="rb_bbs_for_mem rb_bbs_for_mem_view">

        <li class="rb_bbs_for_mem_names">
            <?php echo $view['name'] ?> <?php if ($board['bo_use_ip_view']) { echo "<span class='view_info_span_ip'>($ip)</span>"; } ?>
            <span class="view_info_span"><?php echo passing_time3($view['wr_datetime']) ?></span>
            <span class="view_info_span view_info_span_date"><?php echo date("Y.m.d H:i", strtotime($view['wr_datetime'])) ?></span>
            <?php if ($category_name) { ?>
            <span class="view_info_span"><a href="<?php echo $view['ca_name_href'] ?>"><?php echo $view['ca_name'] ?></a></span>
            <?php } ?>

            <?php
            $view['icon_new'] = "";
            if ($view['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($board['bo_new'] * 3600)))
                $view['icon_new'] = "<span class=\"lb_ico_new\">새글</span>";
            $view['icon_hot'] = "";
            if ($board['bo_hot'] > 0 && $view['wr_hit'] >= $board['bo_hot'])
                $view['icon_hot'] = "<span class=\"lb_ico_hot\">인기</span>";

            echo $view['icon_new']; //뉴아이콘
            echo $view['icon_hot']; //인기아이콘
            ?>
        </li>

        <li class="rb_bbs_for_btm_info">
            <dd>
                <i><img src="<?php echo $board_skin_url ?>/img/ico_eye.svg"></i>
                <span><?php echo number_format($view['wr_hit']); ?></span>
            </dd>

            <dd>
                <i><img src="<?php echo $board_skin_url ?>/img/ico_comm.svg"></i>
                <span><?php echo number_format($view['wr_comment']); ?></span>
            </dd>

        </li>

        <div class="cb"></div>

    </ul>
    <!-- } -->




    <!-- 첨부파일 / 링크 { -->
    <?php

    // Load viewer setting from DB
    $allowed_viewer = array_filter(explode('|', $board['bo_viewer'])); // 설정 값을 배열로 분리 및 빈 값 제거

    $extensions_map = [
        'IMG' => ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
        'MP4' => ['mp4', 'webm', 'ogg'],
        'PDF' => ['pdf'],
        'MP3' => ['mp3', 'm4a']
    ];

    $viewer_files = [];
    $processed_files = [];
    if ($view['file']['count']) {
        for ($i = 0; $i < count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source']) {
                $file_ext = strtolower(pathinfo($view['file'][$i]['source'], PATHINFO_EXTENSION));

                foreach ($allowed_viewer as $type) {
                    if (array_key_exists($type, $extensions_map) && in_array($file_ext, $extensions_map[$type])) {
                        $viewer_files[$type][] = $view['file'][$i];
                        $processed_files[] = $view['file'][$i]['source'];
                        break;
                    }
                }
            }
        }
    }

    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'])
            //if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'])
                $cnt++;
        }
    }

    if ($cnt) {
        echo '<div class="rb_bbs_file">';

        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !in_array($view['file'][$i]['source'], $processed_files)) {
                echo '<ul class="rb_bbs_file_for">';
                echo '<i><img src="' . $board_skin_url . '/img/ico_file.svg"></i>';
                echo '<a href="' . $view['file'][$i]['href'] . '" class="view_file_download">' . $view['file'][$i]['source'] . '</a> (' . $view['file'][$i]['size'] . ')　<!--' . $view['file'][$i]['datetime'] . '　-->' . number_format($view['file'][$i]['download']) . '회';
                //echo '<span class="file_path">[' . G5_DATA_URL . '/file/' . $board['bo_table'] . '/' . $view['file'][$i]['file'] . ']</span>';
                if ($view['file'][$i]['content']) {
                    echo '<li class="file_contents">' . $view['file'][$i]['content'] . '</li>';
                }
                echo '</ul>';
            }
        }

        echo '</div>';
    }
    ?>

    <?php if(isset($view['link']) && array_filter($view['link'])) { ?>

    <div class="rb_bbs_file">
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
        ?>
        <ul class="rb_bbs_file_for">
            <i><img src="<?php echo $board_skin_url ?>/img/ico_link.svg"></i>
            <a href="<?php echo $view['link_href'][$i] ?>" target="_blank"><?php echo $link ?></a>　<?php echo $view['link_hit'][$i] ?>회
        </ul>
        <?php
            }
        }
        ?>
    </div>

    <?php } ?>



    <div id="bo_v_con">
    <?php echo rb_get_view_thumbnail($view['content'], "", $view['wr_id']); ?>

    <br>
    <?php
    if (!empty($viewer_files)) {
        echo '<div class="viewer">';

        foreach ($viewer_files as $type => $files) {
            echo '<div class="viewer_' . strtolower($type) . '">';
            //echo '<h3>' . strtoupper($type) . ' 미리보기</h3>';

            if ($type === 'IMG') {
                echo "<div id=\"bo_v_img\">\n";
                foreach ($files as $file) {
                    if(isset($board['bo_lightbox']) && $board['bo_lightbox'] == 1) {
                        // 이미지와 링크 경로 설정
                        $img_src = G5_DATA_URL . "/file/" . $board["bo_table"] . "/" . $file["file"];
                        $gallery_group = "gallery_" . $view['wr_id'];

                        // a 태그와 Lightbox 적용
                        echo '<a href="' . $img_src . '" data-fslightbox="' . $gallery_group . '" style="display: inline-block; margin-bottom: 10px;">';
                        echo '<img src="' . $img_src . '" alt="' . htmlspecialchars($file['source'], ENT_QUOTES) . '" style="max-width: 100%;">';
                        echo '</a>';
                    } else {
                        echo rb_get_file_thumbnail($file, $view['wr_id']);
                    }
                }
                echo "</div>\n";
            } elseif ($type === 'PDF') {
                echo '<script src="' . $board_skin_url . '/js/pdf.min.js"></script>';
                echo '<div id="pdf-renderer-container" style="width:100%; overflow:hidden;">';
                foreach ($files as $file) {
                    $pdfUrl = G5_DATA_URL . "/file/" . $board["bo_table"] . "/" . $file["file"];
                    echo '<div class="pdf-item" style="margin-bottom: 20px;">';
                    echo '<script>';
                    echo 'document.addEventListener("DOMContentLoaded", () => {
                        const pdfSection = document.createElement("div");
                        pdfSection.style.marginBottom = "20px";

                        const pdfjsLib = window["pdfjs-dist/build/pdf"];
                        pdfjsLib.GlobalWorkerOptions.workerSrc = "' . $board_skin_url . '/js/pdf.worker.min.js";

                        pdfjsLib.getDocument("' . $pdfUrl . '").promise.then(pdf => {
                            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                                pdf.getPage(pageNumber).then(page => {
                                    const canvas = document.createElement("canvas");
                                    const context = canvas.getContext("2d");

                                    const viewport = page.getViewport({ scale: 2 }); // Higher scale for better quality
                                    canvas.width = viewport.width;
                                    canvas.height = viewport.height;

                                    const renderContext = {
                                        canvasContext: context,
                                        viewport: viewport,
                                    };

                                    page.render(renderContext).promise.then(() => {
                                        pdfSection.appendChild(canvas);
                                        if (pageNumber === pdf.numPages) {
                                            const label = document.createElement("label");
                                            label.textContent = "' . $file['source'] . '";
                                            label.style.display = "block";
                                            label.style.marginTop = "10px";
                                            pdfSection.appendChild(label);
                                        }
                                    });
                                    document.querySelector("#pdf-renderer-container").appendChild(pdfSection);
                                });
                            }
                        });
                    });';
                    echo '</script>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                foreach ($files as $file) {
                    $real_path = G5_DATA_URL . '/file/' . $board['bo_table'] . '/' . $file['file'];
                    echo '<div class="viewer_item">';
                    if ($type === 'MP4') {
                        echo '<video controls width="100%" src="' . $real_path . '"></video>';
                    } elseif ($type === 'MP3') {
                        echo '<audio controls src="' . $real_path . '"></audio>';
                    }
                    echo '<label>'.$file['source'].'</label>';
                    echo '</div>';
                }
            }

            echo '</div>'; // End of type-specific div
        }

        echo '</div>'; // End of viewer div
    }
    ?>


    </div>


    <div id="bo_v_share">
        	<?php include_once(G5_SNS_PATH."/view.sns.skin.php"); ?>
        	<ul class="copy_urls">
                <li>
                    <a href="javascript:void(0);" id="data-copy">
                       <img src="<?php echo $board_skin_url ?>/img/ico_sha.png" alt="공유링크 복사" width="32">
                    </a>
        	    </li>
        	    <?php
                $currents_url = G5_URL.$_SERVER['REQUEST_URI'];
                ?>
        	    <input type="hidden" id="data-area" class="data-area" value="<?php echo $currents_url ?>">
        	    <script>
        	        $(document).ready(function() {

        	            $('#data-copy').click(function() {
        	                $('#data-area').attr('type', 'text'); // 화면에서 hidden 처리한 input box type을 text로 일시 변환
        	                $('#data-area').select(); // input에 담긴 데이터를 선택
        	                var copy = document.execCommand('copy'); // clipboard에 데이터 복사
        	                $('#data-area').attr('type', 'hidden'); // input box를 다시 hidden 처리
        	                if (copy) {
        	                    alert("공유 링크가 복사 되었습니다."); // 사용자 알림
        	                }
        	            });

        	        });
        	    </script>
        	</ul>

    </div>


    <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
    <!-- } 본문 내용 끝 -->

    <!--  추천 비추천 시작 { -->
    <?php if ( $good_href || $nogood_href) { ?>
    <div id="bo_v_act">
        <?php if ($good_href) { ?>
        <span class="bo_v_act_gng">
            <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?><?php echo $good_href.'&amp;'.$qstr ?><?php } ?>" id="good_button" class="bo_v_good">추천해요 <?php echo number_format($view['wr_good']) ?></a>
            <b id="bo_v_act_good" class="font-R"></b>
        </span>
        <?php } ?>
        <?php if ($nogood_href) { ?>
        <span class="bo_v_act_gng">
            <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?><?php echo $nogood_href.'&amp;'.$qstr ?><?php } ?>" id="nogood_button" class="bo_v_nogood">별로에요 <?php echo number_format($view['wr_nogood']) ?></a>
            <b id="bo_v_act_nogood" class="font-R"></b>
        </span>
        <?php } ?>
    </div>
    <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
    <div id="bo_v_act">
        <?php if($board['bo_use_good']) { ?>
            <span class="bo_v_act_gng">

                <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?>javascript:void(0);<?php } ?>" class="bo_v_good">추천해요 <?php echo number_format($view['wr_good']) ?></a>
                <b id="bo_v_act_good" class="font-R"></b>
            </span>
        <?php } ?>
        <?php if($board['bo_use_nogood']) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php if(!$is_member) { ?>javascript:alert('로그인 후 이용하실 수 있습니다.');<?php } else { ?>javascript:void(0);<?php } ?>" class="bo_v_nogood">별로에요 <?php echo number_format($view['wr_nogood']) ?></a>
                <b id="bo_v_act_nogood" class="font-R"></b>
            </span>
        <?php } ?>
    </div>
    <?php
            }
        }
    ?>
    <!-- }  추천 비추천 끝 -->


    <ul class="btm_btns">

       <dd class="btm_btns_right">

            <?php if ($list_href) { ?>
            <a href="<?php echo $list_href ?>" type="button" class="fl_btns font-B">목록</a>
            <?php } ?>


            <?php if ($scrap_href) { ?>
            <a href="<?php echo $scrap_href;  ?>" class="fl_btns font-B" target="_blank" onclick="win_scrap(this.href); return false;">스크랩</a>
            <?php } ?>

            <?php if ($write_href) { ?>
            <button type="button" name="btn_submit" class="fl_btns main_color_bg" onclick="location.href='<?php echo $write_href ?>';">
                <img src="<?php echo $board_skin_url ?>/img/ico_write.svg">
                <span class="font-R">글 등록</span>
            </button>
            <?php } ?>

            <div class="cb"></div>

        </dd>

        <div id="bo_v_btns">
            <?php ob_start(); ?>

            <?php if($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>

                <?php if ($reply_href) { ?>
                <a href="<?php echo $reply_href ?>" class="fl_btns">
                <span class="font-B">답글</span>
                </a>
                <?php } ?>

                <?php if ($update_href) { ?>
                <a href="<?php echo $update_href ?>" class="fl_btns">
                <span class="font-B">수정</span>
                </a>
                <?php } ?>

                <?php if ($copy_href) { ?>
                <a href="<?php echo $copy_href ?>" onclick="board_move(this.href); return false;" class="fl_btns">
                <span class="font-B">복사</span>
                </a>
                <?php } ?>

                <?php if ($copy_href) { ?>
                <a href="<?php echo $move_href ?>" onclick="board_move(this.href); return false;" class="fl_btns">
                <span class="font-B">이동</span>
                </a>
                <?php } ?>


                <?php if ($delete_href) { ?>
                <a href="<?php echo $delete_href ?>" onclick="del(this.href); return false;" class="fl_btns">
                <span class="font-B">삭제</span>
                </a>
                <?php } ?>

            <?php } ?>

            <?php
	        $link_buttons = ob_get_contents();
	        ob_end_flush();
	       ?>

        </div>


       <div class="cb"></div>

    </ul>

    <!-- 배너 {
    <ul class="bbs_bn_box">
        배너를 추가해보세요.
    </ul>
    } -->

    <?php
    if(isset($board['bo_use_signature']) && $board['bo_use_signature']) {
        // 서명 출력
        include_once(G5_PATH.'/rb/rb.mod/signature/signature.skin.php');
    }
    ?>

    <ul>
        <?php if ($prev_href || $next_href) { ?>
        <div class="bo_v_nb">
            <?php if ($prev_href) { ?><li class="btn_prv" onclick="location.href='<?php echo $prev_href ?>';"><span class="nb_tit">이전글</span><a href="javascript:void(0);"><?php echo $prev_wr_subject;?></a><span class="nb_date"><?php echo str_replace('-', '.', substr($prev_wr_date, '0', '10')); ?></span></li><?php } ?>
            <?php if ($next_href) { ?><li class="btn_next" onclick="location.href='<?php echo $next_href ?>';"><span class="nb_tit">다음글</span><a href="javascript:void(0);"><?php echo $next_wr_subject;?></a><span class="nb_date"><?php echo str_replace('-', '.', substr($next_wr_date, '0', '10')); ?></span></li><?php } ?>
        </div>
        <?php } ?>

        <?php
        // 코멘트 입출력
        include_once(G5_BBS_PATH.'/view_comment.php');
        ?>
    </ul>
