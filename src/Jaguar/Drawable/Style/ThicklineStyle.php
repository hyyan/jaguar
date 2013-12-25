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
use Jaguar\Canvas;
use Jaguar\Drawable\Style\Brush;
use Jaguar\Dimension;

class ThicklineStyle implements StyleInterface
{
    private $thickness;
    private $show;
    private $hide;
    private $canvas;

    /**
     * construct new Thickline style
     *
     * @param integer                      $thickness
     * @param \Jaguar\Color\ColorInterface $color
     * @param integer                      $st        show time
     * @param integer                      $ht        hide time
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($thickness = 2, $show = 1, $hide = 0)
    {
        $this->setThickness($thickness);
        $this->setInterval($show, $hide);
    }

    /**
     * Set thickness
     *
     * @param integer $thickness
     *
     * @return \Jaguar\Drawable\Style\ThicklineStyle
     *
     * @throws \InvalidArgumentException if the thickness <=0
     */
    public function setThickness($thickness)
    {
        if ($thickness <= 0) {
            throw new \InvalidArgumentException(
            'Line Thickness Must Be Greater Than Zero'
            );
        }
        $this->thickness = $thickness;

        return $this;
    }

    /**
     * Get thickness
     *
     * @return integer
     */
    public function getThickness()
    {
        return $this->thickness;
    }

    /**
     * Set interval
     *
     * @param integer $show
     * @param integer $hide
     *
     * @return \Jaguar\Drawable\Style\ThicklineStyle
     */
    public function setInterval($show, $hide)
    {

        if ($show <= 0) {
            throw new \InvalidArgumentException(
            'Show Time Must Be Greater Than Zero'
            );
        }

        if ($hide < 0) {
            throw new \InvalidArgumentException(
            'Hide Time Must Be Zero Or Greater Than Zero'
            );
        }

        $this->show = $show;
        $this->hide = $hide;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas, AbstractStyledDrawable $drawable)
    {
        $this->canvas = new Canvas(
                new Dimension($this->getThickness(), $this->getThickness())
        );
        $this->canvas->fill($drawable->getColor());
        $style = new Brush($this->canvas, $this->show, $this->hide);

        return $style->apply($canvas, $drawable);
    }
}
