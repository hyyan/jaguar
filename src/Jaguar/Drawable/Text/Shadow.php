<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Text;

use Jaguar\Color\RGBColor;
use Jaguar\CanvasInterface;
use Jaguar\Drawable\Text;

class Shadow implements TextDrawerInterface
{
    private $x;
    private $y;
    private $color;

    /**
     * construct new shadow object
     *
     * @param \Jaguar\Color\RGBColor $color
     * @param integer                $x
     * @param integer                $y
     */
    public function __construct(RGBColor $color = null, $x = 0, $y = 0)
    {
        $this->setOffset($x, $y)->setColor($color === null ? new RGBColor() : $color);
    }

    /**
     * Set x offset
     *
     * @param integer $x
     *
     * @return \Jaguar\Drawable\Text\Shadow
     */
    public function setXOffset($x)
    {
        $this->x = (int) $x;

        return $this;
    }

    /**
     * Get x offset
     *
     * @return integer
     */
    public function getXOffset()
    {
        return $this->x;
    }

    /**
     * Set y offset
     *
     * @param integer $y
     *
     * @return \Jaguar\Drawable\Text\Shadow
     */
    public function setYOffset($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y offset
     *
     * @return integer
     */
    public function getYOffset()
    {
        return $this->y;
    }

    /**
     * Set offset
     *
     * @param integer $x
     * @param integer $y
     *
     * @return \Jaguar\Drawable\Text\Shadow
     */
    public function setOffset($x, $y)
    {
        return $this->setXOffset($x)->setYOffset($y);
    }

    /**
     * Set color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Drawable\Text\Shadow
     */
    public function setColor(RGBColor $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas, Text $text)
    {

        // draw shadow
        return (boolean) (
                @imagefttext(
                        $canvas->getHandler()
                        , $text->getFontSize()
                        , $text->getAngle()
                        , $text->getCoordinate()->getX() + $this->getXOffset()
                        , $text->getCoordinate()->getY() + $this->getYOffset() + $text->getFontSize()
                        , $this->getColor()->getValue()
                        , $text->getFont()
                        , $text->getString()
                        , array('linespacing' => $text->getLineSpacing())
                ) && @imagefttext(
                        $canvas->getHandler()
                        , $text->getFontSize()
                        , $text->getAngle()
                        , $text->getCoordinate()->getX()
                        , $text->getCoordinate()->getY() + $text->getFontSize()
                        , $text->getColor()->getValue()
                        , $text->getFont()
                        , $text->getString()
                        , array('linespacing' => $text->getLineSpacing())
                )
       );
    }

}
