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

class Sketchy extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        imagefilter($canvas->getHandler(), IMG_FILTER_MEAN_REMOVAL);
    }

}
