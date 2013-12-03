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

use Jaguar\Format\Gd;
use Jaguar\Dimension;
use Jaguar\Box;
use Jaguar\Tests\AbstractCanvasTest;

class GdTest extends AbstractCanvasTest
{
    protected function getCanvas()
    {
        return new Gd(new Dimension(300, 300));
    }

    protected function getPalleteFile()
    {
        return $this->getFixture('pallete/pallete.gd2');
        ;
    }

    protected function getInvalidCanvasFile()
    {
        return $this->getFixture('invalid/invalid-gd.gd2');
        ;
    }

    protected function getCanvasFile()
    {
        return $this->getFixture('gd.gd2');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromFileThrowInvalidArgumentExceptionOnNonGd()
    {
        $this->getCanvas()->fromFile($this->getFixture('sky.jpg'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIsGdFileThrowInvalidArgumentException()
    {
        $c = $this->getCanvas();
        $c::isGdFile('not found');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPartFromFileThrowInvalidArgumentException()
    {
        $this->getCanvas()->partFromFile(
                'non readable file'
                , new Box(new Dimension(50, 50))
        );
    }

    /**
     * @expectedException \Jaguar\Exception\CanvasCreationException
     */
    public function testPartFromFileThrowCanvasCreationException()
    {
        $this->getCanvas()->partFromFile(
                $this->getInvalidCanvasFile()
                , new Box(new Dimension(50, 50))
        );
    }

    public function testPartFromFile()
    {
        $c = $this->getCanvas()->partFromFile(
                $this->getCanvasFile()
                , new Box(new Dimension(50, 50))
        );
        $this->assertTrue($c->isHandlerSet());
        $this->assertTrue($c->getDimension()->equals(new Dimension(50, 50)));
    }

}
