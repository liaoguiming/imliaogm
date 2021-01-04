/**
 * Created by Administrator on 2019/12/16 0016.
 */
$(function(){
    goodsNumberStatus();
    //减少购买数量
    $('.less').click(function(){
        var i = $('input[name="goods_number"]').val();
        if($('input[name="goods_number"]').val() == 1){
            $(this).addClass("detail-disabled");
        }else{
            i--;
            $('input[name="goods_number"]').val(i);
            goodsNumberStatus();
        }
    });
    //购买数量输入框操作
    $('input[name="goods_number"]').blur(function(){
        if(!$(this).val() || $(this).val() <= 0){
            $(this).val(1);
        }
        goodsNumberStatus();
    })
    //选择规格
    $('.detail-attr ul li').each(function(){
        $(this).click(function(){
            $('.detail-attr ul li').removeClass("detail-attr-select");
            $(this).addClass("detail-attr-select");
        });
    })
    //增加购买数量
    $('.more').click(function(){
        var i = $('input[name="goods_number"]').val();
        i++;
        $('input[name="goods_number"]').val(i);
        $('.less').removeClass("detail-disabled");
    });
    $('.detail-add-cart').click(function(){
        layer.msg('添加购物车');
    });
    $('.detail-buy-now').click(function(){
        window.location.href = "/business/confirm";
    });
    //选择配送地区
    $('.detail-address-all').on({
        mouseenter:function(){
            $('.detail-address-main').css('border-bottom', 'none');
            $('.detail-address-display').css('display', 'block');
        },
        mouseleave:function(){
            $('.detail-address-display').css('display', 'none');
        }
    });
    var provinceRes = '', cityRes = '', areaRes = '';
    //选择省市区的操作---省
    $('.detail-address-select-1').find('a').on('click', function() {
        var parent_id = $(this).attr('attr-id');
        var type = $(this).parent('li').parent('ul').attr('attr-type');
        var _this = $(this);
        $.post(getAreasUrl, {parent_id:parent_id}, function(data){
            var html = areaAppendHtml(data);
            //先删除再添加地区信息
            $('.detail-address-select-2').remove();
            $('.detail-address-select-all').append(html);
            provinceRes = _this.html();
            areaShowDiv(type);
            areaShowTab(0,  _this.html(), parent_id, 1);
        });
    })
    //选择省市区的操作---市
    $('.detail-address-select-2').find('a').live('click', function() {
        var flag = 0;
        var parent_id = $(this).attr('attr-id');
        var type = $(this).parent('li').parent('ul').attr('attr-type');
        var _this = $(this);
        $.post(getAreasUrl, {parent_id:parent_id}, function(data){
            cityRes = _this.html();
            if(data.code == 0){
                var html = areaAppendHtml(data);
                $('.detail-address-select-3').remove();
                $('.detail-address-select-all').append(html);
                flag = 1;
                areaShowDiv(type);
            }else{
                //没有第三级地区的情况
                $('.detail-address-main span').html(provinceRes + cityRes)
                $('.detail-address-display').css('display', 'none');
            }
            areaShowTab(1,  _this.html(), parent_id, flag);
        });
    })
    //选择省市区的操作---区
    $('.detail-address-select-3').find('a').live('click', function() {
        areaRes = $(this).html();
        $('.detail-address-select').find('a:eq(2)').attr('attr-id', $(this).attr('attr-id'));
        $('.detail-address-select').find('a:eq(2) span').html($(this).html());
        $('.detail-address-main span').html(provinceRes + cityRes + areaRes)
        $('.detail-address-display').css('display', 'none');
        //选择完地区后应该有的操作
        //TODO
    })

    //重新选择省市区的操作
    $('.detail-address-select').find('a').click(function(){
        var id = $(this).attr('attr-id');
        var index = $(this).attr('attr-index');
        //选中效果
        $('.detail-address-select').find('a').removeClass('detail-address-main-select');
        $('.detail-address-select').find('a:eq('+index+')').addClass('detail-address-main-select');
        areaShowDiv(index)
    });

});
//获取省市区拼接的html
function areaAppendHtml(data){
    var html = "<div class=detail-address-select-"+data.data[0].type+"><ul attr-type="+data.data[0].type+">";
    for(var i = 0; i < data.data.length; i++){
        html += "<li><a attr-id="+data.data[i].id+">"+data.data[i].name+"</a></li>";
    }
    html += "</ul></div>"
    return html;
}

//哪些需要展示，哪些需要隐藏，哪些需要删除
function areaShowDiv(type){
    var needShowType = parseInt(type) + 1;
    $('.detail-address-select-all ul').each(function(a, b){
        var divType = $(this).attr('attr-type');
        if(divType == needShowType){
            $(this).parent('div').css('display', 'block');
        }else{
            $(this).parent('div').css('display', 'none');
        }
    });
}

//选择地区tab切换
function areaShowTab(index, html, parent_id, flag){
    var next = parseInt(index) + 1
    //添加属性id
    $('.detail-address-select').find('a:eq('+index+')').attr('attr-id', parent_id);
    //添加名称
    $('.detail-address-select').find('a:eq('+index+') span').html(html);
    //先删除
    $('.detail-address-select').find('a').removeClass('detail-address-main-select');
    //是否隐藏下一级
    if(!flag){
        $('.detail-address-select').find('a:eq('+next+')').css('display', 'none');
    }else{
        $('.detail-address-select').find('a:eq('+next+')').css('display', '');
    }
    var show = flag ? next : index;
    //添加样式
    $('.detail-address-select').find('a:eq('+show+')').addClass('detail-address-main-select');
}

//根据购买数量获取增加和减少按钮状态
function goodsNumberStatus(){
    var i = $('input[name="goods_number"]').val();
    if(i == 1){
        $('.less').addClass('detail-disabled');
    }else{
        $('.less').removeClass('detail-disabled');
    }
}