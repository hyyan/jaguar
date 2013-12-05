<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\FlipAction;

class FlipActionTest extends AbstractActionTest
{

    public function actionProvider()
    {
        return array(
            array(new FlipAction(FlipAction::FLIP_HORIZONTAL)),
            array(new FlipAction(FlipAction::FLIP_VERTICAL)),
            array(new FlipAction(FlipAction::FLIP_BOTH))
        );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFlipDirectionThrowInvalidArgumentException()
    {
        $flip = new FlipAction();
        $flip->setFlipDirection('unsupported direction');
    }

}
