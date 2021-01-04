@extends('home.base')

@section('content')
    <div class="about-content">
        <div class="w1000">
            <div class="item info">
                <div class="title">
                    <h3>我的介绍</h3>
                </div>
                <div class="cont">
                    <div class="per-info">
                        <p>
                            <span class="name">廖贵明</span><br/>
                        </p>
                    </div>
                </div>
            </div>
            <div class="item tool">
                <div class="title">
                    <h3>我的技能</h3>
                </div>
                <div class="layui-fluid">
                    <div class="layui-row">
                        <div class="layui-col-xs6 layui-col-sm3 layui-col-md3">
                            <div class="cont-box">
                                <img src="../res/img/gr_img2.jpg">
                                <p>80%</p>
                            </div>
                        </div>
                        <div class="layui-col-xs6 layui-col-sm3 layui-col-md3">
                            <div class="cont-box">
                                <img src="../res/img/gr_img3.jpg">
                                <p>80%</p>
                            </div>
                        </div>
                        <div class="layui-col-xs6 layui-col-sm3 layui-col-md3">
                            <div class="cont-box">
                                <img src="../res/img/gr_img4.jpg">
                                <p>80%</p>
                            </div>
                        </div>
                        <div class="layui-col-xs6 layui-col-sm3 layui-col-md3">
                            <div class="cont-box">
                                <img src="../res/img/gr_img5.jpg">
                                <p>80%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item contact">
                <div class="title">
                    <h3>联系方式</h3>
                </div>
                <div class="cont">
                    <div class="text">
                        <p class="WeChat">邮箱：<span>449544638@qq.com</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection