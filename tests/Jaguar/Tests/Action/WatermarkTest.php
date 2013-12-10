<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Watermark;

class WatermarkTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Watermark($this->getCanvas());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCloneThrowRuntimeException()
    {
        clone $this->getAction();
    }

    /**
     * @expectedException \Jaguar\Exception\CanvasEmptyException
     */
    public function testSetWatermarkThrowCanvasEmptyException()
    {
        new Watermark(new \Jaguar\Tests\Mock\EmptyCanvasMock);
    }

    public function testApply()
    {
        $canvas = $this->getCanvas();
        $action = new Watermark($canvas->getCopy());
        $this->assertInstanceOf(
                '\Jaguar\Action\ActionInterface'
                , $action->apply($canvas)
        );
    }

}
