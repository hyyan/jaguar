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

use Jaguar\Drawable\Style\Brush;
use Jaguar\Tests\Drawable\AbstractStyleTest;

class BrushTest extends AbstractStyleTest
{
    public function testApply()
    {
        $brush = new Brush($this->getCanvas());
        $this->assertInstanceOf(
                '\Jaguar\Color\StyledBrushedColor'
                , $brush->apply($this->getCanvas(), $this->getDrawable())
        );
    }

    /**
     * @expectedException \Jaguar\Exception\DrawableException
     */
    public function testApplyThrowDrawableException()
    {
        $brush = new Brush(new \Jaguar\Tests\Mock\CanvasMock());
        $brush->apply($this->getCanvas(), $this->getDrawable());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCloneThrowRuntimeException()
    {
        $brush = new Brush($this->getCanvas());
        clone $brush;
    }

}
