<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

use Jaguar\Dimension;

abstract class CompressableCanvas extends AbstractCanvas
{
    const QUALITY_MAX = 100;
    const QUALITY_HIGH = 90;
    const QUALITY_MED = 60;
    const QUALITY_LOW = 40;
    const QUALITY_DRAFT = 30;

    private $quality;

    /**
     * construct new compressed canvas
     *
     * @param \Jaguar\Dimension|\Jaguar\CanvasInterface|file|null $source
     * @param integer                                             $quality default 90
     */
    public function __construct($source = null, $quality = self::QUALITY_HIGH)
    {
        parent::__construct($source);
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
    public function setQuality($quality)
    {
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
    public function getQuality()
    {
        return $this->quality;
    }

}
