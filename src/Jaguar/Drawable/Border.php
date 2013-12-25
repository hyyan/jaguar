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
use Jaguar\Color\RGBColor;
use Jaguar\Drawable\Border\BorderDrawerInterface;
use Jaguar\Drawable\Border\BorderIn;

class Border extends AbstractStyledDrawable
{
    private $drawer;

    /**
     * construct new border
     *
     * @param integer $size border size
     *
     * @param \Jaguar\Color\RGBColor $color
     */
    public function __construct($size = 1, RGBColor $color = null)
    {
        parent::__construct($color);
        $this->setSize($size)
                ->setDrawer(new BorderIn())
                ->setColor($color === null ? new RGBColor(0, 0, 0) : $color);
    }

    /**
     * Set border drawer
     *
     * @param \Jaguar\Drawable\Border\BorderDrawerInterface $drawer
     *
     * @return \Jaguar\Drawable\Border
     */
    public function setDrawer(BorderDrawerInterface $drawer)
    {
        $this->drawer = $drawer;

        return $this;
    }

    /**
     * Get border drawer
     *
     * @return \Jaguar\Drawable\Border\BorderDrawerInterface
     */
    public function getDrawer()
    {
        return $this->drawer;
    }

    /**
     * Aliase for setLineThickness
     *
     * @see \Jaguar\Drawable\AbstractStyledDrawable::setLineThickness
     *
     * @codeCoverageIgnore
     */
    public function setSize($size)
    {
        return $this->setLineThickness($size);
    }

    /**
     * Aliase for getLineThickness
     *
     * @see \Jaguar\Drawable\AbstractStyledDrawable::getLineThickness
     *
     * @codeCoverageIgnore
     */
    public function getSize()
    {
        return $this->getLineThickness();
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Border Object');
        }

        return parent::equals($other);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->getDrawer()->draw($canvas, $this, $style);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf('%s[size=%s]', get_called_class(), $this->getSize());
    }

}
