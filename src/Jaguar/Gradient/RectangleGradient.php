<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Gradient;

use Jaguar\CanvasInterface;
use Jaguar\Drawable\Rectangle;

class RectangleGradient extends AbstractGradient
{

    /**
     * {@inheritdoc}
     */
    protected function doGenerate(CanvasInterface $canvas)
    {
        $width = $canvas->getWidth();
        $height = $canvas->getHeight();
        $n = max($width, $height) / 2;

        $rect = new Rectangle();
        $rect->fill(true);

        for ($i = 0; $i < $n; $i+=$this->getStep() + 1) {

            $rect->getStart()->move(
                    ($i * $width / $height)
                    , ($i * $height / $width)
            );
            $rect->getDimension()->resize(
                    ($width - ($i * $width / $height)) - $rect->getStart()->getX()
                    , ($height - ($i * $height / $width)) - $rect->getStart()->getY()
            );
            $rect->setColor($this->getColor(($i / $n)))->draw($canvas);
        }
    }

}
