<?php

use React\EventLoop\Factory;
use React\Http\Request;
use React\Http\Response;
use React\Http\Server;
use React\Socket\Server as Socket;

require __DIR__ . '/vendor/autoload.php';

$app = function (Request $request, Response $response) {
    dump($request);
    $response->writeHead(200, [
        'content-type' => 'plain/text'
    ]);
    $response->end("Handled request");
};

$loop = Factory::create();
$socket = new Socket($loop);
$http = new Server($socket);

$http->on('request', $app);

$socket->listen(1337);
$loop->run();
