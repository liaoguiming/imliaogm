@extends('home.businessBase')

@section('content')
    <div class="business-content">
        <div class="main-searchBar"></div>
        <div class="main-business">
            <div class="business-main-all">
                @for($i=1; $i<=12; $i++)
                    <div class="business-main-div">
                        <a href="{{route('home.business.detail', ['id' => $i])}}" title="iphone11 pro max"><img class="banner-img" src="/static/home/img/business.jpg"></a>
                        <a href="{{route('home.business.detail', ['id' => $i])}}" target="_blank" title="iphone11 pro max" class="business-a"><div class="business-price">￥5000</div></a>
                        <a href="{{route('home.business.detail', ['id' => $i])}}" target="_blank" title="iphone11 pro max" class="business-a"><div class="business-name">iphone11 pro max</div></a>
                    </div>
                @endfor
            </div>
            <p style="clear: both;"></p>
        </div>
    </div>
@endsection