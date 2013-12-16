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
use Jaguar\Drawable\Arc;
use Jaguar\Coordinate;
use Jaguar\Color\RGBColor;

class CircleGradient extends AbstractGradient
{

    /**
     * {@inheritdoc}
     */
    public function __construct(RGBColor $start = null, RGBColor $end = null, $step = 0)
    {
        parent::__construct($start, $end, $step);
        $this->setStep(6);
    }

    /**
     * {@inheritdoc}
     */
    protected function doGenerate(CanvasInterface $canvas)
    {
        $width = $canvas->getWidth();
        $height = $canvas->getHeight();
        $n = sqrt(pow($width, 2) + pow($height, 2));

        $arc = new Arc(null, new Coordinate($width / 2, $height / 2));
        $arc->fill(true);

        for ($i = 0; $i < $n; $i+=$this->getStep() + 1) {
            $arc->getDimension()->resize($n - $i, $n - $i);
            $arc->setColor($this->getColor(($i / $n)))->draw($canvas);
        }
    }

}
