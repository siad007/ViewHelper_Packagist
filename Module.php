<?php

namespace ViewHelper_Packagist;

use Zend\Http\ClientStatic as HttpClient;
use Zend\Json as ResultBody;

class Module extends \Zend\View\Helper\AbstractHelper
{
    const PACKAGIST_SEARCH = 'https://packagist.org/search.json';

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
        $packagist = ResultBody::decode(HttpClient::get(self::PACKAGIST_SEARCH, $args));

        $html = '<ul id="packagistList">';
        if ($packagist['total'] === 0) {
            $html .= '<li class="no-result">No result.</li>';
        } else {
            foreach ($packagist['results'] as $package) {
                $html .=  sprintf(
                    '<ul class="packagistRow"><li class="packagistName">%s</li><li class="packagistDescription">%s</li><li class="packagistUrl">%s</li><li class="packagistDownloads">%s</li><li class="packagistFavors">%s</li></ul>',
                    $package
                );
            }
        }
        $html = '</ul>';

        return $html;
    }
}

