<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Preset;

use Jaguar\Action\Preset\Dreamy;
use Jaguar\Tests\Action\AbstractActionTest;

class DreamyTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Dreamy();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Preset\Dreamy'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
