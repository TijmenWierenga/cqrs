<?php
stream_set_blocking(STDOUT, false);

use Nathanmac\Utilities\Parser\Parser;
use TijmenWierenga\Project\Common\Domain\Model\File\File;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\ContainerAwareRequestHandler;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\SimpleRouter;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\YamlRouteRegistry;
use TijmenWierenga\Server\AsyncServer;
use TijmenWierenga\Server\Connection;
use TijmenWierenga\Server\DefaultParser;

require __DIR__ . '/vendor/autoload.php';

$app = new App();
$app->run(getenv('APP_ENV'));

$routeRegistry = new YamlRouteRegistry([
    new File(realpath(__DIR__ . '/config/routes.yml'))
]);
$router = new SimpleRouter($routeRegistry);

$connection = Connection::init();
$requestHandler = new ContainerAwareRequestHandler(App::container(), $router);
$parser = new DefaultParser(new Parser());

$server = new AsyncServer($connection, $requestHandler, $parser);

echo "Server is running on {$connection} with environment: "
    . App::environment() . PHP_EOL;

$server->run();
