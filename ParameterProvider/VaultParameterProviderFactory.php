<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

use Fourxxi\Bundle\VaultBundle\Client\VaultClientInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\ParameterMapperInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\SimpleParameterMapper;

class VaultParameterProviderFactory
{
    /**
     * @var VaultClientInterface
     */
    protected $vaultClient;

    /**
     * VaultParameterProviderFactory constructor.
     *
     * @param VaultClientInterface $vaultClient
     */
    public function __construct(VaultClientInterface $vaultClient)
    {
        $this->vaultClient = $vaultClient;
    }

    /**
     * @param string                        $path
     * @param ParameterMapperInterface|null $parameterMapper
     *
     * @return VaultParameterProvider
     */
    public function create(string $path, ParameterMapperInterface $parameterMapper = null)
    {
        $parameterMapper = $parameterMapper ?? new SimpleParameterMapper();

        return new VaultParameterProvider($path, $parameterMapper, $this->vaultClient);
    }
}
