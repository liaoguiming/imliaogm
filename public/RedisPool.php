<?php
namespace Liao;

require 'Pool.php';

class RedisPool extends Pool
{
    function create()
    {
        $redis = new \Swoole\Coroutine\Redis();
        $res = $redis->connect($this->config['host']??'127.0.0.1', $this->config['port']??6379);
        if ($res) {
            return $redis;
        } else {
            return false;
        }
    }
}