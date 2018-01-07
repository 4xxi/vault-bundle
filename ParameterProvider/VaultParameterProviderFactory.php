<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

use Fourxxi\Bundle\VaultBundle\Client\VaultReaderClientInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\ParameterMapperInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\SimpleParameterMapper;

class VaultParameterProviderFactory
{
    /**
     * @var VaultReaderClientInterface
     */
    protected $vaultClient;

    /**
     * VaultParameterProviderFactory constructor.
     *
     * @param VaultReaderClientInterface $vaultClient
     */
    public function __construct(VaultReaderClientInterface $vaultClient)
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
