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

class Sepia extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $grayscale = new Grayscale();
        $colorize = new Colorize(new RGBColor(100, 50, 0));

        $grayscale->apply($canvas);
        $colorize->apply($canvas);
    }

}
