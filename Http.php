<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/4
 * Time: 11:07
 */

class Http
{
    private $server = null;

    public function __construct()
    {
        $this->server = new Swoole\Http\Server('0.0.0.0', 9501);

        $this->server->on('request', [$this, 'onRequest']);
        $this->server->start();
    }

    public function onRequest($request, $response)
    {
        if ($request->server['path_info'] == '/favicon.ico' || $request->server['request_uri'] == '/favicon.ico') {
            $response->end();
            return;
        }
        var_dump($request->get,$request->post);
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end("<h1>Hello Swoole. #".json_encode($request->get)."</h1>");
    }

}
new Http();
