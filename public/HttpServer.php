<?php

class HttpServer
{
    private $port = 9501;
    private $host = '0.0.0.0';
    private $http = null;

    public function __construct()
    {
        $this->http = new Swoole\Http\Server($this->host, $this->port);
        $this->http->set([
            'reactor_num' => 2,     // reactor thread num
            'worker_num' => 4,     // worker process num
            'backlog' => 128,   // listen backlog
            'max_request' => 50,
            'dispatch_mode' => 1,
        ]);
        $this->http->on("workerstart", [$this, 'onWorkerStart']);
        $this->http->on("request", [$this, 'onRequest']);
        $this->http->on("close", [$this, 'onClose']);
        $this->http->start();
    }

    /**
     * 此事件在Worker进程/Task进程启动时发生,这里创建的对象可以在进程生命周期内使用
     * 在onWorkerStart中加载框架的核心文件后
     * 1.不用每次请求都加载框架核心文件，提高性能
     * 2.可以在后续的回调中继续使用框架的核心文件或者类库
     *
     * @param $server
     * @param $worker_id
     */
    public function onWorkerStart($server, $worker_id)
    {
        // 定义应用目录


    }

    /**
     * request回调
     * 输入的变量例：$_SERVER  =  []
     * @param $request
     * @param $response
     */
    public function onRequest($request, $response)
    {
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            $response->end();
            return;
        }
        $_SERVER = [];
        $_GET = [];
        $_POST = [];
        if (isset($request->server)) {
            foreach ($request->server as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if (isset($request->header)) {
            foreach ($request->header as $k => $v) {
                $_SERVER[strtoupper($k)] = $v;
            }
        }
        if (isset($request->get)) {
            foreach ($request->get as $k => $v) {
                $_GET[$k] = $v;
            }
        }
        if (isset($request->post)) {
            foreach ($request->post as $k => $v) {
                $_POST[$k] = $v;
            }
        }
        $_POST['http_server'] = $this->http;
        $info = [
            'getInfo' => $_GET,
            'postInfo' => $_POST,
            'headerInfo' => $_SERVER
        ];
        header("Content-Type", "text/html; charset=utf-8");
        $response->end(json_encode(['error' => 0, 'msg' => 'info', 'data' => $info]));
    }

    /**
     * close
     * @param $http
     * @param $fd
     */
    public function onClose($http, $fd)
    {
        echo "clientid:{$fd}\n";
    }
}

new HttpServer();