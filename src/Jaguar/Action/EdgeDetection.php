<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface;

class EdgeDetection extends AbstractAction
{
    const GRADIENT_NORTH = 'gradient.north';
    const GRADIENT_WEST = 'gradient.west';
    const GRADIENT_EAST = 'gradient.east';
    const GRADIENT_SOUTH = 'gradient.souht';
    const GRADIENT_NORTH_EAST = 'gradient.north_east';
    const GRADIENT_NORTH_WEST = 'gradient.north_west';
    const GRADIENT_SOUTH_EAST = 'gradient.souht_east';
    const GRADIENT_SOUTH_WEST = 'gradient.souht_west';
    const LINE_HORIZONTAL = 'line.horizontal';
    const LINE_VERTICAL = 'line.vertical';
    const LINE_LEFT_DIAGONAL = 'line.left';
    const LINE_RIGHT_DIAGONAL = 'line.right';
    const SOBEL_HORIZONTAL = 'sobel.horizontal';
    const SOBEL_VERTICAL = 'sobel.vertical';
    const PREWITT_HORIZONTAL = 'prewitt.horizontal';
    const PREWITT_VERTICAL = 'prewitt.vertical';
    const SCHARR_HORIZONTAL = 'scharr.horizontal';
    const SCHARR_VERTICAL = 'scharr.vertical';
    const EMBOSS_NORTH = 'emboss.north';
    const EMBOSS_NORTH_EAST = 'emboss.north_east';
    const EMOBOSS_EAST = 'emboss.east';
    const EMBOSS_SOUTH_EAST = 'emboss.south_east';
    const EMBOSS_SOUTH = 'emboss.souht';
    const EMBOSS_SOUTH_WEST = 'emboss.south_west';
    const EMBOSS_WEST = 'emboss.west';
    const EMBOSS_NORTH_WEST = 'emboss.north_west';
    const LAPLACIAN_FILTER1 = 'laplacian_1';
    const LAPLACIAN_FILTER2 = 'laplacian_2';
    const LAPLACIAN_FILTER3 = 'laplacian_3';
    const LAPLACIAN_FILTER4 = 'laplacian_4';
    const FINDEDGE = 'findeedge';

    private $type;
    private $divisor;
    private $offset;
    private static $SUPPORTED_TYPES = array(
        self::GRADIENT_NORTH => array(
            array(-1.0, -2.0, -1.0),
            array(0.0, 0.0, 0.0),
            array(1.0, 2.0, 1.0)
        ),
        self::GRADIENT_WEST => array(
            array(-1.0, 0.0, 1.0),
            array(-2.0, 0.0, 2.0),
            array(-1.0, 0.0, 1.0)
        ),
        self::GRADIENT_EAST => array(
            array(1.0, 0.0, -1.0),
            array(2.0, 0.0, -2.0),
            array(1.0, 0.0, -1.0)
        ),
        self::GRADIENT_SOUTH => array(
            array(1.0, 2.0, 1.0),
            array(0.0, 0.0, 0.0),
            array(-1.0, -2.0, -1.0)
        ),
        self::GRADIENT_NORTH_EAST => array(
            array(0.0, -1.0, -2.0),
            array(1.0, 0.0, -1.0),
            array(2.0, 1.0, 0.0)
        ),
        self::GRADIENT_NORTH_WEST => array(
            array(-2.0, -1.0, 0.0),
            array(-1.0, 0.0, 1.0),
            array(0.0, 1.0, 2.0)
        ),
        self::GRADIENT_SOUTH_EAST => array(
            array(2.0, 1.0, 0.0),
            array(1.0, 0.0, -1.0),
            array(0.0, -1.0, -2.0)
        ),
        self::GRADIENT_SOUTH_WEST => array(
            array(0.0, 1.0, 2.0),
            array(-1.0, 0.0, 1.0),
            array(-2.0, -1.0, 0.0)
        ),
        self::LINE_HORIZONTAL => array(
            array(-1.0, -1.0, -1.0),
            array(2.0, 2.0, 2.0),
            array(-1.0, -1.0, -1.0)
        ),
        self::LINE_VERTICAL => array(
            array(-1.0, 2.0, -1.0),
            array(-1.0, 2.0, -1.0),
            array(-1.0, 2.0, -1.0)
        ),
        self::LINE_LEFT_DIAGONAL => array(
            array(2.0, -1.0, -1.0),
            array(-1.0, 2.0, -1.0),
            array(-1.0, -1.0, 2.0)
        ),
        self::LINE_RIGHT_DIAGONAL => array(
            array(-1.0, -1.0, 2.0),
            array(-1.0, 2.0, -1.0),
            array(2.0, -1.0, -1.0)
        ),
        self::SOBEL_HORIZONTAL => array(
            array(-1.0, 0.0, 1.0),
            array(-2.0, 0.0, 2.0),
            array(-1.0, 0.0, 1.0)
        ),
        self::SOBEL_VERTICAL => array(
            array(1.0, 2.0, 1.0),
            array(0.0, 0.0, 0.0),
            array(-1.0, -2.0, -1.0)
        ),
        self::PREWITT_HORIZONTAL => array(
            array(-1.0, 0.0, 1.0),
            array(-1.0, 0.0, 1.0),
            array(-1.0, 0.0, 1.0)
        ),
        self::PREWITT_VERTICAL => array(
            array(1.0, 1.0, 1.0),
            array(0.0, 0.0, 0.0),
            array(-1.0, -1.0, -1.0)
        ),
        self::SCHARR_HORIZONTAL => array(
            array(-3.0, 0.0, 3.0),
            array(-1.0, 0.0, 1.0),
            array(-3.0, 0.0, 3.0)
        ),
        self::SCHARR_VERTICAL => array(
            array(3.0, 10.0, 3.0),
            array(0.0, 0.0, 0.0),
            array(-3.0, -10.0, -3.0)
        ),
        self::EMBOSS_NORTH => array(
            array(0, -1, 0),
            array(0, 0, 0),
            array(0, 1, 0),
        ),
        self::EMBOSS_NORTH_EAST => array(
            array(0, 0, -1),
            array(0, 0, 0),
            array(1, 0, 0)
        ),
        self::EMOBOSS_EAST => array(
            array(0, 0, 0),
            array(1, 0, -1),
            array(0, 0, 0)
        ),
        self::EMBOSS_SOUTH_EAST => array(
            array(1, 0, 0),
            array(0, 0, 0),
            array(0, 0, -1)
        ),
        self::EMBOSS_SOUTH => array(
            array(0, 1, 0),
            array(0, 0, 0),
            array(0, -1, 0)
        ),
        self::EMBOSS_SOUTH_WEST => array(
            array(0, 0, 1),
            array(0, 0, 0),
            array(-1, 0, 0)
        ),
        self::EMBOSS_WEST => array(
            array(0, 0, 0),
            array(-1, 0, 1),
            array(0, 0, 0)
        ),
        self::EMBOSS_NORTH_WEST => array(
            array(-1, 0, 0),
            array(0, 0, 0),
            array(0, 0, 1)
        ),
        self::FINDEDGE => array(
            array(-1, -1, -1)
            , array(-2, 8, -1)
            , array(-1, -1, -1)
        ),
        self::LAPLACIAN_FILTER1 => array(
            array(0.0, -1.0, 0.0),
            array(-1.0, 4.0, -1.0),
            array(0.0, -1.0, 0.0)
        ),
        self::LAPLACIAN_FILTER2 => array(
            array(0.0, -1.0, 0.0),
            array(-1.0, 5.0, -1.0),
            array(0.0, -1.0, 0.0)
        ),
        self::LAPLACIAN_FILTER3 => array(
            array(-1.0, -1.0, -1.0),
            array(-1.0, 8.0, -1.0),
            array(-1.0, -1.0, -1.0)
        ),
        self::LAPLACIAN_FILTER4 => array(
            array(1.0, -2.0, 1.0),
            array(-2.0, 4.0, -2.0),
            array(1.0, -2.0, 1.0)
        )
    );

    /**
     * construct new edge detection action
     *
     * @param string  $type
     * @param integer $divisor
     * @param integer $offset
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($type = self::GRADIENT_NORTH, $divisor = 1.0, $offset = 0.0)
    {
        $this->setType($type, $divisor, $offset);
    }

    /**
     * Set edge type
     *
     * @param string  $type
     * @param integer $divisor
     * @param integer $offset
     *
     * @return \Jaguar\Action\EdgeDetection
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type, $divisor = 1.0, $offset = 0.0)
    {
        if (!array_key_exists($type, self::$SUPPORTED_TYPES)) {
            throw new \InvalidArgumentException('Invalid Edge Type');
        }
        $this->type = $type;
        $this->divisor = $divisor;
        $this->offset = $offset;

        return $this;
    }

    /**
     * Get edge type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function doApply(CanvasInterface $canvas)
    {
        $matrix = self::$SUPPORTED_TYPES[$this->getType()];
        $con = new Convolution(
                $matrix
                , $this->divisor
                , $this->offset
        );
        $con->apply($canvas);
    }

}
