<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Bootstrap\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ProjectorCompilerPass implements CompilerPassInterface
{
    const SERVICE_NAME = 'common.projector';
    const TAG_NAME = 'projection';

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        if (! $container->has(self::SERVICE_NAME)) {
            return;
        }

        $definition = $container->findDefinition(self::SERVICE_NAME);

        $taggedServices = $container->findTaggedServiceIds(self::TAG_NAME);
        $listeners = [];

        foreach ($taggedServices as $id => $tags) {
            $listeners[] = new Reference($id);
        }

        $definition->addMethodCall('register', [$listeners]);
    }
}
