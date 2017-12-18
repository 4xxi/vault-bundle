<?php

namespace Fourxxi\Bundle\VaultBundle;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vault');

        $rootNode
            ->children()
                ->booleanNode('enabled')
                    ->beforeNormalization()
                        ->ifString()
                            ->then(function ($v) {
                                return in_array($v, ['1', 'true', 'on']);
                            })
                        ->end()
                    ->defaultFalse()
                ->end()
                ->scalarNode('token')->defaultNull()->end()
                ->arrayNode('connection')
                    ->children()
                        ->scalarNode('schema')->defaultValue('https')->end()
                        ->scalarNode('host')->defaultNull()->end()
                        ->scalarNode('port')->defaultValue(8200)->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
