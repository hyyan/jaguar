<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\CanvasInterface;

interface StyleInterface
{

    /**
     * Apply the style on the drawable object
     *
     * @param \Jaguar\CanvasInterface                 $canvas
     * @param \Jaguar\Drawable\AbstractStyledDrawable $drawable
     *
     * @throws \Jaguar\Exception\DrawableException
     */
    public function apply(CanvasInterface $canvas, AbstractStyledDrawable $drawable);
}
