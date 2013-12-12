<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Mirror;
use Jaguar\Action\ActionInterface;

class MirrorTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Mirror();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetDirectionThrowInvalidArgumentException()
    {
        $flip = new Mirror();
        $flip->setDirection('unsupported direction');
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
            array(new Mirror(Mirror::MIRROR_HORIZONTAL)),
            array(new Mirror(Mirror::MIRROR_VERTICAL))
        );
    }

}
