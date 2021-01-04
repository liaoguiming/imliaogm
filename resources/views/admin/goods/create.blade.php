@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加商品</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.goods.store')}}" method="post">
                @include('admin.goods._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.goods._js')
@endsection
