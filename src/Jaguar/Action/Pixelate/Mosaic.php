<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Pixelate;

use Jaguar\Action\Pixelate\AbstractPixelate;
use Jaguar\CanvasInterface;

class Mosaic extends AbstractPixelate
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        imagefilter(
                $canvas->getHandler()
                , IMG_FILTER_PIXELATE
                , $this->getBlockSize()
                , false
        );
    }

}
