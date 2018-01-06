<?php

namespace Fourxxi\Bundle\VaultBundle\Tests\Functional;

use Fourxxi\Bundle\VaultBundle\ParameterMapper\SimpleParameterMapper;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Process\Process;

class VaultClientTest extends WebTestCase
{
    const TYPE_ARRAY = 1;
    const TYPE_FILE = 2;

    protected static $vaultProcess;

    public static function setUpBeforeClass()
    {
        self::$vaultProcess = new Process('vault server -dev -dev-root-token-id="c618a7bc-56ff-9799-be89-514f3557f956"');
        self::$vaultProcess->start();
    }

    public static function tearDownAfterClass()
    {
        self::$vaultProcess->stop(3, SIGINT);
    }

    protected function setUp()
    {
        $this->bootKernel();
    }

    public function testRead()
    {


/*        $provider = [
            [
                'mapper' => 'simple',
                'format' => 'array',
                'data' => [
                    'field1' => 'field2',
                    'field2' => 'field3'
                ]
            ], [
                'mapper' => 'simple',
                'format' => 'json',

            ]
        ];*/
        //var_dump(get_class(static::$kernel->getContainer())); exit();
        //$vaultClient = static::$kernel->getContainer();
        /*$process = new Process("VAULT_ADDR=http://127.0.0.1:8200 vault write secret/test value=hello");
        $process->mustRun();

        $vaultClient = static::$kernel->getContainer()->get('fourxxi_vault.client.client');
        $result = $vaultClient->read('secret/test');
        var_dump($result); exit();*/
        //$this->ass
        /*try {
            $process->mustRun();

            echo $process->getOutput();
        } catch (ProcessFailedException $e) {
            echo $e->getMessage();
        }*/
        //var_dump(get_class(static::$kernel)); exit();*/
        //static::$kernel->getContainer()->get('fourxxi_vault.client.client'); exit();
        /*$tester = $this->createCommandTester();
        $ret = $tester->execute(array('name' => 'TestBundle'));

        $this->assertSame(0, $ret, 'Returns 0 in case of success');
        $this->assertContains('custom: foo', $tester->getDisplay());*/

    }
}