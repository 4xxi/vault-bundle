<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

use Fourxxi\Bundle\VaultBundle\Client\VaultClientInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\ParameterMapperInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class VaultParameterProvider implements ParameterProviderInterface
{
    /**
     * @var VaultClientInterface
     */
    protected $vaultClient;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var ParameterMapperInterface
     */
    protected $parameterMapper;

    /**
     * @var ParameterBag
     */
    protected $parameterBag;

    /**
     * VaultParameterProvider constructor.
     *
     * @param string                   $path
     * @param ParameterMapperInterface $parameterMapper
     */
    public function __construct(
        VaultClientInterface $vaultClient,
        string $path,
        ParameterMapperInterface $parameterMapper
    ) {
        $this->vaultClient = $vaultClient;
        $this->path = $path;
        $this->parameterMapper = $parameterMapper;
        // for lazy loading
        $this->parameterBag = null;
    }

    /**
     * @return ParameterBag
     */
    public function get($name)
    {
        if ($this->parameterBag === null) {
            $response = $this->vaultClient->read($this->path);
            $this->parameterBag = $this->parameterMapper->map($response);
        }

        return $this->parameterBag->get($name);
    }
}
