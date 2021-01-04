/**
 * Created by Administrator on 2020/04/05
 */
$(function(){
    //默认不显示编辑
    $('.consignee-address-opreate').css('display', 'none');
    $('.consignee-main ul li').each(function(a, b){
        $(this).hover(function(){
            $(this).addClass('address-detail-hover');
            $('.consignee-info').css('background', '#FFFFFF');
            $(this).find('.consignee-address-opreate').css('display', '');
        }, function(){
            $(this).removeClass('address-detail-hover');
            $(this).find('.consignee-address-opreate').css('display', 'none');
        });
    })
    //收货人选择 默认选中第一个
    $('.consignee-info:eq(0)').addClass('consignee-info-select');
    $('.consignee-info').click(function(){
        $('.consignee-info').removeClass('consignee-info-select');
        $(this).addClass('consignee-info-select');
    });

    //优惠券选择 默认选中第一个
    $('.confirm-coupon-item:eq(0)').addClass('confirm-coupon-item-select');
    $('.confirm-coupon-item').click(function(){
        $('.confirm-coupon-item').removeClass('confirm-coupon-item-select');
        $(this).addClass('confirm-coupon-item-select');
    });

    //提交订单
    $('.confirm-create-order-button').click(function(){
        layer.msg("生成订单");
    });

});