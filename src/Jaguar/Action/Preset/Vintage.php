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
use Jaguar\Action\Overlay;

class Vintage extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {

        $actions = array(
            new Brightness(15),
            new Contrast(10),
            new Smooth(7),
            new Overlay(
                    $this->getOverlayCanvas('scratch.gd2'), 7
            )
        );

        foreach ($actions as $action) {
            $action->apply($canvas);
        }
    }

}
