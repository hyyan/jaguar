<?php

namespace Jaguar\Color;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class TransparentColor extends AbstractColor {

    /**
     * {@inheritdoc}
     */
    public function getValue() {
        return IMG_COLOR_TRANSPARENT;
    }

}

