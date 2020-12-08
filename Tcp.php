<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/2
 * Time: 11:14
 */

class Tcp
{
    private $server = null;

    public function __construct()
    {
        $this->server = new Swoole\Server("127.0.0.1", 9501);

        $this->server->set([
            'worker_num'    => 4,
            'max_request'   => 50,
        ]);

        $this->server->on("Connect", [$this, "onConnect"]);
        $this->server->on("Receive", [$this, "onReceive"]);
        $this->server->on("Close", [$this, "onClose"]);
        $this->server->start();
    }

    public function onConnect($server, $fd)
    {
        echo "客户端id: {$fd}连接.\n";
    }

    public function onReceive($server, $fd, $from_id, $data)
    {
        $server->send($fd, "接收到的数据：" . $data);
    }

    public function onClose($server, $fd)
    {
        echo "客户端id：{$fd}关闭连接.\n";
    }


}
new Tcp();
