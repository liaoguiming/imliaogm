<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Comment;

class IndexController extends Controller
{

    const LIMIT = 30;

    public function index($page = 1)
    {
        $flag = "index";
        $page = !empty((int)$page) ? (int)$page : 1;
        $limit = self::LIMIT;
        $start = $page == 1 ? 0 : ($page - 1) * $limit;
        //$sql = "SELECT count(*) FROM article_comment WHERE is_show = 1 AND article_id = articles.id";
        $sql = DB::table("article_comment")->select(DB::raw('count(*)'))->where([['is_show', '=', '1'], ['article_id', '=', 'articles.id']]);
        $articles = DB::table('articles')
            ->select('id', 'title', 'description', 'created_at', DB::raw("({$sql->sql()}) as commentCount"))
            ->offset($start)
            ->limit($limit)
            ->orderBy('articles.id', 'desc')
            ->get();
        $numRes = DB::table('articles')->count();
        $maxPage = $numRes % $limit == 0 ? $numRes / $limit : intval($numRes / $limit) + 1;
        $prev = $page == 1 ? 1 : $page - 1;
        $next = $page == $maxPage ? $maxPage : $page + 1;
        return view('home.index.index', compact('articles', 'prev', 'next', 'page', 'flag'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bbs()
    {
        $flag = "bbs";
        return view('home.index.bbs', compact('flag'));
    }

    public function testVue()
    {
        return view('home.index.testVue');
    }

    public function about()
    {
        $flag = "about";
        return view('home.index.about', compact('flag'));
    }

    public function addComment(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|string',
        ]);
        $randName = ['James', 'Messi', 'Henry', 'YaoMing', 'Wade'];
        $request->merge(['nick_name' => $randName[array_rand($randName)]]);
        if (Comment::create($request->all())) {
            return redirect(route('home.index.detail', array('id' => $request['article_id'])))->with(['status' => '评论成功']);
        }
        return redirect(route('home.index.detail'))->with(['status' => '系统错误']);
    }

    public function detail($id)
    {
        $id = (int)$id;
        if (!$id) {
            redirect('/index');
        }
        $article = DB::table('articles')
            ->join('categories', 'articles.category_id', '=', 'categories.id')
            ->where('articles.id', $id)
            ->first();
        if (!$article) {
            return redirect('/index');
            //return redirect(route('home.index.index'))->withErrors(['status' => '文章不存在']);
        }
        //文章评论
        $articleComment = DB::table('article_comment')
            ->where(['article_id' => $id, 'is_show' => 1])
            ->orderBy('id', 'desc')
            ->get();
        //文章点击次数更新
        DB::table('articles')->where('id', $id)->increment('click');
        //DB::table('articles')->select('id')->where('id', '>', $id)->limit(1)->first();
        //DB::table('articles')->select('id')->where('id', '>', $id)->limit(1)->pluck('id');一列的值
        $nextPage = DB::table('articles')->select('id')->where('id', '>', $id)->limit(1)->value('id');
        $maxPage = DB::table('articles')->max("id");
        $nextPage = !empty($nextPage) ? $nextPage : $id;
        $prev = $id > 1 ? $id - 1 : 0;
        $next = $id < $nextPage ? $id + 1 : $nextPage;
        $rand = rand(1, $maxPage);
        $commentCount = sizeof($articleComment);
        return view('home.index.detail', compact('article', 'prev', 'next', 'nextPage', 'id', 'rand', 'articleComment', 'commentCount'));
    }
}
