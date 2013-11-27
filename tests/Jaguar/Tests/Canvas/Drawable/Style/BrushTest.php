<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Canvas\Drawable\Style;

use Jaguar\Canvas\Drawable\Style\Brush;
use Jaguar\Tests\Canvas\Drawable\AbstractStyleTest;

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
     * @expectedException \Jaguar\Exception\Canvas\Drawable\DrawableException
     */
    public function testApplyThrowDrawableException()
    {
        $brush = new Brush(new \Jaguar\Tests\Canvas\Mock\CanvasMock());
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
