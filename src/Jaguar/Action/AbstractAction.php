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
use Jaguar\Exception\CanvasEmptyException;

abstract class AbstractAction implements ActionInterface
{

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas)
    {
        if (!$canvas->isHandlerSet()) {
            throw new CanvasEmptyException();
        }
        $this->doApply($canvas);

        return $this;
    }

    /**
     * @see \Jaguar\Action\ActionInterface::apply
     */
    abstract protected function doApply(CanvasInterface $canvas);
}
