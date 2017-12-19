<?php

namespace Fourxxi\Bundle\VaultBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class DynamicParameterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $enabled = $container->getParameter('fourxxi_vault.enabled');
        $tag = sprintf('fourxxi_vault.%s.parameters_provider', true === $enabled ? 'enabled' : 'disabled');

        $taggedServices = $container->findTaggedServiceIds($tag);

        $providers = [];
        foreach ($taggedServices as $id => $tags) {
            if (!isset($tags[0]['provider_name'])) {
                throw new \LogicException("Tag parameter 'provider_name' isn't set");
            }

            $providers[$tags[0]['provider_name']] = $container->getDefinition($id);
        }

        $container->getDefinition('fourxxi_vault.parameter_getter')->addArgument($providers);
    }
}
