<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

use Jaguar\Action\ActionInterface,
    Jaguar\CanvasInterface,
    Jaguar\Action\Crop,
    Jaguar\Action\Flip,
    Jaguar\Action\Mirror,
    Jaguar\Action\Resize,
    Jaguar\Action\Rotate,
    Jaguar\Color\ColorInterface,
    Jaguar\Coordinate,
    Jaguar\Action\Watermark,
    Jaguar\Action\Overlay,
    Jaguar\Action\EdgeDetection,
    Jaguar\Box,
    Jaguar\Dimension;

/**
 * Provide shortcuts for basic actions
 *
 * @codeCoverageIgnore
 */
final class Transformation
{
    private $canvas;

    /**
     * construct new transformation
     *
     * @param \Jaguar\CanvasInterface $canvas
     */
    public function __construct(CanvasInterface $canvas)
    {
        $this->setCanvas($canvas);
    }

    /**
     * Set working canvas
     *
     * @param \Jaguar\CanvasInterface $canvas
     *
     * @return \Jaguar\Transformation
     */
    public function setCanvas(CanvasInterface $canvas)
    {
        $this->canvas = $canvas;

        return $this;
    }

    /**
     * Get working canvas
     *
     * @return \Jaguar\CanvasInterface
     */
    public function getCanvas()
    {
        return $this->canvas;
    }

    /**
     * Apply action on the working canvas
     *
     * @param \Jaguar\Action\ActionInterface $action
     *
     * @return \Jaguar\Transformation
     */
    public function apply(ActionInterface $action)
    {
        $action->apply($this->getCanvas());

        return $this;
    }

    /**
     * Apply array of actions
     *
     * @param array $actions
     *
     * @return \Jaguar\Transformation
     */
    public function applyArray(array $actions)
    {
        foreach ($actions as $action) {
            $this->apply($action);
        }

        return $this;
    }

    /**
     * Crop the given box from the working canvas
     *
     * @param \Jaguar\Box $box
     *
     * @return \Jaguar\Transformation
     */
    public function crop(Box $box)
    {
        return $this->apply(new Crop($box));
    }

    /**
     * Flip the working in horizontal direction
     *
     * @return \Jaguar\Transformation
     */
    public function flipHorizontal()
    {
        return $this->apply(new Flip(Flip::FLIP_HORIZONTAL));
    }

    /**
     * Flip the working in vertical direction
     *
     * @return \Jaguar\Transformation
     */
    public function flipVertical()
    {
        return $this->apply(new Flip(Flip::FLIP_VERTICAL));
    }

    /**
     * Flip the working in vertical and horizontal directions
     *
     * @return \Jaguar\Transformation
     */
    public function flipBoth()
    {
        return $this->apply(new Flip(Flip::FLIP_BOTH));
    }

    /**
     * Horizontal mirror
     *
     * @return \Jaguar\Transformation
     */
    public function mirrorHorizontal()
    {
        return $this->apply(new Mirror(Mirror::MIRROR_HORIZONTAL));
    }

    /**
     * Vertical mirror
     *
     * @return \Jaguar\Transformation
     */
    public function mirrorVertical()
    {
        return $this->apply(new Mirror(Mirror::MIRROR_VERTICAL));
    }

    /**
     * Resize the working canvas to the given dimension
     *
     * @param \Jaguar\Dimension $dimension
     *
     * @return \Jaguar\Transformation
     */
    public function resize(Dimension $dimension)
    {
        return $this->apply(new Resize($dimension));
    }

    /**
     * Rotate the working canvas
     *
     * @param inetger                      $degree
     * @param \Jaguar\Color\ColorInterface $background
     *
     * @return \Jaguar\Transformation
     */
    public function rotate($degree, ColorInterface $background = null)
    {
        return $this->apply(new Rotate($degree, $background));
    }

    /**
     * Watermakr the working canvas with the given canvas
     *
     * @param \Jaguar\CanvasInterface $watermark
     * @param \Jaguar\Coordinate      $cooridnate
     *
     * @return \Jaguar\Transformation
     */
    public function watermark(CanvasInterface $watermark, Coordinate $cooridnate = null)
    {
        return $this->apply(new Watermark($watermark, $cooridnate));
    }

    /**
     * Overlay the current canvas with the given canvas
     *
     * @param \Jaguar\CanvasInterface $overlay
     * @param integer                 $mount
     * @param \Jaguar\Box             $box
     *
     * @return \Jaguar\Transformation
     */
    public function overlay(CanvasInterface $overlay, $mount = 100, Box $box = null)
    {
        return $this->apply(new Overlay($overlay, $mount, $box));
    }

    /**
     *  Watermakr the working canvas with the given canvas using the overlay method
     *
     * @param \Jaguar\CanvasInterface $watermark
     * @param \Jaguar\Coordinate      $cooridnate
     * @param integer                 $mount
     *
     * @return \Jaguar\Transformation
     */
    public function overlayWatermark(CanvasInterface $watermark, Coordinate $cooridnate = null, $mount = 100)
    {
        return $this->overlay($watermark, $mount, new Box($watermark->getDimension(), $cooridnate));
    }

    /**
     * Apply edge detection filter
     *
     * @param string $type one of the edge detections types
     *
     * @return \Jaguar\Transformation
     */
    public function edgeDetection($type)
    {
        return $this->apply(new EdgeDetection($type));
    }

}
