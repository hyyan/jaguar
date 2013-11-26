<?php

/**
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas;

use Jaguar\Box;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;
use Jaguar\Dimension;
use Jaguar\Canvas\Drawable\DrawableInterface;
use Jaguar\Canvas\Drawable\StyleInterface;

interface CanvasInterface {

    /**
     * Set canvas handler
     * 
     * @param resource $handler gd resource 
     * 
     * @return \Jaguar\Canvas\CanvasInterface 
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
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function isTrueColor();

    /**
     * Set alpha blending
     * 
     * @param boolean $bool default true
     * 
     * @return \Jaguar\Canvas\CanvasInterface 
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasException
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function alphaBlending($bool);

    /**
     * Get Copy of the current canvas
     * 
     * @return \Jaguar\Canvas\CanvasInterface return a canvas with a completey 
     *                                        different gd resource
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     * @throws \Jaguar\Exception\Canvas\CanvasException
     */
    public function getCopy();

    /**
     * Create canvas (true colors only)
     * 
     * @param \Jaguar\Dimension $dimension
     * 
     * @return \Jaguar\Canvas\CanvasInterface self
     * 
     * @throws \Jaguar\Exception\InvalidDimensionException
     * @throws \Jaguar\Exception\Canvas\CanvasCreationException
     */
    public function create(Dimension $dimension);

    /**
     * Create new canvas from file
     * 
     * @param string $image
     * 
     * @return \Jaguar\Canvas\CanvasInterface self
     * 
     * @throws \InvalidArgumentException
     * @throws \Jaguar\Exception\Canvas\CanvasCreationException
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
     * @return \Jaguar\Canvas\CanvasInterface self
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasCreationException
     */
    public function fromString($string);

    /**
     * Draw drawable object on the current canvas
     * 
     * @param \Jaguar\Canvas\Drawable\DrawableInterface $drawable
     * @param Jaguar\Canvas\Drawable\StyleInterface $style
     * 
     * @return \Jaguar\Canvas\CanvasInterface self
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function draw(DrawableInterface $drawable, StyleInterface $style = null);

    /**
     * Merge two canvas together 
     * 
     * <b>Note :</b>
     * 
     * if <tt>$srcBox</t> or <tt>$destBox</tt> is null then a new box object 
     * will be created its dimension equlas the <tt>$src</tt> dimension 
     * and at (0,0) coordinate 
     * 
     * @param \Jaguar\Canvas\CanvasInterface $src the canvas that should be merged
     *                                            into current one
     * 
     * @param \Jaguar\Box $srcBox Box from src canvas
     * @param \Jaguar\Box $destBox Box for the current canvas 
     * 
     * @return \Jaguar\Canvas\CanvasInterface self
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasException
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function paste(CanvasInterface $src, Box $srcBox = null, Box $destBox = null);

    /**
     * Fill canvas with color
     * 
     * @param \Jaguar\Color\ColorInterface $color
     * @param \Jaguar\Coordinate $coordinate start point
     * 
     * @return \Jaguar\Canvas\CanvasInterface self
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    public function fill(ColorInterface $color, Coordinate $coordinate = null);

    /**
     * Save canvas 
     * 
     * @param string $path The path to save the canvas to. If not set or NULL,
     *                     the raw canvas stream will be outputted directly.
     * 
     * @return \Jaguar\Canvas\CanvasInterface self
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     * @throws \Jaguar\Exception\Canvas\CanvasOutputException
     */
    public function save($path = null);

    /**
     * Get a string representation of the current canvas object
     * 
     * @return string
     */
    public function __toString();
}

