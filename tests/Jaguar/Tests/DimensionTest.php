<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests;

use Jaguar\Dimension;

class DimensionTest extends JaguarTestCase
{
    public function testEqualsThrowInvalidArgumentException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $d = new Dimension();
        $d->equals('Invalid');
    }

    public function testEquals()
    {
        $d = new Dimension();
        $this->assertTrue($d->equals(clone $d));
        $this->assertFalse($d->equals(new Dimension(50, 50)));
    }

    public function testToString()
    {
        $this->assertInternalType('string', (string) new Dimension());
    }

    public function testTranslate()
    {
        $d = new Dimension(50, 50);
        $d->translate(50, 50);

        $this->assertTrue($d->equals(new Dimension(100, 100)));
    }

    public function testSize()
    {
        $d = new Dimension();
        $newd = new Dimension(200, 200);

        $d->setSize($newd);
        $getD = $d->getSize(); // new dimension

        $this->assertNotSame($getD, $newd);
        $this->assertTrue($getD->equals($newd));
    }

}
