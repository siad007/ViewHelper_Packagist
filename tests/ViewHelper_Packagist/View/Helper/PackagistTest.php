<?php

require_once __DIR__ . '/../Module.php';

class PackagistTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testSearchNoResult()
    {
        $packagist = new \ViewHelper_Packagist\Module();

        $list = $packagist->search('qwertyqwertz');

        $this->assertEquals('<ul id="packagistList"><li class="no-result">No result.</li></ul>', $list);
    }

}