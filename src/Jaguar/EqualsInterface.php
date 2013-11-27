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

interface EqualsInterface
{
    /**
     * Check that the current object which implements this interfcae is equal
     * to another object from the same type
     *
     * @param mixed $other
     *
     * @throws \InvalidArgumentException if the passed param type is invalid
     */
    public function equals($other);
}
