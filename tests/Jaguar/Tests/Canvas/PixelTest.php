<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Canvas;

use Jaguar\Canvas\Pixel;
use Jaguar\Tests\JaguarTestCase;
use Jaguar\Tests\Canvas\Mock\CanvasMock;
use Jaguar\Tests\Canvas\Mock\EmptyCanvasMock;
use Jaguar\Canvas\Canvas;
use Jaguar\Dimension;

class PixelTest extends JaguarTestCase {

    /**
     * @expectedException \Jaguar\Exception\Canvas\CanvasException
     */
    public function testDrawThrowCanvasException() {
        $pixel = new Pixel();
        $pixel->draw(new CanvasMock());
    }

    /**
     * @expectedException \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function testDrawThrowEmptyCanvasException() {
        $pixel = new Pixel();
        $pixel->draw(new EmptyCanvasMock());
    }

    public function testDraw() {
        $canvas = new Canvas(new Dimension(100, 100));
        $pixel = new Pixel();

        $this->assertSame($canvas, $canvas->draw($pixel));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEqualThrowInvalidArgumnetException() {
        $pixel = new Pixel();
        $pixel->equals('invalid');
    }

    public function testEquals() {
        $pixel = new Pixel();
        $clone = clone $pixel;

        $this->assertTrue($pixel->equals(clone $pixel));

        $clone->move(100, 100);
        $this->assertFalse($pixel->equals($clone));

        $clone->move(0, 0);
        $clone->getColor()->setRed(255);
        $this->assertFalse($pixel->equals($clone));
    }

    public function testToString() {
        $this->assertInternalType('string', (string) new Pixel());
    }

}

