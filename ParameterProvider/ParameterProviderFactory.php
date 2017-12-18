<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

use Fourxxi\Bundle\VaultBundle\Client\VaultClientInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\ParameterMapperInterface;

class ParameterProviderFactory
{
    /**
     * @var VaultClientInterface
     */
    protected $vaultClient;

    /**
     * @var bool
     */
    protected $vaultEnabled;

    /**
     * VaultParameterProviderFactory constructor.
     *
     * @param VaultClientInterface $vaultClient
     */
    public function __construct(VaultClientInterface $vaultClient, bool $vaultEnabled = true)
    {
        $this->vaultClient = $vaultClient;
        $this->vaultEnabled = $vaultEnabled;
    }

    /**
     * @param string                     $path
     * @param ParameterMapperInterface   $parameterMapper
     * @param ParameterProviderInterface $disabledVaultParameterProvider
     *
     * @return ParameterProviderInterface|VaultParameterProvider
     */
    public function create(
        string $path,
        ParameterMapperInterface $parameterMapper,
        ParameterProviderInterface $disabledVaultParameterProvider
    ) {
        if (false === $this->vaultEnabled) {
            return $disabledVaultParameterProvider;
        }

        return new VaultParameterProvider($this->vaultClient, $path, $parameterMapper);
    }
}
