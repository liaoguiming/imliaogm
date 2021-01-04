<?php

namespace App\Http\Controllers\Home;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NavController extends Controller
{

    public function index()
    {
        $navInfo = [];
        $flag = "nav";
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
        return view('home.nav.index', compact('navInfo', 'flag'));
    }

}
