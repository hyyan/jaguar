<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Gradient;

use Jaguar\Gradient\LinearGradient;

class LinearGradientTest extends AbstractGradientTest
{

    protected function getGradient()
    {
        return new LinearGradient();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetTypeThrowInvalidArgumentException()
    {
        $this->getGradient()->setType('Will Fail');
    }

    public function testGenerate()
    {
        $canvas = $this->getCanvas();
        $gradient = $this->getGradient();

        $this->assertInstanceOf('\Jaguar\Gradient\LinearGradient', $gradient->generate($canvas));

        $gradient->setType(LinearGradient::GRADIENT_HORIZONTAL);
        $this->assertInstanceOf('\Jaguar\Gradient\LinearGradient', $gradient->generate($canvas));
    }

}
