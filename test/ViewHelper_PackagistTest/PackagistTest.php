<?php

namespace ViewHelper_PackagistTest;

use \PHPUnit_Framework_TestCase as TestCase;
use ViewHelper_Packagist\Service\Packagist;
use Zend\Http\Client;
use Zend\Http\Client\Adapter\Test;

class PackagistTest extends TestCase
{
    /**
     * @var Zend\Http\Client
     */
    protected $client;
    protected $adapter;

    public function setUp()
    {
        $this->client = new Client('http://fake');
        $this->adapter = new Test();
        $this->client->setAdapter($this->adapter);
        $this->packagist = new Packagist();
        $this->packagist->setHttpClient($this->client);
    }

    /**
     * @test
     */
    public function searchNoResult()
    {
        $list = $this->packagist->search(array('q' => 'qwertyqwertz'));
        $this->assertInternalType('string', $list);
    }

    /**
     * @test
     */
    public function getAutoloaderConfig()
    {
        $module = new \ViewHelper_Packagist\Module;
        $this->assertInternalType('array', $module->getAutoloaderConfig());
    }

    /**
     * @test
     */
    public function fetchPackages()
    {
        $result = $this->packagist->fetch();
        $this->assertInternalType('string', $result);
    }

    /**
     * @test
     */
    public function displayPackages()
    {
        $result = $this->packagist->display('test/test');
        $this->assertInternalType('string', $result);
    }
}
