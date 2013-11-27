<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas\Drawable\Style;

use Jaguar\Canvas\Drawable\StyleInterface;
use Jaguar\Canvas\CanvasInterface;
use Jaguar\Canvas\Drawable\DrawableInterface;
use Jaguar\Exception\Canvas\Drawable\DrawableException;
use Jaguar\Color\TiledColor;

class FillStyle implements StyleInterface
{
    private $pattern;

    /**
     * Constrcut new PatternFill Style
     *
     * @param \Jaguar\Canvas\CanvasInterface $pattern
     */
    public function __construct(CanvasInterface $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(CanvasInterface $canvas, DrawableInterface $drawable)
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
