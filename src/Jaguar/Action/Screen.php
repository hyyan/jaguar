<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface,
    Jaguar\Color\RGBColor,
    Jaguar\Drawable\Line;

/**
 * Screen action
 *
 * This action is similar to the canvas action which was created with preset
 * but in this one you can control the color of the canvas and it does not use
 * any presets
 */
class Screen extends AbstractAction
{
    private $color;
    private $size;

    /**
     * Construct new screen action
     *
     * @param \Jaguar\Color\RGBColor $color
     * @param integer                $size
     *
     */
    public function __construct(RGBColor $color = null, $size = 2)
    {
        $this->setColor($color === null ? new RGBColor(0, 0, 0, 70) : $color)
                ->setSize($size);
    }

    /**
     * Set screen color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Action\Screen
     */
    public function setColor(RGBColor $color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set block size
     *
     * @param integer $size size > 2
     *
     * @return \Jaguar\Action\Screen
     *
     * @throws \InvalidArgumentException
     */
    public function setSize($size)
    {
        if ($size < 2) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid Block Size "%s"', (string) $size
            ));
        }
        $this->size = $size;

        return $this;
    }

    /**
     * Gets size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $width = $canvas->getWidth();
        $height = $canvas->getHeight();

        $line = new Line();
        $line->setColor($this->getColor());

        for ($x = 1; $x <= $width; $x += $this->getSize()) {
            $line->getStart()->move($x, 0);
            $line->getEnd()->move($x, $height);
            $line->draw($canvas);
        }

        for ($y = 1; $y <= $height; $y += $this->getSize()) {
            $line->getStart()->move(0, $y);
            $line->getEnd()->move($width, $y);
            $line->draw($canvas);
        }
    }

}
