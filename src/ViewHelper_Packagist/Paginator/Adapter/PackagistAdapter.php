<?php

namespace ViewHelper_Packagist\Paginator\Adapter;

use Zend\Paginator\Adapter\ArrayAdapter;

use Zend\Authentication\Adapter\AdapterInterface;

use Zend\Paginator\Adapter;

class PackagistAdapter extends ArrayAdapter
{
    /**
     * Constructor.
     *
     * @param array $array PackagistAdapter to paginate
     */
    public function __construct(array $packagist = array())
    {
        $this->array = $packagist['results'];
        $this->count = $packagist['total'];
    }
}