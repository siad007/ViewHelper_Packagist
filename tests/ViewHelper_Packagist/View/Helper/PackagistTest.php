<?php

namespace ViewHelper_Packagist\View\Helper;

use \PHPUnit_Framework_TestCase as TestCase;

class PackagistTest extends TestCase
{
    /**
     *
     */
    public function testSearchNoResult()
    {
        $packagist = new \ViewHelper_Packagist\View\Helper\Packagist();

        $list = $packagist->search('qwertyqwertz');

        $this->assertEquals('<ul id="packagistList"><li class="no-result">No result.</li></ul>', $list);
    }

}
