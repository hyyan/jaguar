<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Canvas\Drawable\Style;

use Jaguar\Tests\Canvas\Drawable\AbstractStyleTest;
use Jaguar\Canvas\Drawable\Style\DashedlineStyle;

class DashedlineStyleTest extends AbstractStyleTest
{

    public function testApply()
    {
        $dl = new DashedlineStyle();
        $this->assertInstanceOf(
                '\Jaguar\Color\StyledColor'
                , $dl->apply($this->getCanvas(), $this->getDrawable())
        );
    }

    /**
     * @expectedException \Jaguar\Exception\Canvas\Drawable\DrawableException
     */
    public function testApplyThrowDrawableException()
    {
        $dl = new DashedlineStyle();
        $dl->apply(new \Jaguar\Tests\Canvas\Mock\CanvasMock(), $this->getDrawable());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFisrtColorShowTimeThrowInvalidArgumentException()
    {
        new DashedlineStyle(-5);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSecondColorShowTimeThrowInvalidArgumentException()
    {
        new DashedlineStyle(5, -5);
    }

    public function testClone()
    {
        $dl = new DashedlineStyle();
        $clone = clone $dl;

        $this->assertNotSame($dl->getSecondColor(), $clone->getSecondColor());
    }

}
