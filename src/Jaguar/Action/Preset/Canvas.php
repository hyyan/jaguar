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
use Jaguar\Action\Overlay;

class Canvas extends AbstractPreset
{

    /**
     * {@inheritdoc}
     *
     * this effect was inspired from Marc Hibbins (http://marchibbins.com/dev/gd)
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $actions = array(
            new Brightness(25),
            new Contrast(25),
            new Colorize(new RGBColor(50, 25, 0)),
            new Overlay(
                    $this->getOverlayCanvas('canvas.png'), 100
            )
        );

        foreach ($actions as $action) {
            $action->apply($canvas);
        }
    }

}
