<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Format;

use Jaguar\Format\Jpeg;
use Jaguar\Dimension;
use Jaguar\Tests\CompressableCanvasTest;

class JpegTest extends CompressableCanvasTest
{
    protected function getCanvas()
    {
        return new Jpeg(new Dimension(300, 300));
    }

    protected function getPalleteFile()
    {
        return $this->getFixture('pallete/pallete.jpeg');
    }

    protected function getInvalidCanvasFile()
    {
        return $this->getFixture('invalid/invalid-sky.jpg');
        ;
    }

    protected function getCanvasFile()
    {
        return $this->getFixture('sky.jpg');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromFileThrowInvalidArgumentExceptionOnNonJpeg()
    {
        $this->getCanvas()->fromFile($this->getFixture('google.png'));
    }

}
