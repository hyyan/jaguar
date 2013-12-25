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
    const FINDEDGE = 'findeedge';
    const LAPLACIAN = 'laplacian';

    private $type;
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
        self::FINDEDGE => array(
            array(-1, -1, -1)
            , array(-2, 8, -1)
            , array(-1, -1, -1)
        ),
        self::LAPLACIAN => array(
            array(0.0, -1.0, 0.0),
            array(-1.0, 4.0, -1.0),
            array(0.0, -1.0, 0.0)
        )
    );

    /**
     * construct new edge detection action
     *
     * @param string $type
     */
    public function __construct($type = self::GRADIENT_NORTH)
    {
        $this->setType($type);
    }

    /**
     * Set edge type
     *
     * @param string $type
     *
     * @return \Jaguar\Action\EdgeDetection\AbstractEdgeDetection
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if (!array_key_exists($type, self::$SUPPORTED_TYPES)) {
            throw new \InvalidArgumentException('Invalid Edge Type');
        }
        $this->type = $type;

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
                , array_sum(array_map('array_sum', $matrix))
        );
        $con->apply($canvas);
    }

}
