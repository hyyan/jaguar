<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Canvas;

use Jaguar\Box;
use Jaguar\Dimension;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;
use Jaguar\Canvas\Drawable;
use Jaguar\Color\RGBColor;
use Jaguar\Exception\Canvas\CanvasDestroyException;
use Jaguar\Exception\Canvas\CanvasEmptyException;
use Jaguar\Exception\Canvas\CanvasCreationException;
use Jaguar\Exception\InvalidDimensionException;
use Jaguar\Exception\Canvas\CanvasException;
use Jaguar\Canvas\Drawable\DrawableInterface;

abstract class AbstractCanvas implements CanvasInterface {

    protected $handler;

    /**
     * Constrcut new canvas
     * 
     * @param \Jaguar\Dimension $dimension
     * 
     * @throws \Jaguar\Exception\InvalidDimensionException
     * @throws \Jaguar\Exception\Canvas\CanvasCreationException
     */
    public function __construct(Dimension $dimension = null) {
        if (null !== $dimension) {
            $this->create($dimension);
        }
    }

    /**
     * Check if the given resource is gd resource
     * 
     * @return boolean
     */
    public function isGdResource($resource) {
        return (
                @is_resource($resource) &&
                @get_resource_type($resource) === "gd"

                ) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function isHandlerSet() {
        return $this->getHandler() ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler() {
        return $this->handler;
    }

    /**
     * {@inheritdoc}
     */
    public function setHandler($handler) {
        if (!$this->isGdResource($handler)) {
            throw new \InvalidArgumentException('Invalid Gd Handler');
        }

        $this->convertPaletteToTrueColor($handler);
        if ($this->isHandlerSet()) {
            $this->destroy();
        }
        $this->handler = $handler;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth() {
        return $this->isHandlerSet() ? @imagesx($this->getHandler()) : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight() {
        return $this->isHandlerSet() ? @imagesy($this->getHandler()) : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getDimension() {
        return new Dimension($this->getWidth(), $this->getHeight());
    }

    /**
     * {@inheritdoc}
     */
    public function isTrueColor() {
        $this->assertEmpty();
        return @imageistruecolor($this->getHandler()) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function alphaBlending($bool) {
        $this->assertEmpty();
        if (false == @imagealphablending($this->getHandler(), $bool)) {
            throw new CanvasException(sprintf(
                    'Faild To Set Alpha Blending Mode On The Canvas "%s"'
                    , (string) $this
            ));
        };
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCopy() {
        $this->assertEmpty();
        return (clone $this);
    }

    /**
     * {@inheritdoc}
     */
    public function create(Dimension $dimension) {

        $x = $dimension->getWidth();
        $y = $dimension->getHeight();

        if ($x <= 0 || $y <= 0) {
            throw new InvalidDimensionException(sprintf(
                    "Invalid Dimension %s ", (string) $dimension
            ));
        }

        $handler = @imagecreatetruecolor($x, $y);

        if (false === $handler) {
            throw new CanvasCreationException(sprintf(
                    'Unable To Create The Canvas "%s"', (string) $this
            ));
        }

        $this->setHandler($handler);
        $this->fill(new RGBColor(255, 255, 255));
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromCanvas(CanvasInterface $canvas) {
        $copy = $canvas->getCopy();
        $this->setHandler($copy->getHandler());
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromString($string) {
        $handler = @imagecreatefromstring($string);
        if (!$this->isGdResource($handler)) {
            throw new CanvasCreationException("Invalid Canvas String");
        }
        $this->setHandler($handler);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromFile($file) {
        $this->isValidFile($file);
        $this->doLoadFromFile($file);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function draw(DrawableInterface $drawable) {
        $drawable->draw($this);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function paste(CanvasInterface $src, Box $srcBox = null, Box $destBox = null) {

        $this->assertEmpty();
        if (!$src->isHandlerSet()) {
            throw new CanvasEmptyException(
            "Could Not Execute Paste - Source Canvas Handler Is Not Set"
            );
        }

        $srcDimension = $src->getDimension();
        $srcBox = ($srcBox === null) ? new Box($srcDimension) : $srcBox;
        $destBox = ($destBox === null) ? new Box($srcDimension) : $destBox;

        if (false == @imagecopyresampled(
                        $this->getHandler()
                        , $src->getHandler()
                        , $destBox->getX()
                        , $destBox->getY()
                        , $srcBox->getX()
                        , $srcBox->getY()
                        , $destBox->getWidth()
                        , $destBox->getHeight()
                        , $srcBox->getWidth()
                        , $srcBox->getHeight())
        ) {
            throw new CanvasException(sprintf(
                    'Could Not Paste "%s" On "%s"'
                    , (string) $src, (string) $this
            ));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fill(ColorInterface $color, Coordinate $coordinate = null) {
        $this->assertEmpty();
        $coordinate = ($coordinate === null) ? new Coordinate() : $coordinate;
        if (
                false == @imagefill(
                        $this->getHandler()
                        , $coordinate->getX()
                        , $coordinate->getY()
                        , $color->getValue()
                )
        ) {
            throw new CanvasException(sprintf(
                    'Could Not Fill Canvas "%s" With The Color "%s"'
                    , (string) $this, (string) $color
            ));
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save($path = null) {
        $this->assertEmpty();
        $this->doSave($path);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy() {
        $this->assertEmpty();
        if (!@imagedestroy($this->getHandler())) {
            throw new CanvasDestroyException(sprintf(
                    'Could Not Destroy The Canvas "%s"', (string) $this
            ));
        }
        $this->handler = null;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() {
        $result = get_called_class();
        $suffix = "[Empty Canvas]";
        if ($this->isHandlerSet()) {
            $properties = $this->getToStringProperties();
            $propertiesAsString = '';
            foreach ($properties as $key => $value) {
                $propertiesAsString.="$key=$value,";
            }
            $suffix = "[" . rtrim($propertiesAsString, ',') . "]";
        }
        return ($result . $suffix);
    }

    /**
     * Create a copy of the current canvas
     */
    public function __clone() {
        if ($this->isHandlerSet()) {
            $class = get_called_class();
            $clone = new $class;
            $clone->create($this->getDimension());
            $clone->paste($this);
            $this->handler = $clone->getHandler();
        }
    }

    /**
     * Check if the given string represents a path to a readable file
     * 
     * @param string $file
     * 
     * @throws \InvalidArgumentException
     */
    protected function isValidFile($file) {
        if (!is_file($file) || !is_readable($file)) {
            throw new \InvalidArgumentException('File Is Not Readable');
        }
    }

    /**
     * Check if the canvas is empty 
     * 
     * @throws \Jaguar\Exception\Canvas\CanvasEmptyException
     */
    protected function assertEmpty() {
        if (false === $this->isHandlerSet()) {
            throw new CanvasEmptyException();
        }
    }

    /**
     * Convert pallete to true color 
     * 
     * @param resource $resource gd reource
     */
    protected function convertPaletteToTrueColor(&$resource) {

        // we are ignoring imagepalettetotruecolor function in php5.5

        if (@imageistruecolor($resource)) {
            return true;
        }
        $dst = @imagecreatetruecolor(@imagesx($resource), @imagesy($resource));
        @imagealphablending($dst, false);
        @imagesavealpha($dst, true);
        @imagecopy(
                        $dst
                        , $resource
                        , 0, 0, 0, 0
                        , @imagesx($resource)
                        , @imagesy($resource)
        );
        @imagealphablending($dst, true);
        @imagesavealpha($dst, false);
        @imagedestroy($resource);
        $resource = $dst;
    }

    /**
     * @see Canvas::fromFile
     */
    abstract protected function doLoadFromFile($file);

    /**
     * @see Canvas::save
     */
    abstract protected function doSave($path);

    /**
     * Get string properties that must be displayed when the canvas is converted
     * to string
     * 
     * @return array array of properties as key/value
     */
    abstract protected function getToStringProperties();
}

