<?php

namespace ViewHelper_PackagistTest;

use \PHPUnit_Framework_TestCase as TestCase;
use ViewHelper_Packagist\View\Helper\Packagist;
use Zend\Http\Client;

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
        $this->adapter = new \Zend_Http_Client_Adapter_Test();
        $this->client->getHttpClient()->setAdapter($this->adapter);
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
    
    public function testCallWebServiceWhenSuccessful()
    {
        $this->adapter->setResponse(
            "HTTP/1.1 200 OK" . "\r\n" .
            "Content-Type: text/html" . "\r\n" .
            "\r\n" .
            'ok'
        );
        
        $packagist = new Packagist();
        $packagist->setHttpClient($this->client);
        $list = $packagist->search(array('q' => 'qwertyqwertz'));
        
        $this->assertEquals('ok', $list);
    }
}
