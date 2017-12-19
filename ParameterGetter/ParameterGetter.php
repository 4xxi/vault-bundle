<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterGetter;

use Fourxxi\Bundle\VaultBundle\ParameterProvider\ParameterProviderInterface;

class ParameterGetter implements ParameterGetterInterface
{
    /**
     * @var ParameterProviderInterface[]
     */
    private $providers;

    /**
     * ParameterProviderCollection constructor.
     *
     * @param ParameterProviderInterface[] $providers
     */
    public function __construct(array $providers = [])
    {
        $this->providers = $providers;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $providerName, string $fieldName)
    {
        if (!isset($this->providers[$providerName])) {
            throw new \LogicException("Provider with name $providerName doesn't exist");
        }

        return $this->providers[$providerName]->get($fieldName);
    }
}
