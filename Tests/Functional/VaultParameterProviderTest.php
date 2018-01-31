<?php

namespace Fourxxi\Bundle\VaultBundle\Tests\Functional;

use Symfony\Component\Yaml\Yaml;

class VaultParameterProviderTest extends VaultWebTestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function test(string $path, string $mapper, $input, $output)
    {
        $container = static::$kernel->getContainer();
        $writerClient = $container->get('fourxxi_vault.test.writer_client');
        $writerClient->write($path, $input);

        $vaultParameterProviderFactory = $container->get('fourxxi_vault.parameter_provider.vault_factory');

        $parameterProvider = $vaultParameterProviderFactory->create(
            $path,
            $container->get(sprintf('fourxxi_vault.test.mapper.%s', $mapper))
        );

        $this->assertEquals($parameterProvider->all(), $output);
    }

    /**
     * @return string
     */
    protected function getEnvironment(): string
    {
        return 'vault_parameter_test';
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        $mysqlOutput = [
            'mysql_host' => '192.168.0.1',
            'mysql_port' => 3306,
        ];

        $elasticsearchOutput = [
            'elasticsearch_host' => '127.0.0.1',
            'elasticsearch_port' => 9200,
        ];

        return [
            'simple_mapper' => [
                'path' => 'secret/mysql',
                'mapper' => 'simple',
                'input' => $mysqlOutput,
                'output' => $mysqlOutput,
            ],
            'yaml_mapper' => [
                'path' => 'secret/elasticsearch',
                'mapper' => 'yaml',
                'input' => [
                    'value' => Yaml::dump($elasticsearchOutput),
                ],
                'output' => $elasticsearchOutput,
            ],
        ];
    }
}
