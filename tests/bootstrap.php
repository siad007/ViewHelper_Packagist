<?php

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
