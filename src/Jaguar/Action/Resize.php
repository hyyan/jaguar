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

class Resize extends AbstractAction
{
    /**
     * New Resource Dimension
     * @var Dimension
     */
    private $dimension;

    /**
     * construct new Resize Action
     *
     * @param \Jaguar\Dimension $dimension
     */
    public function __construct(Dimension $dimension = null)
    {
        $this->setDimension($dimension === null ? new Dimension(1, 1) : $dimension);
    }

    /**
     * Set dimension
     *
     * @param \Jaguar\Dimension $dimension
     *
     * @return \Jaguar\Action\Resize
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
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $copy = new \Jaguar\Canvas($this->getDimension());
        $copy->paste($canvas, null, new Box($this->getDimension()));
        $canvas->destroy();
        $canvas->setHandler($copy->getHandler());

    }

}
