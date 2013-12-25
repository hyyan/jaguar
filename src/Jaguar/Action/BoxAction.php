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

/**
 * Box Action
 *
 * box action is a speical action which can execute actions on a canvas's
 * given area defined by a box  or on the whole canvas except an
 * selected area defined by a box.
 *
 */
class BoxAction extends AbstractAction
{
    private $action;
    private $invert;
    private $box;

    /**
     * construct an new box action
     *
     * @param \Jaguar\Action\ActionInterface $action
     * @param \Jaguar\Box                    $box
     * @param type                           $invert
     */
    public function __construct(ActionInterface $action, Box $box, $invert = false)
    {
        $this->setAction($action);
        $this->setBox($box);
        $this->invertSelection($invert);
    }

    /**
     * Set action
     *
     * @param  \Jaguar\Action\ActionInterface $action
     * @return \Jaguar\Action\BoxAction
     */
    public function setAction(ActionInterface $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \Jaguar\Action\ActionInterface
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set box to apply the action inside it
     *
     * @param \Jaguar\Box $box
     *
     * @return \Jaguar\Action\BoxAction
     */
    public function setBox(Box $box)
    {
        $this->box = $box;

        return $this;
    }

    /**
     * Get box
     *
     * @return \Jaguar\Box
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * Invert the selection box
     *
     * @param string $boolean true to invert the selection box , false to keep
     *                         the selection box
     *
     * @return \Jaguar\Action\BoxAction
     */
    public function invertSelection($boolean)
    {
        $this->invert = (boolean) $boolean;

        return $this;
    }

    /**
     * Check if invert option is enabled
     *
     * @return boolean true if invert selection is enabled , false otherwise
     */
    public function isInvert()
    {
        return $this->invert;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $copy = $canvas->getCopy();
        $this->isInvert() ?
                        // apply the given action on the canvas copy
                        $this->getAction()->apply($canvas) :
                        // apply the given action on the given canvas
                        $this->getAction()->apply($copy);
        // do the magic
        $canvas->paste(
                $copy
                , $this->getBox()
                , $this->getBox()
        );
        // destroy the copy
        $copy->destroy();
    }

}
