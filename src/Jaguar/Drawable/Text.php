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
use Jaguar\Exception\DrawableException;
use Jaguar\Color\ColorInterface;

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
     * @param type $string
     * @param \Jaguar\Coordinate $coordinate
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct($string = null, Coordinate $coordinate = null, ColorInterface$color = null)
    {
        parent::__construct($color);
        $this->setString($string)
                ->setCoordinate($coordinate === null ? new Coordinate() : $coordinate)
                ->setAngle(0)
                ->setLineSpacing(1.0)
                ->setFont(new Font(__DIR__ . '/../Resources/Fonts/arial.ttf'));
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
     * @return \Artist\Draw\Text 
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
     * @return \Artist\Draw\Text 
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
     * {@inheritdoc}
     */
    protected function doDraw(CanvasInterface $canvas)
    {
        if (
                false == @imagefttext(
                        $canvas->getHandler()
                        , $this->getFont()->getFontSize()
                        , $this->getAngle()
                        , $this->getCoordinate()->getX()
                        , $this->getCoordinate()->getY()
                        , $this->getColor()->getValue()
                        , $this->getFont()
                        , $this->getString()
                        , array('linespacing' => $this->getLineSpacing())
                )
        ) {
            throw new DrawableException(sprintf(
                    'Could Not Draw The Text "%s"', (string) $this
            ));
        }
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

        if (!$this->getCoordinate()->equals($other->getCoordinate())) {
            return false;
        }

        if (!$this->getFont()->equals($other->getFont())) {
            return false;
        }

        if (0 !== bccomp($this->getAngle(), $other->getAngle())) {
            return false;
        }

        if (0 !== bccomp($this->getLineSpacing(), $other->getLineSpacing())) {
            return false;
        }

        return true;
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
