<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Gradient;

use Jaguar\Color\RGBColor;
use Jaguar\CanvasInterface;

abstract class AbstractGradient implements GradientInterface
{
    private $start;
    private $end;
    private $step;

    /**
     * construct new gradient
     *
     * @param \Jaguar\Color\RGBColor $start
     * @param \Jaguar\Color\RGBColor $end
     * @param inetger                $step
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(RGBColor $start = null, RGBColor $end = null, $step = 0)
    {
        $this->setStartColor($start === null ? RGBColor::fromHex('#000') : $start);
        $this->setEndColor($end === null ? RGBColor::fromHex('#fff') : $end);
        $this->setStep($step);
    }

    /**
     * {@inheritdoc}
     */
    public function setStep($step)
    {
        if ($step < 0) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid Gradient Step "%s"', $step
            ));
        }

        $this->step = (int) $step;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartColor(RGBColor $color)
    {
        $this->start = $color;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartColor()
    {
        return $this->start;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndColor(RGBColor $color)
    {
        $this->end = $color;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndColor()
    {
        return $this->end;
    }

    /**
     * {@inheritdoc}
     */
    final public function generate(CanvasInterface $canvas)
    {
        $this->doGenerate($canvas);

        return $this;
    }

    /**
     * Interpolate color
     *
     * @param integer $amount
     *
     * @return \Jaguar\Color\RGBColor
     */
    protected function getColor($amount)
    {
        $s = $this->getStartColor();
        $e = $this->getEndColor();

        $r = ($e->getRed() - $s->getRed() != 0) ?
                intval($s->getRed() + ($e->getRed() - $s->getRed()) * $amount) :
                $s->getRed();

        $g = ($e->getGreen() - $s->getGreen() != 0) ?
                intval($s->getGreen() + ($e->getGreen() - $s->getGreen()) * $amount) :
                $s->getGreen();

        $b = ($e->getBlue() - $s->getBlue() != 0) ?
                intval($s->getBlue() + ($e->getBlue() - $s->getBlue()) * $amount) :
                $s->getBlue();

        $a = ($e->getAlpha() - $s->getAlpha() != 0) ?
                intval($s->getAlpha() + ($e->getAlpha() - $s->getAlpha()) * $amount) :
                $s->getAlpha();

        return new RGBColor($r, $g, $b, $a);
    }

    /**
     * @see \Jaguar\Gradient\GradientInterface::generate
     *
     * @param \Jaguar\CanvasInterface $canvas
     */
    abstract protected function doGenerate(CanvasInterface $canvas);
}
