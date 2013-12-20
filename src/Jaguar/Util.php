<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

final class Util
{

    /**
     * Get resource file's path
     *
     * @param string $file resource path
     *
     * @return string the full path to the resource file
     */
    public static function getResourcePath($file)
    {
        return (__DIR__ . '/Resources/' . $file);
    }

}
