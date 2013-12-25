<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface;
use Jaguar\Color\ColorInterface;
use Jaguar\Color\TransparentColor;

class Rotate extends AbstractAction
{
    private $degree;
    private $color;

    /**
     * construct new rotate action
     *
     * @param float                        $degree
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct($degree = 0, ColorInterface $color = null)
    {
        $this->setDegree($degree);
        $this->setBackgroundColor($color === null ? new TransparentColor() : $color);
    }

    /**
     * Set degree
     *
     * @param float $degree
     *
     * @return \Jaguar\Action\Rotate
     */
    public function setDegree($degree)
    {
        $this->degree = (float) $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return float
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set background color
     *
     * @param \Jaguar\Color\ColorInterface $color
     *
     * @return \Jaguar\Action\Rotate
     */
    public function setBackgroundColor(ColorInterface $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get background color
     *
     * @return \Jaguar\Color\ColorInterface
     */
    public function getBackgroundColor()
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $result = imagerotate(
                $canvas->getHandler()
                , $this->getDegree()
                , $this->getBackgroundColor()->getValue()
                , 0
        );
        $canvas->setHandler($result);
    }

}
