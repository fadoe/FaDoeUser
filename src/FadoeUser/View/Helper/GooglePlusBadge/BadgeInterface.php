<?php

namespace FaDoeUser\View\Helper\GooglePlusBadge;
use Zend\View\Helper\HelperInterface as BaseHelperInterface;

interface BadgeInterface extends BaseHelperInterface
{

    /**
     * The URL of the Google+ Profile
     * @param string $href
     */
    public function setHref($href);

    /**
     * @return string
     */
    public function getHref();

    /**
     * The pixel width of the badge to render.
     * 
     * @param int $width
     */
    public function setWidth($width);

    public function getWidth();

    /**
     * The pixel height of the badge to render.
     *
     * @param int $height
     */
    public function setHeight($height);

    public function getHeight();

    /**
     * The color theme of the badge. Use dark when placing the
     * badge on a page with a dark background.
     *
     * @param string $theme
     */
    public function setTheme($theme);

    public function getTheme();

}