<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface,
    Jaguar\Action\Convolution;

class Hipass extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $con = new Convolution(array(
            array(-1, -1, -1)
            , array(-1, 9, -1)
            , array(-1, -1, -1)
        ));
        $con->apply($canvas);
    }

}
