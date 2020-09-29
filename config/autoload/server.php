<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 13:10
 */

use Rebuild\Server\Server;

return [
    'mode' => SWOOLE_PROCESS,
    'servers' => [
        [
            'name' => 'http',
            'type' => 1,
            'host' => '0.0.0.0',
            'port' => 9501,
            'sock_type' => SWOOLE_SOCK_TCP,
            'callbacks' => [
                'request' => [\Rebuild\HttpServer\Server::class, 'onRequest'],
            ],
        ],
    ],
    'settings' => [
        'enable_coroutine' => true,
        'worker_num' => 1,
    ],
    'callbacks' => [
        'worker_start' => [Hyperf\Framework\Bootstrap\WorkerStartCallback::class, 'onWorkerStart'],
    ],
];