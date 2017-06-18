#!/usr/bin/php

<?php
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Console\Application;

require_once __DIR__ . '/vendor/autoload.php';
$app = new App();
$app->run(getenv('APP_ENV') ?: App::ENVIRONMENT_PRODUCTION);
$container = $app::container();

$application = new Application();

$application->add($container->get('common.console.register_user'));

$application->run();