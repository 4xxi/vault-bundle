<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

use Fourxxi\Bundle\VaultBundle\Client\VaultReaderClientInterface;
use Fourxxi\Bundle\VaultBundle\ParameterMapper\ParameterMapperInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class VaultParameterProvider implements ParameterProviderInterface
{
    /**
     * @var VaultReaderClientInterface
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
        string $path,
        ParameterMapperInterface $parameterMapper,
        VaultReaderClientInterface $vaultClient
    ) {
        $this->path = $path;
        $this->vaultClient = $vaultClient;
        $this->parameterMapper = $parameterMapper;
        $this->parameterBag = null;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return $this->getParameterBag()->get($name);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->getParameterBag()->all();
    }

    /**
     * For lazy load parameters.
     *
     * @return ParameterBag
     */
    protected function getParameterBag()
    {
        if ($this->parameterBag === null) {
            $response = $this->vaultClient->read($this->path);
            $this->parameterBag = $this->parameterMapper->map($response);
            $this->parameterBag->resolve();
        }

        return $this->parameterBag;
    }
}
