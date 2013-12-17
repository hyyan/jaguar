<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\CanvasInterface;
use Jaguar\Font;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;
use Jaguar\Box;
use Jaguar\Dimension;
use Jaguar\Drawable\Text\Plain;
use Jaguar\Exception\CanvasEmptyException;

class Text extends AbstractDrawable
{
    private $angle;
    private $font;
    private $spacing;
    private $string;
    private $coordinate;

    /**
     * Constrcut new text object
     *
     * @param type                         $string
     * @param \Jaguar\Coordinate           $coordinate
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct($string = null, Coordinate $coordinate = null, ColorInterface$color = null)
    {
        parent::__construct($color);
        $this->setString($string)
                ->setCoordinate($coordinate === null ? new Coordinate() : $coordinate)
                ->setAngle(0)
                ->setLineSpacing(1.0)
                ->setFont(new Font(__DIR__ . '/../Resources/Fonts/arial.ttf'))
                ->setFontSize(12);
    }

    /**
     * Set string
     *
     * @param string $string
     *
     * @return \Jaguar\Drawable\Text
     */
    public function setString($string)
    {
        $this->string = (string) $string;

        return $this;
    }

    /**
     * Get string
     *
     * @return string
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set Coordinate
     *
     * The coordinate will define the basepoint of the first character
     * (roughly the lower-left corner of the character).
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Drawable\Text
     */
    public function setCoordinate(Coordinate $coordinate)
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    /**
     * Get coordinate
     *
     * @return \Jaguar\Coordinate
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    /**
     * Set font file
     *
     * @param \Jaguar\Font $font
     *
     * @return \Jaguar\Drawable\Text
     */
    public function setFont(Font $font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Get font file
     *
     * @return \Jaguar\Font
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set text angle
     *
     * @param float $angle
     *
     * @return \Jaguar\Draw\Text
     */
    public function setAngle($angle)
    {
        $this->angle = (float) $angle;

        return $this;
    }

    /**
     * Get text angle
     *
     * @return float
     */
    public function getAngle()
    {
        return $this->angle;
    }

    /**
     * Set the line spacing
     *
     * @param float $spacing
     *
     * @return \Jaguar\Draw\Text
     */
    public function setLineSpacing($spacing)
    {
        $this->spacing = (float) $spacing;

        return $this;
    }

    /**
     * Get line spacing
     *
     * @return float
     */
    public function getLineSpacing()
    {
        return $this->spacing;
    }

    /**
     * Set font size
     *
     * @see \Jaguar\Font::setFontSize
     *
     * @param integer $size
     *
     * @return \Jaguar\Draw\Text
     */
    public function setFontSize($size)
    {
        $this->getFont()->setFontSize($size);

        return $this;
    }

    /**
     * Get font size
     *
     * @see \Jaguar\Font::getFontSize
     *
     * @return integer
     */
    public function getFontSize()
    {
        return $this->getFont()->getFontSize();
    }

    /**
     * Get bouding box for the current text object
     *
     * @return \Jaguar\Box box which this text fits inside
     */
    public function getBoundingBox()
    {
        $rect = imageftbbox(
                $this->getFontSize()
                , $this->getAngle()
                , $this->getFont()
                , $this->getString()
                , array('linespacing' => $this->getLineSpacing())
        );

        $minX = min(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $maxX = max(array($rect[0], $rect[2], $rect[4], $rect[6]));
        $minY = min(array($rect[1], $rect[3], $rect[5], $rect[7]));
        $maxY = max(array($rect[1], $rect[3], $rect[5], $rect[7]));

        $dx = abs($this->getCoordinate()->getX() - (abs($minX) - 1));
        $dy = abs($this->getCoordinate()->getY() - (abs($minY) - 1));

        $width = $maxX - $minX;
        $height = $maxY - $minY;

        $padding = $this->getFontSize();
        $dimension = new Dimension(($width + ($padding * 2)), ($height + ($padding * 2)));
        $coordinate = new Coordinate(($dx - $padding), ($dy - $padding));

        return new Box($dimension, $coordinate);
    }

    /**
     * Draw text on the given canvas using the given text drawer
     *
     * @param \Jaguar\CanvasInterface              $canvas
     * @param \Jaguar\Drawable\TextDrawerInterface $drawer
     *
     * @return \Jaguar\Drawable\Text
     * @throws CanvasEmptyException
     */
    final public function draw(CanvasInterface $canvas, TextDrawerInterface $drawer = null)
    {
        if (!$canvas->isHandlerSet()) {
            throw new CanvasEmptyException(sprintf(
                    'Can Not Draw Text (%s) - Canvas Is Empty'
                    , (string) $this
            ));
        }
        $this->doDraw($canvas, $drawer);

        return $this;
    }

    /**
     * @see \Jaguar\Drawable\Text::draw
     */
    protected function doDraw(CanvasInterface $canvas, TextDrawerInterface $drawer = null)
    {
        $drawer = ($drawer === null) ? new Plain() : $drawer;
        $drawer->apply($canvas, $this);
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Text Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if ($this->getString() !== $other->getString()) {
            return false;
        }

        if (!$this->getFont()->equals($other->getFont())) {
            return false;
        }

        if (!$this->getBoundingBox()->equals($other->getBoundingBox())) {
            return false;
        }

        return true;
    }

    /**
     * Clone Text
     */
    public function __clone()
    {
        parent::__clone();
        $this->font = clone $this->font;
        $this->coordinate = clone $this->coordinate;
    }

    /**
     * Get string representation for the current text
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf(
                '%s(%s)[Font=%s,Coordinate=%s]'
                , get_called_class()
                , substr($this->getString(), 0, 30)
                , (string) $this->getFont()
                , (string) $this->getCoordinate()
        );
    }

}
