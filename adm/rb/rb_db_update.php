<?php
$sub_menu = '000000';
include_once('./_common.php');

check_demo();
auth_check_menu($auth, $sub_menu, "w");

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$table_key = sql_query("DESCRIBE rb_key", false);

if (!$table_key) {
    $query_key = sql_query("CREATE TABLE IF NOT EXISTS `rb_key` (
        `key_no` varchar(255) NOT NULL DEFAULT '',
        `key_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8", true);

    function generateUniqueCode($length = 24) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $uniqueCode = '';
        for ($i = 0; $i < $length; $i++) {
            $uniqueCode .= $characters[rand(0, $charactersLength - 1)];
        }
        return $uniqueCode;
    }

    $in_key = generateUniqueCode();

    $sql_key = "INSERT INTO rb_key
                SET key_no = '{$in_key}',
                    key_datetime = '".G5_TIME_YMDHIS."'";
    sql_query($sql_key);
}

$key_info = sql_fetch("SELECT key_no FROM rb_key LIMIT 1");
$key_cnt_row = sql_fetch("SELECT COUNT(*) as cnt FROM rb_key LIMIT 1");
$key_cnt = isset($key_cnt_row['cnt']) ? (int)$key_cnt_row['cnt'] : 0;

if ($key_cnt < 1) {
    die('[에러코드:E005] 라이선스키가 없습니다.');
}

$in_key = $key_info['key_no'];
$site_domain = $_SERVER['HTTP_HOST'];
$user_ip = $_SERVER['REMOTE_ADDR'];

if (!function_exists('curl_init')) {
    die('[에러코드:E000] cURL을 사용할 수 없는 서버 입니다.');
}

$your_site_url = 'https://rebuilder.co.kr/rb/install.php';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $your_site_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(['domain' => $site_domain, 'key' => $in_key, 'user_ip' => $user_ip]));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// SSL 검증 비활성화
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    die('[에러코드:E000] cURL 에러: ' . $error_msg);
}

curl_close($ch);

if ($response === false) {
    die('[에러코드:E001] 데이터 서버에 응답이 없습니다. 공식홈페이지 > 1:1문의를 통해 문의해주세요.');
}

$response_data = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    die('[에러코드:E002] 설치에 문제가 있습니다. 공식홈페이지 > 1:1문의를 통해 문의해주세요.');
}

if (!isset($response_data['status']) || $response_data['status'] == 'error_mbid') {
    die('[에러코드:E006] 라이선스 등록이 되지 않은 빌더입니다. 공식 홈페이지에서 라이선스키 등록을 먼저 해주세요.');
}

if (!isset($response_data['status']) || $response_data['status'] !== 'success') {
    die('[에러코드:E003] 기본정보가 없습니다. 공식홈페이지 > 1:1문의를 통해 문의해주세요.');
}

if (!isset($response_data['schema']['tables'])) {
    die('[에러코드:E004] 스키마 정보가 없습니다. 공식홈페이지 > 1:1문의를 통해 문의해주세요.');
}

$schema = $response_data['schema'];

try {
    $messages = [];

    foreach ($schema['tables'] as $table => $table_info) {
        $columns = $table_info['columns'];
        $query = "SHOW TABLES LIKE '$table'";
        $result = sql_query($query);

        if (mysqli_num_rows($result) == 0) {
            $column_definitions = [];
            foreach ($columns as $column => $definition) {
                $column_definitions[] = "`$column` $definition";
            }

            if (isset($schema['tables'][$table]['primary_key'])) {
                $primary_key = $schema['tables'][$table]['primary_key'];
                $column_definitions[] = "PRIMARY KEY (`$primary_key`)";
            }

            $createTableQuery = "CREATE TABLE `$table` (" . implode(', ', $column_definitions) . ")";
            $createResult = sql_query($createTableQuery);
            if ($createResult) {
                $messages[] = "[$table] 테이블이 생성되었습니다.";
            } else {
                throw new Exception("[$table] 테이블 생성 실패: " . mysqli_error($GLOBALS['g5']['connect_db']));
            }
        } else {
            $addColumns = [];
            foreach ($columns as $column => $definition) {
                $query = "SHOW COLUMNS FROM `$table` LIKE '$column'";
                $result = sql_query($query);

                if (!$result) {
                    throw new Exception("[$table] 에 [$column] 컬럼 확인 오류: " . mysqli_error($GLOBALS['g5']['connect_db']));
                }

                if (mysqli_num_rows($result) == 0) {
                    $addColumns[] = "ADD `$column` $definition";
                } else {
                    $messages[] = "[$table] 에 [$column] 컬럼이 정상 입니다.";
                }
            }

            if (!empty($addColumns)) {
                $alterTableQuery = "ALTER TABLE `$table` " . implode(', ', $addColumns);
                $alterResult = sql_query($alterTableQuery);
                if ($alterResult) {
                    $messages[] = "[$table] 에 컬럼이 추가되었습니다.";
                } else {
                    throw new Exception("[$table] 에 컬럼 추가를 실패했습니다: " . mysqli_error($GLOBALS['g5']['connect_db']));
                }
            }
        }
    }

    if (!empty($messages)) {
        alert(implode("\\n", $messages));
    }
} catch (Exception $e) {
    alert("오류: " . addslashes($e->getMessage()));
}

update_rewrite_rules();
goto_url('./rb_form.php', false);
?>
