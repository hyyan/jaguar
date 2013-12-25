<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\Exception\DrawableException;
use Jaguar\CanvasInterface;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;

class Polygon extends FilledDrawable
{
    private $coordinates = null;
    private $count = 0;

    /**
     * construct new polygon
     *
     * @param \ArrayObject                 $coordinates
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct(\ArrayObject $coordinates = null, ColorInterface $color = null)
    {
        parent::__construct($color);
        $this->coordinates = new \ArrayObject();
        if (null !== $coordinates) {
            $this->setCoordinate($coordinates);
        }
    }

    /**
     * Add new coordinate
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Drawable\Polygon
     */
    public function addCoordinate(Coordinate $coordinate)
    {
        $this->coordinates[] = $coordinate;
        $this->setNumber(count($this->coordinates));

        return $this;
    }

    /**
     * Add an array of coordinates
     *
     * @param \ArrayObject $coordinates
     *
     * @return \Jaguar\Drawable\Polygon
     */
    public function setCoordinate(\ArrayObject $coordinates)
    {
        $this->coordinates = $coordinates;
        $this->setNumber(count($coordinates));

        return $this;
    }

    /**
     * Get polygon coordinates array
     *
     * @return \ArrayObject
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set Polygon coordinates number
     *
     * @param integer $num the number of coordinates which will be drawn
     *
     * @return \Jaguar\Drawable\Polygon
     *
     * @throws \InvalidArgumentException
     * @throws \OutOfBoundsException
     */
    public function setNumber($num)
    {
        $num = (int) $num;
        if ($num <= 0) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid Number "%s" - Polygon Coordinates Number Must Be '
                    . 'Greater Than Zero'
                    , $num
            ));
        }
        $count = count($this->getCoordinates());
        if ($num > $count) {
            throw new \OutOfBoundsException(sprintf(
                    'Given Coodrinates Number "%s" Is Greater Than The Actual '
                    . 'Coordinates Array Size "%s"'
                    , $num, $count
            ));
        }
        $this->count = $num;

        return $this;
    }

    /**
     * Get ploygon points number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Polygon Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if (count($this->getCoordinates()) != count($other->getCoordinates())) {
            return false;
        }

        $count = count($this->getCoordinates());
        $cc = $this->getCoordinates();
        $oc = $other->getCoordinates();

        for ($x = 0; $x < $count; $x++) {
            if (!$cc[$x]->equals($oc[$x])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns a string representation for the current Polygon Object
     *
     * @return string
     */
    public function __toString()
    {
        $result = get_called_class() . "({$this->getNumber()}){";
        foreach ($this->getCoordinates() as $coordinate) {
            $result.= sprintf("\n%s ,", (string) $coordinate);
        }

        return $result . "}";
    }

    /**
     * Clone Polygon
     */
    public function __clone()
    {
        parent::__clone();
        $cloneCoordinate = array();
        foreach ($this->getCoordinates() as $coordinate) {
            $cloneCoordinate[] = clone $coordinate;
        }
        $this->coordinates = new \ArrayObject($cloneCoordinate);
    }

    /**
     * {@inheritdoc}
     */
    protected function drawFilled(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->drawPolygon($canvas, $style, true);
    }

    /**
     * {@inheritdoc}
     */
    protected function drawNonFilled(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->drawPolygon($canvas, $style, false);
    }

    /**
     *
     * @param \Jaguar\CanvasInterface         $canvas
     * @param \Jaguar\Drawable\StyleInterface $style
     * @param boolean                         $filled
     *
     * @throws \RuntimeException
     * @throws \Jaguar\Exception\DrawableException
     */
    private function drawPolygon(
    CanvasInterface $canvas, StyleInterface $style = null, $filled = false)
    {
        $this->assertPointsArrayLength();
        $result = false;

        $color = (is_null($style)) ?
                $this->getColor()->getValue() :
                $style->apply($canvas, $this)->getValue();

        $coordinates = array();
        foreach ($this->getCoordinates() as $coordinate) {
            $coordinates[] = $coordinate->getx();
            $coordinates[] = $coordinate->getY();
        }

        if (true === $filled) {
            $result = @imagefilledpolygon(
                            $canvas->getHandler()
                            , $coordinates
                            , $this->getNumber()
                            , $color
            );
        } else {
            $result = @imagepolygon(
                            $canvas->getHandler()
                            , $coordinates
                            , $this->getNumber()
                            , $color
            );
        }

        if (false == $result) {
            throw new DrawableException(sprintf(
                    'Faild To Draw Polygon "%s"', (string) $this
            ));
        }
    }

    private static $MIN_LENGTH = 3;

    /**
     * Assert Points Array Length
     *
     * @throws \RuntimeException
     */
    private function assertPointsArrayLength()
    {
        if (count($this->getCoordinates()) < self::$MIN_LENGTH) {
            throw new \RuntimeException(sprintf(
                    'There Must Be At Least "%s" Coordinates To Draw A Polygon'
                    , self::$MIN_LENGTH
            ));
        }
    }

}
