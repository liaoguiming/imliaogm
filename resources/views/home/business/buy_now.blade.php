@extends('home.businessBase')

@section('content')
    <div class="business-content">
        <div class="main-searchBar"></div>
        <div class="detail-content">
            <div class="detail-left">
                <a href="{{route('home.business.detail', ['id' => 11])}}" target="_blank" title="iphone11 pro max"><img class="banner-img" src="/static/home/img/detail.jpg"></a>
            </div>
            <div class="detail-right">
                <div class="detail-title">{{$goodsInfo->goods_name}}</div>
                <div class="detail-desc">{{$goodsInfo->goods_desc}}</div>
                <div class="detail-price">
                    <span class="detail-normal">价格：</span>
                    <span class="detail-price-mark">￥<span class="detail-price-main">{{$goodsInfo->goods_site_price}}</span></span>
                </div>
                <div class="detail-service">
                    <div class="detail-service-left">
                        <span class="detail-normal">服务：</span>
                    </div>
                    <div class="detail-service-right">
                        <span class="detail-address-main">提供售后服务</span>
                    </div>
                </div>
                <div class="detail-address" style="clear: both">
                    <span class="detail-address-normal">配送：</span>
                    <div class="detail-address-all">
                        <div class="detail-address-main"><span>请选择</span><img src="/static/home/img/down.svg" width="12" height="12" class="detail-address-img"></div>
                        <div class="detail-address-display">
                            <div class="detail-address-select">
                                <a attr-index="0" class="detail-address-main-select"><span>请选择</span><img src="/static/home/img/down.svg" width="12" height="12" class="detail-address-img"></a>
                                <a attr-index="1"><span>请选择</span><img src="/static/home/img/down.svg" width="12" height="12" class="detail-address-img"></a>
                                <a attr-index="2" style="display: none"><span>请选择</span><img src="/static/home/img/down.svg" width="12" height="12" class="detail-address-img"></a>
                            </div>
                            <div class="detail-address-select-all">
                                <div class="detail-address-select-1">
                                    <ul attr-type="1">
                                        @foreach($areaInfo as $info)
                                        <li><a href="javascript:;" attr-id="{{$info->id}}">{{$info->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-attr">
                    <span class="detail-normal">规格：</span>
                    <ul>
                        <li attr-id="">128G</li>
                        <li attr-id="">256G</li>
                        <li attr-id="">512G</li>
                    </ul>
                </div>
                <div class="detail-number">
                    <span class="detail-number-normal detail-number-left">数量：</span>
                    <div class="detail-number-all">
                        <a class="less"><img src="/static/home/img/minus.svg" width="12" height="12" class="detail-number-img"/></a>
                        <input type="input" value="1" name="goods_number" oninput="value=value.replace(/[^\d]/g,'')"/>
                        <a class="more"><img src="/static/home/img/add.svg" width="12" height="12" class="detail-number-img"/></a>
                    </div>
                </div>
                <div class="detail-buy">
                    <a class="detail-add-cart">加入购物车</a>
                    <a class="detail-buy-now">立即购买</a>
                </div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div class="layui-tab layui-tab-card detail-html">
            <ul class="layui-tab-title">
                <li class="layui-this">商品详情</li>
                <li>用户评价<span class="detail-commentCount">(120)</span></li>
                <li>常见问题</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show" style="text-align: center">
                    <?php echo $goodsInfo->goods_content;?>
                </div>
                <div class="layui-tab-item">
                    <div>评价Apple iPhone 11 Pro (A2217) 256GB 暗夜绿色 移动联通电信4G手机</div>
                    <div>经典旗舰机型推荐：iPhoneXSMax性能强劲，样样出色，限时抢券低至5699元！</div>
                    <div><span class="price-title">本站价：</span>￥5000</div>
                    <div><span class="address-title">配送至：</span>四川省成都市</div>
                    <div>Apple iPhone 11 Pro (A2217) 256GB 暗夜绿色 移动联通电信4G手机</div>
                    <div>经典旗舰机型推荐：iPhoneXSMax性能强劲，样样出色，限时抢券低至5699元！</div>
                    <div><span class="price-title">本站价：</span>￥5000</div>
                    <div><span class="address-title">配送至：</span>四川省成都市</div>
                    <div>Apple iPhone 11 Pro (A2217) 256GB 暗夜绿色 移动联通电信4G手机</div>
                    <div>经典旗舰机型推荐：iPhoneXSMax性能强劲，样样出色，限时抢券低至5699元！</div>
                    <div><span class="price-title">本站价：</span>￥5000</div>
                    <div><span class="address-title">配送至：</span>四川省成都市</div>
                </div>
                <div class="layui-tab-item">
                    <div>常见问题Apple iPhone 11 Pro (A2217) 256GB 暗夜绿色 移动联通电信4G手机</div>
                    <div>经典旗舰机型推荐：iPhoneXSMax性能强劲，样样出色，限时抢券低至5699元！</div>
                    <div><span class="price-title">本站价：</span>￥5000</div>
                    <div><span class="address-title">配送至：</span>四川省成都市</div>
                    <div>Apple iPhone 11 Pro (A2217) 256GB 暗夜绿色 移动联通电信4G手机</div>
                    <div>经典旗舰机型推荐：iPhoneXSMax性能强劲，样样出色，限时抢券低至5699元！</div>
                    <div><span class="price-title">本站价：</span>￥5000</div>
                    <div><span class="address-title">配送至：</span>四川省成都市</div>
                    <div>Apple iPhone 11 Pro (A2217) 256GB 暗夜绿色 移动联通电信4G手机</div>
                    <div>经典旗舰机型推荐：iPhoneXSMax性能强劲，样样出色，限时抢券低至5699元！</div>
                    <div><span class="price-title">本站价：</span>￥5000</div>
                    <div><span class="address-title">配送至：</span>四川省成都市</div>
                </div>
            </div>
        </div>

        <div style="clear: both;"></div>
    </div>
@endsection