<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 12:55
 */

namespace Rebuild\Server;


class ServerFactory
{
    protected $serverConfig = [];

    protected $server;

    public function configure(array $configs)
    {
        $this->serverConfig = $configs;
        $this->getServer()->init($this->serverConfig);
    }

    public function getServer():Server{
        if(!isset($this->server)) {
            $this->server = new Server();
        }
        return $this->server;
    }

}