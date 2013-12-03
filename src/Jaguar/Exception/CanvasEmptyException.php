<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Exception;

class CanvasEmptyException extends CanvasException
{
    public function __construct($message = 'Canvas Handler Is Not Set', $code = null, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
