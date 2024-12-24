<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$g5['title'] = "위시리스트";
include_once('./_head.php');
?>


<form name="fwishlist" method="post" action="./cartupdate.php">
<input type="hidden" name="act" value="multi">
<input type="hidden" name="sw_direct" value="">
<input type="hidden" name="prog" value="wish">
    
<!-- 위시리스트 시작 { -->
<div id="sod_ws" class="rb_shop_list">
   
    
    
    <div class="swiper-container swiper-container-list-wish">
    <div class="swiper-wrapper swiper-wrapper-list-wish">


        <?php
        $sql  = " select a.wi_id, a.wi_time, b.* from {$g5['g5_shop_wish_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id ) ";
        $sql .= " where a.mb_id = '{$member['mb_id']}' and b.it_id != '' order by a.wi_id desc ";
        $result = sql_query($sql);
        for ($i=0; $row = sql_fetch_array($result); $i++) {

            $out_cd = '';
            $sql = " select count(*) as cnt from {$g5['g5_shop_item_option_table']} where it_id = '{$row['it_id']}' and io_type = '0' ";
            $tmp = sql_fetch($sql);
            if(isset($tmp['cnt']) && $tmp['cnt'])
                $out_cd = 'no';

            $it_price = get_price($row);

            if ($row['it_tel_inq']) $out_cd = 'tel_inq';

            $image = rb_it_image($row['it_id'],300, 300);
            $ca = get_shop_item_with_category($row['it_id']);

        ?>
        
        <ul class="swiper-slide swiper-slide-list-wish">
     
            <li class="rb_shop_list_item">
                <div class="v_ch_list">
                    <div class="rb_shop_list_item_img">
                        <a href="<?php echo shop_item_url($row['it_id']); ?>">
                        <?php echo $image; ?>
                        </a>
                        
                        <div class="wish_chk">
                            <?php
                            // 품절검사
                            if(is_soldout($row['it_id']))
                            {
                            ?>
                            품절
                            <?php } else { //품절이 아니면 체크할수 있도록한다 ?>
                            <div class="">
                                <input type="checkbox" name="chk_it_id[<?php echo $i; ?>]" value="1" id="chk_it_id_<?php echo $i; ?>" onclick="out_cd_check(this, '<?php echo $out_cd; ?>');" class="selec_chk">
                                <label for="chk_it_id_<?php echo $i; ?>"><span></span><b class="sound_only"><?php echo $row['it_name']; ?></b></label>
                            </div>
                            <?php } ?>
                            <input type="hidden" name="it_id[<?php echo $i; ?>]" value="<?php echo $row['it_id']; ?>">
                            <input type="hidden" name="io_type[<?php echo $row['it_id']; ?>][0]" value="0">
                            <input type="hidden" name="io_id[<?php echo $row['it_id']; ?>][0]" value="">
                            <input type="hidden" name="io_value[<?php echo $row['it_id']; ?>][0]" value="<?php echo $row['it_name']; ?>">
                            <input type="hidden" name="ct_qty[<?php echo $row['it_id']; ?>][0]" value="1">
                        </div>
                        
                        <a href="./wishupdate.php?w=d&amp;wi_id=<?php echo $row['wi_id']; ?>" class="wish_del"><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><title>delete_2_line</title><g id="delete_2_line" fill='none' fill-rule='nonzero'><path d='M24 0v24H0V0h24ZM12.593 23.258l-.011.002-.071.035-.02.004-.014-.004-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01-.017.428.005.02.01.013.104.074.015.004.012-.004.104-.074.012-.016.004-.017-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113-.013.002-.185.093-.01.01-.003.011.018.43.005.012.008.007.201.093c.012.004.023 0 .029-.008l.004-.014-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014-.034.614c0 .012.007.02.017.024l.015-.002.201-.093.01-.008.004-.011.017-.43-.003-.012-.01-.01-.184-.092Z'/><path fill='#09244BFF' d='M14.28 2a2 2 0 0 1 1.897 1.368L16.72 5H20a1 1 0 1 1 0 2l-.003.071-.867 12.143A3 3 0 0 1 16.138 22H7.862a3 3 0 0 1-2.992-2.786L4.003 7.07A1.01 1.01 0 0 1 4 7a1 1 0 0 1 0-2h3.28l.543-1.632A2 2 0 0 1 9.721 2h4.558Zm3.717 5H6.003l.862 12.071a1 1 0 0 0 .997.929h8.276a1 1 0 0 0 .997-.929L17.997 7ZM10 10a1 1 0 0 1 .993.883L11 11v5a1 1 0 0 1-1.993.117L9 16v-5a1 1 0 0 1 1-1Zm4 0a1 1 0 0 1 1 1v5a1 1 0 1 1-2 0v-5a1 1 0 0 1 1-1Zm.28-6H9.72l-.333 1h5.226l-.334-1Z'/></g></svg></a>
                    </div>
                </div>
                <div class="v_ch_list_r">

                    <div class="rb_shop_list_item_ca"><?php echo $ca['ca_name'];?></div>
                    
                    <div class="rb_shop_list_item_name">
                        <a href="<?php echo shop_item_url($row['it_id']); ?>" class="font-B cut2">
                        <?php echo stripslashes($row['it_name']); ?>
                        </a>
                    </div>

                    <div class="rb_shop_list_item_basic">
                        <?php echo $row['wi_time']; ?>
                    </div>

                </div>
            </li>
        </ul>

        <?php
        }
        ?>
        <?php if($i == 0) echo "<div class=\"da_data\">보관함이 비었습니다.</div>"; ?>


    </div>
    </div>
    
    <div id="sod_ws_act">
        <button type="submit" class="btn01" onclick="return fwishlist_check(document.fwishlist,'');">장바구니 담기</button>
        <button type="submit" class="btn02" onclick="return fwishlist_check(document.fwishlist,'direct_buy');">주문하기</button>
    </div>
    
</div>

</form>
                    <script>
                        var swiper = new Swiper('.swiper-container-list-wish', {
                            slidesPerColumnFill: 'row',
                            slidesPerView: 6, //가로갯수
                            slidesPerColumn: 9999, // 세로갯수
                            spaceBetween: 25, // 간격
                            touchRatio: 0, // 드래그 가능여부(1, 0)

                            breakpoints: { // 반응형 처리
                                
                                1024: {
                                    slidesPerView: 5,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 25,
                                },                
                                768: {
                                    slidesPerView: 3,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 20,
                                },
                                10: {
                                    slidesPerView: 2,
                                    slidesPerColumn: 9999,
                                    spaceBetween: 20,
                                }
                            },

                        });
                    </script>

<script>

    function out_cd_check(fld, out_cd)
    {
        if (out_cd == 'no'){
            alert("옵션이 있는 상품입니다.\n\n상품을 클릭하여 상품페이지에서 옵션을 선택한 후 주문하십시오.");
            fld.checked = false;
            return;
        }

        if (out_cd == 'tel_inq'){
            alert("이 상품은 전화로 문의해 주십시오.\n\n장바구니에 담아 구입하실 수 없습니다.");
            fld.checked = false;
            return;
        }
    }

    function fwishlist_check(f, act)
    {
        var k = 0;
        var length = f.elements.length;

        for(i=0; i<length; i++) {
            if (f.elements[i].checked) {
                k++;
            }
        }

        if(k == 0)
        {
            alert("상품을 하나 이상 체크 하십시오");
            return false;
        }

        if (act == "direct_buy")
        {
            f.sw_direct.value = 1;
        }
        else
        {
            f.sw_direct.value = 0;
        }

        return true;
    }

</script>
<!-- } 위시리스트 끝 -->

<?php
include_once('./_tail.php');