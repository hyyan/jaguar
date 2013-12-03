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

use Jaguar\Tests\JaguarTestCase;

abstract class AbstractStyleTest extends JaguarTestCase
{
    /**
     * Get drawable object
     *
     * @return \Jaguar\Drawable\DrawableInterface
     */
    public function getDrawable()
    {
        return new \Jaguar\Drawable\Pixel();
    }

    /**
     * Get canvas object
     *
     * @return \Jaguar\Drawable\DrawableInterface
     */
    public function getCanvas()
    {
        return new \Jaguar\Canvas(new \Jaguar\Dimension(200, 200));
    }

    abstract public function testApply();
}
