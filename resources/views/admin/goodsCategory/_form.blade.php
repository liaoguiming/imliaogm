{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">上级分类</label>
    <div class="layui-input-block">
        <select name="parent_id" lay-search  lay-filter="parent_id">
            <option value="0">一级分类</option>
            @foreach($goodsCategorys as $first)
                <option value="{{ $first['cat_id'] }}" @if(isset($goodsCategory->parent_id)&&$goodsCategory->parent_id==$first['cat_id']) selected @endif>{{ $first['cat_name'] }}</option>
                @if(isset($first['_child']))
                    @foreach($first['_child'] as $second)
                        <option value="{{$second['cat_id']}}" {{ isset($goodsCategory->id) && $goodsCategory->parent_id==$second['cat_id'] ? 'selected' : '' }} >&nbsp;&nbsp;┗━━{{$second['cat_name']}}</option>
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="cat_name" value="{{ $goodsCategory->cat_name ?? old('cat_name') }}" lay-verify="required" placeholder="请输入名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">排序</label>
    <div class="layui-input-block">
        <input type="text" name="sort" value="{{ $goodsCategory->sort ?? 0 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.goodsCategory')}}" >返 回</a>
    </div>
</div>