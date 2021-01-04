@extends('home.base')

@section('content')
    <div class="content w1000">
        <form class="layui-form" action="/search" id="search_submit">
            <div class="nav-div">
                <input type="text" id="keywords" placeholder="请输入搜索内容" autocomplete="off" class="nav-input">
                <img src="/static/home/img/search.svg" class="search_btn">
            </div>
        </form>
        {{--<div>--}}
            {{--<ul>--}}
                {{--<li class="nav-hot-li">1111</li>--}}
                {{--<li class="nav-hot-li">1111</li>--}}
                {{--<li class="nav-hot-li">1111</li>--}}
                {{--<li class="nav-hot-li">1111</li>--}}
                {{--<li class="nav-hot-li">1111</li>--}}
            {{--</ul>--}}
        {{--</div>--}}

        @foreach($navInfo as $nav)
            <div class="main-nav">
                <div class="nav-cat">{{$nav['catName']}}</div>
                <ul>
                    @foreach($nav['data'] as $n)
                        <a href="{{$n->url}}" target="_blank" title="{{$n->desc}}" class="nav-a">
                            <li class="nav-li">
                                    <span>{{$n->name}}</span>
                                    <p>{{$n->desc}}</p>
                            </li>
                        </a>
                    @endforeach
                </ul>
                <p style="clear: both;"></p>
            </div>
        @endforeach
    </div>
@endsection