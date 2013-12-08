<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Overlay;

use Jaguar\Action\Overlay\Vintage;
use Jaguar\Tests\Action\AbstractActionTest;

class VintageTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Vintage();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Overlay\Vintage'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
