<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class GoodsCategory extends Model
{
    //
    protected $table = 'goods_categories';
    protected $fillable = ['cat_id', 'cat_name','sort','parent_id'];

    //子分类
    public function childs()
    {
        return $this->hasMany('App\Models\GoodsCategory','parent_id','cat_id');
    }

    //所有子类
    public function allChilds()
    {
        return $this->childs()->with('allChilds');
    }
}
