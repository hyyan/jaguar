<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

interface CanvasFactory
{
    /**
     * Checkif the given file can be loaded by this Format
     *
     * @param string $file file's path
     *
     * @return boolean true if can be loaded false otherwise
     */
    public function isSupported($file);

    /**
     * Get mime type for the canvas Format which this factory handle
     *
     * @return string
     */
    public function getMimeType();

    /**
     * Get extension for the canvas Format which this factory handle
     *
     * @param  boolean $includeDot true to include dot in the extension,false to ignore
     * @return string
     */
    public function getExtension($includeDot = true);

    /**
     * Get new canvas instance
     *
     * @return \Jaguar\CanvasInterface
     */
    public function getCanvas();
}
