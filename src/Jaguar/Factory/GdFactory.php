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

use Jaguar\Format\Gd;
use Jaguar\CanvasFactory;

class GdFactory implements CanvasFactory
{
    /**
     * {@inheritdoc}
     */
    public function getCanvas()
    {
        return new Gd();
    }

    /**
     * {@inheritdoc}
     */
    public function isSupported($file)
    {
        return Gd::isGdFile($file);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtension($includeDot = true)
    {
        $result = "gd2";
        if (true == $includeDot) {
            $result = '.' . $result;
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getMimeType()
    {
        return '';
    }

}
