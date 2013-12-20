<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable\Border;

use Jaguar\Tests\JaguarTestCase;

abstract class AbstractBorderDrawerTest extends JaguarTestCase
{

    /**
     * Get border drawer
     *
     * @return \Jaguar\Drawable\Border\BorderDrawerInterface
     */
    abstract public function getDrawer();

    /**
     * Get canvas object
     *
     * @return \Jaguar\Canvas
     */
    public function getCanvas()
    {
        return new \Jaguar\Canvas(new \Jaguar\Dimension(100, 100));
    }

    /**
     * Get border object
     *
     * @return \Jaguar\Drawable\Border
     */
    public function getBorder()
    {
        return new \Jaguar\Drawable\Border();
    }

    public function testDraw()
    {
        $this->assertInstanceOf(
                '\Jaguar\Drawable\Border\BorderDrawerInterface'
                , $this->getDrawer()->draw($this->getCanvas(), $this->getBorder())
        );
    }

}
