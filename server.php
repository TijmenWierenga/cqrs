<?php
stream_set_blocking(STDOUT, false);

use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\ContainerAwareRequestHandler;
use TijmenWierenga\Server\Connection;
use TijmenWierenga\Server\ReactPhpServer;

require __DIR__ . '/vendor/autoload.php';

$app = new App();
$app->run(getenv('APP_ENV'));

$connection = new Connection();
$requestHandler = new ContainerAwareRequestHandler(App::container());

$server = new ReactPhpServer($connection, $requestHandler);

echo "Server is running on {$connection->getIpAddress()}:{$connection->getPort()} with environment: "
    . App::environment() . PHP_EOL;

$server->run();
