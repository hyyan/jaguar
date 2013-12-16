<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Gradient;

use Jaguar\Gradient\CircleGradient;

class CircleGradientTest extends AbstractGradientTest
{

    protected function getGradient()
    {
        return new CircleGradient();
    }

    public function testGenerate()
    {
        $this->assertInstanceOf(
                '\Jaguar\Gradient\CircleGradient'
                , $this->getGradient()->generate($this->getCanvas())
        );
    }

}
