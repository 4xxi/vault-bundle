<?php

namespace Fourxxi\Bundle\VaultBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CachedParameterCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->getParameter('fourxxi_vault.enabled') === false) {
            return;
        }

        $taggedServices = $container->findTaggedServiceIds('fourxxi_vault.cached_parameters');
        foreach ($taggedServices as $id => $info) {
            $container->getParameterBag()->add($container->get($id)->all());
        }
    }
}
