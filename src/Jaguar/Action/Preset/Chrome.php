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
use Jaguar\Transformation;

class Chrome extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(\Jaguar\CanvasInterface $canvas)
    {
        $transformation = new Transformation($canvas);
        $transformation->apply(new Brightness(15))
                ->apply(new Contrast(-15))
                ->overlay($this->getOverlayCanvas('noise.gd2'), 100)
                ->overlay($this->getOverlayCanvas('vignette.gd2'), 100);
    }

}
