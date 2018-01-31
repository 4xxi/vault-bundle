<?php

namespace Fourxxi\Bundle\VaultBundle\Tests\Unit\ParameterMapper;

use Fourxxi\Bundle\VaultBundle\ParameterMapper\YamlParameterMapper;
use PHPUnit\Framework\TestCase;

final class YamlParameterMapperTest extends TestCase
{
    const EXPECTED_VALUE = 'expected_value';

    /**
     * @test
     */
    public function parsesYamlFieldFromResponse(): void
    {
        $response = ['data' => [self::EXPECTED_VALUE => 'field: value']];
        $mapper = new YamlParameterMapper(self::EXPECTED_VALUE);

        $this->assertEquals(['field' => 'value'], $mapper->map($response)->all());
    }

    /**
     * @test
     */
    public function throwsErrorIfFieldIsMissing()
    {
        $this->expectException(\LogicException::class);

        $mapper = new YamlParameterMapper('missing_value');
        $mapper->map([]);
    }
}
