<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Color;

use Jaguar\Tests\JaguarTestCase;

abstract class AbstractColorTest extends JaguarTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEqualsThrowInvalidArgumentException()
    {
        $this->getColor()->equals('Invalid Color Object');
    }

    public function testEquals()
    {
        $this->assertTrue($this->getColor()->equals($this->getColor()));
        $this->assertFalse($this->getColor()->equals(\Jaguar\Color\RGBColor::fromValue(16711680)));
    }

    public function testToString()
    {
        $this->assertInternalType('string', (string) $this->getColor());
    }

    abstract public function getColor();
}
