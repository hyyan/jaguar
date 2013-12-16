<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Gradient;

use Jaguar\Tests\JaguarTestCase;
use Jaguar\Canvas;
use Jaguar\Dimension;

abstract class AbstractGradientTest extends JaguarTestCase
{

    abstract protected function getGradient();

    /**
     * Get canvas instance
     *
     * @return \Jaguar\Canvas
     */
    public function getCanvas()
    {
        return new Canvas(new Dimension(10,10));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetStepThrowInvalidArgumentException()
    {
        $this->getGradient()->setStep(-5);
    }

}
