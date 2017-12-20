<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

interface VaultClientInterface
{
    /**
     * @param string $pathProvider
     *
     * @return array
     */
    public function read(string $path);
}
