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
use Jaguar\Drawable\StyleInterface;
use Jaguar\Drawable\Border\BorderIn;
use Jaguar\Box;
use Jaguar\Coordinate;
use Jaguar\Canvas;

class BorderOut implements BorderDrawerInterface
{

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas, Border $border, StyleInterface $style = null)
    {
        $size = $border->getSize();
        $new = new Canvas($canvas->getDimension()->translate($size, $size));

        $new->paste(
                $canvas
                , null
                , new Box(
                        $canvas->getDimension()->translate(0, 1)
                        , new Coordinate(($size) / 2, ($size) / 2)
                )
        );

        $in = new BorderIn();
        $in->draw($new, $border, $style);

        $canvas->destroy();
        $canvas->setHandler($new->getHandler());

        return $this;
    }

}
