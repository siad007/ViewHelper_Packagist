<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ViewHelper_Packagist\Controller\User' => 'ViewHelper_Packagist\Controller\UserController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'packagist' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/packagist[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ViewHelper_Packagist\Controller\User',
                        'action' => 'index',
                    ),
                ),
            ),
            'packagist-search' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/packagist/search[/:query][/:page]',
                    'constraints' => array(
                        'query' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ViewHelper_Packagist\Controller\User',
                        'action' => 'search',
                        'query' => '',
                        'page' => 1
                    ),
                ),
            ),
            'packagist-display' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/packagist/display[/:vendor][/:package]',
                    'constraints' => array(
                        'vendor' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'package' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'ViewHelper_Packagist\Controller\User',
                        'action' => 'display',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'view-helper_packagist' => __DIR__ . '/../view',
            'user' => __DIR__ . '/../view/view-helper_packagist',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'packagist' => 'ViewHelper_Packagist\View\Helper\Packagist',
        ),
    ),
);
