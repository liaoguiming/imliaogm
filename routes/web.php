<?php
//文件上传接口，前后台共用
Route::post('uploadImg', 'ApiController@uploadImg')->name('uploadImg');
//获取地区信息接口，前后台公用
Route::post('getAreas', 'ApiController@getAreas')->name('getAreas');
//发送短信
Route::post('/sendMsg', 'ApiController@sendMsg')->name('sendMsg');
//保存聊天昵称
Route::post('saveName', 'ApiController@saveName')->name('saveName');
//获取随机名字
Route::get('getName', 'ApiController@getWebSocketName')->name('getName');

Route::get('/','Home\IndexController@index')->name('home');

//支付
Route::group(['namespace' => 'Home'], function () {
    //微信支付
    Route::get('/wechatPay', 'PayController@wechatPay')->name('wechatPay');
    //微信支付回调
    Route::post('/wechatNotify', 'PayController@wechatNotify')->name('wechatNofity');
});

//会员-不需要认证
Route::group(['namespace'=>'Home','prefix'=>'member'],function (){
    //注册
    Route::get('register', 'MemberController@showRegisterForm')->name('home.member.showRegisterForm');
    Route::post('register', 'MemberController@register')->name('home.member.register');
    //登录
    Route::get('login', 'MemberController@showLoginForm')->name('home.member.showLoginForm');
    Route::post('login', 'MemberController@login')->name('home.member.login');
});
//会员-需要认证
Route::group(['namespace'=>'Home','prefix'=>'member','middleware'=>'member'],function (){
    //个人中心
    Route::get('/','MemberController@index')->name('home.member');
    //退出
    Route::get('logout', 'MemberController@logout')->name('home.member.logout');
});
//前台文章
Route::group(['namespace'=>'Home','prefix'=>'index'],function (){
    //文章列表
    Route::get('/','IndexController@index')->name('home.index.index')->middleware('access');
    //文章列表分页
    Route::get('{page}','IndexController@index')->name('home.index.page')->middleware('access');
    //文章详情
    Route::get('detail/{id}', 'IndexController@detail')->name('home.index.detail')->middleware('access');
    //文章评论
    Route::post('detail/addComment', 'IndexController@addComment')->name('home.index.addComment');
    //前台是vue
    Route::get('testVue', 'IndexController@testVue')->name('home.index.vue');
});
//前台导航
Route::group(['namespace'=>'Home','prefix'=>'nav'],function (){
    //导航列表
    Route::get('/','NavController@index')->name('home.nav.index')->middleware('access');
    //导航列表分页
    //Route::get('{page}','navController@index')->name('home.index.page')->middleware('access');
});
//前台留言板
Route::group(['namespace'=>'Home','prefix'=>'bbs'],function (){
    Route::get('/','IndexController@bbs')->name('home.index.bbs')->middleware('access');
});
//前台关于
Route::group(['namespace'=>'Home','prefix'=>'about'],function (){
    Route::get('/','IndexController@about')->name('home.index.about')->middleware('access');
});
//前台商城
Route::group(['namespace'=>'Home','prefix'=>'business'],function (){
    //商城主界面
    Route::get('/','BusinessController@index')->name('home.business.index')->middleware('access');
    //商城详情页
    Route::get('/detail/{id}','BusinessController@detail')->name('home.business.detail')->middleware('access');
    //结算页
    Route::get('/confirm','BusinessController@confirm')->name('home.business.confirm')->middleware('access');
});
//前台聊天室
Route::group(['namespace'=>'Home','prefix'=>'server'],function (){
    //商城主界面
    Route::get('/','ServerController@index')->name('home.server.index')->middleware('access');
});

//前台购物车
Route::group(['namespace'=>'Home','prefix'=>'cart'],function (){
    //商城购物车
    Route::get('/','CartController@index')->name('home.cart.index')->middleware('access');
});
