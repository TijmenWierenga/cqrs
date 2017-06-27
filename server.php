<?php
stream_set_blocking(STDOUT, false);

use TijmenWierenga\Server\Connection;
use TijmenWierenga\Server\ReactPhpServer;

require __DIR__ . '/vendor/autoload.php';

$connection = new Connection();
$server = new ReactPhpServer($connection);
echo "Server is running on {$connection->getIpAddress()}:{$connection->getPort()}";
$server->run();
