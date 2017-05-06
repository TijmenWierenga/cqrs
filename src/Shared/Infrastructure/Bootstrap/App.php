<?php
namespace TijmenWierenga\Project\Shared\Infrastructure\Bootstrap;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class App 
{
    /**
     * List of environments
     */
    const ENVIRONMENT_PRODUCTION = 'prod';
    const ENVIRONMENT_DEVELOPMENT = 'dev';
    const ENVIRONMENT_TESTING = 'test';

    const ENVIRONMENTS = [
        self::ENVIRONMENT_PRODUCTION,
        self::ENVIRONMENT_DEVELOPMENT,
        self::ENVIRONMENT_TESTING
    ];

    /**
     * @var string  The current environment
     */
    private static $environment;

    /**
     * @var ContainerInterface
     */
    private static $container;

    public function run(string $environment = 'prod'): void
    {
        $this->setEnvironment($environment);

        self::$container = new ContainerBuilder();
        $this->setParameters();
        $this->setServices();

        self::$container->compile();
    }

    public static function container(): ContainerInterface
    {
        return self::$container;
    }

    /**
     * @return string
     */
    public static function environment(): string
    {
        return self::$environment;
    }

    private function setEnvironment(string $environment): void
    {
        if (! in_array($environment, self::ENVIRONMENTS)) {
            throw EnvironmentException::invalidEnvironment($environment);
        }

        self::$environment = $environment;
    }

    private function setServices(): void
    {
        $loader = new YamlFileLoader(
            self::container(), new FileLocator(realpath(__DIR__ . '/../../../../config'))
        );
        $loader->load('services.yml');
    }

    private function setParameters(): void
    {
        $loader = new PhpFileLoader(
            self::container(), new FileLocator(realpath(__DIR__ . '/../../../../config'))
        );
        $loader->load('parameters.php');
    }
}
