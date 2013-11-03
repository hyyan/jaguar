<?php

namespace Jaguar\Color;

use Jaguar\EqualsInterface;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

interface ColorInterface extends EqualsInterface {

    /**
     * Get color value
     * 
     * @return integer 
     */
    public function getValue();

    /**
     * Get string representation for the current color object
     * @return string 
     */
    public function __toString();
}

