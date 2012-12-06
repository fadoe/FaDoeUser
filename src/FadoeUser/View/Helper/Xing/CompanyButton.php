<?php

namespace FadoeUser\View\Helper\Xing;
use FadoeUser\View\Helper\Xing\AbstractHelper;

class CompanyButton extends AbstractHelper
{

    const COMPANY_URL = 'https://www.xing.com/companies/%s';
    const IMAGE_URL   = 'http://www.xing.com/assets/companies/img/cp_button.png';

    protected $_companyUrl = null;

    protected $_companyName = null;

    public function __invoke()
    {
        return $this;
    }

    public function setUrl($url)
    {
        $this->_companyUrl = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->_companyUrl;
    }

    public function setName($name)
    {
        $this->_companyName = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_companyName;
    }

    public function render()
    {

        $aAttribs = array(
            'href'   => sprintf(self::COMPANY_URL, $this->getUrl()),
            'target' => '_blank'
        );

        $imgAttribs = array(
            'src'    => self::IMAGE_URL,
            'width'  => 98,
            'height' => 23,
            'border' => 0,
            'title'  => $this->getName(),
            'alt'    => $this->getName()
        );

        $html = '<a' . $this->htmlAttribs($aAttribs) . '>'
              . '<img' . $this->htmlAttribs($imgAttribs) . $this->getClosingBracket()
              . '</a>';

        return $html;
    }

}
