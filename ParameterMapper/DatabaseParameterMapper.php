<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterMapper;

use Fourxxi\Bundle\VaultBundle\ParameterMapper\ParameterMapperInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class DatabaseParameterMapper implements ParameterMapperInterface
{
    /**
     * Mapping data from vault to other objects.
     *
     * @param array $response
     *
     * @return ParameterBag
     */
    public function map(array $response): ParameterBag
    {
        return new ParameterBag([
            'database_user' => $response['user'],
            'database_pass' => $response['password'],
        ]);
    }
}
