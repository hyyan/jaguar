<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Overlay;

use Jaguar\CanvasInterface;
use Jaguar\Action\Color\Brightness;
use Jaguar\Action\Color\Contrast;
use Jaguar\Action\Color\Colorize;
use Jaguar\Color\RGBColor;
use Jaguar\Action\Smooth;
use Jaguar\Action\Overlay;

class Dreamy extends AbstractOverlay
{

    /**
     * {@inheritdoc}
     *
     * this effect was inspired from Marc Hibbins (http://marchibbins.com/dev/gd)
     */
    protected function doApply(CanvasInterface $canvas)
    {

        $actions = array(
            new Brightness(20),
            new Contrast(35),
            new Colorize(new RGBColor(60, 0, 35)),
            new Smooth(7),
            new Overlay(
                    $this->getOverlayCanvas('scratch.png'), 10
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
