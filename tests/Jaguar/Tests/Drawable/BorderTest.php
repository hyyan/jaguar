<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable;

use Jaguar\Drawable\Border;

class BorderTest extends AbstractStyledDrawableTest
{

    public function getDrawable()
    {
        return new Border();
    }

    public function testEquals()
    {
        $border = $this->getDrawable();
        $clone = clone $border;

        $this->assertTrue($border->equals($clone));

        $clone->setSize(1000);

        $this->assertFalse($border->equals($clone));
    }

}
