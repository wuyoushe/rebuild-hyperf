<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 12:49
 */

namespace Rebuild\HttpServer;


class Server
{
    public function onRequest($request, $response)
    {
        // onRequest 方法里面我们吧刚才响应的代码补进来
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }

}