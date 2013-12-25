<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Pixelate;

use Jaguar\Action\AbstractAction;

abstract class AbstractPixelate extends AbstractAction
{
    private $size;

    /**
     * construct new pixelate filter
     *
     * @param integer $size
     */
    public function __construct($size = 2)
    {
        $this->setBlockSize($size);
    }

    /**
     * Set the block size
     *
     * @param integer $size
     *
     * @return \Jaguar\Action\Pixelate\AbstractPixelate
     *
     * @throws \InvalidArgumentException
     */
    public function setBlockSize($size)
    {
        if ($size <= 1) {
            throw new \InvalidArgumentException("Pixel Size Must Be Greater Than One");
        }
        $this->size = (int) abs($size);

        return $this;
    }

    /**
     * Get the block size
     *
     * @return integer
     */
    public function getBlockSize()
    {
        return $this->size;
    }

}
