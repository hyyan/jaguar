<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Blur;

use Jaguar\Action\Smooth;
use Jaguar\Action\Color\Contrast;
use Jaguar\Action\AbstractAction;
use Jaguar\CanvasInterface;

class PartialBlur extends AbstractAction
{

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $actions = array(
            new SelectiveBlur(),
            new GaussianBlur(),
            new Contrast(15),
            new Smooth(-2)
        );

        foreach ($actions as $action) {
            $action->apply($canvas);
        }
    }

}
