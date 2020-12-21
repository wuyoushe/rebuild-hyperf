<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/29
 * Time: 12:49
 */

namespace Rebuild\HttpServer;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use Hyperf\Utils\Context;
use Hyperf\Utils\Str;
use Psr\Http\Message\ServerRequestInterface;
use Rebuild\HttpServer\Router\DispatcherFactory;
use Rebuild\HttpServer\Router\DispatherFactory;
use Swoole\Http\Request as SwooleRequest;
use Swoole\Http\Response as SwooleResponse;
use Hyperf\HttpMessage\Server\Response as Psr7Response;
use Hyperf\HttpMessage\Server\Request as Psr7Request;

class Server
{
    /**
     * @var \Rebuild\HttpServer\Router\DispatcherFactory
     */
    protected $dispatcherFactory;

    protected $dispatcher;

//    public function __construct(string $serverName, DispatcherFactory $dispatcherFactory)
//    {
//        $this->dispatcherFactory = $dispatcherFactory;
//        $this->dispatcher = $this->dispatcherFactory->getDispatcher($serverName);
//    }

    public function __construct(DispatcherFactory $dispatcherFactory)
    {
//        $this->dispatcherFactory = $dispatcherFactory;
        $this->dispatcher = $this->dispatcherFactory->getDispatcher('http');
        $this->coreMiddleware = new CoreMiddleware($dispatcherFactory);
    }

    public function onRequest(SwooleRequest $request, SwooleResponse $response): void
    {
//        onRequest 方法里面我们吧刚才响应的代码补进来
//        $response->header("Content-Type", "text/html; charset=utf-8");
//        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        /** @var \Psr\Http\Message\RequestInterface $psr7Request*/
        /** @var \Psr\Http\Message\ResponseInterface $psr7Reponse */
        [$psr7Request, $psr7Reponse] = $this->initRequestAndResponse($request, $response);

        $httpMethod = $psr7Request->getMethod();
        $uri = $psr7Request->getUri()->getPath();

        //执行中间件
        $psr7Request = $this->coreMiddleware->dispatch($psr7Request);


        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                $response->status(404);
                $response->end('Not Found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                $response->status(405);
                $response->header('Method-Allows', implode(',', $allowedMethods));
                $response->end();
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];
                [$controller, $action] = $handler;
                $instance = new $controller();
                $result = $instance->$action(...$vars);
                $response->end($result);
                break;
        }
    }

    protected function initRequestAndResponse(SwooleRequest $request, SwooleResponse $response): array
    {
        // Initialize PSR-7 Request and Response objects.
        Context::set(ResponseInterface::class, $psr7Response = new Psr7Response());
        Context::set(ServerRequestInterface::class, $psr7Request = Psr7Request::loadFromSwooleRequest($request));
        return [$psr7Request, $psr7Response];
    }

}