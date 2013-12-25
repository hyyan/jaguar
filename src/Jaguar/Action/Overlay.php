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
use Jaguar\Box;

class Overlay extends AbstractAction
{
    private $amount;
    private $overlay;
    private $box;

    /**
     * construct new overlay action
     *
     * @param \Jaguar\CanvasInterface $canvas
     * @param integer                 $amount in range(0,100)
     * @param \Jaguar\Box             $box    defulat null which means the size of
     *                         given canvas will be used for the given
     *                         overlay.
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(CanvasInterface $overlay, $amount = 100, Box $box = null)
    {
        $this->setOverlay($overlay)->setAmount($amount);
        if (!is_null($box)) {
            $this->setBox($box);
        }
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
     * Set the overlay box
     *
     * Overlay box define a position and the size for overlay to use when it
     * merged with the given canvas
     *
     * @param \Jaguar\Box $box
     *
     * @return \Jaguar\Action\Overlay
     */
    public function setBox(Box $box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get overlay box
     *
     * @return \Jaguar\Box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Set overlay amount
     *
     * @param integer $amount in range(0,100)
     *
     * @return \Jaguar\Action\Overlay
     *
     * @throws \InvalidArgumentException
     */
    public function setAmount($amount)
    {
        if ($amount < 0 || $amount > 100) {
            throw new \InvalidArgumentException('Overlay amount must be in range(0,100)');
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get overlay amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
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

        $box = is_null($this->getBox()) ? new Box($canvas->getDimension()) : $this->getBox();
        $compine = new \Jaguar\Canvas($canvas->getDimension());
        $compine->paste($canvas);
        $compine->paste($this->getOverlay(), null, $box);

        imagelayereffect($canvas->getHandler(), IMG_EFFECT_OVERLAY);

        imagecopymerge(
                $canvas->getHandler()
                , $compine->getHandler()
                , 0
                , 0
                , 0
                , 0
                , $canvas->getWidth()
                , $canvas->getHeight()
                , $this->getAmount()
        );

        $canvas->alphaBlending(true);
        $compine->destroy();
    }

}
