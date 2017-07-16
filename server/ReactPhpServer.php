<?php
namespace TijmenWierenga\Server;

use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\Http\Response;
use React\Http\Server as HttpServer;
use React\Promise\Promise;
use React\Socket\Server as SocketServer;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\RequestHandler;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamDataFactory;

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
            return new Promise(function ($resolve, $reject) use ($request) {
                $request->getBody()->on('data', function ($data) use (&$stream) {
                    $stream = $data;
                });

                $request->getBody()->on('end', function () use ($resolve, $request, &$stream) {
                    $streamData = StreamDataFactory::decode($request, $stream);
                    $response = $this->requestHandler->handle($request, $streamData);
                    $resolve($response);
                });

                $request->getBody()->on('error', function (\Exception $exception) use ($resolve) {
                    $response = new Response(
                        400,
                        [
                            'Content-Type' => 'application/json'
                        ],
                        json_encode($exception->getMessage())
                    );
                    $resolve($response);
                });
            });
        });

        $socket = new SocketServer((string) $this->connection, $loop);
        $server->listen($socket);

        $loop->run();
    }
}
