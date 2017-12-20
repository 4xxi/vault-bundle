<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterProvider;

interface ParameterProviderInterface
{
    /**
     * @param $path
     *
     * @return mixed
     */
    public function get($field);

    /**
     * @return array
     */
    public function all();
}
