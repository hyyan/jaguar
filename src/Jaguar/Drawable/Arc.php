<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable;

use Jaguar\Exception\DrawableException;
use Jaguar\CanvasInterface;
use Jaguar\Dimension;
use Jaguar\Coordinate;
use Jaguar\Color\ColorInterface;

class Arc extends FilledDrawable
{
    private $dimension;
    private $center;
    private $sd;
    private $ed;
    private $anglesConnected;
    private $roundedEdge;
    private $anglesConnectedToCenter;

    /**
     * construct new arc
     *
     * @param \Jaguar\Dimension            $dimension
     * @param \Jaguar\Coordinate           $center
     * @param \Jaguar\Color\ColorInterface $color
     */
    public function __construct(Dimension $dimension = null, Coordinate $center = null, ColorInterface $color = null)
    {
        parent::__construct($color);
        $this->setDimension($dimension === null ? new Dimension() : $dimension)
                ->setCenter($center === null ? new Coordinate() : $center)
                ->setDegree(0, 360)
                ->connectAngles(false)
                ->connectAnglesToCenter(false)
                ->setRounded(true);
    }

    /**
     * Set dimension
     *
     * @param \Jaguar\Dimension $dimension
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function setDimension(Dimension $dimension)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return \Jaguar\Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set center
     *
     * @param \Jaguar\Coordinate $coordinate
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function setCenter(Coordinate $coordinate)
    {
        $this->center = $coordinate;

        return $this;
    }

    /**
     * Get center
     *
     * @return \Jaguar\Coordinate
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * Set Start Degree
     *
     * @param integer $degree
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function setStartDegree($degree)
    {
        $this->sd = $degree;

        return $this;
    }

    /**
     * Get Start Degree
     *
     * @return integer
     */
    public function getStartDegree()
    {
        return $this->sd;
    }

    /**
     * Set End Degree
     *
     * @param integer $degree
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function setEndDegree($degree)
    {
        $this->ed = $degree;

        return $this;
    }

    /**
     * get End Degree
     *
     * @return integer
     */
    public function getEndDegree()
    {
        return $this->ed;
    }

    /**
     * Set Start And End Degree
     *
     * @param integer $start start degree
     * @param integer $end   end degree
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function setDegree($start, $end)
    {
        return $this->setStartDegree($start)->setEndDegree($end);
    }

    /**
     * Connect Angles
     *
     * Connet the starting and ending angles with a straight line
     *
     * @param boolean $boolean True To Connect Angles togther
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function connectAngles($boolean)
    {
        $this->anglesConnected = (boolean) $boolean;

        return $this;
    }

    /**
     * Check If Angles are connected
     *
     * @return boolean
     */
    public function isAnglesConnected()
    {
        return $this->anglesConnected;
    }

    /**
     * Set Roundded Edge
     *
     * @param boolean $boolean true fo rounded edge
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function setRounded($boolean)
    {
        $this->roundedEdge = $boolean;

        return $this;
    }

    /**
     * Get is rounded
     *
     * @return boolean
     */
    public function isRounded()
    {
        return $this->roundedEdge;
    }

    /**
     * Connect Angles To The Center Of Arc
     *
     * @param boolean $boolean true indicates that the beginning and ending angles
     *                         should be connected to the center
     *
     * @return \Jaguar\Drawable\Arc
     */
    public function connectAnglesToCenter($boolean)
    {
        $this->anglesConnectedToCenter = $boolean;

        return $this;
    }

    /**
     * Check if angles are connected to center
     *
     * @return boolean
     */
    public function isAnglesConnectedToCenter()
    {
        return $this->anglesConnectedToCenter;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Arc Object');
        }

        if (!parent::equals($other)) {
            return false;
        }

        if (!$this->getDimension()->equals($other->getDimension())) {
            return false;
        }
        if (!$this->getCenter()->equals($other->getCenter())) {
            return false;
        }

        if ($this->getStartDegree() != $other->getStartDegree()) {
            return false;
        }

        if ($this->getEndDegree() != $other->getEndDegree()) {
            return false;
        }

        if ($this->isAnglesConnected() != $other->isAnglesConnected()) {
            return false;
        }

        if ($this->isAnglesConnectedToCenter() != $other->isAnglesConnectedToCenter()) {
            return false;
        }

        if ($this->isRounded() != $other->isRounded()) {
            return false;
        }

        return true;
    }

    /**
     * Returns a string representation of the current arc Object
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "["
                . "dimension={$this->getDimension()},"
                . "startDegree={$this->getStartDegree()},"
                . "endDegree={$this->getEndDegree()},"
                . "center={$this->getCenter()}"
                . "]";
    }

    /**
     * Clone Arc
     */
    public function __clone()
    {
        parent::__clone();
        $this->center = clone $this->center;
        $this->dimension = clone $this->dimension;
    }

    /**
     * {@inheritdoc}
     */
    protected function drawFilled(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->drawArc($canvas, $style, true);
    }

    /**
     * {@inheritdoc}
     */
    protected function drawNonFilled(CanvasInterface $canvas, StyleInterface $style = null)
    {
        $this->drawArc($canvas, $style, false);
    }

    /**
     * Draw Arc
     *
     * @param \Jaguar\CanvasInterface         $canvas
     * @param \Jaguar\Drawable\StyleInterface $style
     * @param boolean                         $filled
     *
     * @throws \Jaguar\Exception\DrawableException
     */
    private function drawArc(
    CanvasInterface $canvas, StyleInterface $style = null, $filled = false)
    {
        $color = (is_null($style)) ?
                $this->getColor()->getValue() :
                $style->apply($canvas, $this)->getValue();

        $falgs = array();
        if ($this->isRounded()) {
            $falgs[] = IMG_ARC_PIE;
        }

        if ($this->isAnglesConnected()) {
            $falgs[] = IMG_ARC_CHORD;
        }

        if ($this->isAnglesConnectedToCenter()) {
            $falgs[] = IMG_ARC_EDGED;
        }
        if ($filled === false) {
            $falgs[] = IMG_ARC_NOFILL;
        }

        if (
                false == @imagefilledarc(
                        $canvas->getHandler()
                        , $this->getCenter()->getX()
                        , $this->getCenter()->getY()
                        , $this->getDimension()->getWidth()
                        , $this->getDimension()->getHeight()
                        , $this->getStartDegree()
                        , $this->getEndDegree()
                        , $color
                        , $this->getBitflags($falgs)
                )
        ) {
            throw new DrawableException(sprintf(
                    'Failed To Draw The Arc "%s"', (string) $this
            ));
        }
    }

    /**
     * Get Bitflags
     *
     * @param array $flags
     *
     * @return integer
     */
    private function getBitflags(array $flags)
    {
        $val = null;
        foreach ($flags as $flag) {
            $val = $val | $flag;
        }

        return $val;
    }

}
