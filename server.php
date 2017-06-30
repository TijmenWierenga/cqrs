<?php
stream_set_blocking(STDOUT, false);

use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Server\Connection;
use TijmenWierenga\Server\ReactPhpServer;

require __DIR__ . '/vendor/autoload.php';

$router = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->get('/info', 'info_handler');
});

$app = new App();
$app->run(App::ENVIRONMENT_DEVELOPMENT);

$connection = new Connection();
$server = new ReactPhpServer($connection, $router);
echo "Server is running on {$connection->getIpAddress()}:{$connection->getPort()}" . PHP_EOL;
$server->run();
