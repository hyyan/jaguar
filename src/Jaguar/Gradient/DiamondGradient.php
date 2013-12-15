<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Gradient;

use Jaguar\CanvasInterface;
use Jaguar\Drawable\Polygon;
use Jaguar\Coordinate;

class DiamondGradient extends AbstractGradient
{

    /**
     * {@inheritdoc}
     */
    protected function doGenerate(CanvasInterface $canvas)
    {
        $width = $canvas->getWidth();
        $height = $canvas->getHeight();
        $ry = ($height > $width) ? 1 : ($width / $height);
        $rx = ($width > $height) ? 1 : ($height / $width);
        $n = min($width, $height);

        $poly = new Polygon();
        $poly->fill(true);

        for ($i = 0; $i < $n; $i+=$this->getStep() + 1) {
            $coordinates = array(
                new Coordinate(
                        $width / 2
                        , $i * $rx - 0.5 * $height
                ), new Coordinate(
                        $i * $ry - 0.5 * $width
                        , $height / 2
                ), new Coordinate(
                         $width / 2
                        , 1.5 * $height - $i * $rx
                ), new Coordinate(
                       1.5 * $width - $i * $ry
                        , $height / 2
                )
            );
            $poly->setCoordinate(new \ArrayObject($coordinates))
                    ->setColor($this->getColor(($i / $n)))
                    ->draw($canvas);
        }
    }

}
