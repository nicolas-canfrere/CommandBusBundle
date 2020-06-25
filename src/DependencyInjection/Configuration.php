<?php

namespace Loxodonta\CommandBusBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('loxodonta_command_bus');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('middlewares')->defaultValue([])
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
