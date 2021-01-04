<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class ServerController extends Controller
{

    public function index()
    {
        $userName = Cookie::get('user_name');
        $d = isset($_GET['d']) && !empty($_GET['d']) ? $_GET['d'] : 0;
        if ($d == 1) {
            Cookie::queue('user_name', '', 24 * 3600);
            //清除用户与客户端fd绑定关系
            Redis::hdel('user_list', $userName);
        }
        $onlineNum = Redis::get('online_num');
        $onlineNum = $onlineNum > 0 ? $onlineNum : 0;
        return view('home.server.index', compact('userName', 'onlineNum'));
    }

}
