<?php

namespace app\Tools;

use Illuminate\Support\Facades\DB;

class CreateList
{
    const SUCCESS = 0;
    const ERROR = 1;

    public static function getTables()
    {
        return DB::raw("show tables");
    }

    public static function getColumns($table)
    {
        return DB::raw("SHOW COLUMNS FROM $table");
    }

}

?>