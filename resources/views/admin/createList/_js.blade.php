<script>
    layui.use(['form'], function(){
        var form = layui.form, layer = layui.layer;
        form.on('select', function(data){
            //data.elem.getAttribute(data-aid));
            var table = data.value;
            var url = "{{route('admin.createList.getTableColumns')}}";
            var i = 0;
            var h = '<label for="" class="layui-form-label">展示字段</label><div class="layui-input-block" id="show_columns">';
            var h1 = '<label for="" class="layui-form-label">搜索字段</label><div class="layui-input-block" id="show_columns">';
            var h2 = '<label for="" class="layui-form-label">操作字段</label><div class="layui-input-block" id="show_columns">';
            $.post(url,{table:table},function(data){
                for(i; i<data.data.length; i++){
                    h += '<input type="checkbox" name="show_columns[]" value="'+data.data[i]+'" title="'+data.data[i]+'">';
                    h1 += '<input type="checkbox" name="search_columns[]" value="'+data.data[i]+'" title="'+data.data[i]+'">';
                    h2 += '<input type="checkbox" name="opreate_columns[]" value="'+data.data[i]+'" title="'+data.data[i]+'">';
                }
                $('#show_columns').html(h + "</div>");
                $('#search_columns').html(h1 + "</div>");
                $('#opreate_columns').html(h2 + "</div>");
                form.render('checkbox');
            })
        });
    });
</script>