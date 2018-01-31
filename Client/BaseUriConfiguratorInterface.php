<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

interface BaseUriConfiguratorInterface
{
    /**
     * @return string
     */
    public function getUri(): string;
}
