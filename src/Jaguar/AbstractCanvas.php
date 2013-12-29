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
use Jaguar\Dimension;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;
use Jaguar\Color\RGBColor;
use Jaguar\Exception\CanvasEmptyException;
use Jaguar\Exception\CanvasCreationException;
use Jaguar\Exception\InvalidDimensionException;
use Jaguar\Exception\CanvasException;
use Jaguar\Drawable\DrawableInterface;
use Jaguar\Exception\InvalidCoordinateException;
use Jaguar\Drawable\Pixel;
use Jaguar\Exception\CanvasDestroyingException;

abstract class AbstractCanvas implements CanvasInterface
{
    protected $handler;

    /**
     * construct new canvas
     *
     * @param \Jaguar\Dimension|\Jaguar\CanvasInterface|file|string $source
     *        the source could be a dimension object to create a new canvas
     *        , another canvas instance to create from
     *        , file path to load canvas from
     *        or null to take no action
     *
     * @throws \Jaguar\Exception\InvalidDimensionException
     * @throws \Jaguar\Exception\CanvasCreationException
     */
    public function __construct($source = null)
    {
        if ($source instanceof Dimension) {
            $this->create($source);
        } elseif ($source instanceof CanvasInterface) {
            $this->fromCanvas($source);
        } elseif (is_file($source) && @is_readable($source)) {
            $this->fromFile($source);
        }
    }

    /**
     * Check if the given resource is gd resource
     *
     * @return boolean
     */
    public function isGdResource($resource)
    {
        return (
                @is_resource($resource) &&
                @get_resource_type($resource) === "gd"

                ) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function isHandlerSet()
    {
        return $this->getHandler() ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * {@inheritdoc}
     */
    public function setHandler($handler)
    {
        if (!$this->isGdResource($handler)) {
            throw new \InvalidArgumentException('Invalid Gd Handler');
        }

        // we are ignoring imagepalettetotruecolor function in php5.5
        if (@imageistruecolor($handler)) {
            $this->handler = $handler;

            return $this;
        }

        $dest = @imagecreatetruecolor(
                        @imagesx($handler)
                        , @imagesy($handler)
        );

        $this->preserveAlpha($dest, $handler);

        @imagealphablending($dest, false);
        @imagesavealpha($dest, true);

        @imagecopy(
                        $dest
                        , $handler
                        , 0, 0, 0, 0
                        , @imagesx($handler)
                        , @imagesy($handler)
        );

        @imagealphablending($dest, true);
        @imagesavealpha($dest, false);

        $this->handler = $dest;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWidth()
    {
        return $this->isHandlerSet() ? @imagesx($this->getHandler()) : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight()
    {
        return $this->isHandlerSet() ? @imagesy($this->getHandler()) : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getDimension()
    {
        return new Dimension($this->getWidth(), $this->getHeight());
    }

    /**
     * {@inheritdoc}
     */
    public function isTrueColor()
    {
        $this->assertEmpty();

        return @imageistruecolor($this->getHandler()) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    public function alphaBlending($bool)
    {
        $this->assertEmpty();
        if (false == @imagealphablending($this->getHandler(), $bool)) {
            throw new CanvasException(sprintf(
                    'Faild To Set Alpha Blending Mode On The Canvas "%s"'
                    , (string) $this
            ));
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Dimension $dimension)
    {
        $x = $dimension->getWidth();
        $y = $dimension->getHeight();

        if ($x <= 0 || $y <= 0) {
            throw new InvalidDimensionException(sprintf(
                    "Invalid Dimension %s ", (string) $dimension
            ));
        }

        $handler = @imagecreatetruecolor($x, $y);

        if (false == $handler) {
            throw new CanvasCreationException(sprintf(
                    'Unable To Create The Canvas "%s"', (string) $this
            ));
        }
        $this->forceDestory();
        $this->setHandler($handler);
        $this->fill(new RGBColor(0, 0, 0, 127));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromString($string)
    {
        $handler = @imagecreatefromstring($string);
        if (!$this->isGdResource($handler)) {
            throw new CanvasCreationException("Invalid Canvas String");
        }
        $this->forceDestory();
        $this->setHandler($handler);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromFile($file)
    {
        $this->isValidFile($file);
        $this->forceDestory();
        $this->doLoadFromFile($file);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function fromCanvas(CanvasInterface $canvas)
    {
        $copy = $canvas->getCopy();
        $this->forceDestory();
        $this->setHandler($copy->getHandler());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPixel(Coordinate $coordinate)
    {
        $this->assertEmpty();
        $x = $coordinate->getX();
        $y = $coordinate->getY();
        if (($x < 0 || $x > $this->getWidth()) || ($y < 0 || $y > $this->getHeight())) {
            throw new InvalidCoordinateException(sprintf(
                    'OutOfBounds - Invalid Coordinate "%s"', (string) $coordinate
            ));
        }

        $pixel = new Pixel($coordinate);
        $pixel->setColor(
                RGBColor::fromValue(
                        @imagecolorat($this->getHandler(), $x, $y)
                        , true
                )
        );

        return $pixel;
    }

    /**
     * {@inheritdoc}
     */
    public function draw(DrawableInterface $drawable, $style = null)
    {
        $drawable->draw($this, $style);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function paste(CanvasInterface $src, Box $srcBox = null, Box $destBox = null)
    {
        $this->assertEmpty();
        if (!$src->isHandlerSet()) {
            throw new CanvasEmptyException(
            'Could Not Execute Paste - Source Canvas Handler Is Not Set'
            );
        }

        $srcDimension = $src->getDimension();
        $srcBox = ($srcBox === null) ? new Box($srcDimension) : $srcBox;
        $destBox = ($destBox === null) ? new Box($srcDimension) : $destBox;

        $this->preserveAlpha($this->getHandler(), $src->getHandler());
        $this->preserveAlpha($src->getHandler(), $this->getHandler());

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
    public function fill(ColorInterface $color, Coordinate $coordinate = null)
    {
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
    public function save($path = null)
    {
        $this->assertEmpty();
        $this->doSave($path);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCopy()
    {
        $this->assertEmpty();
        $clone = clone $this;
        $clone->create($this->getDimension());
        $clone->paste($this);

        return $clone;
    }

    /**
     * Clone canvas
     */
    public function __clone()
    {
        $this->handler = null;
    }

    /**
     * {@inheritdoc}
     */
    public function destroy()
    {
        if (false == @imagedestroy($this->getHandler())) {
            throw new CanvasDestroyingException();
        }
        $this->handler = null;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
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
     * Check if the given string represents a path to a readable file
     *
     * @param string $file
     *
     * @throws \InvalidArgumentException
     */
    protected function isValidFile($file)
    {
        if (!is_file($file) || !is_readable($file)) {
            throw new \InvalidArgumentException(sprintf(
                    'File "%s" Is Not Readable', (string) $file
            ));
        }
    }

    /**
     * Check if the canvas is empty
     *
     * @throws \Jaguar\Exception\CanvasEmptyException
     */
    protected function assertEmpty()
    {
        if (false === $this->isHandlerSet()) {
            throw new CanvasEmptyException();
        }
    }

    /**
     * Destroy the canvas's handler if set
     */
    protected function forceDestory()
    {
        if ($this->isGdResource($this->getHandler())) {
            $this->destroy();
        }
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

    /**
     * Preserve transparent color read from another resource on given resource
     *
     * @param resource $dest the resource which the transparent color will be saved to
     * @param resource $src  the resource which the transparent color will be read from
     */
    protected function preserveAlpha($dest, $src)
    {
        $transparent = @imagecolortransparent($src);
        if (-1 != $transparent) {
            $color = @imagecolorsforindex($src, $transparent);
            $allocated = @imagecolorallocatealpha(
                            $dest
                            , $color['red']
                            , $color['green']
                            , $color['blue']
                            , $color['alpha']
            );
            @imagecolortransparent($dest, $allocated);
            @imagefill($dest, 0, 0, $allocated);
        }
    }

}
