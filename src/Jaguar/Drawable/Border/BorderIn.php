<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Border;

use Jaguar\Drawable\Border;
use Jaguar\CanvasInterface;
use Jaguar\Drawable\Rectangle;
use Jaguar\Drawable\StyleInterface;

class BorderIn implements BorderDrawerInterface
{

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas, Border $border, StyleInterface $style = null)
    {
        $rect = new Rectangle($canvas->getDimension());
        $color = ($style) ? $style->apply($canvas, $border) : $border->getColor();

        $rect->setColor($color)
                ->setLineThickness($border->getSize())
                ->draw($canvas);

        return $this;
    }

}
