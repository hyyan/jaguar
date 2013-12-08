<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\Action\AbstractAction;
use Jaguar\CanvasInterface;

class Overlay extends AbstractAction
{
    private $mount;
    private $overlay;

    /**
     * Constrcut new overlay action
     *
     * @param \Jaguar\CanvasInterface $canvas
     * @param integer                 $mount  in range(0,100)
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(CanvasInterface $overlay, $mount = 10)
    {
        $this->setOverlay($overlay)->setMount($mount);
    }

    /**
     * Set overlay
     *
     * @param \Jaguar\CanvasInterface $canvas
     *
     * @return \Jaguar\Action\Overlay
     */
    public function setOverlay(CanvasInterface $canvas)
    {
        $this->overlay = $canvas;

        return $this;
    }

    /**
     * Get overlay
     *
     * @return \Jaguar\CanvasInterface
     */
    public function getOverlay()
    {
        return $this->overlay;
    }

    /**
     * Set overlay mount
     *
     * @param integer $mount in range(0,100)
     *
     * @return \Jaguar\Action\Overlay
     *
     * @throws \InvalidArgumentException
     */
    public function setMount($mount)
    {
        if ($mount < 0 || $mount > 100) {
            throw new \InvalidArgumentException('Overlay mount must be in range(0,100)');
        }
        $this->mount = $mount;

        return $this;
    }

    /**
     * Get overlay mount
     *
     * @return integer
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * Disable clone
     *
     * @throws \RuntimeException
     */
    public function __clone()
    {
        throw new \RuntimeException('Clone Is Not Possible On Overlay');
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {

        $filter = new \Jaguar\Canvas($canvas->getDimension());
        $filter->paste($this->getOverlay());

        $compine = new \Jaguar\Canvas($canvas->getDimension());
        $compine->paste($canvas);
        $compine->paste($filter);

        imagecopymerge(
                $canvas->getHandler()
                , $compine->getHandler()
                , 0
                , 0
                , 0
                , 0
                , $canvas->getWidth()
                , $canvas->getHeight()
                , $this->getMount()
        );

        $filter->destroy();
        $compine->destroy();
    }

}
