@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新商品</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.goods.update',['id'=>$goodsInfo->goods_id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.goods._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.article._js')
@endsection
