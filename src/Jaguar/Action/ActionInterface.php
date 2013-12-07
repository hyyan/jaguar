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

interface ActionInterface
{

    /**
     * Apply an action
     *
     * @param \Jaguar\CanvasInterface $canvas canvas object
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function apply(CanvasInterface $canvas);
}
