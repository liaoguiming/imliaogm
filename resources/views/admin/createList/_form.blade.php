{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">表名</label>
    <div class="layui-input-inline">
        <select name="table_name" lay-verify="required">
            <option value="">请选择...</option>
            @foreach($tableInfo as $table)
                <option value="{{ $table }}" @if(isset($res['table_name'])&&$res['table_name']==$table)selected @endif>{{ $table }}</option>
       @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">模型名</label>
    <div class="layui-input-block">
        <input type="text" name="model_name" value="{{$res['model_name']??old('model_name')}}" lay-verify="required" placeholder="请输入模型名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item" id="show_columns"></div>
<div class="layui-form-item" id="search_columns"></div>
<div class="layui-form-item" id="opreate_columns"></div>

<div class="layui-form-item">
    <label class="layui-form-label">添加功能</label>
    <div class="layui-input-block">
        <input type="checkbox" checked="" name="is_need_create" lay-skin="switch" lay-filter="switchTest" lay-text="开启|关闭">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">删除功能</label>
    <div class="layui-input-block">
        <input type="checkbox" checked="" name="is_need_delete" lay-skin="switch" lay-filter="switchTest" lay-text="开启|关闭">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.createList')}}" >返 回</a>
    </div>
</div>