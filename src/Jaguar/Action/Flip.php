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
use Jaguar\Dimension;
use Jaguar\Box;
use Jaguar\Coordinate;

class Flip extends AbstractAction
{
    const FLIP_VERTICAL = "flip.vertical";
    const FLIP_HORIZONTAL = "flip.horizontal";
    const FLIP_BOTH = "flip.both";

    private $flipDirection;
    private static $supportedFlipDirection = array(
        self::FLIP_BOTH, self::FLIP_HORIZONTAL, self::FLIP_VERTICAL
    );

    /**
     * construct new flip action
     *
     * @param type $direction
     */
    public function __construct($direction = self::FLIP_HORIZONTAL)
    {
        $this->setDirection($direction);
    }

    /**
     * Set flip direction
     *
     * @param string $direction any of Flip::FLIP_*
     *
     * @return \Jaguar\Action\Flip
     *
     * @throws \InvalidArgumentException
     */
    public function setDirection($direction)
    {
        if (!in_array($direction, self::$supportedFlipDirection)) {
            throw new \InvalidArgumentException(sprintf(
                    '"%s" Is Not Valid Flip Direction', (string) $direction
            ));
        }
        $this->flipDirection = $direction;

        return $this;
    }

    /**
     * Get flip direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->flipDirection;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $width = $canvas->getWidth();
        $height = $canvas->getHeight();

        $copy = new \Jaguar\Canvas($canvas->getDimension());

        $srcBox = null;
        $destBox = null;

        switch ($this->getDirection()) {
            case self::FLIP_VERTICAL:
                $srcBox = new Box(
                        new Dimension($width, - $height)
                        , new Coordinate(0, $height - 1)
                );
                $destBox = new Box(
                        new Dimension($width, $height)
                        , new Coordinate(0, 0)
                );
                break;
            case self::FLIP_HORIZONTAL:
                $srcBox = new Box(
                        new Dimension(-$width, $height)
                        , new Coordinate($width - 1, 0)
                );
                $destBox = new Box(
                        new Dimension($width, $height)
                        , new Coordinate(0, 0)
                );
                break;
            case self::FLIP_BOTH:
                $srcBox = new Box(
                        new Dimension(-$width, -$height)
                        , new Coordinate($width - 1, $height - 1)
                );
                $destBox = new Box(
                        new Dimension($width, $height)
                        , new Coordinate(0, 0)
                );
                break;
        }

        $copy->paste($canvas, $srcBox, $destBox);

        $canvas->destroy();
        $canvas->setHandler($copy->getHandler());
    }

}
