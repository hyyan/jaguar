<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\CanvasInterface;

interface TextDrawerInterface
{

    /**
     * Apply the style on the text object
     *
     * @param \Jaguar\CanvasInterface $canvas
     * @param \Jaguar\Drawable\Text   $text
     *
     * @throws \Jaguar\Exception\DrawableException
     *
     * @return \\Jaguar\Drawable\TextDrawerInterface
     */
    public function apply(CanvasInterface $canvas, Text $text);
}
