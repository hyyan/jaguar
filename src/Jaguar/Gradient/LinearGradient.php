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
use Jaguar\Drawable\Rectangle;
use Jaguar\Color\RGBColor;

class LinearGradient extends AbstractGradient
{
    const GRADIENT_VERTICAL = 'gradient.vertical';
    const GRADIENT_HORIZONTAL = 'gradient.horizontal';

    private $type;
    private static $supported = array(
        self::GRADIENT_HORIZONTAL, self::GRADIENT_VERTICAL
    );

    /**
     * construct new LinearGradient gradient
     *
     * @param string                 $type
     * @param \Jaguar\Color\RGBColor $start
     * @param \Jaguar\Color\RGBColor $end
     * @param integer                $step
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($type = self::GRADIENT_VERTICAL, RGBColor $start = null, RGBColor $end = null, $step = 0)
    {
        parent::__construct($start, $end, $step);
        $this->setType($type);
    }

    /**
     * Set LinearGradient type
     *
     * @param string $type
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if (!in_array($type, self::$supported)) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid LinearGradient Gradient Type ""', (string) $type
            ));
        }
        $this->type = $type;
    }

    /**
     * Get LinearGradient type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    protected function doGenerate(CanvasInterface $canvas)
    {

        $n = $w = null;

        if (self::GRADIENT_VERTICAL == $this->getType()) {
            $n = $canvas->getHeight();
            $w = $canvas->getWidth();
        } else {
            $w = $canvas->getHeight();
            $n = $canvas->getWidth();
        }

        $rect = new Rectangle();
        $rect->fill(true);

        for ($i = 0; $i < $n; $i+=$this->getStep() + 1) {

            if (self::GRADIENT_VERTICAL == $this->getType()) {
                $rect->getStart()->move(0, $i);
                $rect->getDimension()->resize($w, $i + $this->getStep());
            } else {
                $rect->getStart()->move($i, 0);
                $rect->getDimension()->resize($i + $this->getStep(), $w);
            }

            $rect->setColor($this->getColor(($i / $n)))->draw($canvas);
        }
    }

}
