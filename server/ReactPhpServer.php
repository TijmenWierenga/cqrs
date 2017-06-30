<?php
namespace TijmenWierenga\Server;

use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server as ReactServer;
use React\Socket\Server as ReactSocket;
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
        $app = function (Request $request, Response $response) {
            // TODO: Add transformer from Request to ServerRequestInterface
            $this->requestHandler->handle($request);
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
