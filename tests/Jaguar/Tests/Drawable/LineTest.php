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

use Jaguar\Drawable\Line;
use Jaguar\Coordinate;

class LineTest extends AbstractStyledDrawableTest
{
    public function getDrawable()
    {
        return new Line();
    }

    public function testEquals()
    {
        $line = new Line(new Coordinate(0, 0), new Coordinate(100, 100));
        $clone = clone $line;

        $this->assertTrue($line->equals($clone));

        $clone->getStart()->move(10, 10);

        $this->assertFalse($line->equals($clone));

        $clone->getStart()->move(0, 0);
        $clone->getEnd()->move(50, 50);

        $this->assertFalse($line->equals($clone));

        $clone->getEnd()->move(100, 100);
        $clone->getColor()->setRed(255);

        $this->assertFalse($line->equals($clone));
    }

}
