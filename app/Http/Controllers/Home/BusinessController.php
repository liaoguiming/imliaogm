<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BusinessController extends Controller
{
    //
    public function index()
    {
        $navInfo = [];
        $flag = "business";
        $navCat = DB::table('navs')->where('is_show', 1)->pluck('cat_id')->toArray();
        $navCat = array_merge(array_unique($navCat));
        foreach ($navCat as $k => $id) {
            $catName = DB::table('categories')->where('id', $id)->pluck('name')->toArray();
            $navInfo[$k]['catName'] = $catName[0];
            $navInfo[$k]['data'] = DB::table('navs')
                ->select('id', 'name', 'desc', 'url')
                ->where('cat_id', $id)
                ->orderByRaw('sort desc, id asc')
                ->get()
                ->toArray();
        }
        return view('home.business.index', compact('navInfo', 'flag'));
    }

    public function detail($id)
    {
//        $ip = 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $_SERVER['REMOTE_ADDR'];
//        $client = new \GuzzleHttp\Client();
//        $response = $client->post($ip);
//        $total = json_decode((string)$response->getBody(), true);
        //商品信息
        $goodsInfo = DB::table('goods')->where('goods_id', $id)->first();
        //选择的地区信息
        $areaInfo = DB::table('areas')->where('parent_id', NULL)->get()->toArray();
        foreach ($areaInfo as $k => &$v) {
            $v->name = str_replace(['特别行政区', '省', '市'], '', $v->name);
        }
        if (!$goodsInfo) {
            return redirect(route('home.business.index'))->with(['status' => '未找到对应的商品信息']);
        }
        return view('home.business.detail', compact('goodsInfo', 'areaInfo'));
    }

    /**
     * 结算页面 POST提交 包括直接购买
     */
    public function confirm(){
        //选择的地区信息
        $areaInfo = DB::table('areas')->where('parent_id', NULL)->get()->toArray();
        return view('home.business.confirm', compact('areaInfo'));
    }

    private function getChild($items)
    {
        $itemAll = array();
        foreach ($items as $k => $i) {
            if ($i->parent_id == "") {
                $i->parent_id = 0;
            }
            $itemAll[$k + 1] = json_decode(json_encode($i), true);
        }
        foreach ($itemAll as $item) {
            $itemAll[$item['parent_id']]['son'][$item['id']] = &$itemAll[$item['id']];
        }
        return isset($itemAll[0]['son']) ? $itemAll[0]['son'] : array();
    }

}
