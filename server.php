<?php
stream_set_blocking(STDOUT, false);

use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server;
use React\Socket\Server as Socket;

require __DIR__ . '/vendor/autoload.php';

$app = function (Request $request, Response $response) {
    $response->writeHead(200, [
        'content-type' => 'text/html'
    ]);
    $response->write("This message indicates that the React PHP Server is running.");
    $response->end();
};

$loop = Factory::create();
$socket = new Socket($loop);
$http = new Server($socket);

$http->on('request', $app);

$socket->listen(1337, '0.0.0.0');
echo "Listening on port 1337" . PHP_EOL;
$loop->run();
