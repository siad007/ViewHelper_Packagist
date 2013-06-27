<?php

namespace ViewHelper_Packagist;

use ViewHelper_Packagist\View\Helper\Packagist;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    __NAMESPACE__ => __DIR__.'/../../src/'.str_replace('\\', '/', __NAMESPACE__),
                )
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return include __DIR__ . '/../../config/service.config.php';
    }

    public function onBootstrap($e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();

        $serviceManager->get('viewhelpermanager')->setFactory('Packagist', function ($sm) use ($e) {
            return new Packagist($sm);
        });
    }
}
