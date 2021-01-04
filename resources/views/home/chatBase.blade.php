<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="icon" href="/images/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>我的小站</title>
    <link rel="stylesheet" href="/static/home/layui/css/layui.css">
    <link rel="stylesheet" href="/static/home/css/main.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="/js/jquery-1.7.2.min.js"  type="text/javascript"></script>
    <script src="/static/home/layui/layui.all.js"  type="text/javascript"></script>
</head>
<body>
<div class="content">
    <div class="header" style="height: 101px; line-height: 101px;">
        <div class="menu-btn">
            <div class="menu"></div>
        </div>
        <h1 class="logo">
            <a href="/index">
                <span>LIAO BLOG</span>
                <img src="/static/home/img/logo.png">
            </a>
        </h1>
    </div>
    @yield('content')
</div>
<footer class="footer-wrap">
    <div>
        <a href="javascript:;" class="totop">
            <img src="/static/home/img/up.svg" width="20" height="20"/>
        </a>
        <a target="_blank" href="http://beian.miit.gov.cn/">蜀ICP备18006449号</a>
    </div>
</footer>
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

    $(function(){
        $('.search_btn').click(function(){
            var kw = $('#keywords').val();
            if(!kw){
                layer.msg("请输入搜索内容");return;
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
        $('.totop').click(function(){
            $("html,body").stop().animate({ scrollTop: 0 }, 600);
        });
    })
</script>
<script>
    layui.config({
        base: '/js/'
    }).use(['element','laypage','form','menu'],function(){
        element = layui.element,laypage = layui.laypage,form = layui.form,menu = layui.menu;
        menu.init();
        menu.submit()
    });
</script>
@yield('script')
</body>
</html>