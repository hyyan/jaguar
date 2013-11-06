<?php

namespace Jaguar\Tests\Canvas;

use Jaguar\Canvas\Png;
use Jaguar\Dimension;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class PngTest extends CompressableCanvasTest {

    protected function getCanvas() {
        return new Png(new Dimension(300, 300));
    }

    protected function getPalleteFile() {
        return $this->getFixture('pallete/pallete.png');
    }

    protected function getInvalidCanvasFile() {
        return $this->getFixture('invalid/invalid-google.png');
        ;
    }

    protected function getCanvasFile() {
        return $this->getFixture('google.png');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromFileThrowInvalidArgumentExceptionOnNonPng() {
        $this->getCanvas()->fromFile($this->getFixture('sky.jpg'));
    }

    /**
     * @expectedException \Jaguar\Exception\Canvas\CanvasOutputException
     */
    public function testFromFileThrowCanvasCreationExceptionWhenAlphaSavingFails() {
        $c = new Mock\PngMock();
        $c->setSaveAlpha(true);
        $c->save();
    }

}

