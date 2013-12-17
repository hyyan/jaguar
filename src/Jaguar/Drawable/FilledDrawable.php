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

abstract class FilledDrawable extends AbstractStyledDrawable
{
    private $filled;

    /**
     * Draw filled drawable object
     *
     * @param booleab $boolean true fo filled
     *
     * @return \Jaguar\Drawable\FilledDrawable
     */
    public function fill($boolean)
    {
        $this->filled = (boolean) $boolean;

        return $this;
    }

    /**
     * Is filled
     *
     * @return boolean
     */
    public function isFilled()
    {
        return $this->filled;
    }

    /**
     * {@inheritdoc}
     */
    protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null)
    {
        if ($this->isFilled()) {
            $this->drawFilled($canvas, $style);
        }
        $this->drawNonFilled($canvas, $style);
    }

    /**
     * Draw non filled drawable
     *
     * @param \Jaguar\CanvasInterface         $canvas
     * @param \Jaguar\Drawable\StyleInterface $style
     */
    abstract protected function drawNonFilled(CanvasInterface $canvas, StyleInterface $style = null);

    /**
     * Draw filled drawable
     *
     * @param \Jaguar\CanvasInterface         $canvas
     * @param \Jaguar\Drawable\StyleInterface $style
     */
    abstract protected function drawFilled(CanvasInterface $canvas, StyleInterface $style = null);
}
