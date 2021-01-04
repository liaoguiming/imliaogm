<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="/images/favicon.ico"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>我的小站</title>
    <link rel="stylesheet" href="/static/home/layui/css/layui.css">
    <link rel="stylesheet" href="/static/home/css/main.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="/static/home/layui/layui.all.js" type="text/javascript"></script>
</head>
<body>
<div class="business-main">
    <div class="business-header">
        <div class="header-left">
            <a href="/index" @if(isset($flag) && $flag == 'index')class="active"@endif>我的小站</a>
        </div>
        <div class="header-left">
            <a href="/business" @if(isset($flag) && $flag == 'business')class="active"@endif>商城首页</a>
        </div>
        <div class="header-center">
            <img src="/static/home/img/cart.svg" width="18" height="18">
            <a href="/cart" @if(isset($flag) && $flag == 'cart')class="active"@endif>我的购物车<span
                        class="cart-goods-number">1</span></a>
        </div>
        <div class="header-right">
            <a href="/">退出</a>
        </div>
        <div class="header-right">
            <a href="/" @if(isset($flag) && $flag == 'member')class="active"@endif>个人中心</a>
        </div>
        <div class="header-right">
            <a href="/" @if(isset($flag) && $flag == 'order')class="active"@endif>我的订单</a>
        </div>
    </div>
    @yield('content')
</div>
<footer class="footer-wrap">
    <div>商城须知</div>
    <div>
        <a href="javascript:;" class="totop">
            <img src="/static/home/img/up.svg" width="20" height="20"/>
        </a>
        <a target="_blank" href="http://beian.miit.gov.cn/">蜀ICP备18006449号</a>
    </div>
</footer>
<script type="text/javascript" src="/static/home/js/detail.js"></script>
<script type="text/javascript" src="/static/home/js/cart.js"></script>
<script type="text/javascript" src="/static/home/js/confirm.js"></script>
<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var element = layui.element;
    var layer = layui.layer;
    var form = layui.form;
    var table = layui.table;
    var upload = layui.upload;
    var getAreasUrl = "{{route('getAreas')}}";
    form.render();
    element.render();

    //统一错误提示信息
            @if(count($errors)>0)
    var errorStr = '';
    @foreach($errors->all() as $error)
            errorStr += "{{$error}}<br />";
    @endforeach
        layer.msg(errorStr);
    @endif

    @if(session('status'))
        layer.msg("{{session('status')}}");
    @endif

    $(function () {
        $('.search_btn').click(function () {
            var kw = $('#keywords').val();
            if (!kw) {
                layer.msg("请输入搜索内容");
                return;
            }
            var url = "http://www.baidu.com/s?wd=" + kw;
            window.open(url, '_blank');
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 600) {
                $(".totop").fadeIn();
            } else {
                $(".totop").fadeOut();
            }
        });
        $('.totop').click(function () {
            $("html,body").stop().animate({scrollTop: 0}, 600);
        });
        $('.confirm-title-href').click(function(){
            //自定页
            layer.open({
                title:'新增收货地址',
                type: 1,
                skin: 'confirm-add-address', //样式类名
                closeBtn: 1, //不显示关闭按钮
                anim: 2,
                shadeClose: true, //开启遮罩关闭
                content: $('#address-block').html(),
            });
        })
    })



</script>
<script>
    layui.config({
        base: '/js/'
    }).use(['element', 'laypage', 'form', 'menu'], function () {
        element = layui.element, laypage = layui.laypage, form = layui.form, menu = layui.menu;
        menu.init();
        menu.submit()
    });
</script>
@yield('script')
</body>
</html>