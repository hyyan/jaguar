<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Mock;

class EmptyCanvasMock extends CanvasMock
{
    public function isHandlerSet()
    {
        return false;
    }

    public function getHandler()
    {
        return false;
    }

}
