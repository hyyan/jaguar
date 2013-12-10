<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Blur;

use Jaguar\Tests\Action\AbstractActionTest;
use Jaguar\Action\Blur\BoxBlur;

class BoxBlurTest extends AbstractActionTest
{

    public function getAction()
    {
        return new BoxBlur();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Blur\BoxBlur'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
