<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 12:50
 */

namespace Rebuild\Server;


interface ServerInterface
{
    const SERVER_HTTP = 1;

    const SERVER_WEBSOCKET = 2;

    const SERVER_BASE = 3;

    public function init(array $config):ServerInterface;

    public function start();

    public function getServer();

}