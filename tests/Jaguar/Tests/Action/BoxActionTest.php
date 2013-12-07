<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\BoxAction;
use Jaguar\Action\Flip;
use Jaguar\Box;
use Jaguar\Dimension;

class BoxActionTest extends AbstractActionTest
{

    public function getAction()
    {
        return new BoxAction(new Flip(), new Box(new Dimension(50, 50)));
    }

    public function testApply()
    {
        $canvas = $this->getCanvas();
        $action = $this->getAction();

        $action->invertSelection(true);
        $this->assertInstanceOf(
                '\Jaguar\Action\BoxAction'
                , $action->apply($canvas)
        );

        $action->invertSelection(false);
        $this->assertInstanceOf(
                '\Jaguar\Action\BoxAction'
                , $action->apply($canvas)
        );
    }

}
