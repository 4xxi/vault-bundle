<?php

namespace Fourxxi\Bundle\VaultBundle\DependencyInjection;

use Fourxxi\Bundle\VaultBundle\Auth\TokenAuth;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class FourxxiVaultExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setDefinition('fourxxi_vault.auth', $this->getAuthDefinition($config));
        $container->getDefinition('fourxxi_vault.client.base_uri_configurator')->addArgument($config);

        $container->setParameter('fourxxi_vault.enabled', $config['enabled']);
    }

    /**
     * @param array $config
     *
     * @return Definition
     */
    protected function getAuthDefinition(array $config)
    {
        if ($config['enabled'] === false) {
            return new Definition(TokenAuth::class, ['']);
        }

        if (empty($config['auth'])) {
            throw new \LogicException('You should set authentication method');
        }

        if (count($config['auth']) > 1) {
            throw new \LogicException('Only one authentication method can be set');
        }

        if (isset($config['auth']['token'])) {
            return new Definition(TokenAuth::class, [$config['auth']['token']]);
        }
    }
}
