<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable\Style;

use Jaguar\Tests\Drawable\AbstractStyleTest;
use Jaguar\Drawable\Style\FillStyle;

class FillStyleTest extends AbstractStyleTest
{
    public function testApply()
    {
        $style = new FillStyle($this->getCanvas());
        $this->assertInstanceOf(
                '\Jaguar\Color\TiledColor'
                , $style->apply($this->getCanvas(), $this->getDrawable())
        );
    }

    /**
     * @expectedException \Jaguar\Exception\DrawableException
     */
    public function testApplyThrowDrawableException()
    {
        $style = new FillStyle(new \Jaguar\Tests\Mock\CanvasMock());
        $style->apply($this->getCanvas(), $this->getDrawable());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCloneThrowRuntimeException()
    {
        $style = new FillStyle($this->getCanvas());
        clone $style;
    }

}
