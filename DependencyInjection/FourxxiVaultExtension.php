<?php

namespace Centrallo\VaultBundle\DependencyInjection;

use Fourxxi\Bundle\VaultBundle\Configuration;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Yaml\Yaml;

class FourxxiVaultExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs   An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (false === $config['enabled']) {
            return;
        }

        /*$client = new Client();
        $request = $client->get($config['connection']['address'], [
            'X-Vault-Token' => $config['connection']['token'],
            'Content-Type' => 'application/json',
        ]);

        $response = $request->send();
        $responseArray = json_decode($response->getBody(true), true);
        $parameters = Yaml::parse($responseArray['data']['value']);

        foreach ($parameters['parameters'] as $key => $value) {
            $container->setParameter($key, $value);
        }*/
    }
}
