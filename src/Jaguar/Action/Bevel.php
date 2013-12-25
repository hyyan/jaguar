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
use Jaguar\Drawable\Line;
use Jaguar\Color\ColorInterface;
use Jaguar\Coordinate;
use Jaguar\Color\RGBColor;

class Bevel extends AbstractAction
{
    private $c1;
    private $c2;
    private $width;

    /**
     * construct new bevel action
     *
     * @param integer                      $width
     * @param \Jaguar\Color\ColorInterface $c1
     * @param \Jaguar\Color\ColorInterface $c2
     */
    public function __construct($width = 10, ColorInterface $c1 = null, ColorInterface $c2 = null)
    {
        $this->setWidth($width)
                ->setFirstColor($c1 === null ? new RGBColor(255, 255, 255) : $c1)
                ->setSecondColor($c2 === null ? new RGBColor() : $c2);
    }

    /**
     * Set first color
     *
     * @param \Jaguar\Color\ColorInterface $color
     *
     * @return \Jaguar\Action\Bevel
     */
    public function setFirstColor(ColorInterface $color)
    {
        $this->c1 = $color;

        return $this;
    }

    /**
     * Get first color
     *
     * @return \Jaguar\Color\ColorInterface
     */
    public function getFirstColor()
    {
        return $this->c1;
    }

    /**
     * Set second color
     *
     * @param \Jaguar\Color\ColorInterface $color
     *
     * @return \Jaguar\Action\Bevel
     */
    public function setSecondColor(ColorInterface $color)
    {
        $this->c2 = $color;

        return $this;
    }

    /**
     * Get second color
     *
     * @return \Jaguar\Color\ColorInterface
     */
    public function getSecondColor()
    {
        return $this->c2;
    }

    /**
     * Set bevel width
     *
     * @param integer $width
     *
     * @return \Jaguar\Action\Bevel
     *
     * @throws \InvalidArgumentException if width < 1
     */
    public function setWidth($width)
    {
        if ($width < 1) {
            throw new \InvalidArgumentException('Width Must Be > 1');
        }
        $this->width = $width;

        return $this;
    }

    /**
     * Get bevel width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $c1 = clone $this->getFirstColor();
        $c2 = clone $this->getSecondColor();
        $line = new Line();

        $width = $canvas->getWidth();
        $height = $canvas->getHeight();

        for ($i = 0; $i < $this->getWidth(); $i++) {

            $alpha = round(($i / $this->getWidth()) * 127);
            $c1->setAlpha($alpha);
            $c2->setAlpha($alpha);

            $line
                    // left
                    ->setStart(new Coordinate($i, $i + 1))
                    ->setEnd(new Coordinate($i, ($height - $i - 1)))
                    ->setColor($c1)
                    ->draw($canvas)

                    // top
                    ->setStart(new Coordinate($i, $i))
                    ->setEnd(new Coordinate(($width - $i), $i))
                    ->draw($canvas)

                    // right
                    ->setStart(new Coordinate(($width - $i), ($height - $i - 1)))
                    ->setEnd(new Coordinate(($width - $i), $i + 1))
                    ->setColor($c2)
                    ->draw($canvas)

                    // bottom
                    ->setStart(new Coordinate(($width - $i), ($height - $i - 1)))
                    ->setEnd(new Coordinate($i, ($height - $i)))
                    ->draw($canvas);
        }
    }

}
