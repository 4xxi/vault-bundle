<?php

namespace Fourxxi\Bundle\VaultBundle;

use Fourxxi\Bundle\VaultBundle\DependencyInjection\Compiler\CachedParameterCompilerPass;
use Fourxxi\Bundle\VaultBundle\DependencyInjection\Compiler\DynamicParameterCompilerPass;
use Fourxxi\Bundle\VaultBundle\ExpressionLanguage\VaultParameterExpressionLanguageProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FourxxiVaultBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addExpressionLanguageProvider(
            new VaultParameterExpressionLanguageProvider()
        );

        $container->addCompilerPass(new CachedParameterCompilerPass());
        $container->addCompilerPass(new DynamicParameterCompilerPass());

        parent::build($container);
    }
}
