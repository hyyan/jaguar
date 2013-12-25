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

class Smooth extends AbstractAction
{
    private $level;

    /**
     * construct new smooth action
     *
     * @param integer $level
     */
    public function __construct($level = 5)
    {
        $this->setLevel($level);
    }

    /**
     * Set smooth level
     *
     * @param float $level
     *
     * @return \Jaguar\Action\Smooth
     */
    public function setLevel($level)
    {
        $this->level = (float) $level;

        return $this;
    }

    /**
     * Get smooth level
     *
     * @return float
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        imagefilter($canvas->getHandler(), IMG_FILTER_SMOOTH, $this->getLevel());
    }

}
