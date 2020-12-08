<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/2
 * Time: 17:58
 */

class Udp
{
    private $server = null;

    public function __construct()
    {
        $this->server = new Swoole\Server("127.0.0.1", 9502,  SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

        $this->server->set([
            'worker_num'    => 4,
            'max_request'   => 50,
        ]);

        $this->server->on("Packet", [$this, "onPacket"]);
        $this->server->start();
    }

    public function onPacket($server, $data, $clientInfo)
    {
        var_dump($clientInfo);
        $server->sendto($clientInfo['address'], $clientInfo['port'], 'Server：' . $data);
    }

}
new Udp();
