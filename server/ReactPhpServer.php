<?php
namespace TijmenWierenga\Server;

use FastRoute\Dispatcher as Router;
use FastRoute\Dispatcher;
use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server as ReactServer;
use React\Socket\Server as ReactSocket;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ReactPhpServer implements Server
{
    /**
     * @var Connection
     */
    private $connection;
    /**
     * @var Router
     */
    private $router;

    /**
     * ReactPhpServer constructor.
     * @param Connection $connection
     * @param Router $router
     */
    public function __construct(Connection $connection, Router $router)
    {
        $this->connection = $connection;
        $this->router = $router;
    }

    /**
     * Start a new server
     */
    public function run(): void
    {
        $app = function (Request $request, Response $response) {
            $routeInfo = $this->router->dispatch($request->getMethod(), $request->getPath());
            switch ($routeInfo[0]) {
                case Dispatcher::NOT_FOUND:
                    $statusCode = 404;
                    $response->writeHead(404, [
                        'content-type' => 'text/html'
                    ]);
                    $response->write("Not found, vriend");
                    break;
                case Dispatcher::METHOD_NOT_ALLOWED:
                    $allowedMethods = $routeInfo[1];
                    $statusCode = 405;
                    $response->writeHead(405, [
                        'content-type' => 'text/html'
                    ]);
                    $response->write("Method not allowed, vriend");
                    break;
                case Dispatcher::FOUND:
                    $handler = $routeInfo[1];
                    $vars = $routeInfo[2];
                    $response->writeHead(200, [
                        'content-type' => 'text/html'
                    ]);
                    $response->write("App is running in " . App::environment());
                    break;
            };

            $response->end();
        };

        $loop = Factory::create();
        $socket = new ReactSocket($loop);
        $http = new ReactServer($socket);

        $http->on('request', $app);

        $socket->listen($this->connection->getPort(), $this->connection->getIpAddress());
        $loop->run();
    }
}
