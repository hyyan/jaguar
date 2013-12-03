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
use Jaguar\Color\ColorInterface;
use Jaguar\Color\RGBColor;
use Jaguar\Exception\CanvasEmptyException;
use Jaguar\Exception\LineThicknessException;

abstract class AbstractDrawable implements DrawableInterface
{
    private $color;
    private $thickness;

    /**
     * Constrcut new drawable object
     *
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct(ColorInterface $color = null)
    {
        $this->setColor($color !== null ? $color : new RGBColor());
        $this->setLineThickness(1);
    }

    /**
     * {@inheritdoc}
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    public function setColor(ColorInterface $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setLineThickness($thickness)
    {
        if ($thickness <= 0) {
            throw new \InvalidArgumentException(
            'Thickness Value Must Be Greater Than Zero'
            );
        }
        $this->thickness = $thickness;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLineThickness()
    {
        return $this->thickness;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        return $this->getColor()->equals($other->getColor());
    }

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas, StyleInterface $style = null)
    {
        if (!$canvas->isHandlerSet()) {
            throw new CanvasEmptyException(sprintf(
                    'Can Not Draw Drawable (%s) - Canvas Is Empty'
                    , (string) $this
            ));
        }

        @imagesetthickness($canvas->getHandler(), $this->getLineThickness());
        $this->doDraw($canvas, $style);

        return $this;
    }

    /**
     * @see \Jaguar\Drawable\AbstractDrawable::draw
     */
    abstract protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null);

    /** clone the drawable */
    public function __clone()
    {
        $this->color = clone $this->color;
    }

}
