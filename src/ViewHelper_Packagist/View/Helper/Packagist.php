<?php

namespace ViewHelper_Packagist\View\Helper;

use Zend\Http\Client as HttpClient;
use Zend\Json\Json as ResultBody;

class Packagist extends \Zend\View\Helper\AbstractHelper
{
    const PACKAGIST_SEARCH = 'https://packagist.org/search.json';

    /**
     * @var HttpClient
     */
    protected $httpClient = null;

    public function __construct()
    {
        $this->httpClient = $this->httpClient ?: new HttpClient;
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

    public function __invoke($string = null)
    {
        return $this->search($string);
    }

    public function search($args = array('q' => ''))
    {
        $body = $this->httpClient->setUri(self::PACKAGIST_SEARCH)->setParameterGet($args)->send()->getBody();
        $packagist = ResultBody::decode($body);

        $html = '<ul id="packagistList">';
        if (empty($packagist) || $packagist['total'] === 0) {
            $html .= '<li class="no-result">No result.</li>';
        } else {
            foreach ($packagist['results'] as $package) {
                $html .= sprintf(
                    '<ul class="packagistRow"><li class="packagistName">%s</li><li class="packagistDescription">%s</li><li class="packagistUrl">%s</li><li class="packagistDownloads">%s</li><li class="packagistFavors">%s</li></ul>',
                    $package
                );
            }
        }
        $html = '</ul>';

        return $html;
    }
}
