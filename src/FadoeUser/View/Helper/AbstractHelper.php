<?php

namespace FadoeUser\View\Helper;
use Zend\View\Helper\AbstractHelper as ZendAbstractHelper;

class AbstractHelper extends ZendAbstractHelper
{

    public function cloneView()
    {
        $view = clone $this->view;
        $view->setVars(array());
        return $view;
    }

}