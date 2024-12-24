<?php

$ajax_files = json_decode(stripslashes($_POST['ajax_files']),true);
$files = empty($ajax_files['files']) ? [] : $ajax_files['files'];
$del = empty($ajax_files['del']) ? [] : $ajax_files['del'];
//echo '<pre>';
//print_r($ajax_files);
//print_r($files);
//print_r($del);
//exit;

if($files){
  $file_cnt = count($files);
  if($del){ //여집합으로 총파일수구함
    $not_del = [];
    foreach($files as $v){ $not_del[] = empty($v['file']) ? $v['bf_file'] : $v['file']; }
    $c = array_intersect($del,$not_del);
    $d = array_diff($del,$c);
    $e = array_diff($not_del,$c);
    $f = array_merge($d,$e);
    $file_cnt = count($f);
  }
  if($file_cnt>$board['bo_upload_count']){
    foreach($files as $v){
      if(empty($v['href'])){
        @unlink(G5_DATA_PATH.'/file/'.$bo_table.'/'.$v['bf_file']);
        delete_board_thumbnail($bo_table,$v['bf_file']);
      }
    }
    alert('첨부파일을 '.number_format($board['bo_upload_count']).'개 이하로 업로드 해주십시오.');exit;
  }
  $row = sql_fetch(" select max(bf_no) as num from {$g5['board_file_table']} where bo_table='{$bo_table}' and wr_id ='{$wr_id}'");
  $num = empty($row['num']) ? 0 : $row['num'];
  foreach($files as $v){
    if(empty($v['href'])){
      $num++;
      $sql = "insert into {$g5['board_file_table']} set
              bo_table = '{$bo_table}',
              wr_id = '{$wr_id}',
              bf_no = '{$num}',
              bf_source = '{$v['bf_source']}',
              bf_file = '{$v['bf_file']}',
              bf_filesize = '{$v['bf_filesize']}',
              bf_width = '{$v['bf_width']}',
              bf_height = '{$v['bf_height']}',
              bf_type = '{$v['bf_type']}',
              bf_datetime = '".G5_TIME_YMDHIS."' ";
      sql_query($sql);
    }
  }
}
if($del){
  sql_query('delete from `'.$g5['board_file_table'].'` where bo_table="'.$bo_table.'" and wr_id='.$wr_id.' and bf_file in ("'.implode('","',array_values($del)).'")');
}
$sql = "select * from {$g5['board_file_table']} where bo_table='{$bo_table}' and wr_id='{$wr_id}'";
$result = sql_query($sql);
$i=0;
while($row = sql_fetch_array($result)){
  $sql = "update {$g5['board_file_table']} set bf_no='{$i}' where bo_table='{$bo_table}' and wr_id='{$wr_id}' and bf_no='{$row['bf_no']}'";
  sql_query($sql);
  $i++;
}
//sql_query('delete from `'.$g5['board_file_table'].'` where bo_table="'.$bo_table.'" and wr_id='.$wr_id.' and bf_file=""');

// 파일의 개수를 게시물에 업데이트 한다.
$rows = sql_fetch(" select count(*) as cnt from {$g5['board_file_table']} where bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ");
sql_query(" update {$write_table} set wr_file = '{$rows['cnt']}' where wr_id = '{$wr_id}' ");
?>
