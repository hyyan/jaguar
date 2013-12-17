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

use Jaguar\Box;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;
use Jaguar\Dimension;
use Jaguar\Drawable\DrawableInterface;

interface CanvasInterface
{

    /**
     * Set canvas handler
     *
     * @param resource $handler gd resource
     *
     * @return \Jaguar\CanvasInterface
     * @throws \InvalidArgumentException
     */
    public function setHandler($handler);

    /**
     * Get canvas handler
     *
     * @return resource gd resource
     */
    public function getHandler();

    /**
     * Check if the handler is empty
     *
     * @return boolean
     */
    public function isHandlerSet();

    /**
     * Get canvas width
     *
     * @return integer
     */
    public function getWidth();

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight();

    /**
     * Get canvas dimension
     *
     * @return \Jaguar\Dimension
     */
    public function getDimension();

    /**
     * Check if the canvas represents a truecolor canvas
     *
     * @return boolean true if true color false otherwise
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function isTrueColor();

    /**
     * Set alpha blending
     *
     * @param boolean $bool default true
     *
     * @return \Jaguar\CanvasInterface
     *
     * @throws \Jaguar\Exception\CanvasException
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function alphaBlending($bool);

    /**
     * Get Copy of the current canvas
     *
     * @return \Jaguar\CanvasInterface return a canvas with a completey
     *                                        different gd resource
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     * @throws \Jaguar\Exception\CanvasException
     */
    public function getCopy();

    /**
     * Create canvas (true colors only)
     *
     * @param \Jaguar\Dimension $dimension
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \Jaguar\Exception\InvalidDimensionException
     * @throws \Jaguar\Exception\CanvasCreationException
     */
    public function create(Dimension $dimension);

    /**
     * Create new canvas from file
     *
     * @param string $image
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \InvalidArgumentException
     * @throws \Jaguar\Exception\CanvasCreationException
     */
    public function fromFile($file);

    /**
     * Create new canvas representing the canvas obtained from the given string
     *
     * <b>Note : </b>
     * the current canvas handler will be destroy before creating the new one
     * and you have no more access for it
     *
     * @param string $string canvas as string
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \Jaguar\Exception\CanvasCreationException
     */
    public function fromString($string);

    /**
     * Replace this canvas handler with a new one loaded from another canvas
     *
     * <b>Note :</b>
     *
     * note that the current canvas handler will be destroyed
     * before assigning the new one.
     *
     * This behaviour will not allow to create canvas and depend
     * on php garbage collection to clean it
     *
     * @param \Jaguar\CanvasInterface $canvas
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     * @throws \Jaguar\Exception\CanvasException;
     */
    public function fromCanvas(CanvasInterface $canvas);

    /**
     * Get Pixel at specific coordinate
     *
     * @param \Jaguar\Coordinatee $coordinate
     *
     * @return \Jaguar\Drawable\Pixel
     *
     * @throws \Jaguar\Exception\InvalidCoordinateException
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function getPixel(Coordinate $coordinate);

    /**
     * Draw drawable object on the current canvas
     *
     * @param \Jaguar\Drawable\DrawableInterface $drawable
     * @param mixed                              $style
     *
     * @return \Jaguar\CanvasInterface                self
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function draw(DrawableInterface $drawable, $style = null);

    /**
     * Merge two canvas together
     *
     * <b>Note :</b>
     *
     * if <tt>$srcBox</t> or <tt>$destBox</tt> is null then a new box object
     * will be created its dimension equlas the <tt>$src</tt> dimension
     * and at (0,0) coordinate
     *
     * @param \Jaguar\CanvasInterface $src the canvas that should be merged
     *                                            into current one
     *
     * @param \Jaguar\Box $srcBox  Box from src canvas
     * @param \Jaguar\Box $destBox Box for the current canvas
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \Jaguar\Exception\CanvasException
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function paste(CanvasInterface $src, Box $srcBox = null, Box $destBox = null);

    /**
     * Fill canvas with color
     *
     * @param \Jaguar\Color\ColorInterface $color
     * @param \Jaguar\Coordinate           $coordinate start point
     *
     * @return \Jaguar\CanvasInterface                self
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    public function fill(ColorInterface $color, Coordinate $coordinate = null);

    /**
     * Save canvas
     *
     * @param string $path The path to save the canvas to. If not set or NULL,
     *                     the raw canvas stream will be outputted directly.
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     * @throws \Jaguar\Exception\CanvasOutputException
     */
    public function save($path = null);

    /**
     * Destroy the canvas
     *
     * destroy the canvas handler
     *
     * @return \Jaguar\CanvasInterface self
     *
     * @throws \Jaguar\Exception\CanvasDestroyingException
     */
    public function destroy();

    /**
     * Get a string representation of the current canvas object
     *
     * @return string
     */
    public function __toString();
}
