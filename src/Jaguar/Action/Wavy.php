<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\Action\AbstractAction;
use Jaguar\CanvasInterface;
use Jaguar\Box;
use Jaguar\Coordinate;
use Jaguar\Dimension;

class Wavy extends AbstractAction
{
    private $level;

    /**
     * construct new wavy action
     *
     * @param integer $level
     */
    public function __construct($level = 5)
    {
        $this->setLevel($level);
    }

    /**
     * Set wavy level
     *
     * @param integer $level
     *
     * @return \Jaguar\Action\Fancy\Wavy
     */
    public function setLevel($level)
    {
        $this->level = (int) $level;

        return $this;
    }

    /**
     * Get wavy level
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
        $dimension = $canvas->getDimension();
        $newDimension = new Dimension(2, $dimension->getHeight());
        for ($i = 0; $i < $dimension->getWidth(); $i+=2) {
            $canvas->paste(
                    $canvas
                    , new Box($newDimension, new Coordinate($i, 0))
                    , new Box($newDimension, new Coordinate($i - 2, sin($i / 10) * $this->getLevel()))
            );
        }
    }

}
