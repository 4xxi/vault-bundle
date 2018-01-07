<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

interface VaultReaderClientInterface
{
    /**
     * @param string $pathProvider
     *
     * @return array
     */
    public function read(string $path);
}
