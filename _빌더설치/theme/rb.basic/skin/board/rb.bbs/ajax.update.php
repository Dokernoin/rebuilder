<?php
include_once('../../../../../common.php');

$bo_table = isset($_POST['bo_table']) ? $_POST['bo_table'] : '';
$bo_rb_skin_top = isset($_POST['bo_rb_skin_top']) ? $_POST['bo_rb_skin_top'] : '';
$bo_rb_skin_list = isset($_POST['bo_rb_skin_list']) ? $_POST['bo_rb_skin_list'] : '';
$bo_rb_skin_view = isset($_POST['bo_rb_skin_view']) ? $_POST['bo_rb_skin_view'] : '';
$bo_rb_skin_write = isset($_POST['bo_rb_skin_write']) ? $_POST['bo_rb_skin_write'] : '';
$bo_rb_skin_cmt = isset($_POST['bo_rb_skin_cmt']) ? $_POST['bo_rb_skin_cmt'] : '';
$bo_rb_skin_category = isset($_POST['bo_rb_skin_category']) ? $_POST['bo_rb_skin_category'] : '';
$bo_rb_skin_search = isset($_POST['bo_rb_skin_search']) ? $_POST['bo_rb_skin_search'] : '';
$bo_rb_skin_update = isset($_POST['bo_rb_skin_update']) ? $_POST['bo_rb_skin_update'] : '';
$bo_gallery_cols = isset($_POST['bo_gallery_cols']) ? $_POST['bo_gallery_cols'] : '';
$bo_mobile_gallery_cols = isset($_POST['bo_mobile_gallery_cols']) ? $_POST['bo_mobile_gallery_cols'] : '';
$bo_page_rows = isset($_POST['bo_page_rows']) ? $_POST['bo_page_rows'] : '';
$bo_gap_pc = isset($_POST['bo_gap_pc']) ? $_POST['bo_gap_pc'] : '';
$bo_gap_mo = isset($_POST['bo_gap_mo']) ? $_POST['bo_gap_mo'] : '';
$bo_border = isset($_POST['bo_border']) ? $_POST['bo_border'] : '';
$bo_radius = isset($_POST['bo_radius']) ? $_POST['bo_radius'] : '';
$bo_viewer1 = isset($_POST['bo_viewer1']) ? $_POST['bo_viewer1'] : '';
$bo_viewer2 = isset($_POST['bo_viewer2']) ? $_POST['bo_viewer2'] : '';
$bo_viewer3 = isset($_POST['bo_viewer3']) ? $_POST['bo_viewer3'] : '';
$bo_viewer4 = isset($_POST['bo_viewer4']) ? $_POST['bo_viewer4'] : '';
$bo_lightbox = isset($_POST['bo_lightbox']) ? $_POST['bo_lightbox'] : '0';
$bo_gallery_width = isset($_POST['bo_gallery_width']) ? $_POST['bo_gallery_width'] : '';
$bo_gallery_height = isset($_POST['bo_gallery_height']) ? $_POST['bo_gallery_height'] : '';

if ($is_admin) {

    if($bo_table) {
        $sql = " UPDATE {$g5['board_table']} SET
        bo_rb_skin_top = '$bo_rb_skin_top',
        bo_rb_skin_list = '$bo_rb_skin_list',
        bo_rb_skin_view = '$bo_rb_skin_view',
        bo_rb_skin_write = '$bo_rb_skin_write',
        bo_rb_skin_cmt = '$bo_rb_skin_cmt',
        bo_rb_skin_category = '$bo_rb_skin_category',
        bo_rb_skin_search = '$bo_rb_skin_search',
        bo_rb_skin_update = '$bo_rb_skin_update',
        bo_gallery_cols = '$bo_gallery_cols',
        bo_mobile_gallery_cols = '$bo_mobile_gallery_cols',
        bo_page_rows = '$bo_page_rows',
        bo_mobile_page_rows = '$bo_page_rows',
        bo_gallery_width = '$bo_gallery_width',
        bo_gallery_height = '$bo_gallery_height',
        bo_mobile_gallery_width = '$bo_gallery_width',
        bo_mobile_gallery_height = '$bo_gallery_height',
        bo_gap_pc = '$bo_gap_pc',
        bo_gap_mo = '$bo_gap_mo',
        bo_border = '$bo_border',
        bo_radius = '$bo_radius',
        bo_lightbox = '$bo_lightbox',
        bo_viewer = '$bo_viewer1|$bo_viewer2|$bo_viewer3|$bo_viewer4'
        WHERE bo_table = '{$bo_table}' ";
        sql_query($sql);

        $data = array('status' => 'ok');
        echo json_encode($data);

    } else {
        $data = array('status' => 'no');
        echo json_encode($data);
    }

}
