<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterMapper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class SimpleParameterMapper implements ParameterMapperInterface
{
    /**
     * {@inheritdoc}
     */
    public function map(array $response): ParameterBag
    {
        return new ParameterBag($response['data']);
    }
}
