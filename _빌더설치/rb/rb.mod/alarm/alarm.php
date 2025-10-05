<?php
if (!defined('_GNUBOARD_')) exit; //개별 페이지 접근 불가

// 간격
//echo help('기본 60000ms, 밀리초(ms)는 천분의 1초. ex) 60초 = 60000ms');
$wset['delay'] = '60000';
$wset['delay'] = (isset($wset['delay']) && $wset['delay'] >= 60000) ? $wset['delay'] : 60000;
$alarm_url = G5_URL . "/rb/rb.mod/alarm";
?>

<?php 
// 특정 페이지에서 alarm 표시 안함 
$except_alarm_page = array(
    'memo.php',
    'point.php',
    'scrap.php',
    'profile.php',
    'coupon.php',
    'memo_form.php'
);

if (!in_array(basename($_SERVER['PHP_SELF']), $except_alarm_page)) { 
    if (isset($member['mb_id']) && $member['mb_id']) { // $member 배열과 'mb_id' 키가 정의되어 있는지 확인 ?>
        <link rel="stylesheet" href="<?php echo $alarm_url ?>/alarm.css">
        <script>
            var memo_alarm_url = "<?php echo $alarm_url; ?>";
            //var audio = new Audio("<?php echo $alarm_url;?>/memo_on.mp3");  // 임의 폴더 아래에 사운드 파일을 넣고 자바스크립트 동일경로 
        </script>
        <?php
        $dirs = dirname($_SERVER['PHP_SELF']); // $PHP_SELF 대신 $_SERVER['PHP_SELF'] 사용
        $dirs_chk = str_replace('/', '', $dirs);
        ?>
        
        <?php if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === ($app['ap_title'] ?? '')) { ?>
        <script src="<?php echo $alarm_url ?>/alarm.app.js"></script>
        <?php } else { ?>
        <script src="<?php echo $alarm_url ?>/alarm.js"></script>
        <?php } ?>
        <script type="text/javascript">
            $(function() {
                setInterval(function() {
                    check_alarm();
                }, <?php echo $wset['delay'] ?>);
                check_alarm();
            });
        </script>
    <?php } ?>
<?php } ?>
