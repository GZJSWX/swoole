<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/4
 * Time: 11:35
 */

class Task
{
    private $server = null;

    public function __construct()
    {
        $this->server = new Swoole\WebSocket\Server('0.0.0.0', 9503);

        $this->server->set([
            'task_worker_num' => 4,
        ]);

        $this->server->on('open', [$this, 'onOpen']);

        $this->server->on('message', [$this, 'onMessage']);

        $this->server->on('task', [$this, 'onTask']);

        $this->server->on('finish', [$this, 'onFinish']);

        $this->server->on('close', [$this, 'onClose']);

        $this->server->start();
    }

    public function onOpen($server, $request)
    {
        var_dump($request->fd, $request->server);
        $server->push($request->fd, "欢迎客户端：{$request->fd}\n");
    }

    public function onMessage($server,$frame)
    {
        echo "消息：{$frame->data}\n";
        foreach ($server->connections as $fd){
            if($fd == $frame->fd){
                $server->task([
                    'fd' => $fd,
                    'message' => "我：{$frame->data}",
                ]);
                $server->push($fd, "我：{$frame->data}");
            }else{
                $server->push($fd, "对方：{$frame->data}");
            }
        }
    }

    public function onTask($server, $task_id, $src_worker_id, $data)
    {
        sleep(10);
        return $data;
    }

    public function onFinish($server, $task_id, $data)
    {
        var_dump("task_id:" . $task_id);
        var_dump($data);
    }

    public function onClose($server, $fd)
    {
        echo "客户端：{$fd} 关闭\n";
    }

}

new Task();
