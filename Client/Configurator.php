<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

class Configurator
{
    /**
     * @var string
     */
    protected $schema;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $port;

    /**
     * @var string
     */
    protected $token;

    /**
     * Configurator constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->schema = $config['schema'];
        $this->host = $config['host'];
        $this->port = $config['port'];
        $this->token = $config['token'];
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return sprintf('%s://%s:%s', $this->schema, $this->host, $this->port);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
