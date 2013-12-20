<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Border;

use Jaguar\Drawable\Border;
use Jaguar\CanvasInterface;
use Jaguar\Drawable\StyleInterface;

interface BorderDrawerInterface
{

    /**
     * Draw border
     *
     * @param \Jaguar\CanvasInterface         $canvas
     * @param \Jaguar\Drawable\Border         $border
     * @param \Jaguar\Drawable\StyleInterface $style
     *
     * @return \Jaguar\Drawable\Border\BorderDrawerInterface
     */
    public function draw(CanvasInterface $canvas, Border $border, StyleInterface $style = null);
}
