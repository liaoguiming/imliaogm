{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">评论内容</label>
    <div class="layui-input-block">
        1
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">回复</label>
    <div class="layui-input-block">
        <textarea placeholder="请输入回复内容" class="layui-textarea" name="reply_content"></textarea>
    </div>
</div>


<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.comment')}}" >返 回</a>
    </div>
</div>