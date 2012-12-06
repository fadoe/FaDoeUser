<?php

namespace FadoeUserTest\View\Helper;

use FadoeUser\View\Helper\Xing\CompanyButton;

use \PHPUnit_Framework_TestCase as TestCase;

class CompanyButtonTest extends TestCase
{

    public function testRenderButton()
    {
        $xingButton = new CompanyButton();

        $xingButton->setName('FaDoe Test AG');
        $xingButton->setUrl('FaDoe_Test_AG');

        $this->assertEquals(null, $xingButton->render());
    }

}
