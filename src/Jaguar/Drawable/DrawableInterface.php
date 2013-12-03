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

use Jaguar\CanvasInterface;
use Jaguar\Color\ColorInterface;
use Jaguar\EqualsInterface;

interface DrawableInterface extends EqualsInterface
{

    /**
     * Set drawable color
     *
     * @param \Jaguar\Color\ColorInterface $color
     * 
     * @return \Jaguar\Drawable\DrawableInterface
     */
    public function setColor(ColorInterface $color);

    /**
     * Get drawable's Color
     *
     * @return \Jaguar\Color\ColorInterface
     */
    public function getColor();

    /**
     * Set line thickness
     * 
     * @param integer $thickness 
     * 
     * @return \Jaguar\Drawable\DrawableInterface
     * 
     * @throws \InvalidArgumentException if thickness <=0
     */
    public function setLineThickness($thickness);

    /**
     * Get line thickness
     * 
     * @return integer 
     */
    public function getLineThickness();

    /**
     * Draw the drawable object on the given canvas using the given style
     *
     * @param \Jaguar\CanvasInterface $canvas
     * @param \Jaguar\Shape\StyleInterface   $style
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     * @throws \Jaguar\Exception\DrawableException
     */
    public function draw(CanvasInterface $canvas, StyleInterface $style = null);
}
