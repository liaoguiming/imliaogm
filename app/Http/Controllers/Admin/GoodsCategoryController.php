<?php

namespace App\Http\Controllers\Admin;

use App\Models\GoodsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.goodsCategory.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $res = GoodsCategory::where('parent_id', $request->get('parent_id', 0))->orderBy('sort', 'desc')->paginate($request->get('limit', 30))->toArray();
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
        $goodsCategorys = $this->tree(GoodsCategory::get()->toArray(), 'cat_id');
        return view('admin.goodsCategory.create', compact('goodsCategorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['parent_id', 'cat_name', 'sort']);
        GoodsCategory::create($data);
        return redirect(route('admin.goodsCategory'))->with(['status' => '添加成功']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $goodsCategorys = $this->tree(GoodsCategory::get()->toArray(), 'cat_id');
        $goodsCategory = DB::table('goods_categories')->where('cat_id', $id)->first();
        if (!$goodsCategory) {
            return redirect(route('admin.goodsCategory'))->withErrors(['status' => '不存在']);
        }
        return view('admin.goodsCategory.edit', compact('goodsCategory', 'goodsCategorys'));
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
        //$update = DB::table('goods_categories')->where('cat_id', $id)->first();
        $data = $request->only(['parent_id', 'cat_name', 'sort']);
        if (DB::table('goods_categories')->where('cat_id', $id)->update($data)) {
            return redirect(route('admin.goodsCategory'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.goodsCategory'))->withErrors(['status' => '系统错误']);
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
        foreach (GoodsCategory::whereIn('id', $ids)->get() as $model) {
            //删除数据
            $model->delete();
        }
        return response()->json(['code' => 0, 'msg' => '删除成功']);
    }

}
