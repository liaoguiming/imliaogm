@extends('admin.base')

@section('content')
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md8">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">快捷方式</div>
                        <div class="layui-card-body">
                            <div class="layui-carousel layadmin-carousel layadmin-shortcut">
                                <div carousel-item>
                                    <ul class="layui-row layui-col-space10">
                                        @foreach($showInfo as $show)
                                        <li class="layui-col-xs3">
                                            <a lay-href="{{route($show['link'])}}">
                                                <i class="layui-icon layui-icon-note"></i>
                                                <cite>{{$show['name']}}</cite>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    <ul class="layui-row layui-col-space10">
                                        @foreach($showInfo as $show)
                                            <li class="layui-col-xs3">
                                                <a lay-href="{{route($show['link'])}}">
                                                    <i class="layui-icon layui-icon-console"></i>
                                                    <cite>{{$show['name']}}</cite>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-col-md6">
                    <div class="layui-card">
                        <div class="layui-card-header">待办事项</div>
                        <div class="layui-card-body">
                            <div class="layui-carousel layadmin-carousel layadmin-backlog">
                                <div carousel-item>
                                    <ul class="layui-row layui-col-space10">
                                        <li class="layui-col-xs6">
                                            <a lay-href="{{Route('admin.comment')}}" class="layadmin-backlog-body">
                                                <h3>待审评论</h3>
                                                <p><cite>{{$notShowComment}}</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs6">
                                            <a lay-href="app/forum/list.html" class="layadmin-backlog-body">
                                                <h3>待审帖子</h3>
                                                <p><cite>12</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs6">
                                            <a lay-href="template/goodslist.html" class="layadmin-backlog-body">
                                                <h3>待审商品</h3>
                                                <p><cite>99</cite></p>
                                            </a>
                                        </li>
                                        <li class="layui-col-xs6">
                                            <a href="javascript:;" onclick="layer.tips('不跳转', this, {tips: 3});"
                                               class="layadmin-backlog-body">
                                                <h3>待发货</h3>
                                                <p><cite>20</cite></p>
                                            </a>
                                        </li>
                                    </ul>

                                    <ul class="layui-row layui-col-space10">
                                        <li class="layui-col-xs6">
                                            <a href="javascript:;" class="layadmin-backlog-body">
                                                <h3>待审友情链接</h3>
                                                <p><cite style="color: #FF5722;">5</cite></p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">数据概览</div>
                        <div class="layui-card-body">
                            <div class="layui-carousel layadmin-carousel layadmin-dataview" data-anim="fade"
                                 lay-filter="LAY-index-dataview">
                                <div carousel-item id="LAY-index-dataview">
                                    <div><i class="layui-icon layui-icon-loading1 layadmin-loading"></i></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">效果报告</div>
                <div class="layui-card-body layadmin-takerates">
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>转化率（日同比 28% <span class="layui-edge layui-edge-top" lay-tips="增长" lay-offset="-15"></span>）
                        </h3>
                        <div class="layui-progress-bar" lay-percent="65%"></div>
                    </div>
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>签到率（日同比 11% <span class="layui-edge layui-edge-bottom" lay-tips="下降"
                                              lay-offset="-15"></span>）</h3>
                        <div class="layui-progress-bar" lay-percent="32%"></div>
                    </div>
                </div>
            </div>


            <div class="layui-card">
                <div class="layui-card-header">实时监控</div>
                <div class="layui-card-body layadmin-takerates">
                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>CPU使用率</h3>
                        <div class="layui-progress-bar" lay-percent="58%"></div>
                    </div>

                    <div class="layui-progress" lay-showPercent="yes">
                        <h3>内存占用率</h3>
                        <div class="layui-progress-bar layui-bg-red" lay-percent="90%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['index', 'console']);
    </script>
@endsection