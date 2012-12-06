<?php

namespace FadoeUser\View\Helper\Xing;
use FadoeUser\View\Helper\Xing\AbstractHelper;

class ShareButton extends AbstractHelper
{

    const TYPE = 'XING/Share';

    protected $_language = 'de';

    protected $_dataUrl = null;

    /**
     * possible values:
     * - top
     * - right
     * - no_count
     *
     * @var string
     */
    protected $_dataCounter = 'right';

    /**
     * possible values:
     * - null
     * - square
     * - rectangle
     * - small_square
     *
     * @var null|string
     */
    protected $_dataButtonShape = null;


    /**
     * data-url url
     * data-lang de|en
     * data-counter top|right|no_count
     * type XING/Share
     * data-button-shape |square|rectangle|small_square
     */

    /**
     *
     * @return ShareButton
     *
     */
    public function __invoke()
    {
        return $this;
    }

    public function setLanguage($lang)
    {
        if (in_array($lang, array('de', 'en'))) {
            $this->_language = $lang;
        }
        return $this;
    }

    public function getLanguage()
    {
        return $this->_language;
    }

    public function setUrl($url)
    {
        $this->_dataUrl = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->_dataUrl;
    }

    public function setDataCounter($position)
    {
        if (in_array($position, array('top', 'right', 'no_count'))) {
            $this->_dataCounter = $position;
        }
        return $this;
    }

    public function getDataCounter()
    {
        return $this->_dataCounter;
    }

    public function setDataButtonShape($shape = null)
    {
        if (in_array($shape, array(null, 'square', 'rectangle', 'small_square'))) {
            $this->_dataButtonShape = $shape;
        }
        return $this;
    }

    public function getDataButtonShape()
    {
        return $this->_dataButtonShape;
    }

    public function render()
    {
        $sAttrib = array(
            'data-button-shape' => $this->getDataButtonShape(),
            'data-lang'         => $this->getLanguage(),
            'data-counter'      => $this->getDataCounter(),
            'type'              => self::TYPE
        );

        $script = '<script>
  ;(function(d, s) {
    var x = d.createElement(s),
      s = d.getElementsByTagName(s)[0];
    x.src = \'https://www.xing-share.com/js/external/share.js\';
    s.parentNode.insertBefore(x, s);
  })(document, \'script\');
</script>';

        return '<script' . $this->htmlAttribs($sAttrib) . '></script>'
        . $script
        ;
    }

}