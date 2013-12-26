<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Preset;

use Jaguar\CanvasInterface;
use Jaguar\Action\Color\Brightness;
use Jaguar\Action\Color\Contrast;
use Jaguar\Action\Color\Colorize;
use Jaguar\Color\RGBColor;
use Jaguar\Transformation;

class Canvas extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $transformation = new Transformation($canvas);

        $transformation
                ->apply(new Brightness(25))
                ->apply(new Contrast(25))
                ->apply(new Colorize(new RGBColor(50, 25, 0)))
                ->overlay($this->getOverlayCanvas('canvas.gd2'), 50);
    }

}
