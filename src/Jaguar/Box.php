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

class Box implements EqualsInterface
{
    private $BoxCoordinateObject;
    private $BoxDimensionObject;

    /**
     * Construct New Box Object
     *
     * @param \Jaguar\Dimension  $dimension
     * @param \Jaguar\Coordinate $coordinate
     */
    public function __construct(Dimension $dimension = null, Coordinate $coordinate = null)
    {
        $this->setDimension(($dimension === null) ? new Dimension(0, 0) : $dimension);
        $this->setCoordinate(($coordinate === null) ? new Coordinate(0, 0) : $coordinate);
    }

    /**
     * Set Box Coordinate
     *
     * The coordinate represent the (Top Left) position of the box
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Box
     */
    public function setCoordinate(Coordinate $coordinate)
    {
        $this->BoxCoordinateObject = $coordinate;

        return $this;
    }

    /**
     * Get Box Coordinate
     *
     * @return \Jaguar\Coordinate
     */
    public function getCoordinate()
    {
        return $this->BoxCoordinateObject;
    }

    /**
     * Set Box Dimension
     *
     * @param \Jaguar\Dimension $dimension
     *
     * @return \Jaguar\Box
     */
    public function setDimension(Dimension $dimension)
    {
        $this->BoxDimensionObject = $dimension;

        return $this;
    }

    /**
     * Get Box Dimension
     *
     * @return \Jaguar\Dimension
     */
    public function getDimension()
    {
        return $this->BoxDimensionObject;
    }

    /**
     * Scale the box by the given ratio
     *
     * @param number $ratio
     *
     * @return \Jaguar\Box
     */
    public function scale($ratio)
    {
        $this->getDimension()
                ->setWidth(
                        round($ratio * $this->getDimension()->getWidth())
                )->setHeight(
                round($ratio * $this->getDimension()->getHeight())
        );

        return $this;
    }

    /**
     *
     * @see \Jaguar\Coordinate::getX
     *
     * @codeCoverageIgnore
     * @return integer
     */
    public function getX()
    {
        return $this->getCoordinate()->getX();
    }

    /**
     *
     * @see \Jaguar\Coordinate::getY
     *
     * @codeCoverageIgnore
     * @return integer
     */
    public function getY()
    {
        return $this->getCoordinate()->getY();
    }

    /**
     *
     * @see \Jaguar\Dimension::getWidth
     *
     * @codeCoverageIgnore
     * @return integer
     */
    public function getWidth()
    {
        return $this->getDimension()->getWidth();
    }

    /**
     *
     * @see \Jaguar\Dimension::getHeight
     *
     * @codeCoverageIgnore
     * @return integer
     */
    public function getHeight()
    {
        return $this->getDimension()->getHeight();
    }

    /**
     * Resize the box
     *
     * @param integer $width
     * @param integer $height
     *
     * @return \Jaguar\Box
     *
     * @see \Jaguar\Dimension::resize
     * @codeCoverageIgnore
     */
    public function resize($width, $height)
    {
        $this->getDimension()->resize($width, $height);

        return $this;
    }

    /**
     * Translate the box dimension
     *
     * @param integer $dx
     * @param integer $dy
     *
     * @return \Jaguar\Box
     *
     * @see \Jaguar\Dimension::translate
     * @codeCoverageIgnore
     */
    public function translateDimension($dx, $dy)
    {
        $this->getDimension()->translate($dx, $dy);

        return $this;
    }

    /**
     * Move box's coordinate
     *
     * @param integer $x
     * @param integer $y
     *
     * @return \Jaguar\Box
     *
     * @see \Jaguar\Coordinate::move
     * @codeCoverageIgnore
     */
    public function move($x, $y)
    {
        $this->getCoordinate()->move($x, $y);

        return $this;
    }

    /**
     * Translate the box's coordinate
     *
     * @param integer $dx
     * @param integer $dy
     *
     * @return \Jaguar\Box
     *
     * @see \Jaguar\Coordinate::translate
     * @codeCoverageIgnore
     */
    public function translateCoordinate($dx, $dy)
    {
        $this->getCoordinate()->translate($dx, $dy);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof Box)) {
            throw new \InvalidArgumentException('Invalid Box Object');
        }

        if (
                ($other->getCoordinate()->equals($this->getCoordinate())) &&
                ($other->getDimension()->equals($this->getDimension()))
        ) {
            return true;
        }

        return false;
    }

    /**
     * Returns a string representation for the box object
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "["
                . "{$this->getDimension()},"
                . "{$this->getCoordinate()}"
                . "]";
    }

    /**
     * Clone Box
     */
    public function __clone()
    {
        $this->BoxCoordinateObject = clone $this->BoxCoordinateObject;
        $this->BoxDimensionObject = clone $this->BoxDimensionObject;
    }

}
