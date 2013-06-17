<?php

namespace ViewHelper_PackagistTest;

use \PHPUnit_Framework_TestCase as TestCase;
use ViewHelper_Packagist\View\Helper\Packagist;
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
        $this->assertEquals('<ul id="packagistList"><li class="no-result">No result.</li></ul>', $list);
    }
    
    /**
     * @test
     */
    public function getAutoloaderConfig()
    {
        $module = new \ViewHelper_Packagist\Module;
        $this->assertInternalType('array', $module);
    }
}
