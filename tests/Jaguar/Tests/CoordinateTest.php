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

use Jaguar\Coordinate;

class CoordinateTest extends JaguarTestCase
{
    public function testEqualsThrowInvalidArgumentException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $c = new Coordinate();
        $c->equals('invalid');
    }

    public function testEquals()
    {
        $c = new Coordinate();
        $this->assertTrue($c->equals(clone $c));
        $this->assertFalse($c->equals(new Coordinate(10, 10)));
    }

    public function testToString()
    {
        $this->assertInternalType('string', (string) new Coordinate());
    }

    public function testTranslate()
    {
        $c = new Coordinate();
        $c->translate(50, 50);

        $this->assertTrue($c->equals(new Coordinate(50, 50)));
    }

    public function testLocation()
    {
        $c = new Coordinate();
        $newLocation = new Coordinate(50, 50);

        $c->setLocation($newLocation);
        $getNewLocation = $c->getLocation(); // new coordinate object

        $this->assertNotSame($getNewLocation, $newLocation);
        $this->assertTrue($getNewLocation->equals($newLocation));
    }

}
