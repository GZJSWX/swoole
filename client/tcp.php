<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/2
 * Time: 17:33
 */

go(function(){
    $client = new Swoole\Coroutine\Client(SWOOLE_SOCK_TCP);

    if (!$client->connect('127.0.0.1', 9501, 0.5)) {
        echo "connect failed. Error: {$client->errCode}\n";
    }

    fwrite(STDOUT, '请输入:');
    $ret = fgets(STDOUT);
    $client->send($ret);
    echo $client->recv();
    $client->close();
});
