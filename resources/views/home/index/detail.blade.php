@extends('home.base')

@section('content')
    <div class="content whisper-content leacots-content details-content">
        <div class="cont w1000">
            <div class="whisper-list">
                <div class="item-box">
                    <div class="review-version">
                        <div class="form-box">
                            <div class="article-cont">
                                <div class="title">
                                    <h3>{{$article->title}}</h3>
                                    <p class="cont-info"><span class="data">{{$article->created_at}}</span><span>{{$article->click}}</span><span class="types" style="margin-left: 30px;">{{$article->name}}</span></p>
                                </div>
                                <?php echo $article->content;?>
                                <div class="btn-box">
                                    @if($prev != 0)<a href="/index/detail/{{$prev}}"><button class="layui-btn layui-btn-primary">上一篇</button></a>@endif
                                    @if($next != $id)<a href="/index/detail/{{$next}}"><button class="layui-btn layui-btn-primary">下一篇</button></a>@endif
                                    <a href="/index/detail/{{$rand}}"><button class="layui-btn layui-btn-primary">随机传送</button></a>
                                </div>
                            </div>
                            <div class="form">
                                <form class="layui-form" action="{{route('home.index.addComment')}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="layui-form-item layui-form-text">
                                        <div class="layui-input-block">
                                            <textarea name="content" placeholder="既然来了，就说几句" class="layui-textarea"></textarea>
                                        </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <input type="hidden" name="article_id" value="{{$id}}">
                                        <input type="hidden" name="user_id" value="1">
                                        <input type="hidden" name="email" value="396384529@qq.com">
                                        <div class="layui-input-block" style="text-align: right;">
                                            <button class="layui-btn">確定</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="volume">
                            全部留言 <span>{{$commentCount}}</span>
                        </div>
                        <div class="list-cont">
                            @foreach($articleComment as $comment)
                            <div class="cont">
                                <div class="text">
                                    <p class="tit"><span class="name">{{$comment->nick_name}}</span><span class="data">{{$comment->created_at}}</span></p>
                                    <p class="ct">{{$comment->content}}</p>
                                    @if($comment->reply_content)
                                        <p class="ct" style="margin: 20px 0px 0px 50px;"><span style="color: green;">回复：</span>{{$comment->reply_content}}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div id="demo" style="text-align: center;"></div>
        </div>
    </div>
@endsection