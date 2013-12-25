<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Style;

use Jaguar\Drawable\StyleInterface;
use Jaguar\Drawable\AbstractStyledDrawable;
use Jaguar\CanvasInterface;
use Jaguar\Color\ColorInterface;
use Jaguar\Color\StyledColor;
use Jaguar\Color\TransparentColor;
use Jaguar\Exception\DrawableException;

class DashedlineStyle implements StyleInterface
{
    private $secondColor;
    private $sct;
    private $fct;

    /**
     * construct new dashedline style
     *
     * @param integer                      $fct   the first color show time
     * @param integer                      $sct   the second color show time
     * @param \Jaguar\Color\ColorInterface $color the second color
     *
     * @throws \InvalidArgumentException if the time <=0
     */
    public function __construct($fct = 1, $sct = 1, ColorInterface $color = null)
    {
        $this->setSecondColor(($color !== null) ? $color : new TransparentColor());
        $this->setFirstColorShowTime($fct);
        $this->setSecondColorShowTime($sct);
    }

    /**
     * Set second color to use when drawing the dashed line , where by default
     * the colo is transparent
     *
     * @param \Jaguar\Color\ColorInterface $color
     *
     * @return \Jaguar\Drawable\Style\DashedlineStyle
     */
    public function setSecondColor(ColorInterface $color)
    {
        $this->secondColor = $color;

        return $this;
    }

    /**
     * Get the second color
     *
     * @return \Jaguar\Color\ColorInterface
     */
    public function getSecondColor()
    {
        return $this->secondColor;
    }

    /**
     * Set the first color show time
     *
     * the color show time is a number which indicates how many time to show
     * the color before starting by showing the second color .
     *
     * for instance : 5 menas will draw five pixels with the first color (the
     * default drawable color) then draw n pixels using the second color
     *
     * @param integer $time
     *
     * @return \Jaguar\Drawable\Style\DashedlineStyle
     *
     * @throws \InvalidArgumentException if the time <=0
     */
    public function setFirstColorShowTime($time)
    {
        $this->assertShowTime($time);
        $this->fct = $time;

        return $this;
    }

    /**
     * Get the first color show time
     *
     * @return integer
     */
    public function getFirstColorShowTime()
    {
        return $this->fct;
    }

    /**
     * Set the second color show time
     *
     * @see \Jaguar\Drawable\Style\DashedlineStyle::setFirstColorShowTime
     *
     * @param integer $time
     *
     * @return \Jaguar\Drawable\Style\DashedlineStyle
     *
     * @throws \InvalidArgumentException if the time <=0
     */
    public function setSecondColorShowTime($time)
    {
        $this->assertShowTime($time);
        $this->sct = $time;

        return $this;
    }

    /**
     * Get the second color show time
     *
     * @return integer
     */
    public function getSecondColorShowTime()
    {
        return $this->sct;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas, AbstractStyledDrawable $drawable)
    {
        $fv = $drawable->getColor()->getValue();
        $sv = $this->getSecondColor()->getValue();
        $style = array_merge(
                array_fill(0, $this->getFirstColorShowTime(), $fv)
                , array_fill(0, $this->getSecondColorShowTime(), $sv)
        );

        if (false == @imagesetstyle($canvas->getHandler(), $style)) {
            throw new DrawableException('Could Not Apply The DashedLine Style');
        }

        return new StyledColor();
    }

    /** clone the style */
    public function __clone()
    {
        $this->secondColor = clone $this->secondColor;
    }

    /**
     * @param type $time
     *
     * @throws \InvalidArgumentException
     */
    private function assertShowTime($time)
    {
        if ($time <= 0) {
            throw new \InvalidArgumentException(
            'Show Time Must Be Greater Than Zero'
            );
        }
    }

}
