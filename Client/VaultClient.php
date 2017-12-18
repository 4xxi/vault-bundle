<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class VaultClient implements VaultClientInterface
{
    const VERSION_API = 'v1';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var Configurator
     */
    protected $configurator;

    /**
     * Client constructor.
     *
     * @param Configurator $configurator
     */
    public function __construct(Configurator $configurator)
    {
        $this->configurator = $configurator;
        $this->client = $this->createHttpClient();
    }

    /**
     * {@inheritdoc}
     */
    public function read(string $path)
    {
        $request = $this->createRequest('GET', $path);
        $response = $this->client->send($request);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return HttpClient
     */
    protected function createHttpClient()
    {
        $headers = [
            'X-Vault-Token' => $this->configurator->getToken(),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        return new HttpClient(['headers' => $headers]);
    }

    /**
     * @param string $method
     * @param string $path
     *
     * @return Request
     */
    protected function createRequest($method, $path)
    {
        $uri = sprintf('%s/%s/%s', $this->configurator->getUrl(), self::VERSION_API, $path);

        return new Request($method, $uri);
    }
}
