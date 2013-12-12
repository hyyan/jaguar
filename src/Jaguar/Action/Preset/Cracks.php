<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Preset;

use Jaguar\Action\Overlay;

class Cracks extends AbstractPreset
{

    /**
     * {@inheritdoc}
     *
     * this effect was inspired from Marc Hibbins (http://marchibbins.com/dev/gd)
     */
    protected function doApply(\Jaguar\CanvasInterface $canvas)
    {
        $carcks = new Overlay(
                $this->getOverlayCanvas('cracks.gd2'), 100
        );
        $carcks->apply($canvas);
    }

}
