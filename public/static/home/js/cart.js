/**
 * Created by Administrator on 2019/12/16 0016.
 */
$(function(){
    //减少购买数量
    $('.cart-less').click(function(){
        var i = $('input[name="cart-goods_number"]').val();
        if($('input[name="cart-goods_number"]').val() == 1){
            $(this).addClass("detail-disabled");
        }else{
            i--;
            $('input[name="cart-goods_number"]').val(i);
        }
    });
    //增加购买数量
    $('.cart-more').click(function(){
        var i = $('input[name="cart-goods_number"]').val();
        i++;
        $('input[name="cart-goods_number"]').val(i);
        $('.less').removeClass("detail-disabled");
    });
    $('.cost-button').click(function(){
        window.location.href = "/business/confirm";
    });
});