<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';
    protected $guarded = ['goods_id'];

    //所属文章名称
    public function cat()
    {
        return $this->belongsTo('App\Models\GoodsCategory', 'cat_id', 'cat_id')->select(['cat_id', 'cat_name']);
    }
}
