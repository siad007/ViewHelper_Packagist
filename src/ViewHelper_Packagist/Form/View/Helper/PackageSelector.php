<?php

namespace ViewHelper_Packagist\Form\View\Helper;

class PackageSelector extends \Zend\Form\View\Helper\AbstractHelper
{
    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @return string|FormSelect
     */
    public function __invoke(ElementInterface $element = null)
    {
        return $element ? $this->render($element) : $this;
    }

    public function render(ElementInterface $element)
    {
        if (!$element instanceof SelectElement) {
            throw new Exception\InvalidArgumentException(sprintf(
                    '%s requires that the element is of type Zend\Form\Element\Select',
                    __METHOD__
            ));
        }

        $name   = $element->getName();
        if (empty($name) && $name !== 0) {
            throw new Exception\DomainException(sprintf(
                    '%s requires that the element has an assigned name; none discovered',
                    __METHOD__
            ));
        }
    }
}