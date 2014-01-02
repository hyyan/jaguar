<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface,
    Jaguar\Action\Color\BlackAndWhite,
    Jaguar\Action\Overlay;

class Posterize extends AbstractAction
{
    private $level;

    /**
     * Constrcut new postrize level
     *
     * @param integer $level
     */
    public function __construct($level = 64)
    {
        $this->setLevel($level);
    }

    /**
     * Set postrize level
     *
     * @param integer $level in range (0,100)
     *
     * @return \Jaguar\Action\Postrize
     *
     * @throws \InvalidArgumentException
     */
    public function setLevel($level)
    {
        if ($level < 0 || $level > 100) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid Postrize Level "%s"', (string) $level
            ));
        }
        $this->level = (int) $level;

        return $this;
    }

    /**
     * Get postrize level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    protected function doApply(CanvasInterface $canvas)
    {

        $copy = $canvas->getCopy();

        // convert copy to black and white
        $baw = new BlackAndWhite();
        $baw->apply($copy);

        // overlay the canvas with the black and white copy
        $overlay = new Overlay($copy, $this->getLevel());
        $overlay->apply($canvas);

        $copy->destroy();
    }

}
