<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable;

use Jaguar\Drawable\Polygon;
use Jaguar\Coordinate;

class PolygonTest extends FilledDrawableTest
{

    public function getDrawable()
    {
        return new Polygon($this->getCoordinates());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNumberThrowInvalidArgumentException()
    {
        $this->getDrawable()->setNumber(0);
    }

    /**
     * @expectedException \OutOfBoundsException
     */
    public function testSetNumberThrowOutOfBoundsException()
    {
        $this->getDrawable()->setNumber(20);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testDrawThrowRuntimeException()
    {
        $poly = new Polygon();
        $poly->draw($this->getCanvas());
    }

    public function testAddCooridnateRaiseTheNumber()
    {
        $poly = $this->getDrawable();
        $poly->addCoordinate(new Coordinate(200, 200));

        $this->assertEquals(4, count($poly->getCoordinates()));
    }

    public function testEquals()
    {
        $poly = $this->getDrawable();
        $clone = clone $poly;

        $this->assertTrue($poly->equals($clone));

        $coordinates = $clone->getCoordinates();
        unset($coordinates[0]);

        $this->assertFalse($poly->equals($clone));

        $clone->setCoordinate($this->getCoordinates());

        $coordinates = $clone->getCoordinates();
        $coordinates[0]->move(50, 100);

        $this->assertFalse($poly->equals($clone));

        $clone->setCoordinate($this->getCoordinates());
        $clone->getColor()->setRed(255);

        $this->assertFalse($poly->equals($clone));
    }

    /**
     * Get Polygon Points Array
     *
     * @return array
     */
    public function getCoordinates()
    {
        return new \ArrayObject(array(
            new Coordinate(0, 0),
            new Coordinate(50, 100),
            new Coordinate(200, 100),
        ));
    }

}
