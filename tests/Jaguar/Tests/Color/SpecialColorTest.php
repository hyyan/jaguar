<?php

namespace Jaguar\Tests\Color;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

abstract class SpecialColorTest extends AbstractColorTest {

    public function testEquals() {
        $this->assertTrue($this->getColor()->equals($this->getColor()));
    }

}

