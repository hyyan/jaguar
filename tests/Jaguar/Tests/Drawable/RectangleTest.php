<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable;

use Jaguar\Drawable\Rectangle;
use Jaguar\Dimension;

class RectangleTest extends FilledDrawableTest
{

    public function getDrawable()
    {
        return new Rectangle(new Dimension(100, 100));
    }

    public function testEquals()
    {
        $rect = $this->getDrawable();
        $clone = clone $rect;

        $this->assertTrue($rect->equals($clone));

        $clone->getDimension()->resize(50, 50);

        $this->assertFalse($rect->equals($clone));

        $clone->setDimension($rect->getDimension());
        $clone->getStart()->move(50, 50);

        $this->assertFalse($rect->equals($clone));

        $clone->getStart()->move(0, 0);
        $clone->getColor()->setRed(255);

        $this->assertFalse($rect->equals($clone));
    }

}
