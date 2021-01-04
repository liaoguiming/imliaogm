<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{

    public function index()
    {
        return view('admin.comment.index');
    }

    public function data(Request $request)
    {

        $model = Comment::query();
        if ($request->get('is_show')) {
            $isShow = $request->get('is_show') == 1 ? 0 : 1;
            $model = $model->where('is_show', $isShow);
        }
        if ($request->get('content')) {
            $model = $model->where('content', 'like', $request->get('content') . '%');
        }
        $res = $model->orderBy('id', 'desc')->with('article')->paginate($request->get('limit', 30))->toArray();
        foreach ($res['data'] as &$v) {
            $v['is_show_zh'] = $v['is_show'] ? "显示" : "隐藏";
            $v['is_show_button'] = $v['is_show'] ? "隐藏" : "显示";
        }
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    public function changeStatus(Request $request)
    {
        $ids = $request->get('ids');
        $isShow = $request->get('is_show');
        $comment = Comment::with('article')->findOrFail($ids);
        $data['is_show'] = $isShow == 0 ? 1 : 0;
        if ($comment->update($data)) {
            return response()->json(['code' => 0, 'msg' => '修改成功']);
        }
        return response()->json(['code' => 1, 'msg' => '修改失败']);
    }

    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)) {
            return response()->json(['code' => 1, 'msg' => '请选择删除项']);
        }
        foreach (Comment::whereIn('id', $ids)->get() as $model) {
            //删除文章
            $model->delete();
        }
        return response()->json(['code' => 0, 'msg' => '删除成功']);
    }
}
