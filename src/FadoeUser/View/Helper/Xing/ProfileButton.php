<?php

namespace FadoeUser\View\Helper\Xing;
use FadoeUser\View\Helper\Xing\AbstractHelper;

class ProfileButton extends AbstractHelper
{
    const BTN_1_DE  = 'btn_1_de';
    const BTN_2_DE  = 'btn_2_de';
    const BTN_3_DE  = 'btn_3_de';
    const BTN_4_DE  = 'btn_4_de';
    const BTN_5_DE  = 'btn_5_de';
    const BTN_6_DE  = 'btn_6_de';
    const BTN_7_DE  = 'btn_7_de';
    const BTN_8_DE  = 'btn_8_de';
    const BTN_9_DE  = 'btn_9_de';
    const BTN_16_DE = 'btn_16_de';

    const PROFILE_URL = 'http://www.xing.com/profile/%s';
    const BUTTON_URL  = 'http://www.xing.com/img/buttons/%s';

    protected static $buttonconfig = array(
        self::BTN_1_DE => array(
            'button' => '1_de_btn.gif',
            'width' => 85,
            'height' => 23
            ),
        self::BTN_2_DE => array(
            'button' => '2_de_btn.gif',
            'width' => 118,
            'height' => 23
        ),
        self::BTN_3_DE => array(
            'button' => '3_de_btn.gif',
            'width' => 118,
            'height' => 23
        ),
        self::BTN_4_DE => array(
            'button' => '4_de_btn.gif',
            'width' => 118,
            'height' => 23

        ),
        self::BTN_5_DE => array(
            'button' => '5_de_btn.gif',
            'width' => 118,
            'height' => 23

        ),
        self::BTN_6_DE => array(
            'button' => '6_de_btn.gif',
            'width' => 118,
            'height' => 23

        ),
        self::BTN_7_DE => array(
            'button' => '7_de_btn.gif',
            'width' => 139,
            'height' => 23

        ),
        self::BTN_8_DE => array(
            'button' => '8_de_btn.gif',
            'width' => 118,
            'height' => 23

        ),
        self::BTN_9_DE => array(
            'button' => '9_de_btn.gif',
            'width' => 80,
            'height' => 15

        ),
        self::BTN_16_DE => array(
            'button' => '16_de_btn.gif',
            'width' => 118,
            'height' => 23

        )
    );

    protected $_url = null;
    protected $_name = null;

    public function setUrl($url)
    {
        $this->_url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function render()
    {
        $aAttribs = array(
            'href'   => sprintf(self::PROFILE_URL, $this->getUrl()),
            'target' => '_blank',
            'rel'    => 'me'
        );

        $button = self::BTN_16_DE;

        $button = self::$buttonconfig[$button];

        $imgAttribs = array(
            'src'   => sprintf(self::BUTTON_URL, $button['button']),
            'width'  => $button['width'],
            'height' => $button['height'],
            'alt'    => $this->getName(),
            'title'  => $this->getName()
        );

        $html = '<a' . $this->htmlAttribs($aAttribs) . '>'
              . '<img' . $this->htmlAttribs($imgAttribs) . $this->getClosingBracket()
              . '</a>';

        return $html;
    }

    public function __invoke()
    {
        return $this;
    }

}

