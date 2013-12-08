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
use Jaguar\Action\Overlay;
use Jaguar\Color\RGBColor;

class Velvet extends AbstractPreset
{

    /**
     * {@inheritdoc}
     *
     * this effect was inspired from Marc Hibbins (http://marchibbins.com/dev/gd)
     */
    protected function doApply(\Jaguar\CanvasInterface $canvas)
    {
        $actions = array(
            new Brightness(5),
            new Contrast(25),
            new Colorize(new RGBColor(0, 45, 65)),
            new Overlay(
                    $this->getOverlayCanvas('noise.png'), 45
            ),
            new Overlay(
                    $this->getOverlayCanvas('vignette.png'), 100
            )
        );

        foreach ($actions as $action) {
            $action->apply($canvas);
        }
    }

}
