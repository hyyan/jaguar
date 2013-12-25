<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Style;

use Jaguar\CanvasInterface;
use Jaguar\Drawable\AbstractStyledDrawable;
use Jaguar\Drawable\StyleInterface;
use Jaguar\Color\StyledBrushedColor;
use Jaguar\Exception\DrawableException;

class Brush implements StyleInterface
{
    private $st;
    private $ht;
    private $brush;

    /**
     * construct new brush
     *
     * @param \Jaguar\CanvasInterface $canvas
     * @param integer                 $show
     * @param integer                 $hide
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(CanvasInterface $canvas, $show = 1, $hide = 0)
    {
        $this->brush = $canvas;
        $this->setInterval($show, $hide);
    }

    /**
     * Set show time
     *
     * @param integer $time
     *
     * @return \Jaguar\Drawable\Style\Brush
     *
     * @throws \InvalidArgumentException if the time <=0
     */
    public function setShowTime($time)
    {
        if ($time <= 0) {
            throw new \InvalidArgumentException(
            'Show Time Must Be Greater Than Zero'
            );
        }
        $this->st = (int) $time;

        return $this;
    }

    /**
     * Get show time
     *
     * @return integer
     */
    public function getShowTime()
    {
        return $this->st;
    }

    /**
     * Set hide time
     *
     * @param integer $time
     *
     * @return \Jaguar\Drawable\Style\Brush
     *
     * @throws \InvalidArgumentException if the time <0
     */
    public function setHideTime($time)
    {
        if ($time < 0) {
            throw new \InvalidArgumentException(
            'Hide Time Must Be Zero Or Greater Than Zero'
            );
        }
        $this->ht = (int) $time;

        return $this;
    }

    /**
     * Get hide time
     *
     * @return integer
     */
    public function getHideTime()
    {
        return $this->ht;
    }

    /**
     * Set show hide interval
     *
     * @param integer $show
     * @param integer $hide
     *
     * @return \Jaguar\Drawable\Style\Brush
     *
     * @throws \InvalidArgumentException
     */
    public function setInterval($show, $hide)
    {
        return $this->setShowTime($show)->setHideTime($hide);
    }

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas, AbstractStyledDrawable $drawable)
    {
        $interval = array_merge(
                array_fill(0, $this->getShowTime(),1)
                , $this->getHideTime() == 0 ?
                        array() :
                        array_fill(0, $this->getHideTime(), 0)
        );

        if (
                false == @imagesetstyle(
                        $canvas->getHandler()
                        , $interval
                ) ||
                false == @imagesetbrush(
                        $canvas->getHandler()
                        , $this->brush->getHandler()
                )
        ) {
            throw new DrawableException('Could Not Set The Brush And Interval');
        }

        return new StyledBrushedColor();
    }

    /**
     * Disable Brush Clone
     *
     * @throws \RuntimeException
     */
    public function __clone()
    {
        throw new \RuntimeException('Clone Is Not Possible On Brush');
    }

}
