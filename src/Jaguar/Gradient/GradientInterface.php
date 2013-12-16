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
use Jaguar\Color\RGBColor;

interface GradientInterface
{

    /**
     * Set gradient step
     *
     * @param integer $step
     *
     * @return \Jaguar\Gradient\GradientInterface
     *
     * @throws \InvalidArgumentException if setp < 0
     */
    public function setStep($step);

    /**
     * Get gradient step
     *
     * @return integer
     */
    public function getStep();

    /**
     * Set start color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Gradient\GradientInterface
     */
    public function setStartColor(RGBColor $color);

    /**
     * Get start color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function getStartColor();

    /**
     * Set end color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Gradient\GradientInterface
     */
    public function setEndColor(RGBColor $color);

    /**
     * Get end color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function getEndColor();

    /**
     * Generate gradient
     *
     * $param \Jaguar\CanvasInterface canvas
     *
     * @return \Jaguar\Gradient\GradientInterface
     */
    public function generate(CanvasInterface $canvas);
}
