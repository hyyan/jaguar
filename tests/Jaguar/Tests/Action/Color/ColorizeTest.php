<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Color;

use Jaguar\Tests\Action\AbstractActionTest;
use Jaguar\Action\Color\Colorize;
use Jaguar\Color\RGBColor;

class ColorizeTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Colorize(new RGBColor());
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Color\Colorize'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
