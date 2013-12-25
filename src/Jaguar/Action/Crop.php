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
use Jaguar\Canvas;
use Jaguar\Dimension;

class Crop extends AbstractAction
{
    private $box;

    /**
     * construct new crop action
     *
     * @param \Jaguar\Box $box
     */
    public function __construct(Box $box = null)
    {
        $this->setBox($box === null ? new Box(new Dimension(1, 1)) : $box);
    }

    /**
     * Set crop box
     *
     * @param \Jaguar\Box $box
     *
     * @return \Jaguar\Action\Crop
     */
    public function setBox(Box $box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get crop box
     *
     * @return \Jaguar\Box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $dimension = $this->getBox()->getDimension();
        $coordinate = $this->getBox()->getCoordinate();

        $new = new Canvas($dimension);
        $new->paste($canvas, new Box($dimension, $coordinate), new Box($dimension));

        $canvas->destroy();
        $canvas->setHandler($new->getHandler());

    }

}
