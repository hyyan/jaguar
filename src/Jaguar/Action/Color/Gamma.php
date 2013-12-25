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

class Gamma extends AbstractAction
{
    private $level;

    /**
     * construct new gamma action
     *
     * @param float $level
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($level = 1.0)
    {
        $this->setLevel($level);
    }

    /**
     * Set gamma level
     *
     * @param float $level
     *
     * @return \Jaguar\Action\Color\Gamma
     *
     * @throws \InvalidArgumentException
     */
    public function setLevel($level)
    {
        if (!($level >= 0.01 && $level <= 4.99)) {
            throw new \InvalidArgumentException("Gamma Level Must Be In Range(0.01,4.99)");
        }
        $this->level = (float) $level;

        return $this;
    }

    /**
     * Get gamma level
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
        imagegammacorrect($canvas->getHandler(), 1.0, $this->getLevel());
    }

}
