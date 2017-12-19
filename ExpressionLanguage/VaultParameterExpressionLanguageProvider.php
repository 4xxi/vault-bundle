<?php

namespace Fourxxi\Bundle\VaultBundle\ExpressionLanguage;

use Symfony\Component\ExpressionLanguage\ExpressionFunction;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;

class VaultParameterExpressionLanguageProvider implements ExpressionFunctionProviderInterface
{
    /**
     * @return ExpressionFunction[] An array of Function instances
     */
    public function getFunctions()
    {
        $compiler = function ($providerName, $fieldName) {
            return sprintf('$this->get(\'fourxxi_vault.parameter_getter\')->get(%1$s, %2$s)', $providerName, $fieldName);
        };

        $evaluator = function ($variables, $providerName, $fieldName) {
            return $variables['container']->get('fourxxi_vault.parameter_getter')->get($providerName, $fieldName);
        };

        return [
            new ExpressionFunction('v', $compiler, $evaluator),
            new ExpressionFunction('vault', $compiler, $evaluator),
            new ExpressionFunction('fourxxi_vault', $compiler, $evaluator),
        ];
    }
}
