<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Color;

use Jaguar\CanvasInterface,
    Jaguar\Action\AbstractAction,
    Jaguar\Action\Color\Contrast,
    Jaguar\Action\Color\Grayscale,
    Jaguar\Transformation;

class BlackAndWhite extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $transformation = new Transformation($canvas);
        $transformation->apply(new Grayscale())
                ->apply(new Contrast(-1000));
    }

}
