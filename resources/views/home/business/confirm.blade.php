@extends('home.businessBase')

@section('content')
    <div class="business-content">
        <div>填写并核对订单信息</div>
        <div class="confirm-main-content">
            <!--收货人信息开始-->
            <div class="consignee">
                <div class="confirm-title">
                    <h3>收货人信息</h3>
                    <div class="confirm-title-href"><a>新增收货地址</a></div>
                </div>
                <div class="consignee-main">
                    <ul>
                        @for($i=1; $i<=4; $i++)
                            <li>
                                <div class="consignee-info">廖贵明</div>
                                <div class="consignee-address-detail">
                                    <span>廖贵明</span>
                                    <span>四川 成都市 双流区 华阳镇街道 华阳正东下街20号六菱小区</span>
                                    <span>132****5200</span>
                                    @if($i == 1)<span class="default-consignee">默认地址</span>@endif
                                </div>
                                <div class="consignee-address-opreate">
                                    @if($i != 1)<a>设为默认地址</a>@endif
                                    <a>编辑</a>
                                    @if($i != 1)<a>删除</a>@endif
                                </div>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <!--收货人信息结束-->

            <div class="split-line"></div>

            <!--确认商品信息开始-->
            <div class="confirm-goods-list">
                <div class="confirm-title">
                    <h3>送货清单</h3>
                    <div class="confirm-title-href"><a href="/cart">返回购物车修改</a></div>
                </div>
                <div class="confirm-goods-list">
                    <div class="confirm-goods-main">
                        @for($i=1; $i<5; $i++)
                            <div class="confirm-goods-info">
                                <div class="confirm-goods-img"><a href="{{route('home.business.detail', ['id' => 11])}}" title="iphone11 pro max"><img src="/static/home/img/business.jpg" width="80" height="80"></a></div>
                                <div class="confirm-goods-desc">
                                    <div class="confirm-goods-name"><a href="{{route('home.business.detail', ['id' => 11])}}" title="iphone11 pro max">一加 OnePlus 7 Pro 2K+90Hz 流体屏 骁龙855旗舰 4800万超广角三摄</a></div>
                                    <div class="confirm-goods-attr">
                                        <span>曜岩灰</span><span>8GB 256GB</span>
                                    </div>
                                </div>
                                <div class="confirm-goods-fee">
                                    <div class="confirm-goods-price">￥5000</div>
                                    <div class="confirm-goods-number"><b>x</b>{{$i}}</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <!--确认商品信息结束-->

            <div class="split-line"></div>

            <!--使用优惠券信息开始-->
            <div class="confirm-coupon-info">
                <div class="confirm-title">
                    <h3>使用优惠</h3>
                </div>
                <div class="confirm-coupon-main">
                    <ul>
                        @for($i=1; $i<=10; $i++)
                            <li class="confirm-coupon-li">
                                <div class="confirm-coupon-item">
                                    <div class="coupon-price">￥100</div>
                                    <div class="coupon-limit">满199</div>
                                    <div class="coupon-time">有效期至<span>2020-12-31</span></div>
                                </div>
                            </li>
                        @endfor
                    </ul>
                </div>
            </div>
            <!--使用优惠券信息结束-->
        </div>

        <!--订单金额结算模块开始-->
        <div class="confirm-total-info">
            <div class="confirm-order-summary">
                <div class="fee-list">
                    <span><em class="total-number">2</em> 件商品，总商品金额：</span>
                    <em class="price">￥10000.00</em>
                </div>
                <div class="fee-list">
                    <span>运费：</span>
                    <em class="price" style="color: rgb(255, 102, 0);">￥0.00</em>
                </div>
                <div class="fee-list">
                    <span>商品优惠：</span>
                    <em class="price">￥10.00</em>
                </div>
            </div>
            <div class="confirm-create-order">
                <div>
                    <div class="total-fee">
                        <span>应付总额：</span>
                        <em class="fee">￥234.00</em>
                    </div>
                    <div class="consignee-result">
                        <span style="margin-right: 30px;">寄送至： 四川 成都市 双流区 华阳镇街道 华阳正东下街20号六菱小区</span>
                        <span>收货人：廖贵明 132****5200</span>
                    </div>
                </div>
                <button class="confirm-create-order-button">提交订单</button>
            </div>
        </div>
        <!--订单金额结算模块结束-->
    </div>
    <!--结算页面新增地址开始-->
    <div id="address-block" style="display: none;">
        <div class="add-consignee-form">
            <div class="item-1 detail-address">
                <span class="label"><em>*</em>所在地区</span>
                <div class="detail-address-all">
                    <div class="detail-address-main" style="top: 0 !important;margin:0 !important;"><span>请选择</span><img src="/static/home/img/down.svg" width="12" height="12" class="detail-address-img"></div>
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
            <div class="item" id="name_div">
                <span class="label"><em>*</em>收货人</span>
                <div class="fl">
                    <input type="text" name="consignee" class="input"/>
                </div>
            </div>
            <div class="item" id="name_div">
                <span class="label"><em>*</em>详细地址</span>
                <div class="fl">
                    <input type="text" name="consignee" class="input"/>
                </div>
            </div>
            <div class="item" id="name_div">
                <span class="label"><em>*</em>手机号码</span>
                <div class="fl">
                    <input type="text" class="tiny-input" value="0086" disabled/>
                    <em>-</em>
                    <input type="text" name="consignee" class="small-input"/>
                </div>
            </div>
            <div class="item" id="name_div">
                <span class="label"><em>&nbsp;&nbsp;</em>固定电话</span>
                <div class="fl">
                    <input type="text" class="tiny-input" value="0086" disabled/>
                    <em>-</em>
                    <input type="text" name="consignee" class="small-input"/>
                </div>
            </div>
            <div class="item" id="name_div">
                <span class="label"><em>&nbsp;&nbsp;</em>邮箱地址</span>
                <div class="fl">
                    <input type="text" name="consignee" class="input"/>
                    <p>用来接收订单提醒邮件，便于您及时了解订单状态</p>
                </div>
            </div>
            <div class="item" id="name_div">
                <span class="label"><em>&nbsp;&nbsp;</em>地址别名</span>
                <div class="fl">
                    <input type="text" name="consignee" class="input"/>
                </div>
            </div>
            <div class="item" id="button_div">
                <span class="label"><em>&nbsp;&nbsp;</em></span>
                <div class="fl">
                    <a href="#none" class="btn" onclick="save_Consignee()"><span id="saveConsigneeTitleDiv">保存收货人信息</span></a>
                </div>
            </div>
        </div>
    </div>
    <!--结算页面新增地址结束-->
@endsection