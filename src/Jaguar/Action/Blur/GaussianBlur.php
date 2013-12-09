<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Blur;

use Jaguar\CanvasInterface;
use Jaguar\Action\AbstractAction;
use Jaguar\Action\Convolution;

class GaussianBlur extends AbstractAction
{
    private static $matrix = array(
        array(1.0, 2.0, 1.0),
        array(2.0, 4.0, 2.0),
        array(1.0, 2.0, 1.0)
    );

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $con = new Convolution(self::$matrix, 16);
        $con->apply($canvas);
    }

}
