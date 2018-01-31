<?php

namespace Fourxxi\Bundle\VaultBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VaultWebTestCase extends WebTestCase
{
    protected function setUp()
    {
        $this->bootKernel(['environment' => $this->getEnvironment()]);
    }

    protected static function getKernelClass()
    {
        // compatibility with symfony 2.8
        if (isset($_ENV['KERNEL_CLASS'])) {
            return $_ENV['KERNEL_CLASS'];
        }

        return parent::getKernelClass();
    }

    /**
     * @return string
     */
    protected function getEnvironment(): string
    {
        return 'test';
    }
}
