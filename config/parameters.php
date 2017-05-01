<?php
use Symfony\Component\DependencyInjection\Reference;

$container->setParameter('redis_config', [
    'scheme' => getenv('REDIS_SCHEME'),
    'host' => getenv('REDIS_HOST'),
    'port' => getenv('REDIS_PORT'),
    'database' => getenv('REDIS_DB')
]);
