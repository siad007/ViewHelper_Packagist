<?php

namespace ViewHelper_Packagist\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Packagist View Helper.
 */
class Packagist extends AbstractHelper
{
    protected $sm;

    public function __construct($sm)
    {
        $this->sm = $sm;
    }

    /**
     * Get view helper config.
     *
     * @return multitype:multitype:\ViewHelper_Packagist\View\Helper\Packagist
     */
    public function getViewHelperConfig()
    {
        return array(
            'services' => array(
                'packagist' => $this
            )
        );
    }

    /**
     * @return \ViewHelper_Packagist\View\Helper\Packagist
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * Display a details page from vendor/package string.
     *
     * @param string $name
     *
     * @return Ambigous <string, mixed>
     */
    public function display($name)
    {
        $packagist = $this->sm->getServiceLocator()->get('ViewHelper_Packagist\Service\Packagist')->display($name);

        $html = '';
        if (empty($packagist)) {
            return $html;
        }

        $html .= "<h3>{$name}</h3>";
        foreach ($packagist['packages'][$name] as $version => $release) {
            $html .= "<h4><a href='{$release['homepage']}'>{$version}</a></h4>";
            $html .= "<p><b>{$release['name']}</b> {$release['description']}</p>";
            $html .= "<p>" . implode(', ', $release['keywords']) . "</p>";
            $html .= "<p>{$release['version']} ({$release['version_normalized']})</p>";
            $html .= "<p>".implode(', ', $release['license'])."</p>";
            foreach ($release['authors'] as $person) {
                $html .= "<p>".implode(', ', $person)."</p>";
            }
            $html .= "<p>".implode(', ', $release['source'])."</p>";
            $html .= "<p>".implode(', ', $release['dist'])."</p>";
            $html .= "<p>{$release['type']}</p>";
            $html .= "<p>{$release['time']}</p>";
            foreach ($release['autoload'] as $name => $autoloader) {
                $html .= "<p><b>{$name}</b> ".implode(', ', $autoloader)."</p>";
            }
            $html .= print_r($release, true);
        }

        return $html;
    }

    /**
     * Fetch a list of all packages.
     *
     * @param string $separator
     *
     * @return string
     */
    public function fetch($separator = '<br />')
    {
        $packagist = $this->sm->getServiceLocator()->get('ViewHelper_Packagist\Service\Packagist')->fetch($separator);

        $html = '';
        if (empty($packagist)) {
            return $html;
        }

        foreach ($packagist['packageNames'] as $package) {
            $html .= $package . $separator;
        }

        return $html;
    }

    /**
     * Search for packages.
     *
     * @param array $args
     *
     * @return string
     */
    public function search($args = array('q' => ''))
    {
        $packagist = $this->sm->getServiceLocator()->get('ViewHelper_Packagist\Service\Packagist')->search($args);

        $html = '<ul id="packagistList">';
        if (empty($packagist) || $packagist['total'] === 0) {
            $html .= '<li class="no-result">No result.</li>';
        } else {
            foreach ($packagist['results'] as $package) {
                $html .= vsprintf(
                        '<ul class="packagistRow"><li class="packagistName"><a href="%3$s">%1$s</a></li><li class="packagistDescription">%2$s</li><li class="packagistDownloads">%4$s</li><li class="packagistFavers">%5$s</li></ul>',
                        $package
                );
            }
        }
        $html .= '</ul>';

        return $html;
    }
}
