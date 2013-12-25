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

class Outline implements TextDrawerInterface
{
    private $width;
    private $color;

    /**
     * construct new outline
     *
     * @param \Jaguar\Color\RGBColor $color
     * @param inetger                $width
     */
    public function __construct(RGBColor $color = null, $width = 0)
    {
        $this->setWidth($width)->setColor($color === null ? new RGBColor() : $color);
    }

    /**
     * Set outline width
     *
     * @param integer $width
     *
     * @return \Jaguar\Drawable\Text\Outline
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;

        return $this;
    }

    /**
     * Get outline width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set outline color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Drawable\Text\Outline
     */
    public function setColor(RGBColor $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get outline color
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
        $x = $text->getCoordinate()->getX();
        $y = $text->getCoordinate()->getY();

        $width = $this->getWidth();
        $outlineColor = $this->getColor()->getValue();

        $result = true;

        for ($xc = $x - abs($width); $xc <= $x + abs($width); $xc++) {
            for ($yc = $y - abs($width); $yc <= $y + abs($width); $yc++) {
                $result = @imagefttext(
                                $canvas->getHandler()
                                , $text->getFontSize()
                                , $text->getAngle()
                                , $xc
                                , $yc + $text->getFontSize()
                                , $outlineColor
                                , $text->getFont()
                                , $text->getString()
                                , array('linespacing' => $text->getLineSpacing())
                );
            }
        }

        return (boolean) ($result && @imagefttext(
                        $canvas->getHandler()
                        , $text->getFontSize()
                        , $text->getAngle()
                        , $text->getCoordinate()->getX()
                        , $text->getCoordinate()->getY() + $text->getFontSize()
                        , $text->getColor()->getValue()
                        , $text->getFont()
                        , $text->getString()
                        , array('linespacing' => $text->getLineSpacing())
        ));
    }

}
