<?php
include_once('../../common.php');

$mod_type = isset($_POST['mod_type']) ? $_POST['mod_type'] : '';
$is_shop  = (isset($_POST['is_shop']) && $_POST['is_shop'] == '1') ? 1 : 0;

// helpers
function run_q($sql){ return sql_query($sql); }
function esc($s){ return sql_escape_string($s); } // 그누보드 기본 이스케이프
function to_int($v){ return (int)$v; }

/* ===== ca_name ===== */
if ($mod_type === "ca_name") {
    $md_bo_table = isset($_POST['md_bo_table']) ? $_POST['md_bo_table'] : '';
    if ($md_bo_table) {
        $res_ca = sql_fetch("SELECT bo_category_list FROM {$g5['board_table']} WHERE bo_table = '".esc($md_bo_table)."' AND bo_use_category = '1'");
        $cat = isset($res_ca['bo_category_list']) ? $res_ca['bo_category_list'] : '';
        $cat_opt = explode("|", $cat);
    }
    if (!empty($md_bo_table) && !empty($cat)) {
        ?>
        <ul class="mt-5 selected_latest selected_select">
            <select class="select w100" name="md_sca" id="md_sca">
                <option value="">전체 카테고리</option>
                <?php foreach($cat_opt as $option): ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php endforeach; ?>
            </select>
        </ul>
        <?php
    }
    exit;
}

/* ===== ca_name_tab ===== */
if ($mod_type === "ca_name_tab") {
    $md_bo_table = isset($_POST['md_bo_table']) ? $_POST['md_bo_table'] : '';
    if ($md_bo_table) {
        $res_ca = sql_fetch("SELECT bo_category_list FROM {$g5['board_table']} WHERE bo_table = '".esc($md_bo_table)."' AND bo_use_category = '1'");
        $cat = isset($res_ca['bo_category_list']) ? $res_ca['bo_category_list'] : '';
        $cat_opt = explode("|", $cat);
    }
    if (!empty($md_bo_table)) {
        ?>
        <ul class="mt-5 selected_tab selected_select">
            <select class="select w100" name="md_sca_tab" id="md_sca">
                <option value="">카테고리를 선택하세요.</option>
                <?php if (!empty($cat_opt)) { foreach($cat_opt as $option): if($option){ ?>
                    <option value="<?php echo $option; ?>"><?php echo $option; ?></option>
                <?php } endforeach; } ?>
                <option value="">전체</option>
            </select>
        </ul>
        <?php
    }
    exit;
}

/* ===== mod_order: update module order ===== */
if ($mod_type === "mod_order") {
    $order = isset($_POST['order']) ? $_POST['order'] : array();
    if ($order && is_array($order)) {
        $table = $is_shop ? 'rb_module_shop' : 'rb_module';
        foreach ($order as $item) {
            $md_id    = isset($item['id']) ? to_int($item['id']) : 0;
            $order_id = isset($item['order_id']) ? to_int($item['order_id']) : 0;
            if ($md_id <= 0) continue;
            run_q("UPDATE {$table} SET md_order_id = {$order_id} WHERE md_id = {$md_id}");
        }
        echo "success"; exit;
    }
    echo "Invalid order data"; exit;
}

/* ===== sec_order: update section order + sec_uid 갱신 ===== */
if ($mod_type === "sec_order") {
    $order = isset($_POST['order']) ? $_POST['order'] : array();
    if ($order && is_array($order)) {
        $sec_table = $is_shop ? 'rb_section_shop' : 'rb_section';
        $mod_table = $is_shop ? 'rb_module_shop'  : 'rb_module';
        $ids = array();

        foreach ($order as $item) {
            $sec_id   = isset($item['id']) ? to_int($item['id']) : 0;
            $order_id = isset($item['order_id']) ? to_int($item['order_id']) : 0;
            if ($sec_id <= 0) continue;

            // 섹션 순서 갱신
            run_q("UPDATE {$sec_table} SET sec_order_id = {$order_id} WHERE sec_id = {$sec_id}");
            $ids[] = $sec_id;
        }

        // 해당 섹션들의 sec_uid 다시 계산
        if (count($ids)) {
            $in = implode(',', array_map('intval', $ids));
            run_q("UPDATE {$sec_table} SET sec_uid = CONCAT(sec_key, '_', sec_order_id) WHERE sec_id IN ({$in})");

            // ⬇ 섹션 내부 모듈들도 sec_uid 같이 갱신
            $res = sql_query("SELECT sec_id, sec_key, sec_order_id FROM {$sec_table} WHERE sec_id IN ({$in})");
            while ($row = sql_fetch_array($res)) {
                $sec_uid = $row['sec_key'] . '_' . $row['sec_order_id'];
                run_q("UPDATE {$mod_table} SET md_sec_key = '".esc($row['sec_key'])."', md_sec_uid = '".esc($sec_uid)."' WHERE md_sec_key = '".esc($row['sec_key'])."'");
            }
        }

        echo "success"; exit;
    }
    echo "Invalid order data"; exit;
}

/* ===== sec_move_to_layout: 섹션의 레이아웃 문자열/숫자 모두 허용 ===== */
if ($mod_type === "sec_move_to_layout") {
    $maps_json = isset($_POST['maps']) ? $_POST['maps'] : '';
    $maps = $maps_json ? json_decode($maps_json, true) : array();

    if (!is_array($maps) || !count($maps)) { echo "Invalid maps"; exit; }

    $table = $is_shop ? 'rb_section_shop' : 'rb_section';

    foreach ($maps as $m) {
        $sec_id     = isset($m['sec_id']) ? to_int($m['sec_id']) : 0;
        $sec_layout = isset($m['sec_layout']) ? $m['sec_layout'] : '';
        if ($sec_id <= 0 || $sec_layout === '') continue;
        run_q("UPDATE {$table} SET sec_layout = '".esc($sec_layout)."' WHERE sec_id = {$sec_id}");
    }

    echo "success"; exit;
}

/* ===== mod_update_sec: 모듈의 섹션 소속 키/UID 갱신 (NULL 허용) =====
   maps: [
     { md_sec_key: "sec_xxx", md_sec_uid: "sec_xxx_12", mod_ids: [1,2,3] },
     { md_sec_key: null, md_sec_uid: null, mod_ids: [4,5] }
   ]
*/
if ($mod_type === "mod_update_sec") {
    $maps_json = isset($_POST['maps']) ? $_POST['maps'] : '';
    $maps = $maps_json ? json_decode($maps_json, true) : array();

    if (!is_array($maps) || !count($maps)) { echo "Invalid maps"; exit; }

    $table = $is_shop ? 'rb_module_shop' : 'rb_module';

    foreach ($maps as $m) {
        $ids = isset($m['mod_ids']) && is_array($m['mod_ids']) ? $m['mod_ids'] : array();
        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, function($v){ return $v > 0; });
        if (!count($ids)) continue;

        $in = implode(',', $ids);

        // 키/UID가 모두 null 이면 NULL 세팅
        if (array_key_exists('md_sec_key', $m) && array_key_exists('md_sec_uid', $m)
            && (is_null($m['md_sec_key']) && is_null($m['md_sec_uid']))) {
            run_q("UPDATE {$table} SET md_sec_key = NULL, md_sec_uid = NULL WHERE md_id IN ({$in})");
        } else {
            $key = isset($m['md_sec_key']) ? esc($m['md_sec_key']) : '';
            $uid = isset($m['md_sec_uid']) ? esc($m['md_sec_uid']) : '';
            run_q("UPDATE {$table} SET md_sec_key = '{$key}', md_sec_uid = '{$uid}' WHERE md_id IN ({$in})");
        }
    }
    echo "success"; exit;
}

/* ===== mod_move_to_layout: 모듈 md_layout 일괄 변경 (문자/숫자 허용) =====
   maps: [{ sec_layout: "L1", mod_ids: [1,2,3] }, ...]
*/
if ($mod_type === "mod_move_to_layout") {
    $maps_json = isset($_POST['maps']) ? $_POST['maps'] : '';
    $maps = $maps_json ? json_decode($maps_json, true) : array();

    if (!is_array($maps) || !count($maps)) { echo "Invalid maps"; exit; }

    $table = $is_shop ? 'rb_module_shop' : 'rb_module';

    foreach ($maps as $m) {
        $layout = isset($m['sec_layout']) ? $m['sec_layout'] : '';
        $ids    = isset($m['mod_ids']) && is_array($m['mod_ids']) ? $m['mod_ids'] : array();

        $ids = array_map('intval', $ids);
        $ids = array_filter($ids, function($v){ return $v > 0; });

        if ($layout === '' || !count($ids)) continue;

        $in = implode(',', $ids);
        run_q("UPDATE {$table} SET md_layout = '".esc($layout)."' WHERE md_id IN ({$in})");
    }

    echo "success"; exit;
}

/* default */
echo "No action";
exit;
