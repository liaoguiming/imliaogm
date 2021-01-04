<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NavController extends Controller
{

    public function index()
    {
        return view('admin.nav.index');
    }

    public function data(Request $request)
    {

        $model = Nav::query();
        if ($request->get('desc')) {
            $model = $model->where('desc', 'like', $request->get('desc') . '%');
        }
        $res = $model->orderBy('id', 'desc')->with('category')->paginate($request->get('limit', 30))->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $navCategorys = Nav::navAllowCat();
        return view('admin.nav.create', compact('navCategorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'desc' => 'required|string',
            'url' => 'required|string',
            'sort' => 'required|numeric',
            'cat_id' => 'required|numeric'
        ]);
        $data = $request->only(['cat_id', 'name', 'desc', 'sort', 'url', 'icon']);
        $data['is_show'] = 1;
        if (Nav::create($data)) {
            return redirect(route('admin.nav'))->with(['status' => '添加完成']);
        }
        return redirect(route('admin.nav'))->with(['status' => '系统错误']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nav = Nav::findOrFail($id);
        if (!$nav) {
            return redirect(route('admin.nav'))->withErrors(['status' => '导航不存在']);
        }
        //分类
        $navCategorys = Nav::navAllowCat();
        return view('admin.nav.edit', compact('nav', 'navCategorys'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'desc' => 'required|string',
            'url' => 'required|string',
            'sort' => 'required|numeric',
            'cat_id' => 'required|numeric'
        ]);
        $article = Nav::with('category')->findOrFail($id);
        $data = $request->only(['cat_id', 'name', 'desc', 'sort', 'url', 'icon']);
        if ($article->update($data)) {
            return redirect(route('admin.nav'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.nav'))->withErrors(['status' => '系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return response()->json(['code' => 1, 'msg' => '请选择删除项']);
        }
        foreach (Nav::whereIn('id', $ids)->get() as $model) {
            //删除文章
            $model->delete();
        }
        return response()->json(['code' => 0, 'msg' => '删除成功']);
    }

}
