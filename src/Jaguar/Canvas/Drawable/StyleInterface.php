<?php

/**
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas\Drawable;

use Jaguar\Canvas\CanvasInterface;

interface StyleInterface {

    /**
     * Apply the style on the drawable object
     * 
     * @param \Jaguar\Canvas\CanvasInterface $canvas
     * @param \Jaguar\Canvas\DrawableInterface $drawable
     */
    public function apply(CanvasInterface $canvas, DrawableInterface $drawable);
}

