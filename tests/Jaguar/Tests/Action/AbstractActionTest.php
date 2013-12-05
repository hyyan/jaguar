<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Tests\JaguarTestCase;
use Jaguar\Action\ActionInterface;

abstract class AbstractActionTest extends JaguarTestCase
{

    /**
     * Action Provider
     * 
     * @return array
     */
    abstract public function actionProvider();

    /**
     * Get canvas instance
     * 
     * @return \Jaguar\Canvas
     */
    public function getCanvas()
    {
        return new \Jaguar\Canvas(new \Jaguar\Dimension(100, 100));
    }

    /**
     * @dataProvider actionProvider
     * 
     * @expectedException \Jaguar\Exception\CanvasEmptyException
     */
    public function testApplyThrowCanvasEmptyException(ActionInterface $action)
    {
       $action->apply(new \Jaguar\Tests\Mock\EmptyCanvasMock());
    }

    /**
     * @dataProvider actionProvider
     * 
     * @param \Jaguar\Action\ActionInterface $action
     */
    public function testApply(ActionInterface $action)
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\ActionInterface'
                , $action->apply($this->getCanvas())
        );
    }

}
