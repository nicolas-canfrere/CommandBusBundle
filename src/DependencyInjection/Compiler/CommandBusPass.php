<?php

namespace Loxodonta\CommandBusBundle\DependencyInjection\Compiler;

use Loxodonta\CommandBus\CommandBus;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommandBusPass
 */
class CommandBusPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has(CommandBus::class)) {
            return;
        }

        $definition = $container->findDefinition(CommandBus::class);

        $taggedServices = $container->findTaggedServiceIds('loxodonta.command_bus.handler');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('registerHandler', [new Reference($id)]);
        }

        if ($container->hasParameter('loxodonta.command_bus.middlewares')) {
            $middlewareIds = $container->getParameter('loxodonta.command_bus.middlewares');
            $container->getParameterBag()->remove('loxodonta.command_bus.middlewares');
            foreach ($middlewareIds as $id) {
                if ($container->has($id)) {
                    $definition->addMethodCall('registerMiddleware', [new Reference($id)]);
                }
            }
        }
    }
}
