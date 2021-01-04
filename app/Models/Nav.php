<?php

namespace App\models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    //
    protected $table = 'navs';
    protected $guarded = ['id'];

    //所属文章名称
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'cat_id', 'id')->select(['id', 'name']);
    }

    public static function navAllowCat()
    {
        $sql = DB::table("categories")->select('id')->where([['sort', '=', '1'], ['parent_id', '=', '0']]);
        $navCategorys = DB::table('categories')
            ->select('id', 'name')
            ->where('parent_id', DB::raw("({$sql->sql()})"))
            ->orderBy('categories.id', 'asc')
            ->get();
        return $navCategorys;
    }
}
