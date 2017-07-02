<?php
stream_set_blocking(STDOUT, false);

use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\ContainerAwareRequestHandler;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\YamlRouteRegistry;
use TijmenWierenga\Server\Connection;
use TijmenWierenga\Server\ReactPhpServer;
use TijmenWierenga\Project\Common\Domain\Model\File\File;

require __DIR__ . '/vendor/autoload.php';

$app = new App();
$app->run(getenv('APP_ENV'));

$routeRegistry = new YamlRouteRegistry([
    new File(realpath(__DIR__ . '/config/routes.yml'))
]);
$router = new \TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\SimpleRouter($routeRegistry);

$connection = new Connection();
$requestHandler = new ContainerAwareRequestHandler(App::container(), $router);

$server = new ReactPhpServer($connection, $requestHandler);

echo "Server is running on {$connection->getIpAddress()}:{$connection->getPort()} with environment: "
    . App::environment() . PHP_EOL;

$server->run();
