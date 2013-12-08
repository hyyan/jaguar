<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Overlay;

use Jaguar\Action\Overlay\Monopin;
use Jaguar\Tests\Action\AbstractActionTest;

class MonopinTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Monopin();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Overlay\Monopin'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
