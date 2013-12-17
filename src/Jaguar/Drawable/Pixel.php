<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;
use Jaguar\CanvasInterface;
use Jaguar\Exception\DrawableException;

class Pixel extends AbstractStyledDrawable
{
    private $coordinate;

    /**
     * Construct new pixel object
     *
     * @param \Jaguar\Coordinate           $coordinate
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct(Coordinate $coordinate = null, ColorInterface $color = null)
    {
        parent::__construct($color);
        $this->setCoordinate($coordinate !== null ? $coordinate : new Coordinate());
    }

    /**
     * Set the pixel's coordinate
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Drawable\Pixel
     */
    public function setCoordinate(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    /**
     * Get pixel's coordinate
     *
     * @return \Jaguar\Coordinate
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * {@inheritdoc}
     */
    protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null)
    {

        $x = $this->getCoordinate()->getX();
        $y = $this->getCoordinate()->getY();
        $isStyle = ($style === null) ? false : true;
        $color = ($isStyle === true) ?
                $style->apply($canvas, $this)->getValue() :
                $this->getColor()->getValue();

        if (
                false == @imagesetpixel(
                        $canvas->getHandler()
                        , $x
                        , $y
                        , $color
                )
        ) {
            throw new DrawableException(sprintf(
                    'Faild To Draw The Pixel At (%s)', (string) $this
            ));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Pixel Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if (!$this->getCoordinate()->equals($other->getCoordinate())) {
            return false;
        }

        return true;
    }

    /**
     * Returns a string representation for this pixel object
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class() .
                "(x={$this->getCoordinate()->getX()},y={$this->getCoordinate()->getY()})"
                . (string) $this->getColor();
    }

    /**
     * Clone Pixel
     */
    public function __clone()
    {
        parent::__clone();
        $this->coordinate = clone $this->coordinate;
    }

}
