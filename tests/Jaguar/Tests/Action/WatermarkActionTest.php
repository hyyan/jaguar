<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\WatermarkAction;

class WatermarkActionTest extends AbstractActionTest
{

    public function getAction()
    {
        return new WatermarkAction($this->getCanvas());
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
        new WatermarkAction(new \Jaguar\Tests\Mock\EmptyCanvasMock);
    }

    public function testApply()
    {
        $canvas = $this->getCanvas();
        $action = new WatermarkAction($canvas->getCopy());
        $this->assertInstanceOf(
                '\Jaguar\Action\ActionInterface'
                , $action->apply($canvas)
        );
    }

}
