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

class Dimension implements EqualsInterface
{
    private $width;
    private $height;

    /**
     * construct new dimension object
     *
     * @param integereger $width
     * @param integereger $height
     */
    public function __construct($width = 0, $height = 0)
    {
        $this->translate($width, $height);
    }

    /**
     * Set Width
     *
     * @param integer $width
     *
     * @return \Jaguar\Dimension
     */
    public function setWidth($width)
    {
        $this->width = (integer) ceil($width);

        return $this;
    }

    /**
     * Set Height
     *
     * @param integer $height
     *
     * @return \Jaguar\Dimension
     */
    public function setHeight($height)
    {
        $this->height = (integer) ceil($height);

        return $this;
    }

    /**
     * Get Width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get Height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set size
     *
     * set new width and height for the current dimension using the width and
     * the hight of the passed dimension
     *
     * @param \Jaguar\Dimension $dimension
     *
     * @return \Jaguar\Dimension
     */
    public function setSize(Dimension $dimension)
    {
        return $this->setWidth($dimension->getWidth())
                        ->setHeight($dimension->getHeight());
    }

    /**
     * Get new Dimension object with same width and height
     *
     * @return \Jaguar\Dimension
     */
    public function getSize()
    {
        return new self($this->getWidth(), $this->getHeight());
    }

    /**
     * Rsize the current dimenison
     *
     * set new width and height for the current dimension object
     *
     * @param integer $width
     * @param integer $height
     *
     * @return \Jaguar\Dimension
     */
    public function resize($width, $height)
    {
        return $this->setWidth($width)->setHeight($height);
    }

    /**
     * Translates this dimension, with size (w,h),
     * by {dx} and {dy} so that it now represents
     * the dimension {dx+w,dy+h}
     *
     * @param integer $dx
     * @param integer $dy
     *
     * @return \Jaguar\Dimension
     */
    public function translate($dx, $dy)
    {
        return $this->setWidth($dx + $this->getWidth())
                        ->setHeight($dy + $this->getHeight());
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Dimension Object');
        }

        if (
                ($other->getWidth() == $this->getWidth()) &&
                ($other->getHeight() == $this->getHeight())
        ) {
            return true;
        }

        return false;
    }

    /**
     * Returns a string representation for the current dimension object
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "["
                . "width={$this->getWidth()},"
                . "height={$this->getHeight()}"
                . "]";
    }

}
