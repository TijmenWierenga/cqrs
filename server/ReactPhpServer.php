<?php
namespace TijmenWierenga\Server;

use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server as ReactServer;
use React\Socket\Server as ReactSocket;

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
     * ReactPhpServer constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Start a new server
     */
    public function run(): void
    {
        $app = function (Request $request, Response $response) {
            $response->writeHead(200, [
                'content-type' => 'text/html'
            ]);
            $response->write("This message indicates that the React PHP Server is running.");
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
