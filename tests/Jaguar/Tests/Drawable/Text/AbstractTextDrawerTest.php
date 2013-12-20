<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable\Text;

use Jaguar\Tests\JaguarTestCase;
use Jaguar\Drawable\Text;
use Jaguar\Canvas;

abstract class AbstractTextDrawerTest extends JaguarTestCase
{

    /**
     * Get text object
     *
     * @return \Jaguar\Drawable\Text
     */
    public function getText()
    {
        return new Text();
    }

    /**
     * Get canvas object
     *
     * @return \Jaguar\Canvas
     */
    public function getCanvas()
    {
        return new Canvas(new \Jaguar\Dimension(100, 100));
    }

    abstract public function getDrawer();

    public function testDraw()
    {
        $this->assertTrue(is_bool(
                        $this->getDrawer()->draw($this->getCanvas(), $this->getText())
        ));
    }

}
