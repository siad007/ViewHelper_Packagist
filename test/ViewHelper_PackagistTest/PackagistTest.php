<?php

namespace ViewHelper_PackagistTest;

use \PHPUnit_Framework_TestCase as TestCase;
use ViewHelper_Packagist\View\Helper\Packagist;
use Zend\Json;

class PackagistTest extends TestCase
{
    /**
     *
     */
    public function testSearchNoResult()
    {
        $packagist = new Packagist();

        $list = $packagist->search('qwertyqwertz');

        $this->assertEquals('<ul id="packagistList"><li class="no-result">No result.</li></ul>', $list);
    }

}
