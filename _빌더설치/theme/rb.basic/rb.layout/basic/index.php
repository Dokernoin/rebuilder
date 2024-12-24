<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 레이아웃 폴더내 style.css 파일
add_stylesheet('<link rel="stylesheet" href="'.G5_THEME_URL.'/rb.layout/'.$rb_core['layout'].'/style.css">', 0);
?>

<!--
* 환경설정에서 모듈 추가를 사용하려면 반드시 class="flex_box" 를 포함해야 합니다.

* 참고사항
- 섹션을 좌/우 에 배치하는 경우
- <div class="flex_box left"></div>
- <div class="flex_box right"></div>
- 와 같이 class="flex_box" 를 두개로 배치한 후 css를 추가해주세요.

- 생성되는 모듈은 각 섹션의 좌측부터 순서대로 배치되며
- 지정된 width 를 벗어나면 줄바꿈 되어 생성 됩니다.

- class="flex_box" 를 사용하지 않고 직접 메인페이지를 구성할 수 있습니다.
-->

<div class="flex_box"></div>