<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable\Style;

use Jaguar\Tests\Drawable\AbstractStyleTest;
use Jaguar\Drawable\Style\ThicklineStyle;

class ThicklineStyleTest extends AbstractStyleTest
{

    public function testApply()
    {
        $tl = new ThicklineStyle();
        $this->assertInstanceOf(
                '\Jaguar\Color\StyledBrushedColor'
                , $tl->apply($this->getCanvas(), $this->getDrawable())
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetThicknessThrowInvalidArgumentException()
    {
        new ThicklineStyle(-5);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetIntervalThrowInvalidArgumentExceptionOnShowTime()
    {
        $tl = new ThicklineStyle();
        $tl->setInterval(-5,0);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetHideTimeThrowInvalidArgumentExceptionOnHideTime()
    {
        $tl = new ThicklineStyle();
        $tl->setInterval(1, -5);
    }

}
