<?php

namespace Loxodonta\CommandBusBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Loxodonta\CommandBus\Signature\CommandBusHandlerInterface;

/**
 * Class LoxodontaCommandBusExtension
 */
class LoxodontaCommandBusExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->registerForAutoconfiguration(CommandBusHandlerInterface::class)
                  ->addTag('loxodonta.command_bus.handler');

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        if (!empty($config['middlewares'])) {
            $middlewares = [];
            foreach ($config['middlewares'] as $middleware) {
                if (class_exists($middleware)) {
                    $middlewares[] = $middleware;
                }
            }
            $container->setParameter('loxodonta.command_bus.middlewares', $middlewares);
        }
    }

    public function getAlias()
    {
        return 'loxodonta_command_bus';
    }
}
