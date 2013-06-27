<?php
return array(
    'factories' => array(
        'ViewHelper_Packagist\Service\Packagist' => function ($sm)
        {
            return new \ViewHelper_Packagist\Service\Packagist($sm);
        },
    )
);
