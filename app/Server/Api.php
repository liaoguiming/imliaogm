<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/7/11 0011
 * Time: 12:19
 */

namespace App\Server;


class Api
{

    protected $controller;

    protected $action;

    protected $request;

    protected $response;

    function __construct($controller, $action, $request, $response)
    {
        $this->controller = ucfirst($controller);
        $this->action = ucfirst($action);
        $this->request = $request;
        $this->response = $response;
    }

    public function run()
    {
        header("Content-Type", "text/html; charset=utf-8");
        $this->response->end(json_encode(['error' => 0, 'msg' => $this->action, 'data' => date('Y-m-d H:i:s', time())]));
    }

}