<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

class BaseUriConfigurator implements BaseUriConfiguratorInterface
{
    /**
     * @var
     */
    protected $apiVersion;

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
     * Configurator constructor.
     *
     * @param $config
     */
    public function __construct($config)
    {
        $this->schema = $config['connection']['schema'];
        $this->host = $config['connection']['host'];
        $this->port = $config['connection']['port'];
        $this->apiVersion = $config['connection']['api_version'];
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return sprintf('%s://%s:%s/%s/', $this->schema, $this->host, $this->port, $this->apiVersion);
    }
}
