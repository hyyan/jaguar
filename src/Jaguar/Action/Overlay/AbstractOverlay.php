<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Overlay;

use Jaguar\Action\AbstractAction;
use Jaguar\Canvas;
use Jaguar\Dimension;

abstract class AbstractOverlay extends AbstractAction
{
    private $canvas;

    /**
     * Get overlay path
     *
     * @param string $file overlay file
     *
     * @return string the full path
     */
    public function getOverlayPath($file)
    {
        return (__DIR__ . '/../../Resources/Overlay/' . $file);
    }

    /**
     * Get overlay canvas
     *
     * @param \Jaguar\Dimension $dimension
     * @param string            $file
     *
     * @return \Jaguar\CanvasInterface
     */
    public function getOverlayCanvas($file)
    {
        $this->canvas = new Canvas();
        $this->canvas->fromFile($this->getOverlayPath($file));

        return $this->canvas;
    }

}
