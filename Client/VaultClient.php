<?php

namespace Fourxxi\Bundle\VaultBundle\Client;

use Fourxxi\Bundle\VaultBundle\Auth\AuthInterface;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

class VaultClient implements VaultClientInterface
{
    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * Client constructor.
     *
     * @param BaseUriConfigurator $configurator
     */
    public function __construct(AuthInterface $auth, BaseUriConfigurator $baseUriConfigurator)
    {
        $this->client = new HttpClient(
            [
                'headers' => [
                    'X-Vault-Token' => $auth->getToken(),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'base_uri' => $baseUriConfigurator->getUri(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function read(string $path)
    {
        $response = $this->client->send(new Request('GET', $path));

        return json_decode($response->getBody()->getContents(), true);
    }
}
