<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Color;

use Jaguar\Action\AbstractAction;
use Jaguar\CanvasInterface;
use Jaguar\Color\RGBColor;

class Boost extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $actions = array(
            new Contrast(35),
            new Colorize(new RGBColor(25, 25, 25))
        );

        foreach ($actions as $action) {
            $action->apply($canvas);
        }
    }

}
