<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas\Drawable\Style;

use Jaguar\Canvas\CanvasInterface;
use Jaguar\Canvas\Drawable\DrawableInterface;
use Jaguar\Canvas\Drawable\StyleInterface;
use Jaguar\Color\StyledBrushedColor;
use Jaguar\Exception\Canvas\Drawable\DrawableException;

class Brush implements StyleInterface
{
    private $interval;
    private $brush;

    /**
     * Constrcut new brush
     *
     * @param \Jaguar\Canvas\CanvasInterface $canvas
     * @param array                          $interval
     */
    public function __construct(CanvasInterface $canvas, array $interval = null)
    {
        $this->brush = $canvas;
        $this->setInterval($interval !== null ? $interval : array(1));
    }

    /**
     * Set brush interval
     *
     * Interval is an array which contains 0's and 1's values where 1's indicate
     * when brush will be drawn and 0's indicate no drawing of the brush.
     *
     * @param array $interval
     */
    public function setInterval(array $interval)
    {
        $this->interval = $interval;
    }

    /**
     * Get brush interval
     *
     * @return array
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas, DrawableInterface $drawable)
    {
        if (
                false == @imagesetbrush(
                        $canvas->getHandler()
                        , $this->brush->getHandler()
                ) ||
                false == @imagesetstyle(
                        $canvas->getHandler()
                        , $this->getInterval()
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
