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

abstract class AbstractDrawable implements DrawableInterface
{
    private $color;

    /**
     * Constrcut new drawable object
     *
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct(ColorInterface $color = null)
    {
        $this->setColor($color !== null ? $color : new RGBColor());
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
    public function equals($other)
    {
        return $this->getColor()->equals($other->getColor());
    }

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas)
    {
        if (!$canvas->isHandlerSet()) {
            throw new CanvasEmptyException(sprintf(
                    'Can Not Draw Drawable (%s) - Canvas Is Empty'
                    , (string) $this
            ));
        }
        $this->doDraw($canvas);

        return $this;
    }

    /**
     * @see \Jaguar\Drawable\AbstractDrawable::draw
     */
    abstract protected function doDraw(CanvasInterface $canvas);

    /** clone the drawable */
    public function __clone()
    {
        $this->color = clone $this->color;
    }

}
