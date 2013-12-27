<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Preset;

use Jaguar\Action\Color\Brightness;
use Jaguar\Action\Color\Contrast;
use Jaguar\Action\Color\Colorize;
use Jaguar\Color\RGBColor;
use Jaguar\Transformation;

class Velvet extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(\Jaguar\CanvasInterface $canvas)
    {
        $transformation = new Transformation($canvas);
        $transformation->apply(new Brightness(5))
                ->apply(new Contrast(25))
                ->apply(new Colorize(new RGBColor(0, 45, 65)))
                ->overlay($this->getOverlayCanvas('noise.gd2'), 45)
                ->overlay($this->getOverlayCanvas('vignette.gd2'), 50);
    }

}
