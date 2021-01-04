@extends('home.base')

@section('content')
    <div class="content w1000">
        @foreach($articles as $article)
            <div class="cont w1000">
                <div class="list-item">
                    <div class="item">
                        <div class="layui-fluid">
                            <div class="layui-row">
                                <div class="layui-col-xs12 layui-col-sm8 layui-col-md10 content-border">
                                    <div class="item-cont">
                                        {{--<button class="layui-btn layui-btn-danger new-icon">new</button>--}}
                                        <a class="title-a" href="/index/detail/{{$article->id}}">
                                            <h3>{{$article->title}}</h3></a>
                                        <h5>{{$article->created_at}}<span style="float: right; clear: both;"> {{$article->commentCount}} Comments</span>
                                        </h5>
                                        <p>{{$article->description}}</p>
                                        <a href="/index/detail/{{$article->id}}" class="go-icon">继续浏览 >></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="w1000">
            <div class="list-item">
                <div class="item">
                    <div class="layui-fluid">
                        <div class="layui-row">
                            <div class="layui-col-xs12 layui-col-sm8 layui-col-md10">
                                <div class="item-cont">
                                    <ul class="page">
                                        @if($page != 1)<li class="prev"><a href="/index/{{$prev}}">« Prev</a></li>@endif
                                        @if($next != $page)<li class="next"><a href="/index/{{$next}}">Next »</a></li>@endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection