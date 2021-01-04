<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class CreateList extends Model
{
    protected $table = 'create_list';
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany('App\Models\CreateListItem', 'create_list_id', 'id')->where('type', 3);
    }

}
