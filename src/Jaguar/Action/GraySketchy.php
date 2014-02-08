<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\Action\AbstractAction,
    Jaguar\CanvasInterface,
    Jaguar\Transformation,
    Jaguar\Action\Sketchy,
    Jaguar\Action\Color\BlackAndWhite;

class GraySketchy extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $trans = new Transformation($canvas);
        $trans->applyArray(array(
            new Sketchy(),
            new BlackAndWhite()
        ));
    }

}
