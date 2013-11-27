<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Canvas\Drawable;

use Jaguar\Tests\JaguarTestCase;
use Jaguar\Canvas\Canvas;
use Jaguar\Dimension;

abstract class AbstractDrawableTest extends JaguarTestCase
{
    /**
     * Get drawabale object
     *
     * @return \Jaguar\Canvas\Drawable\DrawableInterface
     */
    abstract public function getDrawable();

    /**
     * Get canvas object
     *
     * @return \Jaguar\Canvas\Drawable\DrawableInterface
     */
    public function getCanvas()
    {
        return new Canvas(new Dimension(100, 100));
    }

    /**
     * @expectedException \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function testDrawThrowCanvasEmptyException()
    {
        $canvas = new \Jaguar\Tests\Canvas\Mock\EmptyCanvasMock();
        $canvas->draw($this->getDrawable());
    }

    /**
     * @expectedException \Jaguar\Exception\Canvas\Drawable\DrawableException
     */
    public function testDrawThrowDrawableException()
    {
        $canvas = new \Jaguar\Tests\Canvas\Mock\CanvasMock();
        $canvas->draw($this->getDrawable());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEqualsThrowInvalidArgumnetException()
    {
        $this->getDrawable()->equals('invalid');
    }

    public function testDraw()
    {
        $canvas = $this->getCanvas();
        $drawable = $this->getDrawable();
        $this->assertSame($canvas, $canvas->draw($drawable));
        $this->assertSame($drawable, $drawable->draw($canvas));
    }

    public function testToString()
    {
        $this->assertInternalType('string', (string) $this->getDrawable());
    }

}
