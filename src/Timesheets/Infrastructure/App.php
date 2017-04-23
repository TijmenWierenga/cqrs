<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class App 
{
    /**
     * @var ContainerInterface
     */
    private static $container;

    public function run(): void
    {
        self::$container = new ContainerBuilder();
        self::$container->compile();
    }

    public static function getContainer(): ContainerInterface
    {
        return self::$container;
    }
}
