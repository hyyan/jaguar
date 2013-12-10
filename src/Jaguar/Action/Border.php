<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface;
use Jaguar\Drawable\Rectangle;
use Jaguar\Dimension;
use Jaguar\Coordinate;
use Jaguar\Color\RGBColor;

class Border extends AbstractAction
{
    private $size;
    private $color;

    public function __construct($size = 1, RGBColor $color = null)
    {
        $this->setSize($size);
        $this->setColor($color === null ? new RGBColor(0, 0, 0) : $color);
    }

    /**
     * Set border size
     *
     * @param integer $size
     *
     * @return \Jaguar\Action\Border
     *
     * @throws \InvalidArgumentException
     */
    public function setSize($size)
    {
        if ($size < 1) {
            throw new \InvalidArgumentException('Invalid Border Size - Must Be >= 1');
        }
        $this->size = (int) $size;

        return $this;
    }

    /**
     * Get border sizes
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set border color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Action\Border
     */
    public function setColor(RGBColor $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get border color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $cloneRgb = clone $this->getColor();
        $cloneRgb->setAlpha(0);

        $width = $canvas->getWidth() - ($this->getSize() * 2);
        $height = $canvas->getHeight() - ($this->getSize() * 2);

        $rect = new Rectangle(
                new Dimension($width, $height)
                , new Coordinate($this->getSize(), $this->getSize())
                , $cloneRgb
        );
        $rect->draw($canvas);

        imagefilltoborder(
                $canvas->getHandler()
                , 0
                , 0
                , $cloneRgb->getValue()
                , $cloneRgb->getValue()
        );
    }

}
