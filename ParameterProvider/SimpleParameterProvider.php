<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class SimpleParameterProvider implements ParameterProviderInterface
{
    /**
     * @var ParameterBag
     */
    private $parameterBag;

    /**
     * SimpleParameterProvider constructor.
     *
     * @param ParameterBag $parameterBag
     */
    public function __construct(ParameterBag $parameterBag)
    {
        $this->parameterBag = $parameterBag;
    }

    /**
     * @return ParameterBag
     */
    public function get($name)
    {
        return $this->parameterBag->get($name);
    }
}
