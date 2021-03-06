<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 12:50
 */
declare(strict_types=1);
namespace Rebuild\Server;

use Rebuild\HttpServer\Router\DispatcherFactory;
use Swoole\Coroutine\Server as SwooleCoServer;
use Swoole\Server as SwooleServer;
use Swoole\Http\Server as SwooelHttpServer;


class Server implements ServerInterface
{

    protected $server;

    protected $onRequestCallbacks = [];

    public function init(array $config): ServerInterface
    {
        //先只支持一个server
        foreach ($config['servers'] as $server){
            $this->server = new SwooelHttpServer($server['host'], $server['port'], $server['type'], $server['sock_type']);
            $this->registerSwooleEvents($server['callbacks']);
            break;
        }
        return $this;
    }

    public function start()
    {
        $this->getServer()->start();
    }

    public function getServer()
    {
        return $this->server;
    }

    protected function registerSwooleEvents(array $callbacks)
    {
        foreach ($callbacks as $swolleEvent => $callback) {
            list($class, $method) = $callback;

            if($class === \Rebuild\HttpServer\Server::class) {
                $instance = new $class(new DispatcherFactory());
            }else {
                $instance = new $class();
            }


            $this->server->on($swolleEvent, [$instance, $method]);
        }
    }
}