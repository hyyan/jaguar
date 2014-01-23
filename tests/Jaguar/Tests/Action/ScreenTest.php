<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Screen;

class ScreenTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Screen();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSizeThrowInvalidArgumentException()
    {
        $this->getAction()->setSize(1);
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Screen'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
