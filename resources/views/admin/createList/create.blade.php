@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加功能配置</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.createList.store')}}" method="post">
                @include('admin.createList._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.createList._js')
@endsection
