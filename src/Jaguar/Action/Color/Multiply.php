<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Color;

use Jaguar\Action\AbstractAction;
use Jaguar\CanvasInterface;
use Jaguar\Color\RGBColor;

class Multiply extends AbstractAction
{
    private $color;

    /**
     * construct new colorize action
     *
     * @param \Jaguar\Color\RGBColor $color
     */
    public function __construct(RGBColor $color)
    {
        $this->setColor($color);
    }

    /**
     * Set color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Action\Color\Colorize
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
    protected function doApply(CanvasInterface $canvas)
    {
        imagefilter(
                $canvas->getHandler()
                , IMG_FILTER_COLORIZE
                , -(255 - $this->getColor()->getRed())
                , -(255 - $this->getColor()->getGreen())
                , -(255 - $this->getColor()->getBlue())
                , -(127 - $this->getColor()->getAlpha())
        );
    }

}
