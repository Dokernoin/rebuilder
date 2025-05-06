<?php
include_once('../../common.php');

$mod_type = isset($_POST['mod_type']) ? $_POST['mod_type'] : '';
$is_shop = isset($_POST['is_shop']) ? $_POST['is_shop'] : '';
?>

<?php if(isset($mod_type) && $mod_type == "ca_name") { 
    
    $md_bo_table = isset($_POST['md_bo_table']) ? $_POST['md_bo_table'] : '';
    
    if(isset($md_bo_table) && $md_bo_table) { 
        
        // 해당게시판의 카테고리 조회
        $res_ca = sql_fetch (" select bo_category_list from {$g5['board_table']} where bo_table = '{$md_bo_table}' and bo_use_category = '1' "); 
        $cat = isset($res_ca['bo_category_list']) ? $res_ca['bo_category_list'] : '';
        $cat_opt = explode("|", $cat);

    }
?>
    <?php if(isset($md_bo_table) && $md_bo_table) { ?>
    <?php if(isset($cat) && $cat) { ?>
    <ul class="mt-5 selected_latest selected_select">
        <select class="select w100" name="md_sca" id="md_sca">
            <option value="">전체 카테고리</option>
                <?php foreach($cat_opt as $option): ?>
                <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
        </select>
    </ul>
    <?php } ?>
    <?php } ?>
    
<?php } ?>

<?php if(isset($mod_type) && $mod_type == "ca_name_tab") {

    $md_bo_table = isset($_POST['md_bo_table']) ? $_POST['md_bo_table'] : '';

    if(isset($md_bo_table) && $md_bo_table) {

        // 해당게시판의 카테고리 조회
        $res_ca = sql_fetch (" select bo_category_list from {$g5['board_table']} where bo_table = '{$md_bo_table}' and bo_use_category = '1' ");
        $cat = isset($res_ca['bo_category_list']) ? $res_ca['bo_category_list'] : '';
        $cat_opt = explode("|", $cat);

    }
?>
    <?php if(isset($md_bo_table) && $md_bo_table) { ?>

    <ul class="mt-5 selected_tab selected_select">
        <select class="select w100" name="md_sca_tab" id="tab_sca">

                <option value="">카테고리를 선택하세요.</option>
                <?php foreach($cat_opt as $option): ?>
                <?php if(isset($option) && $option) { ?>
                <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php } ?>
                <?php endforeach; ?>

                <option value="">전체</option>

        </select>
    </ul>

    <?php } ?>

<?php } ?>


<?php 
    if(isset($mod_type) && $mod_type == "mod_order") { 
        $order = $_POST['order'];
        
        if ($order && is_array($order)) {
            // 각 아이템의 순서를 업데이트
            foreach ($order as $item) {
                $md_id = $item['id'];
                $order_id = $item['order_id'];
                if(isset($is_shop) && $is_shop == 1) {
                    $sql = "UPDATE rb_module_shop SET md_order_id = {$order_id} WHERE md_id = {$md_id};";
                } else { 
                    $sql = "UPDATE rb_module SET md_order_id = {$order_id} WHERE md_id = {$md_id};";
                }
                sql_query($sql);
            }
            echo "success";
        } else {
            echo "Invalid order data";
        }
        
    }
?>
