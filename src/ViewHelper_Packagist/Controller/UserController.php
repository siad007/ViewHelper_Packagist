<?php

namespace ViewHelper_Packagist\Controller;

use ViewHelper_Packagist\Paginator\Adapter\PackagistAdapter;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;

class UserController extends AbstractActionController
{
    public function indexAction()
    {

    }

    public function searchAction()
    {
        $query = array(
            'q' => $this->params('query'),
            'page' => $this->params('page')
        );

        $packagist = $this->getServiceLocator()
                ->get('ViewHelper_Packagist\Service\Packagist')->search($query);

        $paginator = new Paginator(new PackagistAdapter($packagist));
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'));
        $paginator::setDefaultItemCountPerPage(15);
        $view = new ViewModel(
                array(
                    'results' => $packagist['results'],
                    'paginator' => $paginator
                ));
        $view->setTemplate('user/search.phtml');
        return $view;
    }

    public function displayAction()
    {
        $vendor = $this->params('vendor');
        $package = $this->params('package');

        $display = $this->getServiceLocator()
                ->get('ViewHelper_Packagist\Service\Packagist')
                ->display(array('p' => $vendor . '/' . $package));

        $view = new ViewModel(
                array(
                    'packages' => $display['packages']
                ));
        $view->setTemplate('user/display.phtml');
        return $view;
    }
}
