<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Bootstrap;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventPublisher;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\CompilerPass\LoggerCompilerPass;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\CompilerPass\ProjectorCompilerPass;

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

    /**
     * @param string $environment
     */
    public function run(string $environment = 'prod'): void
    {
        $this->setEnvironment($environment);

        self::$container = new ContainerBuilder();
        $this->setParameters();
        $this->setServices();
        $this->registerCompilerPasses();

        self::$container->compile();
        $this->boot();
    }

    /**
     * @return ContainerInterface
     */
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

    /**
     * @param string $environment
     */
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

    private function registerCompilerPasses(): void
    {
        /** @var ContainerBuilder $container */
        $container = self::container();
        $container->addCompilerPass(new ProjectorCompilerPass());
        $container->addCompilerPass(new LoggerCompilerPass());
    }

    private function boot(): void
    {
        $this->registerDomainEventSubscribers();
    }

    private function registerDomainEventSubscribers(): void
    {
        $container = self::container();
        DomainEventPublisher::instance()->subscribe($container->get('common.event.logger'));
    }
}
