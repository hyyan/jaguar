<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Color;

use Jaguar\Action\AbstractAction;
use Jaguar\CanvasInterface;

class Brightness extends AbstractAction
{
    private $level;

    /**
     * construct new brightness action
     *
     * @param integer $level
     *
     * @throws \InvalidArgumentException if invalid level
     */
    public function __construct($level = 0)
    {
        $this->setLevel($level);
    }

    /**
     * Set brightness level
     *
     * @param integer $level in range (-100,100)
     *
     * @return \Jaguar\Action\Color\Brightness
     *
     * @throws \InvalidArgumentException if invalid level
     */
    public function setLevel($level)
    {
        if ($level < -100 || $level > 100) {
            throw new \InvalidArgumentException(
            "Brightness Level Must Be In Range(-100,100)"
            );
        }
        $this->level = $level;

        return $this;
    }

    /**
     * Get brightness level
     *
     * @return integer
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
        imagefilter($canvas->getHandler(), IMG_FILTER_BRIGHTNESS, $this->getLevel());
    }

}
