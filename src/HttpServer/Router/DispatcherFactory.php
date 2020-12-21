<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/12/21
 * Time: 13:42
 */

namespace Rebuild\HttpServer\Router;


use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class DispatcherFactory
{
    /**
     * @var string[]
     */
    protected $routeFiles = [BASE_PATH. '/config/routes.php'];

    /**
     * @var Dispatcher[]
     */
    protected $dispatchers = [];

    /**
     * @var array
     */
    protected $routes = [];

    public function __construct()
    {
        $this->initConfigRoute();
    }

    public function getDispatcher(string $serverName): Dispatcher
    {
        if (!isset($this->dispatchers[$serverName])) {
            $this->dispatchers[$serverName] = simpleDispatcher(function(RouteCollector $r){
                foreach ($this->routes as $route) {
                    [$httpMethod, $path, $handler] = $route;
                    $r->addRoute($httpMethod, $path, $handler);
                }
            });
        }
        return $this->dispatchers[$serverName];
    }

    public function initConfigRoute()
    {
        foreach ($this->routeFiles as $file) {
            if (file_exists($file)) {
                $routes = require_once $file;
                $this->routes = array_merge_recursive($this->routes, $routes);
            }
        }
    }

}