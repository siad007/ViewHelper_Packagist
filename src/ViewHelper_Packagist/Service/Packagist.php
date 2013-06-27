<?php

namespace ViewHelper_Packagist\Service;

use Zend\Cache\Storage\Adapter\Filesystem as Cache;
use Zend\Http\Client as HttpClient;
use Zend\Http\Client\Adapter\Curl;
use Zend\Json\Json as ResultBody;
use Zend\Serializer\Adapter\PhpSerialize as Serializer;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Packagist implements ServiceLocatorAwareInterface
{
    const PACKAGIST_SEARCH = 'https://packagist.org/search.json';
    const PACKAGIST_LIST = 'https://packagist.org/packages/list.json';
    const PACKAGIST_DISPLAY = 'https://packagist.org/p/%s.json';

    protected $cache = null;

    /**
     * @var HttpClient
     */
    protected $httpClient = null;

    public function __construct()
    {
        $adapter = new Curl;
        $adapter->setOptions(
                array('curloptions' => array(
                                CURLOPT_SSL_VERIFYPEER => false,
                                CURLOPT_SSL_VERIFYHOST => false
                ))
        );
        $this->httpClient = $this->getHttpClient() ?: new HttpClient;
        $this->httpClient->setAdapter($adapter);

        $this->cache = $this->getCache() ?: new Cache;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {

    }

    public function getServiceLocator()
    {

    }

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function setHttpClient(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function getHttpClient()
    {
        return $this->httpClient;
    }

    public function display($name)
    {
        return $this->getResult(self::PACKAGIST_DISPLAY, $name);
    }

    public function fetch($separator = '<br />')
    {
        return $this->getResult(self::PACKAGIST_LIST, $separator);
    }

    public function search($args = array('q' => ''))
    {
        return $this->getResult(self::PACKAGIST_SEARCH, $args);
    }

    protected function getResult($uri, $args = '')
    {
        $array = new Serializer;
        $key = hash('md5', is_array($args) ? $array->serialize($args) : $args);
        $packagist = $this->cache->getItem($key, $success);

        if (!$success) {
            if (is_string($uri) && strpos($uri, '%s')) {
                $client = $this->httpClient->setUri(sprintf($uri, implode('/', $args)));
            } else {
                $client = $this->httpClient->setUri($uri);
            }
            if (is_array($args)) {
                $client->setParameterGet($args);
            }
            $body = $client->send()->getBody();
            $packagist = ResultBody::decode($body, true);
            $packagist = $array->serialize($packagist);

            $this->cache->setItem($key, $packagist);
        }
        $packagist = $array->unserialize($packagist);

        return $packagist;
    }
}