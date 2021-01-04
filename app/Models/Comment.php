<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'article_comment';
    protected $guarded = ['id'];

    //所属文章名称
    public function article()
    {
        return $this->belongsTo('App\Models\Article')->select(['id', 'title']);
    }
}
