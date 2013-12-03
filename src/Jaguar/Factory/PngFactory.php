<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Factory;

use Jaguar\Format\Png;
use Jaguar\CanvasFactory;

class PngFactory implements CanvasFactory
{
    /**
     * {@inheritdoc}
     */
    public function getCanvas()
    {
        return new Png();
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported($file)
    {
        return Png::isPngFile($file);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension($includeDot = true)
    {
        return image_type_to_extension(IMAGETYPE_PNG, $includeDot);
    }

    /**
     * {@inheritdoc}
     */
    public function getMimeType()
    {
        return image_type_to_mime_type(IMAGETYPE_PNG);
    }

}
