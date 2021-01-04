{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="cat_id" lay-verify="required">
            <option value=""></option>
            @foreach($navCategorys as $category)
                <option value="{{ $category->id }}" @if(isset($nav->cat_id)&&$nav->cat_id==$category->id)selected @endif >{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">导航名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{$nav->name??old('name')}}" lay-verify="required" placeholder="请输入导航名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">导航描述</label>
    <div class="layui-input-block">
        <input type="text" name="desc" value="{{$nav->desc??old('desc')}}" lay-verify="required" placeholder="请输入导航描述" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">导航网址</label>
    <div class="layui-input-block">
        <input type="text" name="url" value="{{$nav->url??old('url')}}" lay-verify="required" placeholder="请输入导航网址"  class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">导航排序</label>
    <div class="layui-input-block">
        <input type="text" name="sort" value="{{$nav->sort??0}}" lay-verify="required" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($nav->icon))
                        <li><img src="{{ $nav->icon }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="icon" id="icon" value="{{ $nav->icon??'' }}">
            </div>
        </div>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.nav')}}" >返 回</a>
    </div>
</div>