<?php

namespace Jaguar\Canvas;

use Jaguar\Dimension;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

abstract class CompressableCanvas extends AbstractCanvas {

    private $quality;

    /**
     * Constrcut new compressed canvas
     * 
     * @param \Jaguar\Dimension $dimension
     * @param integer $quality default 75
     */
    public function __construct(Dimension $dimension = null, $quality = 75) {
        parent::__construct($dimension);
        $this->setQuality($quality);
    }

    /**
     * Set Canvas Output Quality
     * 
     * @param integer $quality ranges from 0 (worst quality, smaller file) to 100 
     *                         (best quality, biggest file)
     * 
     * @throws \InvalidArgumentException
     */
    public function setQuality($quality) {
        if ($quality >= 0 && $quality <= 100) {
            $this->quality = $quality;
        } else {
            throw new \InvalidArgumentException(
            'Quality should be in range(0,100)'
            );
        }
    }

    /**
     * Get Canvas Output Quality
     * 
     * @return integer
     */
    public function getQuality() {
        return $this->quality;
    }

}

