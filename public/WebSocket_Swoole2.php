<?php
namespace Liao;

require 'RedisPool.php';

class WebSocket
{
    //创建websocket服务器对象，监听0.0.0.0:9502端口口口口111
    private $port = 9502;
    private $host = '0.0.0.0';
    private $config = ['host' => '127.0.0.1', 'port' => 6379];
    private $websocket = null;
    private $redis = null;

    public function __construct()
    {
        \Co\Run(function () {
            $this->redis = new \Liao\RedisPool($this->config, 50);
            $this->chatInit();
            $this->websocket = new \Swoole\WebSocket\Server($this->host, $this->port);
            $this->websocket->on("open", [$this, 'onOpen']);
            $this->websocket->on("message", [$this, 'onMessage']);
            $this->websocket->on("close", [$this, 'onClose']);
        });
        $this->websocket->start();
    }

    /**
     * 聊天室初始化
     */
    public function chatInit()
    {
        //服务器启动时设置在线人数为0;
        $this->redis->set('online_num', 0);
        foreach ($this->redis->hgetall('user_list') as $k) {
            $this->redis->hdel('user_list', $k);
        }
        foreach ($this->redis->hgetall('fds') as $k) {
            $this->redis->hdel('fds', $k);
        }
    }

    /**
     * 有人接入连接的时候向其他已经接入的人发出通知信息
     * @param array $res 需要通知的信息
     */
    public function openNotice($websocket, $fd, $res)
    {
        foreach ($res['fd_keys'] as $k) {
            if ($k != $fd) {
                $res['fd'] = $k;
                $websocket->push($k, json_encode($res));
            }
        }
    }

    private function getUserRecord()
    {
        $record = $this->redis->get('user_chat_record');
        return $record ? unserialize($record) : [];
    }

    private function setUserRecord($data)
    {
        $data['to'] = isset($data['to']) && !empty($data['to']) ? $data['to'] : 'group';
        $data['from_fd'] = isset($data['from_fd']) && !empty($data['from_fd']) ? $data['from_fd'] : 0;
        $data['to_fd'] = isset($data['to_fd']) && !empty($data['to_fd']) ? $data['to_fd'] : 0;
        $record = $this->getUserRecord();
        //长度超过2000条时
        if (sizeof($record) > 2000) {
            //去掉二维数组第一个数组
            array_shift($record);
        }
        //添加
        array_push($record, $data);
        $this->redis->set('user_chat_record', serialize($record));
    }

    private function getUserList()
    {
        //获取user_list键名
        $fdKeys = $this->redis->hkeys('user_list');
        //获取user_list键值
        $fdVals = $this->redis->hvals('user_list');
        //根据客户端连接先后排序
        for ($i = 0; $i < sizeof($fdVals); $i++) {
            $sortArr[$fdVals[$i]] = $fdKeys[$i];
        }
        //根据客户端连接fd升序排列
        ksort($sortArr);
        return $sortArr;
    }

    private function formatRes($fd, $param = [])
    {
        $groupLastArr = [];
        $personLastArr = [];
        $userList = $this->getUserList();
        $data = $this->getUserRecord();
        foreach ($data as $k => $v) {
            if ($v['from_fd'] == 0) {
                $groupLastArr[] = $v;
            } else {
                $personLastArr[] = $v;
            }
        }
        $groupLast = $groupLastArr ? end($groupLastArr) : "最后一条群聊信息";
        $personLast = $personLastArr ? end($personLastArr) : [];
        $res = [
            'data' => $data,
            'groupLastInfo' => mb_substr($groupLast['content'], 0, 22, 'UTF-8'),
            'personLastInfo' => !empty($personLast) ? $personLast['content'] : '',
            'online_num' => $this->redis->get('online_num'),
            'fd_keys' => array_keys($userList),
            'fd_vals' => array_values($userList),
            'fd' => $fd,
            'time' => date('H:i:s', time()),
        ];
        return $res;
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
    public function onOpen($websocket, $request)
    {
        $userName = $request->get['userName'];
        //在线人数加1
        $this->redis->incr('online_num');
        if ($userName) {
            $this->redis->hset('user_list', $userName, $request->fd);
        }
        $res = $this->formatRes($request->fd);
        //有人连接服务器之后，向其他人推送上线信息
        $this->openNotice($websocket, $request->fd, $res);
        $websocket->push($request->fd, json_encode($res));
        echo "客户端-{$request->fd} 加入聊天室！\n";
    }

    /**
     * request回调
     * 输入的变量例：$_SERVER  =  []
     * @param $request
     * @param $response
     */
    public function onMessage($websocket, $frame)
    {
        $data = json_decode($frame->data, true);
        if ($data['type'] == 'public') {
            //保存群聊天聊天记录
            $this->setUserRecord([
                'user_name' => $data['userName'],
                'content' => $data['content'],
                'time' => date('H:i:s', time()),
                'from' => $data['userName']
            ]);
        } elseif ($data['type'] == 'private') {
            //保存私聊聊天记录
            $this->setUserRecord([
                'user_name' => $data['userName'],
                'content' => $data['content'],
                'time' => date('H:i:s', time()),
                'from' => $data['userName'],
                'to' => $data['chatWith'],
                'from_fd' => $frame->fd,
                'to_fd' => $data['chatWithFd']
            ]);
        }
        //实时获取聊天记录
        $res = $this->formatRes($frame->fd);
        if ($data['type'] == 'public') {
            //如果保存了群聊天信息则给在线的每个人都发信息
            foreach ($res['fd_keys'] as $k) {
                $res['type'] = 'public';
                $res['show_fd'] = 0;
                $websocket->push($k, json_encode($res));
            }
        } else {
            $res['type'] = 'private';
            $res['show_fd'] = $data['chatWithFd'];
            //并且将自己发送的消息记录展示给自己
            $websocket->push($frame->fd, json_encode($res));
            //如果是私聊，发送聊天记录到指定客户端
            if ($data['chatWithFd'] != 0 && $data['chatWithFd'] != $frame->fd) {
                $res['show_fd'] = $frame->fd;
                $res['fd'] = $data['chatWithFd'];
                $websocket->push($data['chatWithFd'], json_encode($res));
            }
        }
    }

    /**
     * close
     * @param $http
     * @param $fd
     */
    public function onClose($websocket, $fd)
    {
        //在线人数减1
        $this->redis->decr('online_num');
        //清除用户数据
        $sortArr = $this->getUserList();
        //下线后删除该绑定用户
        $this->redis->hdel('user_list', $sortArr[$fd]);
        unset($sortArr[$fd]);
        $res = $this->formatRes($fd);
        $this->openNotice($websocket, $fd, $res);
        echo "客户端-{$fd} 退出聊天室！\n";
    }
}

new WebSocket();