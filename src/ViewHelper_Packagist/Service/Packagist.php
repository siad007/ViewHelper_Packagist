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
    const PACKAGIST_INCLUDES = 'https://packagist.org/p/packages-%s.json';

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

    public function fetch($vendor = '')
    {
        return $this->getResult(self::PACKAGIST_LIST, $vendor);
    }

    public function search($args = array('q' => ''))
    {
        return $this->getResult(self::PACKAGIST_SEARCH, $args);
    }

    public function includes($date = '2006')
    {
        return $this->getResult(self::PACKAGIST_INCLUDES, $date);
    }

    protected function getResult($uri, $args = '')
    {
        $array = new Serializer;
        $key = hash('md5', is_array($args) ? $array->serialize($args) : $args);
        $packagist = $this->cache->getItem($key, $success);

        if (!$success) {
            switch ($uri) {
                case self::PACKAGIST_SEARCH:
                    $this->httpClient->setUri($uri);
                    $this->httpClient->setParameterGet($args);
                break;
                case self::PACKAGIST_LIST:
                    $this->httpClient->setUri($uri);
                    $args === '' ?: $this->httpClient->setParameterGet(array('vendor' => $args));
                break;
                case self::PACKAGIST_INCLUDES:
                case self::PACKAGIST_DISPLAY:
                    $this->httpClient->setUri(sprintf($uri, $args));
                break;

                default:
                break;
            }

            $body = $this->httpClient->send()->getBody();
            $packagist = ResultBody::decode($body, true);
            $packagist = $array->serialize($packagist);

            $this->cache->setItem($key, $packagist);
        }

        return $array->unserialize($packagist);
    }
}
