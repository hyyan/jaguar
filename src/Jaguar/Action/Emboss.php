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

class Emboss extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $con = new Convolution(array(
            array(2, 0, 0)
            , array(0, -1, 0)
            , array(0, 0, -1)
        ), 1.5, 127);
        $con->apply($canvas);
    }

}
