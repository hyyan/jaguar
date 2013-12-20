<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\Color\ColorInterface;
use Jaguar\CanvasInterface;
use Jaguar\Exception\CanvasEmptyException;

abstract class AbstractStyledDrawable extends AbstractDrawable
{
    private $thickness;

    public function __construct(\Jaguar\Color\ColorInterface $color = null)
    {
        parent::__construct($color);
        $this->setLineThickness(1);
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
        return parent::equals($other) && ($this->getLineThickness() === $other->getLineThickness());
    }

    /**
     * {@inheritdoc}
     */
    final public function draw(CanvasInterface $canvas, StyleInterface $style = null)
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
     * @param \Jaguar\Drawable\CanvasInterface $canvas
     * @param \Jaguar\Drawable\StyleInterface  $style
     */
    abstract protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null);
}
