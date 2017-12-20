<?php

namespace Fourxxi\Bundle\VaultBundle\Auth;

interface AuthInterface
{
    /**
     * @return string
     */
    public function getToken(): string;
}
