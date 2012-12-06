<?php

namespace FadoeUser\View\Helper;
use FadoeUser\View\Helper\Xing\AbstractHelper as AbstractXingHelper;
use FadoeUser\View\Helper\Xing\HelperInterface as XingHelper;
use Zend\View\Exception;

class Xing extends AbstractXingHelper
{

    /**
     * View helper namespace
     *
     * @var string
     */
    const NS = 'FadoeUser\View\Helper\Xing';

    /**
     *
     * @var Xing\PluginManager
     */
    protected $plugins = null;

    /**
     * default proxy to use in {@link render()}
     *
     * @var string
     */
    protected $defaultProxy = 'profile';

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
     * @return Xing
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
     * echo $this->xing()->profileButton();
     *
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
     * @throws \Zend\View\Exception\ExceptionInterface  if method does not exist in container
     */
    public function __call($method, array $arguments = array())
    {
        // check if call should proxy to another helper
        $helper = $this->findHelper($method, false);
        if ($helper) {
            if ($helper instanceof ServiceLocatorAwareInterface && $this->getServiceLocator()) {
                $helper->setServiceLocator($this->getServiceLocator());
            }
            return call_user_func_array($helper, $arguments);
        }
        throw new RuntimeException('Plugin ' . $method . ' not found.');
    }

    /**
     * Set manager for retrieving navigation helpers
     *
     * @param  Xing\PluginManager $plugins
     * @return Xing
     */
    public function setPluginManager(Xing\PluginManager $plugins)
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
     * Lazy-loads an instance of Xing\HelperLoader if none currently
     * registered.
     *
     * @return Xing\PluginManager
     */
    public function getPluginManager()
    {
        if (null === $this->plugins) {
            $this->setPluginManager(new Xing\PluginManager());
        }
        return $this->plugins;
    }

    /**
     * Returns the helper matching $proxy
     *
     * The helper must implement the interface
     * {@link FaDoe\View\Helper\Xing\Helper}.
     *
     * @param string $proxy                        helper name
     * @param bool   $strict                       [optional] whether
     *                                             exceptions should be
     *                                             thrown if something goes
     *                                             wrong. Default is true.
     * @return \FaDoe\View\Helper\Xing\HelperInterface  helper instance
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
     * @param  XingHelper $helper  helper instance
     * @return void
     */
    protected function inject(XingHelper $helper)
    {
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
