<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Flip;
use Jaguar\Action\ActionInterface;

class FlipTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Flip();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFlipDirectionThrowInvalidArgumentException()
    {
        $flip = new Flip();
        $flip->setFlipDirection('unsupported direction');
    }

    /**
     * @dataProvider actionProvider
     *
     * @param \Jaguar\Action\ActionInterface $action
     */
    public function testApply(ActionInterface $action)
    {
        $canvas = $this->getCanvas();
        $this->assertInstanceOf('\Jaguar\Action\ActionInterface', $action->apply($canvas));
    }

    public function actionProvider()
    {
        return array(
            array(new Flip(Flip::FLIP_HORIZONTAL)),
            array(new Flip(Flip::FLIP_VERTICAL)),
            array(new Flip(Flip::FLIP_BOTH))
        );
    }

}
