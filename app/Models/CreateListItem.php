<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class CreateListItem extends Model
{
    protected $table = 'create_list_item';
    protected $guarded = ['id'];

    //列表配置下所有的字段
    public function listItems()
    {
        return $this->belongsTo('App\Models\CreateList');
    }
}
