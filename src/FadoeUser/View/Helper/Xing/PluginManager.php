<?php

namespace FaDoeUser\View\Helper\Xing;

use Zend\View\Exception;
use Zend\View\HelperPluginManager;

class PluginManager extends HelperPluginManager
{
    /**
     * default set of helpers
     * @var array
     */
    protected $invokableClasses = array(
        'companybutton' => 'FadoeUser\View\Helper\Xing\CompanyButton',
        'profilebutton' => 'FadoeUser\View\Helper\Xing\ProfileButton',
        'sharebutton'   => 'FadoeUser\View\Helper\Xing\ShareButton'
    );

    /**
     * Validate the plugin
     *
     * Checks that the helper loaded is an instance of AbstractHelper.
     *
     * @param  mixed $plugin
     * @return void
     * @throws Exception\InvalidArgumentException if invalid
     */
    public function validatePlugin($plugin)
    {
        if ($plugin instanceof AbstractHelper) {
            // we're okay
            return;
        }

        throw new Exception\InvalidArgumentException(sprintf(
            'Plugin of type %s is invalid; must implement %s\AbstractHelper',
            (is_object($plugin) ? get_class($plugin) : gettype($plugin)),
            __NAMESPACE__
        ));
    }

}
