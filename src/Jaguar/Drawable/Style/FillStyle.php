<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Style;

use Jaguar\Drawable\StyleInterface;
use Jaguar\CanvasInterface;
use Jaguar\Drawable\AbstractStyledDrawable;
use Jaguar\Exception\DrawableException;
use Jaguar\Color\TiledColor;

class FillStyle implements StyleInterface
{
    private $pattern;

    /**
     * construct new PatternFill Style
     *
     * @param \Jaguar\CanvasInterface $pattern
     */
    public function __construct(CanvasInterface $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas, AbstractStyledDrawable $drawable)
    {
        if (
                false == @imagesettile(
                        $canvas->getHandler()
                        , $this->pattern->getHandler()
                )
        ) {
            throw new DrawableException('Could Not Apply The Fill Pattern Style');
        }

        return new TiledColor();
    }

    /**
     * Disable Style Clone
     *
     * @throws \RuntimeException
     */
    public function __clone()
    {
        throw new \RuntimeException('Clone Is Not Possible ON PatterFill Style');
    }

}
