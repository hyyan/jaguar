<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

class Coordinate implements EqualsInterface
{
    private $x;
    private $y;

    /**
     * Construct New Coordinate Object
     *
     * @param integer $x x pos
     * @param integer $y y pos
     */
    public function __construct($x = 0, $y = 0)
    {
        $this->move($x, $y);
    }

    /**
     * Set X Position
     *
     * @param integer $x
     *
     * @return \Jaguar\Coordinate
     */
    public function setX($x)
    {
        $this->x = (integer) floor($x);

        return $this;
    }

    /**
     * Get X Position
     *
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set Y Position
     *
     * @param integer $y
     *
     * @return \Jaguar\Coordinate
     */
    public function setY($y)
    {
        $this->y = (integer) floor($y);

        return $this;
    }

    /**
     * Get Y position
     *
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Chage the current coordinate location to match the passed coordinate
     * location
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Coordinate
     */
    public function setLocation(Coordinate $coordinate)
    {
        return $this->setX($coordinate->getX())->setY($coordinate->getY());
    }

    /**
     * Get New Coordinate Object with same location of the current one
     *
     * @return \Jaguar\Coordinate
     */
    public function getLocation()
    {
        return new Coordinate($this->getX(), $this->getY());
    }

    /**
     * Moves this coordinate to the specified location in the (x,y)
     * coordinate plane.
     *
     * @param integer $x
     * @param integer $y
     *
     * @return \Jaguar\Coordinate
     */
    public function move($x, $y)
    {
        return $this->setX($x)->setY($y);
    }

    /**
     * Translates this point, at location (x,y),
     * by {dx} along the {x} axis and {dy}
     * along the {y} axis so that it now represents the coordinate
     * {x+dx,y+dy)}.
     *
     * @param integer $x the distance to move this coordinate
     *                   along the X axis
     * @param integer $y the distance to move this coordinate
     *                   along the Y axis
     *
     * @return \Jaguar\Coordinate
     */
    public function translate($dx, $dy)
    {
        return $this->setX($dx + $this->getX())->setY($dy + $this->getY());
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Coordinate Object');
        }

        if (
                ($other->getX() == $this->getX()) &&
                ($other->getY() == $this->getY())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Returns a string representation of the current coordinate object
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "["
                . "x={$this->getX()},"
                . "y={$this->getY()}"
                . "]";
    }

}
