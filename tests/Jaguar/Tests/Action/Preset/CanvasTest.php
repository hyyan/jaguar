<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Preset;

use Jaguar\Tests\Action\AbstractActionTest;
use Jaguar\Action\Preset\Canvas;

class CanvasTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Canvas();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Preset\Canvas'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
