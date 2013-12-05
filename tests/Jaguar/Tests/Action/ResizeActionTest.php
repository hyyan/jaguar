<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\ResizeAction;
use Jaguar\Dimension;

class ResizeActionTest extends AbstractActionTest
{

    public function actionProvider()
    {
        return array(
            array(new ResizeAction(new Dimension(200, 200)), new Dimension(200, 200)),
            array(new ResizeAction(new Dimension(200, 200)), new Dimension(50, 50))
        );
    }

    public function testSetGetDimension()
    {
        $action = new ResizeAction(new Dimension(200, 200));
        $this->assertInstanceOf('\Jaguar\Dimension', $action->getDimension());
    }

}
