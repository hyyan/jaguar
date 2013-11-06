<?php

namespace Jaguar\Tests\Canvas;

use Jaguar\Canvas\Gif;
use Jaguar\Dimension;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class GifTest extends AbstractCanvasTest {

    protected function getCanvas() {
        return new Gif(new Dimension(300, 300));
    }

    protected function getPalleteFile() {
        return $this->getFixture('pallete/pallete.gif');
    }

    protected function getInvalidCanvasFile() {
        return $this->getFixture('invalid/invalid-linux.gif');
        ;
    }

    protected function getCanvasFile() {
        return $this->getFixture('linux.gif');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromFileThrowInvalidArgumentExceptionOnNonGif() {
        $this->getCanvas()->fromFile($this->getFixture('sky.jpg'));
    }

}

