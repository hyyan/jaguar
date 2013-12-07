<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable;

abstract class FilledDrawableTest extends AbstractStyledDrawableTest
{

    public function testDrawWithFill()
    {
        $canvas = $this->getCanvas();
        $drawable = $this->getDrawable();

        $drawable->fill(true);

        $this->assertSame($canvas, $canvas->draw($drawable));
        $this->assertSame($drawable, $drawable->draw($canvas));

        $drawable->fill(false);

        $this->assertSame($canvas, $canvas->draw($drawable));
        $this->assertSame($drawable, $drawable->draw($canvas));
    }

}
