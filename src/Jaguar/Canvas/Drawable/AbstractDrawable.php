<?php

/**
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas\Drawable;

use Jaguar\Canvas\CanvasInterface;
use Jaguar\Color\ColorInterface;
use Jaguar\Color\RGBColor;

abstract class AbstractDrawable implements DrawableInterface {

    private $color;

    /**
     * Constrcut new drawable object
     * 
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct(ColorInterface $color = null) {
        $this->setColor($color !== null ? $color : new RGBColor());
    }

    /**
     * Get color
     * 
     * @return \Jaguar\Color\ColorInterface
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Set Color 
     * 
     * @param \Jaguar\Color\ColorInterface $color
     * 
     * @return \Jaguar\Canvas\Drawable\AbstractDrawable 
     */
    public function setColor(ColorInterface $color) {
        $this->color = $color;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other) {

        if ($other instanceof DrawableInterface) {
            throw new \InvalidArgumentException('Invalid Drawable Object');
        }

        return $this->getColor()->equals($other->getColor());
    }

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas, StyleInterface $style = null) {
        if (!$canvas->isHandlerSet()) {
            throw new CanvasEmptyException(sprintf(
                    'Can Not Draw Drawable (%s) - Canvas Is Empty'
                    , (string) $this
            ));
        }
        $this->doDraw($canvas, $style);
        return $this;
    }

    /**
     * @see \Jaguar\Canvas\Drawable\AbstractDrawable::draw
     */
    abstract protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null);

    /** clone the drawable */
    public function __clone() {
        $this->color = clone $this->color;
    }

}

