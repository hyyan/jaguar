<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\CropAction;
use Jaguar\Dimension;
use Jaguar\Box;

class CropActionTest extends AbstractActionTest
{

    public function actionProvider()
    {
        return array(
            array(new CropAction()),
            array(new CropAction(new Box(new Dimension(500, 500))))
        );
    }

    public function testSetGetBox()
    {
        $action = new CropAction();
        $this->assertSame($action, $action->setBox(new Box()));
        $this->assertInstanceOf('\Jaguar\Box', $action->getBox());
    }

}
