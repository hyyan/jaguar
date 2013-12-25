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
use Jaguar\Coordinate;
use Jaguar\Exception\CanvasEmptyException;
use Jaguar\Box;

class Watermark extends AbstractAction
{
    private $watermark;
    private $coordinate;

    /**
     * construct new watermark action
     *
     * @param \Jaguar\CanvasInterface $watermark
     * @param \Jaguar\Coordinate      $coordinate
     */
    public function __construct(CanvasInterface $watermark, Coordinate $coordinate = null)
    {
        $this->setCoordinate($coordinate === null ? new Coordinate() : $coordinate);
        $this->setWatermark($watermark);
    }

    /**
     * Set watermark
     *
     * @param \Jaguar\CanvasInterface $watermark
     *
     * @return \Jaguar\Action\Watermark
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function setWatermark(CanvasInterface $watermark)
    {
        if (!$watermark->isHandlerSet()) {
            throw new CanvasEmptyException();
        }
        $this->watermark = $watermark;

        return $this;
    }

    /**
     * Get watermark
     *
     * @return \Jaguar\Exception\CanvasEmptyException
     */
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * Set watermark position
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Action\Watermark
     */
    public function setCoordinate(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    /**
     * Get watermark position
     *
     * @return \Jaguar\Action\Watermark
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * Disable clone for watermark
     *
     * @throws \RuntimeException
     */
    public function __clone()
    {
        throw new \RuntimeException('Watermark clone is not possible');
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $dimension = $this->getWatermark()->getDimension();
        $canvas->paste(
                $this->getWatermark()
                , new Box($dimension)
                , new Box($dimension, $this->getCoordinate())
        );
    }

}
