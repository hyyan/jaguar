<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action\Preset;

use Jaguar\Action\AbstractAction;
use Jaguar\Canvas;

abstract class AbstractPreset extends AbstractAction
{

    /**
     * Get overlay path
     *
     * @param string $file overlay file
     *
     * @return string the full path
     */
    public function getOverlayPath($file)
    {
        return (__DIR__ . '/../../Resources/Preset/' . $file);
    }

    /**
     * Get overlay canvas
     *
     * @param string $file
     *
     * @return \Jaguar\CanvasInterface
     */
    public function getOverlayCanvas($file)
    {
        $canvas = new Canvas();
        $canvas->fromFile($this->getOverlayPath($file));

        return $canvas;
    }

}
