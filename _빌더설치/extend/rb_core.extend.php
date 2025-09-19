<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 500 에러가 나오시는 경우 아래 코드를 주석해제하셔서
// 보이는 에러구문을 알려주세요.

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

define('RB_VER',  '2.2.3.2'); // 버전

/*********************************************/

$rb_config = sql_fetch (" select * from rb_config "); // 환경설정 테이블 조회
$rb_builder = sql_fetch (" select * from rb_builder "); // 빌더설정 테이블 조회

$rb_core['theme'] = !empty($config['cf_theme']) ? $config['cf_theme'] : ''; // 테마
$rb_core['layout'] = !empty($rb_config['co_layout']) ? $rb_config['co_layout'] : ''; // 레이아웃(메인)
$rb_core['layout_hd'] = !empty($rb_config['co_layout_hd']) ? $rb_config['co_layout_hd'] : ''; // 레이아웃(헤더)
$rb_core['layout_ft'] = !empty($rb_config['co_layout_ft']) ? $rb_config['co_layout_ft'] : ''; // 레이아웃(푸터)
$rb_core['color'] = !empty($rb_config['co_color']) ? 'co_'.$rb_config['co_color'] : ''; // 강조컬러
$rb_core['header'] = !empty($rb_config['co_header']) ? 'co_header_'.$rb_config['co_header'] : ''; // 헤더스타일
$rb_core['font'] = !empty($rb_config['co_font']) ? $rb_config['co_font'] : ''; // 폰트스타일
$rb_core['sub_width'] = !empty($rb_config['co_sub_width']) ? $rb_config['co_sub_width'] : "1400"; // 서브가로사이즈
$rb_core['main_width'] = !empty($rb_config['co_main_width']) ? $rb_config['co_main_width'] : "1400"; // 메인가로사이즈
$rb_core['tb_width'] = !empty($rb_config['co_tb_width']) ? $rb_config['co_tb_width'] : "1400"; // 상단, 하단 가로사이즈
$rb_core['padding_top'] = !empty($rb_config['co_main_padding_top']) ? $rb_config['co_main_padding_top'] : "0"; // 상단, 하단 가로사이즈

/* 2.1.4 { */
$rb_core['gap_pc'] = !empty($rb_config['co_gap_pc']) ? $rb_config['co_gap_pc'] : '0'; // 간격
$rb_core['inner_padding_pc'] = !empty($rb_config['co_inner_padding_pc']) ? $rb_config['co_inner_padding_pc'] : '0'; // 내부여백
/* } */


/* 2.2 { */
$rb_core['side_skin'] = !empty($rb_config['co_side_skin']) ? $rb_config['co_side_skin'] : ''; // 사이드메뉴 스킨
$rb_core['side_skin_shop'] = !empty($rb_config['co_side_skin_shop']) ? $rb_config['co_side_skin_shop'] : ''; // 사이드메뉴 스킨 (마켓)
$rb_core['sidemenu'] = !empty($rb_config['co_sidemenu']) ? $rb_config['co_sidemenu'] : ''; // 사이드메뉴 여부, 위치
$rb_core['sidemenu_shop'] = !empty($rb_config['co_sidemenu_shop']) ? $rb_config['co_sidemenu_shop'] : ''; // 사이드메뉴 여부, 위치 (마켓)
$rb_core['sidemenu_width'] = !empty($rb_config['co_sidemenu_width']) ? $rb_config['co_sidemenu_width'] : '200'; // 사이드메뉴 가로크기
$rb_core['sidemenu_width_shop'] = !empty($rb_config['co_sidemenu_width_shop']) ? $rb_config['co_sidemenu_width_shop'] : '200'; // 사이드메뉴 가로크기 (마켓)
$rb_core['sidemenu_padding'] = !empty($rb_config['co_sidemenu_padding']) ? $rb_config['co_sidemenu_padding'] : '0'; // 사이드메뉴 여백
$rb_core['sidemenu_padding_shop'] = !empty($rb_config['co_sidemenu_padding_shop']) ? $rb_config['co_sidemenu_padding_shop'] : '0'; // 사이드메뉴 여백 (마켓)
$rb_core['sidemenu_hide'] = !empty($rb_config['co_sidemenu_hide']) ? $rb_config['co_sidemenu_hide'] : '0'; // 사이드메뉴 숨김
$rb_core['sidemenu_hide_shop'] = !empty($rb_config['co_sidemenu_hide_shop']) ? $rb_config['co_sidemenu_hide_shop'] : '0'; // 사이드메뉴 숨김 (마켓)
$rb_core['menu_shop'] = !empty($rb_config['co_menu_shop']) ? $rb_config['co_menu_shop'] : '0'; // 마켓 메뉴설정

// 현재 페이지 URL로 v_code 변환
$rb_page_url = $_SERVER['REQUEST_URI'];
$rb_page_urls = urldecode($rb_page_url);
$rb_page_urls = explode('?', $rb_page_urls)[0]; // 쿼리스트링 제거
$rb_page_urls = preg_replace('/\.php$/', '', $rb_page_urls);
$rb_page_urls = str_replace('/', '-', $rb_page_urls);
$rb_page_urls = ltrim($rb_page_urls, '-');


// 카테고리
if (strpos($_SERVER['REQUEST_URI'], '/adm/') === false) {
    if (isset($ca_id) && preg_match('/^\d+$/', $ca_id) && isset($w) && $w != "u") {
        $cate_id = implode('-', str_split($ca_id, 2)); // ex: 101010 → 10-10-10
        $rb_page_urls = 'shop-list-' . $cate_id;
    }
}

if (isset($bo_table) && $bo_table) {
    $rb_page_urls = 'bo-table-' . $bo_table;
} else if (isset($co_id) && $co_id) {
    $rb_page_urls = 'content-' . $co_id;
} else if (isset($gr_id) && $gr_id) {
    $rb_page_urls = 'group-' . $gr_id;
} else if (isset($it_id) && $it_id && isset($w) && $w != "u") {
    $rb_page_urls = 'item-' . $it_id;
} else if(isset($ev_id) && $ev_id) {
    $rb_page_urls = 'event-' . $ev_id;
} else if(isset($fr_id) && $fr_id) {
    $rb_page_urls = 'form-' . $fr_id;
}


// 노드 신규등록
rb_auto_insert_node_if_inherited($rb_page_urls);

$rb_page_sql = "SELECT * FROM rb_topvisual WHERE v_code = '{$rb_page_urls}'";
$rb_v_info = sql_fetch($rb_page_sql);

// 상위노드 검색
function rb_has_topvisual_all($v_code) {
    $parts = explode('-', $v_code);

    // 가장 긴 prefix부터 하나씩 줄여가며 탐색
    for ($i = count($parts) - 1; $i > 0; $i--) {
        $parent_code = implode('-', array_slice($parts, 0, $i));

        $sql = "SELECT COUNT(*) as cnt FROM rb_topvisual
                WHERE v_code = '{$parent_code}' AND co_topvisual_all = 1";
        $row = sql_fetch($sql);

        if (isset($row['cnt']) && $row['cnt'] > 0) {
            return true;
        }
    }

    return false;
}

// 노드가 등록되지않은 경우 인서트 (접속 기준 상위 노드를 찾는다)
function rb_auto_insert_node_if_inherited($v_code, $table = 'rb_topvisual') {
    // 1. 현재 노드가 DB에 존재하는지 확인
    $chk_sql = "SELECT COUNT(*) as cnt FROM {$table} WHERE v_code = '{$v_code}'";
    $chk = sql_fetch($chk_sql);

    if (isset($chk['cnt']) && $chk['cnt'] > 0) {
        return; // 이미 존재 → 등록 안함
    }

    $rb_page_url = $_SERVER['REQUEST_URI'];

    // 2. 상위 노드 중 co_topvisual_all = 1 인 노드 찾기
    $parts = explode('-', $v_code);
    for ($i = count($parts) - 1; $i > 0; $i--) {
        $parent_code = implode('-', array_slice($parts, 0, $i));

        $parent_sql = "SELECT * FROM {$table}
                       WHERE v_code = '{$parent_code}'
                         AND co_topvisual_all = 1
                       LIMIT 1";
        $parent = sql_fetch($parent_sql);

        if ($parent) {
            $v_url = $rb_page_url;
            $v_use = 1;
            $v_time = G5_TIME_YMDHIS;

            // 기본 필드
            $columns = ['v_code', 'v_name', 'v_url', 'v_use', 'co_topvisual_all', 'v_time'];
            $values  = ["'{$v_code}'", "''", "'{$v_url}'", "'{$v_use}'", "'0'", "'{$v_time}'"];

            // 스타일도 상속할 경우
            if (isset($parent['co_topvisual_style_all']) && intval($parent['co_topvisual_style_all']) === 1) {
                $style_fields = [
                    'co_topvisual_height',
                    'co_topvisual_width',
                    'co_topvisual_bl',
                    'co_topvisual_border',
                    'co_topvisual_radius',
                    'co_topvisual_m_color',
                    'co_topvisual_m_size',
                    'co_topvisual_m_font',
                    'co_topvisual_m_align',
                    'co_topvisual_s_color',
                    'co_topvisual_s_size',
                    'co_topvisual_s_font',
                    'co_topvisual_s_align',
                    'co_topvisual_bg_color',
                    'co_topvisual_main'
                ];

                foreach ($style_fields as $field) {
                    $columns[] = $field;
                    $values[]  = "'" . addslashes($parent[$field] ?? '') . "'";
                }
            }

            // INSERT 쿼리 실행
            $insert_sql = "INSERT INTO {$table} (" . implode(', ', $columns) . ")
                           VALUES (" . implode(', ', $values) . ")";
            sql_query($insert_sql);

            // 파일 복사: /data/topvisual/{parent_code}.txt / .jpg → {v_code}.txt / .jpg
            $topvisual_path = G5_DATA_PATH . '/topvisual';
            $exts = ['txt', 'jpg'];

            foreach ($exts as $ext) {
                $source = "{$topvisual_path}/{$parent_code}.{$ext}";
                $target = "{$topvisual_path}/{$v_code}.{$ext}";

                if (file_exists($source)) {
                    @copy($source, $target);
                }
            }
            break;
        }
    }
}


// 상위노드명 출력
function rb_get_inherited_topvisual_node($v_code, $table = 'rb_topvisual') {
    $parts = explode('-', $v_code);

    for ($i = count($parts) - 1; $i > 0; $i--) {
        $parent_code = implode('-', array_slice($parts, 0, $i));

        $sql = "SELECT v_code, v_name, v_url FROM {$table}
                WHERE v_code = '{$parent_code}' AND co_topvisual_all = 1 LIMIT 1";
        $row = sql_fetch($sql);

        if ($row) {
            return $row; // 전체 정보 반환
        }
    }

    return null;
}


// 기본 조건: 현재 노드가 사용 또는 전체사용일 때
if (isset($rb_v_info['v_use']) && in_array(intval($rb_v_info['v_use']), [1, 2])) {
    $should_show_visual = true;
}

// 추가 조건: 상위 노드 중 co_topvisual_all = 1이 있는 경우
elseif (rb_has_topvisual_all($rb_page_urls)) {
    $should_show_visual = true;
}

$rb_v_info['topvisual_height'] = !empty($rb_v_info['co_topvisual_height']) ? $rb_v_info['co_topvisual_height'] : '200'; // 상단영역 세로크기
$rb_v_info['topvisual_width'] = !empty($rb_v_info['co_topvisual_width']) ? $rb_v_info['co_topvisual_width'] : ''; // 상단영역 가로크기
$rb_v_info['topvisual_bl'] = isset($rb_v_info['co_topvisual_bl']) ? $rb_v_info['co_topvisual_bl'] : '10'; // 상단영역 블라인드

$rb_v_info['topvisual_border'] = isset($rb_v_info['co_topvisual_border']) ? $rb_v_info['co_topvisual_border'] : '0'; // 상단영역 테두리
$rb_v_info['topvisual_radius'] = isset($rb_v_info['co_topvisual_radius']) ? $rb_v_info['co_topvisual_radius'] : '10'; // 상단영역 라운드

$rb_v_info['topvisual_m_color'] = !empty($rb_v_info['co_topvisual_m_color']) ? $rb_v_info['co_topvisual_m_color'] : '#ffffff'; // 상단영역 메인워딩 컬러
$rb_v_info['topvisual_m_size'] = !empty($rb_v_info['co_topvisual_m_size']) ? $rb_v_info['co_topvisual_m_size'] : '20'; // 상단영역 메인워딩 사이즈
$rb_v_info['topvisual_m_font'] = !empty($rb_v_info['co_topvisual_m_font']) ? $rb_v_info['co_topvisual_m_font'] : 'font-B'; // 상단영역 메인워딩 두께
$rb_v_info['topvisual_m_align'] = !empty($rb_v_info['co_topvisual_m_align']) ? $rb_v_info['co_topvisual_m_align'] : 'left'; // 상단영역 메인워딩 정렬

$rb_v_info['topvisual_s_color'] = !empty($rb_v_info['co_topvisual_s_color']) ? $rb_v_info['co_topvisual_s_color'] : '#ffffff'; // 상단영역 서브워딩 컬러
$rb_v_info['topvisual_s_size'] = !empty($rb_v_info['co_topvisual_s_size']) ? $rb_v_info['co_topvisual_s_size'] : '16'; // 상단영역 서브워딩 사이즈
$rb_v_info['topvisual_s_font'] = !empty($rb_v_info['co_topvisual_s_font']) ? $rb_v_info['co_topvisual_s_font'] : 'font-R'; // 상단영역 서브워딩 두께
$rb_v_info['topvisual_s_align'] = !empty($rb_v_info['co_topvisual_s_align']) ? $rb_v_info['co_topvisual_s_align'] : 'left'; // 상단영역 서브워딩 정렬

$rb_v_info['topvisual_bg_color'] = !empty($rb_v_info['co_topvisual_bg_color']) ? $rb_v_info['co_topvisual_bg_color'] : '#f9f9f9';
$rb_v_info['topvisual_style_all'] = !empty($rb_v_info['co_topvisual_style_all']) ? $rb_v_info['co_topvisual_style_all'] : '0';

/* } */

/* 2.2.3 { */

$rb_core['padding_top'] = isset($rb_config['co_padding_top']) ? $rb_config['co_padding_top'] : '';
$rb_core['padding_top_sub'] = isset($rb_config['co_padding_top_sub']) ? $rb_config['co_padding_top_sub'] : '';
$rb_core['padding_top_shop'] = isset($rb_config['co_padding_top_shop']) ? $rb_config['co_padding_top_shop'] : '';
$rb_core['padding_top_sub_shop'] = isset($rb_config['co_padding_top_sub_shop']) ? $rb_config['co_padding_top_sub_shop'] : '';

$rb_core['padding_btm'] = isset($rb_config['co_padding_btm']) ? $rb_config['co_padding_btm'] : '';
$rb_core['padding_btm_sub'] = isset($rb_config['co_padding_btm_sub']) ? $rb_config['co_padding_btm_sub'] : '';
$rb_core['padding_btm_shop'] = isset($rb_config['co_padding_btm_shop']) ? $rb_config['co_padding_btm_shop'] : '';
$rb_core['padding_btm_sub_shop'] = isset($rb_config['co_padding_btm_sub_shop']) ? $rb_config['co_padding_btm_sub_shop'] : '';

// 여백 인라인 스타일
function rb_inline_padding($arr, $key, $prop = null) {
    if (!is_array($arr) || !is_string($key) || $key === '') return '';

    $v = array_key_exists($key, $arr) ? $arr[$key] : '';
    if ($v === '' || $v === null || !is_scalar($v)) return '';

    $v = trim((string)$v);
    if ($v === '' || !is_numeric($v)) return '';

    $n = (float)$v;
    if ($n < 0) return '';

    // 방향 결정
    $css = '';
    if ($prop !== null && $prop !== '') {
        switch (strtolower(trim($prop))) {
            case 'top':    $css = 'padding-top';    break;
            case 'bottom': $css = 'padding-bottom'; break;
            case 'left':   $css = 'padding-left';   break;
            case 'right':  $css = 'padding-right';  break;
            default: return ''; // 잘못된 값이면 출력 안 함
        }
    } else {
        $tokens = preg_split('/[_\-]+/', strtolower($key)) ?: array(strtolower($key));
        if     (in_array('bottom', $tokens, true) || in_array('btm', $tokens, true)) $css = 'padding-bottom';
        elseif (in_array('left',   $tokens, true))                                   $css = 'padding-left';
        elseif (in_array('right',  $tokens, true))                                   $css = 'padding-right';
        elseif (in_array('top',    $tokens, true))                                   $css = 'padding-top';
        else return ''; // 방향 못 찾으면 출력 안 함
    }

    return $css . ':' . (int)$n . 'px;';
}

/* } */


//영카트 사용여부
$rb_core['layout_shop'] = !empty($rb_config['co_layout_shop']) ? $rb_config['co_layout_shop'] : ''; // 레이아웃(메인)
$rb_core['layout_hd_shop'] = !empty($rb_config['co_layout_hd_shop']) ? $rb_config['co_layout_hd_shop'] : ''; // 레이아웃(헤더)
$rb_core['layout_ft_shop'] = !empty($rb_config['co_layout_ft_shop']) ? $rb_config['co_layout_ft_shop'] : ''; // 레이아웃(푸터)
//$rb_core['padding_top_shop'] = !empty($rb_config['co_main_padding_top_shop']) ? $rb_config['co_main_padding_top_shop'] : "0";

$rb_core['color'] = str_replace('#', '', $rb_core['color']); // # 제거 2.1.4
$rb_core['header'] = str_replace('#', '', $rb_core['header']); // # 제거 2.1.4

if(isset($rb_core['tb_width']) && $rb_core['tb_width'] == "100") {
    $tb_width_inner = "100%";
    $tb_width_padding = "padding:0px 40px";
} else { 
    $tb_width_inner = $rb_core['tb_width']."px";
    $tb_width_padding = "";
}

if(isset($rb_core['main_width']) && $rb_core['main_width'] == "100") {
    $rb_main_wide = "rb_main_wide";
} else {
    $rb_main_wide = "";
}

if(isset($rb_core['sub_width']) && $rb_core['sub_width'] == "100") {
    $rb_sub_wide = "rb_sub_wide";
} else {
    $rb_sub_wide = "";
}

// SEO설정
$sql_seo = " select * from rb_seo limit 1";
$seo = sql_fetch($sql_seo);



/*********************************************/


// SIR @트리플님 코드적용 // 출처 : https://sir.kr/g5_tip/21657
add_event('tail_sub', 'prism_tail_sub', G5_HOOK_DEFAULT_PRIORITY);
add_replace('html_purifier_result', 'prism_html_purifier_result', 10, 3);
function prism_script(){
    add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/rb/rb.mod/prism/prism.css">', -2);
    $sh = '<script src="'.G5_URL.'/rb/rb.mod/prism/prism.js"></script>'.PHP_EOL;
    $sh .= '<script>var is_SyntaxHighlighter = true;</script>';
    add_javascript($sh, 0);
}
function prism_tail_sub(){
    global $wr_id;
    if($_SERVER['SCRIPT_NAME'] != '/bbs/board.php' || !$wr_id) return;
    prism_script();
}
function PrismJS($m) {
    $str = isset($m[3]) ? $m[3] : '';
    if(!$str)
        return;
    $str = stripslashes($str);
    $str = preg_replace("/(<br>|<br \/>|<br\/>|<p>)/i", "\n", $str);
    $str = preg_replace("/(<div>|<\/div>|<\/p>)/i", "", $str);
    $str = str_replace(" ", " ", $str);
    $str = str_replace("/</", "<", $str);
    $str = str_replace("/[/", "&lsqb;", $str);
    $str = str_replace("/{/", "&lcub;", $str);
    if(!$str)
        return;
    //$brush = isset($m[2]) ? strtolower(trim($m[2])) : 'html';
    $brush = 'php';
    //prism_script();
    return '<div class="line-numbers"><pre><code class="language-'.$brush.'">'.$str.'</code></pre></div>'.PHP_EOL;
}
function prism_html_purifier_result($str){
    $content = preg_replace_callback("/(\[code\]|\[code=(.*)\])(.*)\[\/code\]/iUs", "PrismJS", $str); // PrismJS
    return $content;
}

// 문자 발송 함수 @SIR 플래토님 코드사용 출처 : https://sir.kr/g5_tip/8262
function smsSend($sHp, $rHp, $msg) {      
    global $g5, $config;
    $rtn = "";
    try {
        $send_hp = str_replace("-","",$sHp); // - 제거 
        $recv_hp = str_replace("-","",$rHp); // - 제거         
        $SMS = new SMS; // SMS 객체 생성
        $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']); 
        $SMS->Add($recv_hp, $send_hp, $config['cf_icode_id'], iconv("utf-8", "euc-kr", stripslashes($msg)), ""); 
        $SMS->Send(); 
        $rtn = true;
    }
    catch(Exception $e) {
        alert("처리중 문제가 발생했습니다.".$e->getMessage());
        $rtn = false;
    }
    return $rtn;
}

// 새글에 NEW 아이콘
function get_new_ico($bo_table, $ca_name) {
    
    global $g5;


    $new_icon = '';
    $bbs = sql_fetch("select * from {$g5['board_table']} where bo_table = '{$bo_table}'");


    if($bbs && isset($bbs['bo_table'])) {
        $write_table = $g5['write_prefix'].$bbs['bo_table'];
        if(isset($ca_name) && !empty($ca_name)) {
            $time = sql_fetch("select * from {$write_table} where wr_is_comment = 0 and ca_name = '{$ca_name}' order by wr_id desc limit 1");
        } else { 
            $time = sql_fetch("select * from {$write_table} where wr_is_comment = 0 order by wr_id desc limit 1");
        }
    }


    if (isset($bbs['bo_new']) && isset($time['wr_datetime']) && $time['wr_datetime'] >= date("Y-m-d H:i:s", G5_SERVER_TIME - ($bbs['bo_new'] * 3600))) {
        $new_icon = '<span class="gnb_new_ico">n</span>';
    }


    return $new_icon;
}

    
// 전체 URL (SEO)
function getCurrentUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    
    return $protocol . $host . $requestUri;
}


// 안읽은 쪽지
if ($is_member) {
    if( isset($member['mb_memo_cnt']) ){
        $memo_not_read = $member['mb_memo_cnt'];
    } else {
        $memo_not_read = get_memo_not_read($member['mb_id']);
    }
}

// 날자계산
function passing_time($datetime) {
	$time_lag = time() - strtotime($datetime);
	
	if($time_lag < 60) {
		$posting_time = "방금";
	} else if($time_lag >= 60 and $time_lag < 3600) {
		$posting_time = floor($time_lag/60)."분 전";
	} else if($time_lag >= 3600 and $time_lag < 86400) {
		$posting_time = floor($time_lag/3600)."시간 전";
	} else if($time_lag >= 86400 and $time_lag < 2419200) {
		$posting_time = floor($time_lag/86400)."일 전";
	} else {
		$posting_time = date("Y.m.d", strtotime($datetime));
	} 
	
	return $posting_time;
}

// 날자계산2
function passing_time2($datetime) {
	$time_lag = time() - strtotime($datetime);
	
	if($time_lag < 60) {
		$posting_time = "방금<br>".date("Y.m.d", strtotime($datetime));
	} else if($time_lag >= 60 and $time_lag < 3600) {
		$posting_time = floor($time_lag/60)."분 전<br>".date("Y.m.d", strtotime($datetime));
	} else if($time_lag >= 3600 and $time_lag < 86400) {
		$posting_time = floor($time_lag/3600)."시간 전<br>".date("Y.m.d", strtotime($datetime));
	} else if($time_lag >= 86400 and $time_lag < 2419200) {
		$posting_time = floor($time_lag/86400)."일 전<br>".date("Y.m.d", strtotime($datetime));
	} else {
        $posting_time = "오래 전<br>".date("Y.m.d", strtotime($datetime));
	} 
	
	return $posting_time;
}

// 날자계산3
function passing_time3($datetime) {
	$time_lag = time() - strtotime($datetime);
	
	if($time_lag < 60) {
		$posting_time = "방금";
	} else if($time_lag >= 60 and $time_lag < 3600) {
		$posting_time = floor($time_lag/60)."분 전";
	} else if($time_lag >= 3600 and $time_lag < 86400) {
		$posting_time = floor($time_lag/3600)."시간 전";
	} else if($time_lag >= 86400 and $time_lag < 2419200) {
		$posting_time = floor($time_lag/86400)."일 전";
	} else {
        $posting_time = "오래 전";
	} 
	
	return $posting_time;
}

// 회원 게시물 갯수
function wr_cnt($mb_id, $type){
    global $g5;

    $wr_sum = 0;
    $sql = sql_query(" select bo_table from {$g5['board_table']} ");
    
    while($row = sql_fetch_array($sql)) {
        
        $write_table = $g5['write_prefix'] . $row['bo_table'];
        
        if($type == "w") {
            $sql2 = " select count(*) as cnt from {$write_table} where mb_id = '{$mb_id}' and wr_is_comment = 0 ";
        } else if ($type == "c") {
            $sql2 = " select count(*) as cnt from {$write_table} where mb_id = '{$mb_id}' and wr_is_comment = 1 ";
        }
        $wr = sql_fetch($sql2);
        $wr_sum += $wr['cnt'];
    }

    return $wr_sum;
}


// 생성된 게시판 목록조회
function rb_board_list($bo_tables) {
    global $g5;
    
    $str = ""; // 초기화
    
    $sql = " select bo_table, bo_subject from {$g5['board_table']} group by bo_table order by bo_table asc"; 
    $result = sql_query($sql); 
    
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    { 
        if($bo_tables == $row['bo_table']) {
            $str .= "<option value='$row[bo_table]' selected"; 
        } else { 
            $str .= "<option value='$row[bo_table]'"; 
        }
        
        $str .= ">$row[bo_subject] ($row[bo_table])</option>"; 
    } 
    return $str; 
}

// 카테고리 목록조회
function rb_sca_list($md_bo_table, $md_sca) {
    global $g5;
    
    $str = ""; // 초기화
    
    $res_ca = sql_fetch (" select bo_category_list from {$g5['board_table']} where bo_table = '{$md_bo_table}' and bo_use_category = '1' "); 
    $cat = $res_ca['bo_category_list'];
    $cat_opt = explode("|", $cat);
    
    if($cat) {
        foreach($cat_opt as $option):
            if($md_sca == $option) {
                $str .= "<option value='$option' selected>$option</option>";
            } else { 
                $str .= "<option value='$option'>$option</option>";
            }
        endforeach;
    }

    return $str; 
}


// 생성된 투표 목록조회
function rb_poll_list($poll_id) {
    global $g5;
    $sql = " select po_id, po_subject from {$g5['poll_table']} where po_use = '1' order by po_id asc"; 
    $result = sql_query($sql); 
    
    $str = ""; // 초기화
    
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    { 
        if($poll_id == $row['po_id']) {
            $str .= "<option value='$row[po_id]' selected"; 
        } else { 
            $str .= "<option value='$row[po_id]'"; 
        }
        
        $str .= ">$row[po_subject]</option>"; 
    } 
    return $str; 
}


// 생성된 배너그룹 목록조회
function rb_banner_group_list($bn_position) {
    $sql = " select bn_position from rb_banner where bn_position NOT IN ('개별출력', '미출력') group by bn_position order by bn_position asc "; 
    $result = sql_query($sql); 
    
    $str = ""; // 초기화
    
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    { 
        if($bn_position == $row['bn_position']) {
            $str .= "<option value='$row[bn_position]' selected"; 
        } else { 
            $str .= "<option value='$row[bn_position]'"; 
        }
        
        $str .= ">$row[bn_position]</option>"; 
    } 
    return $str; 
}

// 생성된 배너 목록조회
function rb_banner_list($bn_position) {
    $sql = " select bn_id, bn_position, bn_alt from rb_banner where bn_position NOT IN ('미출력') group by bn_position order by bn_id asc"; 
    $result = sql_query($sql); 
    
    $str = ""; // 초기화
    
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    { 
        if($bn_position == $row['bn_position']) {
            $str .= "<option value='$row[bn_position]' selected"; 
        } else { 
            $str .= "<option value='$row[bn_position]'"; 
        }
        
        $str .= ">$row[bn_position]</option>"; 
    } 
    return $str; 
}

// 생성된 개별출력 배너 목록조회
function rb_banner_id_list($bn_id) {
    $sql = " select bn_id, bn_position, bn_alt from rb_banner where bn_position = '개별출력' order by bn_id asc"; 
    $result = sql_query($sql); 
    
    $str = ""; // 초기화
    
    for ($i=0; $row=sql_fetch_array($result); $i++) 
    { 
        if($bn_id == $row['bn_id']) {
            $str .= "<option value='$row[bn_id]' selected"; 
        } else { 
            $str .= "<option value='$row[bn_id]'"; 
        }
        
        $str .= ">$row[bn_alt] ($row[bn_id]) </option>"; 
    } 
    return $str; 
}



// 배너가 있는지 검사
function rb_banner_select_is($bn_position) {
    $sql = sql_fetch("SELECT COUNT(*) as cnt FROM rb_banner where bn_position NOT IN ('미출력') AND bn_position = '{$bn_position}'");
    $str = "false"; // 기본값 설정

    if ($sql['cnt'] > 0) {
        $str = "true";
    }

    return $str;
}


// 디렉토리 조회
function rb_dir_select($skin_gubun, $selected = '')
{
    global $config;
    
    $str = "";

    $skins = array();


        $dirs = rb_skin_dir($skin_gubun, G5_THEME_PATH . '/');
        if (!empty($dirs)) {
            foreach ($dirs as $dir) {
                $skins[] = 'theme/' . $dir;
            }
        }


    $skins = array_merge($skins, rb_skin_dir($skin_gubun));


    for ($i = 0; $i < count($skins); $i++) {

        if (preg_match('#^theme/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
        }
        
        if(strpos($skins[$i], "theme/") !== false) {
            if (!isset($str)) {
                $str = '';
            }
            $str .= option_selected($text, $selected, $text);
        }
    }

    return $str;
}


// 디렉토리 조회 (영카트)
function rb_dir_select_shop($skin_gubun, $selected = '')
{
    global $config;
    
    $str = "";

    $skins = array();


        $dirs = rb_skin_dir($skin_gubun, G5_THEME_PATH . '/shop/');
        if (!empty($dirs)) {
            foreach ($dirs as $dir) {
                $skins[] = 'theme/' . $dir;
            }
        }


    $skins = array_merge($skins, rb_skin_dir($skin_gubun));


    for ($i = 0; $i < count($skins); $i++) {

        if (preg_match('#^theme/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
        }
        
        if(strpos($skins[$i], "theme/") !== false) {
            if (!isset($str)) {
                $str = '';
            }
            $str .= option_selected($text, $selected, $text);
        }
    }

    return $str;
}



// 스킨디렉토리에 지정한 스킨이 있는지 여부 검사
function rb_skin_select_is($skin_gubun, $selected = '')
{
    global $config;

    $skins = array();
    $str = "false"; // 기본값 설정

    if (defined('G5_THEME_PATH') && $config['cf_theme']) {
        $dirs = rb_skin_dir($skin_gubun, G5_THEME_PATH . '/' . G5_SKIN_DIR);
        if (!empty($dirs)) {
            foreach ($dirs as $dir) {
                $skins[] = 'theme/' . $dir;
            }
        }
    }

    $skins = array_merge($skins, rb_skin_dir($skin_gubun));

    for ($i = 0; $i < count($skins); $i++) {
        if (strpos($skins[$i], "theme/") !== false) {
            if ($skins[$i] == $selected) {
                $str = "true";
            }
        }
    }

    return $str;
}




// 스킨디렉토리 조회
function rb_skin_select($skin_gubun, $selected = '')
{
    global $config;
    
    $str = "";

    $skins = array();

    if (defined('G5_THEME_PATH') && $config['cf_theme']) {
        $dirs = rb_skin_dir($skin_gubun, G5_THEME_PATH . '/' . G5_SKIN_DIR);
        if (!empty($dirs)) {
            foreach ($dirs as $dir) {
                $skins[] = 'theme/' . $dir;
            }
        }
    }

    $skins = array_merge($skins, rb_skin_dir($skin_gubun));


    for ($i = 0; $i < count($skins); $i++) {

        if (preg_match('#^theme/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
        }
        
        if(strpos($skins[$i], "theme/") !== false) {
            $str .= option_selected($skins[$i], $selected, $text);
        }
    }

    return $str;
}


                      
// 스킨디렉토리 조회 내부함수
function rb_skin_dir($skin, $skin_path = G5_SKIN_PATH)
{
    global $g5;

    $result_array = array();

    $dirname = $skin_path . '/' . $skin . '/';
    if (!is_dir($dirname)) {
        return array();
    }

    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if ($file == '.' || $file == '..') {
            continue;
        }

        if (is_dir($dirname . $file)) {
            $result_array[] = $file;
        }
    }
    closedir($handle);
    sort($result_array);

    return $result_array;
}



// 위젯디렉토리에 지정한 위젯이 있는지 여부 검사
function rb_widget_select_is($skin_gubun, $selected = '')
{
    global $config;

    $skins = array();
    $str = "false"; // 기본값 설정

    $dirs = rb_widget_dir($skin_gubun, G5_PATH . '/rb');
    if (!empty($dirs)) {
        foreach ($dirs as $dir) {
            $skins[] = 'rb.widget/' . $dir;
        }
    }

    $skins = array_merge($skins, rb_skin_dir($skin_gubun));

    for ($i = 0; $i < count($skins); $i++) {
        if (strpos($skins[$i], "rb.widget/") !== false) {
            if ($skins[$i] == $selected) {
                $str = "true";
                break; // 선택된 스킨을 찾으면 반복문을 종료
            }
        }
    }

    return $str;
}



// 위젯디렉토리 조회
function rb_widget_select($skin_gubun, $selected = '')
{
    global $config;
    
    $str = "";

    $skins = array();


        $dirs = rb_widget_dir($skin_gubun, G5_PATH . '/rb');
        if (!empty($dirs)) {
            foreach ($dirs as $dir) {
                $skins[] = 'rb.widget/' . $dir;
            }
        }


    $skins = array_merge($skins, rb_widget_dir($skin_gubun));


    for ($i = 0; $i < count($skins); $i++) {

        if (preg_match('#^rb.widget/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
        }
        
        if(strpos($skins[$i], "rb.widget/") !== false) {
            $str .= option_selected($skins[$i], $selected, $text);
        }
    }

    return $str;
}

// 위젯디렉토리 조회 내부함수
function rb_widget_dir($skin, $skin_path = G5_SKIN_PATH)
{
    global $g5;

    $result_array = array();

    $dirname = $skin_path . '/' . $skin . '/';
    if (!is_dir($dirname)) {
        return array();
    }

    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if ($file == '.' || $file == '..') {
            continue;
        }

        if (is_dir($dirname . $file)) {
            $result_array[] = $file;
        }
    }
    closedir($handle);
    sort($result_array);

    return $result_array;
}



// 배너스킨 디렉토리 조회
function rb_banner_skin_select($skin_gubun, $selected = '')
{
    global $config;
    
    $str = "";

    $skins = array();


        $dirs = rb_banner_dir($skin_gubun, G5_PATH . '/rb');
        if (!empty($dirs)) {
            foreach ($dirs as $dir) {
                $skins[] = 'rb.mod/banner/skin/' . $dir;
            }
        }


    $skins = array_merge($skins, rb_widget_dir($skin_gubun));


    for ($i = 0; $i < count($skins); $i++) {

        if (preg_match('#^rb.mod/banner/skin/(.+)$#', $skins[$i], $match)) {
            $text = $match[1];
        }
        
        if(strpos($skins[$i], "rb.mod/banner/skin/") !== false) {
            $str .= option_selected($skins[$i], $selected, $text);
        }
    }

    return $str;
}

// 배너 스킨 디렉토리 조회 내부함수
function rb_banner_dir($skin, $skin_path = G5_SKIN_PATH)
{
    global $g5;

    $result_array = array();

    $dirname = $skin_path . '/' . $skin . '/';
    if (!is_dir($dirname)) {
        return array();
    }

    $handle = opendir($dirname);
    while ($file = readdir($handle)) {
        if ($file == '.' || $file == '..') {
            continue;
        }

        if (is_dir($dirname . $file)) {
            $result_array[] = $file;
        }
    }
    closedir($handle);
    sort($result_array);

    return $result_array;
}

// 쪽지발송 (쪽지타입, 제목, 링크주소, 수신ID, 발신ID)
if (isset($app['ap_title'], $app['ap_key'], $app['ap_pid']) && $app['ap_title'] && $app['ap_key'] && $app['ap_pid']) { //푸시사용시

    function memo_auto_send($title, $link_url, $recv_id, $send_id) {
        global $g5, $app, $config, $rb_builder;

        // 최대 메모 ID 가져오기
        $me = sql_fetch("SELECT max(me_id) as new_me_id FROM {$g5['memo_table']}");
        $me_id = $me ? $me['new_me_id'] + 1 : 1;

        $memo_cont = $title . "\n" . $link_url;
        $memo_cont_push = $title;

        $recv = $recv_id; // 수신 아이디
        $send = $send_id; // 발신 아이디
        $memo = $memo_cont;
        $memo_push = $memo_cont_push;
        
        // 수신아이디가 관리자이고, 시스템 메세지 일때 수신여부를 체크함 (작업중)
        if($recv == $config['cf_admin'] && $send == "system-msg") {
            
            if(isset($rb_builder['bu_systemmsg_use']) && $rb_builder['bu_systemmsg_use'] == 1) {
            
                $sql_msg = "INSERT INTO {$g5['memo_table']} SET me_id = '{$me_id}', me_recv_mb_id = '{$recv}', me_send_mb_id = '{$send}', me_send_datetime = '".G5_TIME_YMDHIS."', me_memo = '".addslashes($memo)."', me_type = 'recv'";
                sql_query($sql_msg);

                $sql_al = "UPDATE {$g5['member_table']} SET mb_memo_call = 'system-msg', mb_memo_cnt = '".get_memo_not_read($recv)."' WHERE mb_id = '{$recv}'";
                sql_query($sql_al);

            }
            

        } else { 

            $sql_msg = "INSERT INTO {$g5['memo_table']} SET me_id = '{$me_id}', me_recv_mb_id = '{$recv}', me_send_mb_id = '{$send}', me_send_datetime = '".G5_TIME_YMDHIS."', me_memo = '".addslashes($memo)."', me_type = 'recv'";
            sql_query($sql_msg);

            $sql_al = "UPDATE {$g5['member_table']} SET mb_memo_call = 'system-msg', mb_memo_cnt = '".get_memo_not_read($recv)."' WHERE mb_id = '{$recv}'";
            sql_query($sql_al);
            
        }

        // PWA 푸시
        if (function_exists('send_pwa_if_needed')) {
            send_pwa_if_needed($recv, $send, '시스템 알림', $link_url, $memo_push);
        }

        // 웹앱 푸시
        if (function_exists('send_push_if_needed')) {
            send_push_if_needed($recv, $memo_push, $ap_key);
        }

    }

    function send_push_if_needed($recv, $body, $api_key) {
        global $config, $app;

        $title = "시스템 알림";

        if ($recv) {
            $mb = get_member($recv);
            $send_push = ($recv == $config['cf_admin'] && $app['ap_systems_msg'] == 1) || (isset($mb['mb_sms']) && $mb['mb_sms'] == 1);

            if ($send_push) {
                $tokens = get_user_tokens($recv);
                if (!empty($tokens)) {
                    $jsonKeyFilePath = G5_DATA_PATH . '/push/' . addslashes($api_key); // 비공개키 파일 경로
                    sendPushNotificationAsync($tokens, $title, $body, $jsonKeyFilePath); // 비동기 발송 처리 함수
                }
            }
        }
    }

    function get_user_tokens($recv) {
        global $g5;
        $tokens = [];
        $sql = "SELECT tk_token FROM rb_app_token WHERE tk_token != '' and mb_id = '{$recv}'";
        $result = sql_query($sql);

        while ($row = sql_fetch_array($result)) {
            $tokens[] = $row['tk_token'];
        }
        return $tokens;
    }

    function sendPushNotificationAsync($tokens, $title, $body, $jsonKeyFilePath) {
        $postData = json_encode([
            'tokens' => $tokens,
            'title' => $title,
            'body' => $body,
            'jsonKeyFilePath' => $jsonKeyFilePath
        ]);

        $ch = curl_init(G5_URL.'/rb/rb.lib/curl.send_push.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, 100);
        curl_exec($ch);
        curl_close($ch);
    }

} else { // 일반

    function memo_auto_send($title, $link_url, $recv_id, $send_id) {
        global $g5, $config, $rb_builder;

        $me = sql_fetch("SELECT max(me_id) as new_me_id FROM {$g5['memo_table']}");
        $me_id = $me ? $me['new_me_id'] + 1 : 1;

        $memo_cont = $title . "\n" . $link_url;

        $recv = $recv_id; // 수신 아이디
        $send = $send_id; // 발신 아이디
        $memo = $memo_cont;
        
        // 수신아이디가 관리자이고, 시스템 메세지 일때 수신여부를 체크함 (작업중)
        if($recv == $config['cf_admin'] && $send == "system-msg") {
            
            if(isset($rb_builder['bu_systemmsg_use']) && $rb_builder['bu_systemmsg_use'] == 1) {
                
                $sql_msg = "INSERT INTO {$g5['memo_table']} SET me_id = '{$me_id}', me_recv_mb_id = '{$recv}', me_send_mb_id = '{$send}', me_send_datetime = '".G5_TIME_YMDHIS."', me_memo = '".addslashes($memo)."', me_type = 'recv'";
                sql_query($sql_msg);

                $sql_al = "UPDATE {$g5['member_table']} SET mb_memo_call = 'system-msg', mb_memo_cnt = '".get_memo_not_read($recv)."' WHERE mb_id = '{$recv}'";
                sql_query($sql_al);

            }
            
        } else { 

            $sql_msg = "INSERT INTO {$g5['memo_table']} SET me_id = '{$me_id}', me_recv_mb_id = '{$recv}', me_send_mb_id = '{$send}', me_send_datetime = '".G5_TIME_YMDHIS."', me_memo = '".addslashes($memo)."', me_type = 'recv'";
            sql_query($sql_msg);

            $sql_al = "UPDATE {$g5['member_table']} SET mb_memo_call = 'system-msg', mb_memo_cnt = '".get_memo_not_read($recv)."' WHERE mb_id = '{$recv}'";
            sql_query($sql_al);
            
        }
        
        // PWA 푸시
        if (function_exists('send_pwa_if_needed')) {
            send_pwa_if_needed($recv, $send, '시스템 알림', $link_url, $memo_push);
        }

    }
}



// 바이트 환산
function byteFormat($bytes, $unit = "", $decimals = 0) {
    $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);
    $value = 0;

    if ($bytes > 0) {

        // Generate automatic prefix by bytes 
        // If wrong prefix given
        if (!array_key_exists($unit, $units)) {
            $pow = floor(log($bytes)/log(1024));
            $unit = array_search($pow, $units);

        }

        // Calculate byte value by prefix
        $value = ($bytes/pow(1024,floor($units[$unit])));

    }


    // If decimals is not numeric or decimals is less than 0 
    // then set default value

    if (!is_numeric($decimals) || $decimals < 0) {
        $decimals = 2;
    }

    // Format output
    return sprintf('%.' . $decimals . 'f '.$unit, $value);

}

// 최신글 함수(메인용)
function rb_latest($bo_table, $skin_dir='', $rows=10, $subject_len=40, $cache_time=1, $options='', $md_sca='', $md_order='', $rb_module_table='', $is_notice=0)
{
    global $g5;

    if (!$skin_dir) $skin_dir = 'basic';
    $time_unit = 3600;  // 1시간으로 고정

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            if(!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if(G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest/'.$skin_dir;
        }
    }

    $caches = false;

    if(G5_USE_CACHE) {
        $cache_file_name = "latest-{$bo_table}-{$skin_dir}-{$md_sca}-{$md_order}-{$rows}-{$subject_len}-{$is_notice}-".g5_cache_secret_key();
        $caches = g5_get_cache($cache_file_name, (int) $time_unit * (int) $cache_time);
        $cache_list = isset($caches['list']) ? $caches['list'] : array();
        g5_latest_cache_data($bo_table, $cache_list);
    }

    if( $caches === false ){

        $list = array();

        $board = get_board_db($bo_table, true);
        if( ! $board ){
            return '';
        }

        $bo_subject = get_text($board['bo_subject']);
        $tmp_write_table = $g5['write_prefix'] . $bo_table;
        $notice_ids = array_filter(array_map('trim', explode(',', $board['bo_notice'])));
        $notice_ids_str = count($notice_ids) ? implode(',', $notice_ids) : '';



        if ($is_notice == 1 && $notice_ids_str) {
            // 공지글 상단 고정, 정렬옵션 상관없이 항상 위에!
            $sql = "SELECT * FROM {$tmp_write_table} WHERE wr_is_comment = 0";
            if($md_sca) $sql .= " AND ca_name = '{$md_sca}' ";
            // 공지글이면 0, 아니면 1 → 무조건 공지글이 먼저!
            $sql .= " ORDER BY (CASE WHEN wr_id IN ($notice_ids_str) THEN 0 ELSE 1 END), ";
            if($md_order) {
                $sql .= " {$md_order} ";   // 일반글은 정렬옵션 적용
            } else {
                $sql .= " wr_num ";
            }
            $sql .= " LIMIT 0, {$rows} ";

            $result = sql_query($sql);
            for ($i=0; $row = sql_fetch_array($result); $i++) {
                unset($row['wr_password']);
                $row['wr_email'] = '';
                if (strstr($row['wr_option'], 'secret')){
                    $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                    $row['file'] = array('count'=>0);
                }
                $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
                $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type in (1, 2, 3, 18) ", true) : array('bf_file'=>'', 'bf_content'=>'');
                $list[$i]['bo_table'] = $bo_table;
                $list[$i]['is_notice'] = in_array($row['wr_id'], $notice_ids) ? true : false;
                if(! isset($list[$i]['icon_file'])) $list[$i]['icon_file'] = '';
            }
        } else {
            // 그냥 최신글 LIMIT개
            $sql = "SELECT * FROM {$tmp_write_table} WHERE wr_is_comment = 0 ";
            if($md_sca) $sql .= " AND ca_name = '{$md_sca}' ";
            if($md_order) {
                $sql .= " ORDER BY {$md_order} ";
            } else {
                $sql .= " ORDER BY wr_num ";
            }
            $sql .= " LIMIT 0, {$rows} ";

            $result = sql_query($sql);
            for ($i=0; $row = sql_fetch_array($result); $i++) {
                unset($row['wr_password']);
                $row['wr_email'] = '';
                if (strstr($row['wr_option'], 'secret')){
                    $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                    $row['file'] = array('count'=>0);
                }
                $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
                $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type in (1, 2, 3, 18) ", true) : array('bf_file'=>'', 'bf_content'=>'');
                $list[$i]['bo_table'] = $bo_table;
                $list[$i]['is_notice'] = in_array($row['wr_id'], $notice_ids) ? true : false;
                if(! isset($list[$i]['icon_file'])) $list[$i]['icon_file'] = '';
            }
        }

        g5_latest_cache_data($bo_table, $list);

        if(G5_USE_CACHE) {
            $caches = array(
                'list' => $list,
                'bo_subject' => sql_escape_string($bo_subject),
            );
            g5_set_cache($cache_file_name, $caches, (int) $time_unit * (int) $cache_time);
        }
    } else {
        $list = $cache_list;
        $bo_subject = (is_array($caches) && isset($caches['bo_subject'])) ? $caches['bo_subject'] : '';
    }

    ob_start();
    $rb_module_table = isset($rb_module_table) ? $rb_module_table : '';
    include $latest_skin_path.'/latest.skin.php';
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}




function rb_latest_tabs($skin_dir = '', $json_list = '', $rows = 10, $subject_len = 40, $cache_time = 1, $options = '', $md_order = '', $rb_module_table = '', $is_notice = 0) {
    global $g5;

    if (!$skin_dir) $skin_dir = 'basic';
    if (!$json_list) return '';

    $time_unit = 3600; // 1시간

    if (preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest_tabs/'.$match[1];
            if (!is_dir($latest_skin_path))
                $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest_tabs/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        } else {
            $latest_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/latest_tabs/'.$match[1];
            $latest_skin_url = str_replace(G5_PATH, G5_URL, $latest_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if (G5_IS_MOBILE) {
            $latest_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/latest_tabs/'.$skin_dir;
            $latest_skin_url  = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/latest_tabs/'.$skin_dir;
        } else {
            $latest_skin_path = G5_SKIN_PATH.'/latest_tabs/'.$skin_dir;
            $latest_skin_url  = G5_SKIN_URL.'/latest_tabs/'.$skin_dir;
        }
    }

    $tab_items = json_decode($json_list, true);
    if (!is_array($tab_items) || !count($tab_items)) return '';

    $tabs = [];
    foreach ($tab_items as $item) {
        if (strpos($item, '||') !== false) {
            list($bo_table, $md_sca) = explode('||', $item);
        } else {
            $bo_table = $item;
            $md_sca = '';
        }

        $board = get_board_db($bo_table, true);
        if (!$board) continue;

        $bo_subject = get_text($board['bo_subject']);

        $list = [];
        $tmp_write_table = $g5['write_prefix'] . $bo_table;

        // 공지글 wr_id 추출
        $notice_ids = array_filter(array_map('trim', explode(',', $board['bo_notice'])));
        $notice_ids_str = count($notice_ids) ? implode(',', $notice_ids) : '';

        if ($is_notice == 1 && $notice_ids_str) {
            // 공지글 상단고정, 나머지는 정렬옵션
            $sql = "SELECT * FROM {$tmp_write_table} WHERE wr_is_comment = 0";
            if($md_sca) $sql .= " AND ca_name = '{$md_sca}' ";
            // 공지글은 0, 그 외는 1로 두고 정렬옵션으로 나머지 정렬
            $sql .= " ORDER BY (CASE WHEN wr_id IN ($notice_ids_str) THEN 0 ELSE 1 END), ";
            if($md_order) {
                $sql .= " {$md_order} ";
            } else {
                $sql .= " wr_num ";
            }
            $sql .= " LIMIT 0, {$rows} ";
        } else {
            // 그냥 최신글 LIMIT개
            $sql = "SELECT * FROM {$tmp_write_table} WHERE wr_is_comment = 0 ";
            if($md_sca) $sql .= " AND ca_name = '{$md_sca}' ";
            if($md_order) {
                $sql .= " ORDER BY {$md_order} ";
            } else {
                $sql .= " ORDER BY wr_num ";
            }
            $sql .= " LIMIT 0, {$rows} ";
        }

        $result = sql_query($sql);

        for ($i = 0; $row = sql_fetch_array($result); $i++) {
            unset($row['wr_password']);
            $row['wr_email'] = '';
            if (strstr($row['wr_option'], 'secret')) {
                $row['wr_content'] = $row['wr_link1'] = $row['wr_link2'] = '';
                $row['file'] = array('count'=>0);
            }
            $list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
            $list[$i]['first_file_thumb'] = (isset($row['wr_file']) && $row['wr_file']) ? get_board_file_db($bo_table, $row['wr_id'], 'bf_file, bf_content', "and bf_type in (1, 2, 3, 18) ", true) : array('bf_file'=>'', 'bf_content'=>'');
            $list[$i]['bo_table'] = $bo_table;
            $list[$i]['is_notice'] = in_array($row['wr_id'], $notice_ids) ? true : false;
            if (!isset($list[$i]['icon_file'])) $list[$i]['icon_file'] = '';
        }

        $tabs[] = [
            'bo_table' => $bo_table,
            'sca' => $md_sca,
            'bo_subject' => $bo_subject,
            'list' => $list
        ];
    }

    ob_start();
    $rb_module_table = isset($rb_module_table) ? $rb_module_table : '';
    include $latest_skin_path.'/latest.tabs.skin.php';
    $content = ob_get_clean();

    return $content;
}



// 파일업로드
function rb_upload_files($srcfile, $destfile, $dir)
{
    if ($destfile == "") return false;
    // 업로드 한후 , 퍼미션을 변경함
    @move_uploaded_file($srcfile, $dir.'/'.$destfile);
    @chmod($dir.'/'.$destfile, G5_FILE_PERMISSION);
    return true;
}

// 배너출력
function rb_banners($position, $bnid='', $skin='', $order='')
{
    global $g5, $rb_core;
    
    if($skin == "") {
        $skin_path = G5_PATH.'/rb/rb.mod/banner/skin/rb.basic/banner.skin.php';
    } else { 
        $skin_path = G5_PATH.'/rb/'.$skin.'/banner.skin.php';
    }


    if(file_exists($skin_path)) {


        // 배너 출력
        
        if($position == "개별출력") {
            if(IS_MOBILE()) {
                $sql = " select * from rb_banner where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' and bn_device IN ('mobile', 'both') and bn_id = '$bnid' order by bn_order, bn_id desc ";
            } else { 
                $sql = " select * from rb_banner where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' and bn_device IN ('pc', 'both') and bn_id = '$bnid' order by bn_order, bn_id desc ";
            }
            $result = sql_query($sql);
        } else { 
            if($order == "rand()") {
                if(IS_MOBILE()) {
                    $sql = " select * from rb_banner where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' and bn_device IN ('mobile', 'both') order by rand() ";
                } else { 
                    $sql = " select * from rb_banner where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' and bn_device IN ('pc', 'both') order by rand() ";
                }
                $result = sql_query($sql);
            } else { 
                if(IS_MOBILE()) {
                    $sql = " select * from rb_banner where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' and bn_device IN ('mobile', 'both') order by bn_order, bn_id desc ";
                } else { 
                    $sql = " select * from rb_banner where '".G5_TIME_YMDHIS."' between bn_begin_time and bn_end_time and bn_position = '$position' and bn_device IN ('pc', 'both') order by bn_order, bn_id desc ";
                }
                $result = sql_query($sql);
            }
        }

        
        include $skin_path;
    } else {
        echo '<p>'.str_replace(G5_PATH.'/', '', $skin_path).' 경로에 스킨 파일이 존재하지 않습니다.</p>';
    }
}


// 게시글보기 파일 썸네일 리턴
function rb_get_file_thumbnail($file, $wr_id){

    if( ! is_array($file) ) return '';

    if( preg_match('/(\.jpg|\.jpeg|\.gif|\.png|\.bmp|\.webp)$/i', $file['file']) && $contents = run_replace('get_file_thumbnail_tags', '', $file) ){
        return $contents;
    } else if ($file['view']) {
        return rb_get_view_thumbnail($file['view'], "", $wr_id);
    }

    return $file['view'];
}

// 게시글보기 썸네일 생성
function rb_get_view_thumbnail($contents = '', $thumb_width = 0, $wr_id = '')
{
    global $board, $config;

    if (!$thumb_width)
        $thumb_width = $board['bo_image_width'];

    // $contents 중 img 태그 추출
    $matches = get_editor_image($contents, true);

    if(empty($matches))
        return $contents;

    $extensions = array(1=>'gif', 2=>'jpg', 3=>'png', 18=>'webp');

    for($i=0; $i<count($matches[1]); $i++) {

        $img = $matches[1][$i];
        $img_tag = isset($matches[0][$i]) ? $matches[0][$i] : '';

        preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
        $src = isset($m[1]) ? $m[1] : '';
        preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
        $style = isset($m[1]) ? $m[1] : '';
        preg_match("/width:\s*(\d+)px/", $style, $m);
        $width = isset($m[1]) ? $m[1] : '';
        preg_match("/height:\s*(\d+)px/", $style, $m);
        $height = isset($m[1]) ? $m[1] : '';
        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = isset($m[1]) ? get_text($m[1]) : '';

        // 이미지 path 구함
        $p = parse_url($src);
        if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
            $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
        else
            $data_path = $p['path'];

        $srcfile = G5_PATH.$data_path;

        if(is_file($srcfile)) {
            $size = @getimagesize($srcfile);
            if(empty($size))
                continue;

            $file_ext = $extensions[$size[2]];
            if (!$file_ext) continue;

            // jpg 이면 exif 체크
            if( $file_ext === 'jpg' && function_exists('exif_read_data')) {
                $degree = 0;
                $exif = @exif_read_data($srcfile);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $degree = 90;
                            break;
                        case 3:
                            $degree = 180;
                            break;
                        case 6:
                            $degree = -90;
                            break;
                    }

                    // 세로사진의 경우 가로, 세로 값 바꿈
                    if($degree == 90 || $degree == -90) {
                        $tmp = $size;
                        $size[0] = $tmp[1];
                        $size[1] = $tmp[0];
                    }
                }
            }

            // Animated GIF 체크
            $is_animated = false;
            if($file_ext === 'gif') {
                $is_animated = is_animated_gif($srcfile);

                if($replace_content = run_replace('thumbnail_is_animated_gif_content', '', $contents, $srcfile, $is_animated, $img_tag, $data_path, $size)){

                    $contents = $replace_content;
                    continue;
                }
            }

            // 원본 width가 thumb_width보다 작다면
            if($size[0] <= $thumb_width)
                continue;

            // 썸네일 높이
            $thumb_height = round(($thumb_width * $size[1]) / $size[0]);
            $filename = basename($srcfile);
            $filepath = dirname($srcfile);

            // 썸네일 생성
            if(!$is_animated)
                $thumb_file = thumbnail($filename, $filepath, $filepath, $thumb_width, $thumb_height, false);
            else
                $thumb_file = $filename;

            if(!$thumb_file)
                continue;

            if ($width) {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'" width="'.$width.'" height="'.$height.'"/>';
            } else {
                $thumb_tag = '<img src="'.G5_URL.str_replace($filename, $thumb_file, $data_path).'" alt="'.$alt.'"/>';
            }

            // $img_tag에 editor 경로가 있으면 원본보기 링크 추가
            if(strpos($img_tag, G5_DATA_DIR.'/'.G5_EDITOR_DIR) && preg_match("/\.({$config['cf_image_extension']})$/i", $filename)) {
                $imgurl = str_replace(G5_URL, "", $src);

                if(isset($board['bo_lightbox']) && $board['bo_lightbox'] == 1) {
                    $attr_href = G5_URL.str_replace($filename, $thumb_file, $data_path);
                    $thumb_tag = '<a href="'.$attr_href.'" data-fslightbox="gallery_'.$wr_id.'">'.$thumb_tag.'</a>';
                } else {
                    $attr_href = run_replace('thumb_view_image_href', G5_BBS_URL.'/view_image.php?fn='.urlencode($imgurl), $filename, '', $width, $height, $alt);
                    $thumb_tag = '<a href="'.$attr_href.'" target="_blank" class="view_image">'.$thumb_tag.'</a>';
                }
            }

            $contents = str_replace($img_tag, $thumb_tag, $contents);
        }
    }

    return run_replace('get_view_thumbnail', $contents);
}


// 사이드뷰 추가 @Leegun 님께서 도움 주셨습니다.
add_replace('member_sideview_items', function ($sideview, $data = []) {
    global $g5;

    // $data 배열에서 mb_id를 가져옵니다.
    if (isset($data['mb_id']) && $data['mb_id']) {
            
        // 미니홈 메뉴 항목 생성
        $my_menu = ['my' => '<a href="' . G5_URL . '/rb/home.php?mb_id=' . $data['mb_id'] . '" rel="nofollow">미니홈</a>'];

        // 기존 메뉴 항목 앞에 새로운 메뉴 항목 추가
        $sideview['menus'] = $my_menu + $sideview['menus'];
    }
    return $sideview;

}, G5_HOOK_DEFAULT_PRIORITY, 2);


// 사용하지 않는 페이지 리다이렉트 처리
$redirect_map = [
    '/bbs/new.php' => '/rb/new.php',
];

// 현재 페이지의 URL을 확인 (쿼리 스트링을 제외한 경로)
$current_urls = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 쿼리 스트링을 확인 (파라미터)
$query_string = $_SERVER['QUERY_STRING'];

// 만약 현재 URL이 배열의 키에 있으면, 해당 값으로 리다이렉트
if (array_key_exists($current_urls, $redirect_map)) {
    // 리다이렉트할 URL에 쿼리 스트링을 붙여서 처리
    $redirect_urls = $redirect_map[$current_urls];

    // 쿼리 스트링이 존재하면 '?'를 붙여서 추가
    if (!empty($query_string)) {
        $redirect_urls .= '?' . $query_string;
    }

    // 리다이렉트 실행
    header('Location: ' . $redirect_urls);
    exit; // 리다이렉트 후 스크립트 실행 중지
}
