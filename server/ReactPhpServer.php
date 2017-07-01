<?php
namespace TijmenWierenga\Server;

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server as HttpServer;
use React\Socket\Server as SocketServer;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\RequestHandler;

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
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * ReactPhpServer constructor.
     * @param Connection $connection
     * @param RequestHandler $requestHandler
     */
    public function __construct(Connection $connection, RequestHandler $requestHandler)
    {
        $this->connection = $connection;
        $this->requestHandler = $requestHandler;
    }

    /**
     * Start a new server
     */
    public function run(): void
    {
        $loop = Factory::create();

        $server = new HttpServer(function (ServerRequestInterface $request) {
            return $this->requestHandler->handle($request);
        });

        $socket = new SocketServer((string) $this->connection, $loop);
        $server->listen($socket);

        echo "Server is running on {$this->connection} in environment: " . App::environment();

        $loop->run();
    }
}
