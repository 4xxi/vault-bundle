<?php

namespace Fourxxi\Bundle\VaultBundle\ParameterMapper;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Yaml\Yaml;

class YamlParameterMapper implements ParameterMapperInterface
{
    /**
     * @var string
     */
    protected $valueField;

    /**
     * YamlParameterMapper constructor.
     *
     * @param string $valueField
     */
    public function __construct(string $valueField = 'value')
    {
        $this->valueField = $valueField;
    }

    /**
     * {@inheritdoc}
     */
    public function map(array $response): ParameterBag
    {
        if (!isset($response['data'][$this->valueField])) {
            throw new \LogicException("$this->valueField field doesn't exists data array");
        }

        return new ParameterBag(Yaml::parse($response['data'][$this->valueField]));
    }
}
