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
use Jaguar\Action\Overlay;

class StrongBeam extends AbstractPreset
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $action = new Overlay($this->getOverlayCanvas('light/strong-beam.gd2'), 100);
        $action->apply($canvas);
    }

}
