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
    }
    
    /**
     * @test
     */
    public function searchNoResult()
    {
        $packagist = new Packagist();
        $packagist->setHttpClient($this->client);
        $list = $packagist->search(array('q' => 'qwertyqwertz'));

        $this->assertEquals('<ul id="packagistList"><li class="no-result">No result.</li></ul>', $list);
    }
}
