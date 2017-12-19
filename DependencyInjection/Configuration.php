<?php

namespace Fourxxi\Bundle\VaultBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('fourxxi_vault');

        $rootNode
            ->children()
                ->booleanNode('enabled')
                    ->beforeNormalization()
                        ->ifString()
                            ->then(function ($v) {
                                return in_array($v, ['1', 'true', 'on']);
                            })
                        ->end()
                    ->isRequired()
                ->end()
                ->arrayNode('auth')
                    ->children()
                        ->scalarNode('token')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('connection')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('schema')->defaultValue('https')->end()
                        ->scalarNode('host')->defaultNull()->end()
                        ->scalarNode('port')->defaultValue(8200)->end()
                        ->scalarNode('api_version')->defaultValue('v1')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
