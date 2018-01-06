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

    /**
     * @param string $path
     * @param array $value
     * @return mixed
     */
    public function write(string $path, array $value);
}
