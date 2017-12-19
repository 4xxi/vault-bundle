<?php

namespace Fourxxi\Bundle\VaultBundle\Auth;

class TokenAuth implements AuthInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * TokenAuth constructor.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
