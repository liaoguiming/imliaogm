@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新评论内容</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.comment.update',['id'=>$res->id])}}" method="post">
                {{ method_field('put') }}
                @include('admin.comment._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.comment._js')
@endsection
