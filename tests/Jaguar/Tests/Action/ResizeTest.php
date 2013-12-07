<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Resize;
use Jaguar\Dimension;
use Jaguar\Action\ActionInterface;

class ResizeTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Resize();
    }

    public function actionProvider()
    {
        return array(
            array(
                new Resize(new Dimension(200, 200))
                , new Dimension(200, 200)
            ),
            array(
                new Resize(new Dimension(50, 50))
                , new Dimension(50, 50)
            )
        );
    }

    /**
     * @dataProvider actionProvider
     *
     * @param \Jaguar\Action\ActionInterface $action
     * @param \Jaguar\Dimension              $dimension
     */
    public function testApply(ActionInterface $action, Dimension $dimension)
    {
        $canvas = $this->getCanvas();
        $this->assertInstanceOf(
                '\Jaguar\Action\ActionInterface'
                , $action->apply($canvas)
        );
        $this->assertTrue($canvas->getDimension()->equals($dimension));
    }

}
