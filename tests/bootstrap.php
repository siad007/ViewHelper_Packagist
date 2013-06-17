<?php

define('ZF2_PATH', realpath(__DIR__ . '/../../../vendor/zendframework/zendframework/library/'));

$path = array(
    ZF2_PATH,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

require_once 'Zend/Loader/AutoloaderFactory.php';
require_once 'Zend/Loader/StandardAutoloader.php';

use Zend\Loader\AutoloaderFactory;
use Zend\Loader\StandardAutoloader;

// setup autoloader
AutoloaderFactory::factory(
    array(
     'Zend\Loader\StandardAutoloader' => array(
            StandardAutoloader::AUTOREGISTER_ZF => true,
            StandardAutoloader::ACT_AS_FALLBACK => false,
            StandardAutoloader::LOAD_NS => $additionalNamespaces,
        )
    )
);

$files = array(
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../../vendor/autoload.php',
);

foreach ($files as $file) {
    if (file_exists($file)) {
        $loader = require __DIR__ . '/../vendor/autoload.php';

        break;
    }
}

if (!$loader) {
    throw new \RuntimeError('vendor/autoload.php not found.');
}
