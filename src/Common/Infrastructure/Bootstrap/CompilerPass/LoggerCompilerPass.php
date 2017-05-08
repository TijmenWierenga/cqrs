<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Bootstrap\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class LoggerCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->has('common.logger')) {
            return;
        }

        $logger = $container->getDefinition('common.logger');

        $handlers = $container->findTaggedServiceIds('logger_handler');

        foreach ($handlers as $id => $tags) {
            $logger->addMethodCall('pushHandler', [new Reference($id)]);
        }
    }
}
