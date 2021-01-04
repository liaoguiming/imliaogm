@extends('home.businessBase')

@section('content')
    <div class="cart-content">
        <div class="cart-main">
            <div class="cart-count-info">全部商品<span style="margin-left: 5px;">1</span></div>
            <div class="cart-title-info">
                <div>
                    <div class="tleft dd cart-checkbox"><input type="checkbox" class="cart-checkbox-main"/>全选</div>
                    <div class="tleft dd cart-goods">商品</div>
                    <div class="tleft dd cart-prop"></div>
                    <div class="tleft dd cart-price">单价</div>
                    <div class="tleft dd cart-number">数量</div>
                    <div class="tleft dd cart-total">金额</div>
                    <div class="tleft dd cart-opreate">操作</div>
                </div>
            </div>
            <div class="cart-main-info">
                @for($i=1; $i<5; $i++)
                    <div>
                        <div class="tleft ddd"><input type="checkbox"/></div>
                        <div class="tleft ddd cart-goods-info">
                            <div class="cart-gd-img"><a href="{{route('home.business.detail', ['id' => 11])}}" title="iphone11 pro max"><img src="/static/home/img/business.jpg" width="80" height="80"></a></div>
                            <div class="cart-gd-name"><a href="{{route('home.business.detail', ['id' => 11])}}" title="iphone11 pro max">一加 OnePlus 7 Pro 2K+90Hz 流体屏 骁龙855旗舰 4800万超广角三摄</a></div>
                        </div>
                        <div class="tleft ddd cart-prop-info">
                            <div>曜岩灰</div>
                            <div>8GB 256GB</div>
                        </div>
                        <div class="tleft ddd cart-price-info">￥5000</div>
                        <div class="tleft ddd cart-number-info">100</div>
                        <div class="tleft ddd cart-total-info">￥500000</div>
                        <div class="tleft ddd cart-opreate-info">
                            <a>删除</a>
                        </div>
                    </div>
                    <div style="clear: both"></div>
                @endfor
            </div>
        </div>
        <div class="cart-bottom-opreate">
            <div class="cart-opreate-left">
                <div class="tleft dd cart-bottom-checkbox"><input type="checkbox" class="cart-checkbox-main"/>全选</div>
                <a>删除选中商品</a>
                <a>清理购物车</a>
            </div>
            <div class="cart-opreate-right">
                <div class="tright">
                    <a class="cart-cost-button cost-button">去结算</a>
                </div>
                <div class="tright cart-bottom-total">总价：<span class="cart-total-price">￥500000</span></div>
                <div class="tright cart-bottom-gf">已选择<span class="cart-total-price">1</span>件商品</div>
            </div>
        </div>
        <div class="cart-hot-category">
            <div class="business-main-all">
                @for($i=0; $i<=3; $i++)
                    <div class="business-main-div">
                        <a href="{{route('home.business.detail', ['id' => 11])}}" title="iphone11 pro max"><img class="banner-img" src="/static/home/img/business.jpg"></a>
                        <div class="business-price"><a href="/" target="_blank" title="iphone11 pro max" class="business-a">￥5000</a></div>
                        <div class="business-name"><a href="/" target="_blank" title="iphone11 pro max" class="business-a">iphone11 pro max</a></div>
                    </div>
                @endfor
            </div>
        </div>
        <div style="clear: both"></div>
    </div>
@endsection