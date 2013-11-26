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

abstract class AbstractDrawableTest extends JaguarTestCase {

    /**
     * Get drawabale object
     * 
     * @return \Jaguar\Canvas\Drawable\DrawableInterface 
     */
    abstract public function getDrawable();

    /**
     * @expectedException \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function testDrawThrowCanvasEmptyException() {
        $canvas = new \Jaguar\Tests\Canvas\Mock\EmptyCanvasMock();
        $canvas->draw($this->getDrawable());
    }

    /**
     * @expectedException \Jaguar\Exception\Canvas\Drawable\DrawableException
     */
    public function testDrawThrowDrawableException() {
        $canvas = new \Jaguar\Tests\Canvas\Mock\CanvasMock();
        $canvas->draw($this->getDrawable());
    }

}

