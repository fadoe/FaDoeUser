<?php

namespace FadoeUser\View\Helper;

use FadoeUser\View\Helper\AbstractHelper;

/**
 * @see https://developers.google.com/+/plugins/badge/?utm_source=wmt&utm_medium=ui&utm_campaign=badge
 */
class GooglePlusButton extends AbstractHelper
{

    public function __invoke($googleId)
    {
        $view = $this->cloneView();
        $view->googleId = $googleId;
        return $view->render('social/googleplusbutton.phtml');
    }
    
}