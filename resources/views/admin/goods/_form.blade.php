{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">商品分类</label>
    <div class="layui-input-inline">
        <select name="cat_id" lay-verify="required">
            <option value=""></option>
            @foreach($goodsCategorys as $category)
                <option value="{{ $category->cat_id }}" @if(isset($goodsInfo->cat_id)&&$goodsInfo->cat_id==$category->cat_id)selected @endif >{{ $category->cat_name }}</option>
                @if(isset($category->allChilds)&&!$category->allChilds->isEmpty())
                    @foreach($category->allChilds as $child)
                        <option value="{{ $child->cat_id }}" @if(isset($goodsInfo->cat_id)&&$goodsInfo->cat_id==$child->cat_id)selected @endif >&nbsp;&nbsp;&nbsp;┗━━{{ $child->cat_name }}</option>
                        @if(isset($child->allChilds)&&!$child->allChilds->isEmpty())
                            @foreach($child->allChilds as $third)
                                <option value="{{ $third->cat_id }}" @if(isset($goodsInfo->cat_id)&&$goodsInfo->cat_id==$third->cat_id)selected @endif >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;┗━━{{ $third->cat_name }}</option>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">商品名称</label>
    <div class="layui-input-block">
        <input type="text" name="goods_name" value="{{$goodsInfo->goods_name??old('goods_name')}}" lay-verify="required" placeholder="请输入商品名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">商品描述</label>
    <div class="layui-input-block">
        <textarea name="goods_desc" placeholder="请输入描述" class="layui-textarea">{{$goodsInfo->goods_desc??old('goods_desc')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">商品价格</label>
    <div class="layui-input-block">
        <input type="number" name="goods_price" value="{{$goodsInfo->goods_price??0.00}}" lay-verify="required"  class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">商品本站价</label>
    <div class="layui-input-block">
        <input type="number" name="goods_site_price" value="{{$goodsInfo->goods_site_price??0.00}}" lay-verify="required"  class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul id="layui-upload-box" class="layui-clear">
                    @if(isset($goodsInfo->goods_thumb))
                        <li><img src="{{ $goodsInfo->goods_thumb }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="goods_thumb" id="thumb" value="{{ $goodsInfo->goods_thumb??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否展示</label>
    <div class="layui-input-block">
        <input type="checkbox" value="1" @if(isset($goodsInfo->is_show)&&$goodsInfo->is_show==1)checked @endif name="is_show" lay-skin="switch" lay-filter="switchTest" lay-text="是|否">
    </div>
</div>

<div class="layui-form-item">
    <label class="layui-form-label">是否热门</label>
    <div class="layui-input-block">
        <input type="checkbox" value="1" @if(isset($goodsInfo->is_hot)&&$goodsInfo->is_hot==1)checked @endif name="is_hot" lay-skin="switch" lay-filter="switchTest" lay-text="是|否">
    </div>
</div>

@include('UEditor::head');
<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="goods_content" type="text/plain">
            {!! $goodsInfo->goods_content??old('goods_content') !!}
        </script>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.goods')}}" >返 回</a>
    </div>
</div>