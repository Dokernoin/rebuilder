<style>
    .gap_width_line_wrap {height:1px; border-top:1px solid rgba(0,0,0,0.1);}
</style>

<div class="gap_width_line_wrap gap_width_line_wrap_<?php echo $row_mod['md_id'] ?> pc"></div>

    <script>
        
        //부모 width를 무시하고 div 를 100%로 만들고, 모듈설정 버튼의 100% 처리를 위해 스크립트를 사용 합니다.
        //복제 사용을 위해 $row_mod['md_id'](모듈ID) 를 활용 합니다.
        
        function gap_width_line_wrap_<?php echo $row_mod['md_id'] ?>() {
            const content_w = $('.gap_width_line_wrap_<?php echo $row_mod['md_id'] ?>');
            const firstAdminOv_w = content_w.nextUntil('.admin_ov').next('.admin_ov');
            
            if ($(window).width() > <?php echo $rb_core['main_width'] ?>) {
                content_w.css({
                    'width': '100vw',
                    'position': 'relative',
                    'left': '50%',
                    'transform': 'translateX(-50%)'
                });
                firstAdminOv_w.css({
                    'width': '100vw',
                    'left': '50%',
                    'transform': 'translateX(-50%)'
                });
            } else {
                content_w.css({
                    'width': '100%',
                    'position': 'static',
                    'left': '0',
                    'transform': 'none'
                });
                firstAdminOv_w.css({
                    'width': '100%',
                    'left': '0',
                    'transform': 'none'
                });
            }
        }

        $(document).ready(gap_width_line_wrap_<?php echo $row_mod['md_id'] ?>);
        $(window).resize(gap_width_line_wrap_<?php echo $row_mod['md_id'] ?>);
    </script>