<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

interface VaultWriterClientInterface
{
    /**
     * @param string $path
     * @param array  $value
     *
     * @return mixed
     */
    public function write(string $path, array $value);
}
