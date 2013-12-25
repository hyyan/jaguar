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
use Jaguar\Box;
use Jaguar\Coordinate;
use Jaguar\Dimension;

class Mirror extends AbstractAction
{
    const MIRROR_VERTICAL = "MIRROR_VERTICAL";
    const MIRROR_HORIZONTAL = "MIRROR_HORIZONTAL";

    private $direction;
    private static $Supporteddirection = array(
        self::MIRROR_HORIZONTAL, self::MIRROR_VERTICAL
    );

    /**
     * construct new mirror action
     *
     * @param string $direction MirrorAction::MIRROR_VERTICAL Or
     *                          MirrorAction::MIRROR_HORIZONTAL
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($direction = self::MIRROR_HORIZONTAL)
    {
        $this->setDirection($direction);
    }

    /**
     * Set direction
     *
     * @param string $direction MirrorAction::MIRROR_VERTICAL Or
     *                          MirrorAction::MIRROR_HORIZONTAL
     *
     * @return \Jaguar\Action\Mirror
     *
     * @throws \InvalidArgumentException
     */
    public function setDirection($direction)
    {
        if (!in_array($direction, self::$Supporteddirection)) {
            throw new \InvalidArgumentException(sprintf(
                    '"%s" Is Not Valid Mirror Direction', (string) $direction
            ));
        }
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $width = $canvas->getWidth();
        $height = $canvas->getHeight();

        $mirrorPoint = null;
        $srcBox = null;
        $destBox = null;

        switch ($this->getdirection()) {

            case self::MIRROR_VERTICAL:
                $mirrorPoint = $width / 2;
                $srcBox = new Box(
                        new Dimension(-$mirrorPoint, $height)
                        , new Coordinate($mirrorPoint - 1, 0)
                );
                $destBox = new Box(
                        new Dimension($mirrorPoint, $height)
                        , new Coordinate($mirrorPoint, 0)
                );

                break;
            case self::MIRROR_HORIZONTAL:
                $mirrorPoint = $height / 2;
                $srcBox = new Box(
                        new Dimension($width, - $mirrorPoint)
                        , new Coordinate(0, $mirrorPoint - 1)
                );
                $destBox = new Box(
                        new Dimension($width, $mirrorPoint)
                        , new Coordinate(0, $mirrorPoint)
                );
                break;
        }
        $canvas->paste($canvas, $srcBox, $destBox);
    }

}
