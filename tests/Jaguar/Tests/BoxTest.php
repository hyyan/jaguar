<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests;

use Jaguar\Box;

class BoxTest extends JaguarTestCase
{
    public function testEqualsThrowInvalidArgumentException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $box = new Box();
        $box->equals('invalid');
    }

    public function testEquals()
    {
        $box = new Box();
        $clone = clone $box;

        $this->assertTrue($box->equals($clone));

        $box->move(50, 50);
        $this->assertFalse($box->equals($clone));

        $box->move(0, 0);
        $box->resize(50, 50);

        $this->assertFalse($box->equals($clone));
    }

    public function testToString()
    {
        $this->assertInternalType('string', (string) new Box());
    }

    /**
     * @dataProvider getRatios
     *
     * @param integer $ratio
     */
    public function testScale($ratio)
    {
        $box = new Box();

        $dw = $box->getWidth();
        $dh = $box->getHeight();

        $box->scale($ratio);

        $this->assertEquals((round($dw * $ratio)), $box->getWidth());
        $this->assertEquals((round($dh * $ratio)), $box->getHeight());
    }

    /**
     * Ratios Dataprovider
     *
     * @return array
     */
    public function getRatios()
    {
        return array(
            array(5),
            array(2),
            array(3.6)
        );
    }

}
