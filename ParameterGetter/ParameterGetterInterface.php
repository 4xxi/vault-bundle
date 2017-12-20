<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterGetter;

interface ParameterGetterInterface
{
    /**
     * @param $providerName
     * @param $field
     *
     * @return mixed
     */
    public function get(string $providerName, string $fieldName);
}
