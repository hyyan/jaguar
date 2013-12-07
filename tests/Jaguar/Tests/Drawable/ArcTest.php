<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable;

use Jaguar\Drawable\Arc;
use Jaguar\Dimension;

class ArcTest extends FilledDrawableTest
{

    public function getDrawable()
    {
        return new Arc(new Dimension(100, 100));
    }

    public function testEquals()
    {

        $arc = new Arc();
        $clone = clone $arc;

        $this->assertTrue($clone->equals($arc));

        $clone->getCenter()->move(50, 50);

        $this->assertFalse($clone->equals($arc));

        $clone->getCenter()->move(0, 0);
        $clone->setStartDegree(-90);

        $this->assertFalse($clone->equals($arc));

        $clone->setStartDegree(0);
        $clone->setEndDegree(180);

        $this->assertFalse($clone->equals($arc));

        $clone->setEndDegree(360);
        $clone->getDimension()->resize(500, 500);

        $this->assertFalse($clone->equals($arc));

        $clone->getDimension()->resize(0, 0);
        $clone->setRounded(false); // default true

        $this->assertFalse($clone->equals($arc));

        $clone->setRounded(true);
        $clone->connectAngles(true); // default false

        $this->assertFalse($clone->equals($arc));

        $clone->connectAngles(false);
        $clone->connectAnglesToCenter(true); // default false

        $this->assertFalse($clone->equals($arc));

        $clone->connectAnglesToCenter(false);
        $clone->getColor()->setRed(255);

        $this->assertFalse($clone->equals($arc));
    }

}
