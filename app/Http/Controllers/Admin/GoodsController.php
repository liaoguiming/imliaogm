<?php

namespace App\Http\Controllers\Admin;

use App\Models\Goods;
use App\Models\GoodsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goodsCategorys = GoodsCategory::with('allChilds')->where('parent_id', 0)->orderBy('sort', 'desc')->get();
        return view('admin.goods.index', compact('goodsCategorys'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request)
    {
        $model = Goods::query();
        if ($request->get('cat_id')) {
            $model = $model->where('cat_id', $request->get('cat_id'));
        }
        if ($request->get('goods_name')) {
            $model = $model->where('goods_name', 'like', $request->get('goods_name') . '%');
        }
        $res = $model->orderBy('goods_id', 'desc')->with(['cat'])->paginate($request->get('limit', 30))->toArray();
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
        $goodsCategorys = GoodsCategory::with('allChilds')->where('parent_id', 0)->orderBy('sort', 'desc')->get();
        return view('admin.goods.create', compact('goodsCategorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['cat_id', 'goods_name', 'goods_desc', 'goods_pic', 'goods_price', 'goods_site_price', 'goods_content', 'is_show', 'is_hot']);
        Goods::create($data);
        return redirect(route('admin.goods'))->with(['status' => '添加成功']);
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
        $goodsCategorys = GoodsCategory::with('allChilds')->where('parent_id', 0)->orderBy('sort', 'desc')->get();
        $goodsInfo = DB::table('goods')->where('goods_id', $id)->first();
        if (!$goodsInfo) {
            return redirect(route('admin.goods'))->withErrors(['status' => '商品不存在']);
        }
        return view('admin.goods.edit', compact('goodsInfo', 'goodsCategorys'));
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
        //$update = Goods::with('cat')->findOrFail($id);
        $data = $request->only(['cat_id', 'goods_name', 'goods_desc', 'goods_pic', 'goods_price', 'goods_site_price', 'goods_content', 'is_show', 'is_hot']);
        if (DB::table('goods')->where('goods_id', $id)->update($data)) {
            return redirect(route('admin.goods'))->with(['status' => '更新成功']);
        }
        return redirect(route('admin.goods'))->withErrors(['status' => '系统错误']);
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
        foreach (Goods::whereIn('id', $ids)->get() as $model) {
            //删除数据
            $model->delete();
        }
        return response()->json(['code' => 0, 'msg' => '删除成功']);
    }

}
