<?php

namespace FadoeUser\View\Helper;
use FadoeUser\View\Helper\Google\AbstractHelper as AbstractGoogleHelper;
use FadoeUser\View\Helper\Google\HelperInterface as GoogleHelper;
use Zend\View\Exception;


/**
 * @TODO Page und Profile
 * @TODO Synchron, Assynchron
 * @TODO
 */
class Google extends AbstractGoogleHelper
{

    /**
     * View helper namespace
     *
     * @var string
     */
    const NS = 'FadoeUser\View\Helper\Google';

    /**
     *
     * @var GooglePlusBadge\PluginManager
     */
    protected $plugins = null;

    /**
     * default proxy to use in {@link render()}
     *
     * @var string
     */
    protected $defaultProxy = 'analytics';

    /**
     * Indicates whether or not a given helper has been injected
     *
     * @var array
     */
    protected $injected = array();

    /**
     * Whether container should be injected when proxying
     *
     * @var bool
     */
    protected $injectContainer = true;

    /**
     *
     * @return Google
     */
    public function __invoke($container = null)
    {
        if (null !== $container) {
            $this->setContainer($container);
        }
        return $this;
    }

    /**
     * Magic overload: Proxy to other Google helpers or the container
     *
     * Examples of usage from a view script or layout:
     * <code>
     * // proxy to Menu helper and render container:
     * echo $this->GooglePlusBadge()->page();
     *
     * // proxy to Breadcrumbs helper and set indentation:
     * $this->navigation()->breadcrumbs()->setIndent(8);
     *
     * // proxy to container and find all pages with 'blog' route:
     * $blogPages = $this->navigation()->findAllByRoute('blog');
     * </code>
     *
     * @param  string $method             helper name or method name in
     *                                    container
     * @param  array  $arguments          [optional] arguments to pass
     * @return mixed                      returns what the proxied call returns
     * @throws \Zend\View\Exception\ExceptionInterface        if proxying to a helper, and the
     *                                    helper is not an instance of the
     *                                    interface specified in
     *                                    {@link findHelper()}
     * @throws \Zend\Navigation\Exception\ExceptionInterface  if method does not exist in container
     */
    public function __call($name, $arguments)
    {
        // check if call should proxy to another helper
        $helper = $this->findHelper($method, false);
        if ($helper) {
            if ($helper instanceof ServiceLocatorAwareInterface && $this->getServiceLocator()) {
                $helper->setServiceLocator($this->getServiceLocator());
            }
            return call_user_func_array($helper, $arguments);
        }

        // default behaviour: proxy call to container
        return parent::__call($method, $arguments);
    }

/**
     * Set manager for retrieving navigation helpers
     *
     * @param  Navigation\PluginManager $plugins
     * @return Navigation
     */
    public function setPluginManager(Google\PluginManager $plugins)
    {
        $renderer = $this->getView();
        if ($renderer) {
            $plugins->setRenderer($renderer);
        }
        $this->plugins = $plugins;
        return $this;
    }

    /**
     * Retrieve plugin loader for navigation helpers
     *
     * Lazy-loads an instance of Navigation\HelperLoader if none currently
     * registered.
     *
     * @return Navigation\PluginManager
     */
    public function getPluginManager()
    {
        if (null === $this->plugins) {
            $this->setPluginManager(new Google\PluginManager());
        }
        return $this->plugins;
    }

    /**
     * Returns the helper matching $proxy
     *
     * The helper must implement the interface
     * {@link Zend\View\Helper\Navigation\Helper}.
     *
     * @param string $proxy                        helper name
     * @param bool   $strict                       [optional] whether
     *                                             exceptions should be
     *                                             thrown if something goes
     *                                             wrong. Default is true.
     * @return \Zend\View\Helper\Navigation\HelperInterface  helper instance
     * @throws Exception\RuntimeException if $strict is true and
     *         helper cannot be found
     */
    public function findHelper($proxy, $strict = true)
    {
        $plugins = $this->getPluginManager();
        if (!$plugins->has($proxy)) {
            if ($strict) {
                throw new Exception\RuntimeException(sprintf(
                    'Failed to find plugin for %s',
                    $proxy
                ));
            }
            return false;
        }

        $helper = $plugins->get($proxy);
        $class  = get_class($helper);

        if (!isset($this->injected[$class])) {
            $this->inject($helper);
            $this->injected[$class] = true;
        }

        return $helper;
    }

    /**
     * Injects container, ACL, and translator to the given $helper if this
     * helper is configured to do so
     *
     * @param  NavigationHelper $helper  helper instance
     * @return void
     */
    protected function inject(GoogleHelper $helper)
    {
        if ($this->getInjectContainer() && !$helper->hasContainer()) {
            $helper->setContainer($this->getContainer());
        }
    }

    /**
     * Sets the default proxy to use in {@link render()}
     *
     * @param  string $proxy                default proxy
     * @return \Zend\View\Helper\Navigation  fluent interface, returns self
     */
    public function setDefaultProxy($proxy)
    {
        $this->defaultProxy = (string) $proxy;
        return $this;
    }

    /**
     * Returns the default proxy to use in {@link render()}
     *
     * @return string  the default proxy to use in {@link render()}
     */
    public function getDefaultProxy()
    {
        return $this->defaultProxy;
    }

        /**
     * Sets whether container should be injected when proxying
     *
     * @param bool $injectContainer         [optional] whether container should
     *                                      be injected when proxying. Default
     *                                      is true.
     * @return \Zend\View\Helper\Navigation  fluent interface, returns self
     */
    public function setInjectContainer($injectContainer = true)
    {
        $this->injectContainer = (bool) $injectContainer;
        return $this;
    }

    /**
     * Returns whether container should be injected when proxying
     *
     * @return bool  whether container should be injected when proxying
     */
    public function getInjectContainer()
    {
        return $this->injectContainer;
    }

    /**
     * Renders helper
     *
     * @param  \Zend\Navigation\AbstractContainer $container  [optional] container to
     *                                               render. Default is to
     *                                               render the container
     *                                               registered in the helper.
     * @return string helper output
     * @throws Exception\RuntimeException if helper cannot be found
     */
    public function render($container = null)
    {
        $helper = $this->findHelper($this->getDefaultProxy());
        return $helper->render($container);
    }

}