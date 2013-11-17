<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas;

use Jaguar\Coordinate;
use Jaguar\EqualsInterface;
use Jaguar\Color\ColorInterface;
use Jaguar\Color\RGBColor;
use Jaguar\Exception\Canvas\CanvasEmptyException;
use Jaguar\Exception\Canvas\CanvasException;

class Pixel extends Coordinate implements Drawable, EqualsInterface {

    private $pixelColor;

    /**
     * Construct New Pixel Object
     * 
     * @param integer $x x pos
     * @param integer $y y pos
     * @param \Jaguar\Color\ColorInterface $color 
     */
    public function __construct($x = 0, $y = 0, ColorInterface $color = null) {
        parent::__construct($x, $y);
        $this->setColor($color === null ? new RGBColor(0, 0, 0) : $color);
    }

    /**
     * Get color
     * 
     * @return \Jaguar\Color\ColorInterface
     */
    public function getColor() {
        return $this->pixelColor;
    }

    /**
     * Set Color 
     * 
     * @param \Jaguar\Color\ColorInterface $color
     * 
     * @return \Jaguar\Canvas\Pixel 
     */
    public function setColor(ColorInterface $color) {
        $this->pixelColor = $color;
        return $this;
    }

    /**
     * Draw pixel on the given canvas
     * 
     * @param \Jaguar\Canvas\CanvasInterface $canavs
     * 
     * @return \Jaguar\Canvas\Pixel
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     * @throws \Jaguar\Exception\Canvas\CanvasException 
     */
    public function draw(CanvasInterface $canavs) {
        if (!$canavs->isHandlerSet()) {
            throw new CanvasEmptyException(sprintf(
                    "Can Not Draw Pixel At (%s) - Canvas Is Empty"
                    , (string) $this
            ));
        }

        $x = $this->getX();
        $y = $this->getY();
        if (
                false == @imagesetpixel(
                        $canavs->getHandler()
                        , $x
                        , $y
                        , $this->getColor()->getValue()
                )
        ) {
            throw new CanvasException(sprintf(
                    "Faild To Draw The Pixel At (%s)"
                    , (string) $this
            ));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other) {
        
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Pixel Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if (!$this->getColor()->equals($other->getColor())) {
            return false;
        }

        return true;
    }

    /**
     * Returns a string representation for this pixel object
     * 
     * @return string
     */
    public function __toString() {
        return get_called_class() .
                "(x={$this->getX()},y={$this->getY()})"
                . (string) $this->getColor();
    }

    /**
     * Clone Pixel
     */
    public function __clone() {
        $this->pixelColor = clone $this->pixelColor;
    }

}

