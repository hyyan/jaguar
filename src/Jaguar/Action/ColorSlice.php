<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface;
use Jaguar\Color\RGBColor;
use Jaguar\Dimension;
use Jaguar\Drawable\Rectangle;

class ColorSlice extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $colors = array(
            new RGBColor(0, 0, 150, 100),
            new RGBColor(255, 0, 0, 100),
            new RGBColor(0, 0, 0, 100),
            new RGBColor(150, 0, 0, 100),
            new RGBColor(255, 204, 0, 100),
            new RGBColor(100, 100, 100, 100),
        );

        $width = round($canvas->getWidth() / 6);
        $dimension = new Dimension($width, $canvas->getHeight());
        $rect = new Rectangle($dimension);
        $rect->fill(true);

        for ($i = 0; $i < 6; $i++) {
            $rect->getStart()->move(($width * $i), 0);
            $rect->setColor($colors[$i])->draw($canvas);
        }

        $actions = array(
            new Smooth(20),
            new Color\Contrast(35)
        );
        foreach ($actions as $action) {
            $action->apply($canvas);
        }
    }

}
