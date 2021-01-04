@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('config.createList.create')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.createList.create') }}">添 加</a>
                @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('config.createList.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                </div>
            </script>
            <script type="text/html" id="article">
                @{{d.article.title}}
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('zixun.comment')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    ,height: 500
                    ,url: "{{ route('admin.createList.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'table_name', title: '表名'}
                        ,{field: 'model_name', title: '模型名'}
                        ,{field: 'is_need_create', title: '添加编辑功能'}
                        ,{field: 'is_need_delete', title: '删除功能'}
                        ,{field: 'created_at', title: '创建时间'}
                        ,{field: 'updated_at', title: '更新时间'}
                        ,{fixed: 'right', width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            {{--$.post("{{ route('admin.createList.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {--}}
                                {{--if (result.code==0){--}}
                                    {{--obj.del(); //删除对应行（tr）的DOM结构--}}
                                {{--}--}}
                                {{--layer.close(index);--}}
                                {{--layer.msg(result.msg)--}}
                            {{--});--}}
                        });
                    } else if(layEvent === 'edit'){
                        location.href = '/admin/createList/'+data.id+'/edit';
                    }
                });

                @can('zixun.comment.edit')
                //监听是否显示
                form.on('switch(isShow)', function(obj){
                    var index = layer.load();
                    var url = $(obj.elem).attr('url')
                    var data = {
                        "is_show" : obj.elem.checked==true?1:0,
                        "_method" : "put"
                    }
                    $.post(url,data,function (res) {
                        layer.close(index)
                        layer.msg(res.msg)
                    },'json');
                });
                @endcan

                //按钮批量删除
                $("#listDelete").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.article.destroy') }}",{_method:'delete',ids:ids},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg)
                            });
                        })
                    }else {
                        layer.msg('请选择删除项')
                    }
                })

                //搜索
                $("#searchBtn").click(function () {
                    var isShow = $("#is_show").val()
                    var content = $("#content").val();
                    dataTable.reload({
                        where:{is_show:isShow,content:content},
                        page:{curr:1}
                    })
                })
            })
        </script>
    @endcan
@endsection