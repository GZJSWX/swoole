<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 12:08
 */
$server = new Swoole\Server('127.0.0.1', 9502, SWOOLE_PROCESS, SWOOLE_SOCK_UDP);

//监听数据接收事件
$server->on('Packet', function ($server, $data, $clientInfo) {
    var_dump($clientInfo);
    var_dump($data);
    $server->sendto($clientInfo['address'], $clientInfo['port'], 'Server:' . $data);
});

//启动服务
$server->start();
