<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Blur;

use Jaguar\Action\Blur\GaussianBlur;
use Jaguar\Tests\Action\AbstractActionTest;

class GaussianBlurTest extends AbstractActionTest
{

    public function getAction()
    {
        return new GaussianBlur();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Blur\GaussianBlur'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
