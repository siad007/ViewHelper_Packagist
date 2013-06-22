<?php

namespace ViewHelper_Packagist\View\Helper;

use Zend\Http\Client as HttpClient;
use Zend\Json\Json as ResultBody;
use Zend\Http\Client\Adapter\Curl;

class Packagist extends \Zend\View\Helper\AbstractHelper
{
    const PACKAGIST_SEARCH = 'https://packagist.org/search.json';
    const PACKAGIST_LIST = 'https://packagist.org/packages/list.json';

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

    public function getViewHelperConfig()
    {
        return array('services' => array('packagist' => $this));
    }

    public function __invoke()
    {
        return $this;
    }

    public function fetch($separator = '<br />')
    {
        $body = $this->httpClient->setUri(self::PACKAGIST_LIST)->send()->getBody();
	$packagist = ResultBody::decode($body, true);

	$html = '';
	foreach ($packagist['packageNames'] as $package) {
	    $html .= $package . $separator;
	}

	return $html;
    }

    public function search($args = array('q' => ''))
    {
        $body = $this->httpClient->setUri(self::PACKAGIST_SEARCH)->setParameterGet($args)->send()->getBody();
        $packagist = ResultBody::decode($body, true);

        $html = '<ul id="packagistList">';
        if (empty($packagist) || $packagist['total'] === 0) {
            $html .= '<li class="no-result">No result.</li>';
        } else {
            foreach ($packagist['results'] as $package) {
                $html .= vsprintf(
                    '<ul class="packagistRow"><li class="packagistName"><a href="%3$s">%1$s</a></li><li class="packagistDescription">%2$s</li><li class="packagistDownloads">%4$s</li><li class="packagistFavors">%5$s</li></ul>',
                    $package
                );
            }
        }
        $html .= '</ul>';

        return $html;
    }
}
