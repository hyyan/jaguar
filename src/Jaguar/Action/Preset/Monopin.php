<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Preset;

use Jaguar\Action\Color\Contrast;
use Jaguar\Action\Color\Grayscale;
use Jaguar\Transformation;

class Monopin extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(\Jaguar\CanvasInterface $canvas)
    {
        $tranformation = new Transformation($canvas);
        $tranformation->apply(new Grayscale())
                ->apply(new Contrast(5))
                ->overlay($this->getOverlayCanvas('vignette.gd2'), 30);
    }

}
