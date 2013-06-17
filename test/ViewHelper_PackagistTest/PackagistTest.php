<?php

namespace ViewHelper_PackagistTest;

use \PHPUnit_Framework_TestCase as TestCase;
use ViewHelper_Packagist\View\Helper\Packagist;
use Zend\Http\Client;

class PackagistTest extends TestCase
{
    /**
     *
     */
    public function testSearchNoResult()
    {
        $packagist = new Packagist();
        $packagist->setHttpClient(new Client(null, array('adapter' => 'Zend\Http\Client\Adapter\Test')));
        $list = $packagist->search(array('q' => 'qwertyqwertz');

        $this->assertEquals('<ul id="packagistList"><li class="no-result">No result.</li></ul>', $list);
    }

}
