<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 14:42
 */
// 创建websocket server对象，监听0.0.0.0:9502端口
$server = new Swoole\WebSocket\Server('0.0.0.0',9502);

// 监听websocket连接打开事件
$server->on('open', function ($server, $request) {
    var_dump($request->fd, $request->server);
    $server->push($request->fd, "Hello, welcome\n");
});

//监听websocket消息事件
$server->on('message', function ($server, $frame) {
    echo "Message: {$frame->data}\n";
    $server->push($frame->fd, "server: {$frame->data}\n");
});

//监听websocket连接关闭事件
$server->on('close', function ($server, $fd) {
    echo "client-{$fd} is closed\n";
});

$server->start();
