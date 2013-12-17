<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\Coordinate;
use Jaguar\CanvasInterface;
use Jaguar\Drawable\StyleInterface;
use Jaguar\Exception\DrawableException;

class Line extends AbstractStyledDrawable
{
    private $startCoordinate;
    private $endCoordinate;

    /**
     * Construct new line object
     *
     * @param \Jaguar\Coordinate $sc
     * @param \Jaguar\Coordinate $ec
     */
    public function __construct(
    Coordinate $sc = null, Coordinate $ec = null, ColorInterface $color = null)
    {
        parent::__construct($color);
        $start = $sc === null ? new Coordinate() : $sc;
        $end = $ec === null ? new Coordinate() : $ec;
        $this->setLocation($start, $end);
    }

    /**
     * Set Start Coordinate
     *
     * @param \Jaguar\Coordinate $sc start coordinate
     *
     * @return \Jaguar\Drawable\Line
     */
    public function setStart(Coordinate $sc)
    {
        $this->startCoordinate = $sc;

        return $this;
    }

    /**
     * Get Start Coordinate
     *
     * @return \Jaguar\Coordinate
     */
    public function getStart()
    {
        return $this->startCoordinate;
    }

    /**
     * Set End Coordinate
     *
     * @param \Jaguar\Coordinate $ec end coordinate
     *
     * @return \Jaguar\Drawable\Line
     */
    public function setEnd(Coordinate $ec)
    {
        $this->endCoordinate = $ec;

        return $this;
    }

    /**
     * Get End Coordinate
     *
     * @return \Jaguar\Coordinate
     *
     */
    public function getEnd()
    {
        return $this->endCoordinate;
    }

    /**
     * Set Line Start And End Coordinate
     *
     * @param \Jaguar\Coordinate $start
     * @param \Jaguar\Coordinate $end
     *
     * @return \Jaguar\Drawable\Line
     */
    public function setLocation(Coordinate $start, Coordinate $end)
    {
        return $this->setStart($start)->setEnd($end);
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Line Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if (!$this->getStart()->equals($other->getStart())) {
            return false;
        }

        if (!$this->getEnd()->equals($other->getEnd())) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function doDraw(CanvasInterface $canvas, StyleInterface $style = null)
    {

        $sx = $this->getStart()->getX();
        $sy = $this->getStart()->getY();
        $ex = $this->getEnd()->getX();
        $ey = $this->getEnd()->getY();

        $color = (is_null($style)) ? $this->getColor()->getValue() :
                $style->apply($canvas, $this)->getValue();

        if (false == @imageline(
                        $canvas->getHandler()
                        , $sx
                        , $sy
                        , $ex
                        , $ey
                        , $color
                )
        ) {
            throw new DrawableException(sprintf(
                    'Colud Not Draw The Line Object From "%s" To "%s"'
                    , $this->getStart(), $this->getEnd()
            ));
        }
    }

    /**
     * Returns a string representation for the line object
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "["
                . "start={$this->getStart()},"
                . "end={$this->getEnd()}"
                . "]";
    }

    /** Clone Line */
    public function __clone()
    {
        parent::__clone();
        $this->startCoordinate = clone $this->startCoordinate;
        $this->endCoordinate = clone $this->endCoordinate;
    }

}
