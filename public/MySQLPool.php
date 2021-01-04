<?php
namespace Liao;

require 'Pool.php';

class MySQLPool extends Pool
{
    function create()
    {
        $db = new \Swoole\Coroutine\MySQL();
        $res = $db->connect($this->config);
        if ($res) {
            return $db;
        } else {
            return false;
        }
    }

}