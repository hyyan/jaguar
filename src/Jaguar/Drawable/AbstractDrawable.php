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

use Jaguar\Color\ColorInterface;
use Jaguar\Color\RGBColor;

abstract class AbstractDrawable implements DrawableInterface
{
    private $color;

    /**
     * construct new drawable object
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

    /** clone the drawable */
    public function __clone()
    {
        $this->color = clone $this->color;
    }

    /**
     * Get string representation for the current drawable object
     *
     * @return string
     */
    abstract public function __toString();
}
