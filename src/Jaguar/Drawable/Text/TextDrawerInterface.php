<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Text;

use Jaguar\CanvasInterface;
use Jaguar\Drawable\Text;

interface TextDrawerInterface
{

    /**
     * Apply the style on the text object
     *
     * @param \Jaguar\CanvasInterface $canvas
     * @param \Jaguar\Drawable\Text   $text
     *
     * @return boolean true on success false otherwise
     */
    public function draw(CanvasInterface $canvas, Text $text);
}
