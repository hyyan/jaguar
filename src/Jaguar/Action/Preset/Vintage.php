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
use Jaguar\Action\Smooth;
use Jaguar\Transformation;

class Vintage extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $transformation = new Transformation($canvas);
        $transformation->apply(new Brightness(15))
                ->apply(new Contrast(10))
                ->apply(new Smooth(7))
                ->overlay($this->getOverlayCanvas('scratch.gd2'), 30);
    }

}
