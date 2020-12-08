<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/11/19
 * Time: 14:31
 */
$server = new Swoole\Http\Server('0.0.0.0', 9501);

$server->on('request', function ($request, $response) {
    if ($request->server['path_info'] == '/favicon.ico'
        || $request->server['request_uri'] == '/favicon.ico') {
        $response->end();
        return;
    }
    var_dump($request->server);
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end("<h1>Hello Swoole.#" . rand(1000,9999) . "</h1>");
});

$server->start();
