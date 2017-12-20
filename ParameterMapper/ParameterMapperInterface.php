<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterMapper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

interface ParameterMapperInterface
{
    /**
     * Mapping data from vault to other objects.
     *
     * @param array $response
     *
     * @return ParameterBag
     */
    public function map(array $response): ParameterBag;
}
