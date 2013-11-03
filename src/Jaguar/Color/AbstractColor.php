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

abstract class AbstractColor implements ColorInterface {

    /**
     * {@inheritdoc}
     */
    public function equals($other) {

        if (!($other instanceof ColorInterface)) {
            throw new \InvalidArgumentException('Invalid Color Object');
        }

        return $this->doEquals($other);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString() {
        return get_called_class() .
                '[' . (string) $this->getValue() . ']';
    }

    abstract protected function doEquals(ColorInterface $color);
}

