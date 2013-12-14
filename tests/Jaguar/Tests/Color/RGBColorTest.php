<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Color;

use Jaguar\Color\RGBColor;

class RGBColorTest extends AbstractColorTest
{

    public function getColor()
    {
        return new RGBColor();
    }

    public function testEquals()
    {
        $c = $this->getColor();
        $clone = clone $c;

        $this->assertTrue($c->equals($clone));

        $clone->setAlpha(50);
        $this->assertFalse($c->equals($clone));
    }

    /**
     * @dataProvider invalidRGBColorsDataProvider
     * @expectedException \InvalidArgumentException
     *
     * @param integer $r
     * @param integer $g
     * @param integer $b
     * @param integer $a
     */
    public function testSetChannelsThrowException($r, $g, $b, $a)
    {
        new RGBColor($r, $g, $b, $a);
    }

    /**
     * Invalid RGBColors Data Provider
     * @return array
     */
    public function invalidRGBColorsDataProvider()
    {
        return array(
            array(1000, 0, 0, 0),
            array(-1000, 0, 0, 0),
            array(0, 0, 0, 1000),
            array(0, 0, 0, -1000),
        );
    }

    public function testChannels()
    {
        $c = new RGBColor(255, 150, 0, 50);

        $this->assertEquals($c->getRed(), 255);
        $this->assertEquals($c->getGreen(), 150);
        $this->assertEquals($c->getBlue(), 0);
        $this->assertEquals($c->getAlpha(), 50);
    }

    public function testSetGetRGBColor()
    {
        $c = new RGBColor();
        $nc = new RGBColor(255, 0, 0);

        $c->setRGBColor($nc);
        $getNc = $c->getRGBColor();

        $this->assertNotSame($getNc, $nc);
        $this->assertTrue($getNc->equals($nc));
    }

    public function testIsOpaque()
    {
        $c = $this->getColor();
        $this->assertTrue($c->isOpaque());

        $c->setAlpha(127);
        $this->assertFalse($c->isOpaque());
    }

    public function testIsTransparent()
    {
        $c = $this->getColor();
        $this->assertFalse($c->isTransparent());

        $c->setAlpha(127);
        $this->assertTrue($c->isTransparent());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIsValidChannelValueThrowInvalidArgumentException()
    {
        $c = $this->getColor();
        $c->isValidChannelValue(255, 'Unknown Channel');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDissloveThrowInvalidArgumentException()
    {
        $color = new RGBColor(0, 0, 0, 127);
        $color->dissolve(1);
    }

    public function testDissolve()
    {
        $color = $this->getColor();
        $alpha = $color->getAlpha();
        $string = (string) $color;

        $disslovedRGBColor = $color->dissolve(2);

        $this->assertNotSame($color, $disslovedRGBColor);
        $this->assertEquals(2 + $alpha, $disslovedRGBColor->getAlpha());
        $this->assertNotEquals($string, (string) $disslovedRGBColor);
    }

    /**
     * @dataProvider getRGBColorsDataProvider
     *
     * @param integer $r
     * @param integer $g
     * @param integer $b
     */
    public function testBrighter($r, $g, $b)
    {
        $c = new RGBColor($r, $g, $b);
        $bc = $c->brighter();

        $ca = array(
            $c->getRed(),
            $c->getGreen(),
            $c->getBlue(),
            $c->getAlpha()
        );

        $bca = array(
            $bc->getRed(),
            $bc->getGreen(),
            $bc->getBlue(),
            $bc->getAlpha()
        );

        for ($x = 0; $x < count($ca); $x++) {
            $this->assertGreaterThanOrEqual($ca[$x], $bca[$x]);
        }
    }

    /**
     * @dataProvider getRGBColorsDataProvider
     *
     * @param integer $r
     * @param integer $g
     * @param integer $b
     */
    public function testDarker($r, $g, $b)
    {
        $c = new RGBColor($r, $g, $b);
        $dc = $c->darker();

        $ca = array(
            $c->getRed(),
            $c->getGreen(),
            $c->getBlue(),
            $c->getAlpha()
        );

        $dca = array(
            $dc->getRed(),
            $dc->getGreen(),
            $dc->getBlue(),
            $dc->getAlpha()
        );

        for ($x = 0; $x < count($dc); $x++) {
            $this->assertLessThanOrEqual($ca[$x], $dca[$x]);
        }
    }

    public function getRGBColorsDataProvider()
    {
        return array(
            array(200, 0, 0), // red
            array(0, 0, 0, 0), // black (should return gray on bright)
            array(0, 0, 255), // blue (no bright color)
        );
    }

    /**
     * @dataProvider getGrayscaleRGBColorsDataProvider
     *
     * @param \Jaguar\Color\RGBColor $color
     * @param \Jaguar\Color\RGBColor $expected
     */
    public function testGrayscale(RGBColor $color, RGBColor $expected)
    {
        $this->assertTrue($color->grayscale()->equals($expected));
    }

    /**
     * gGrayscale RGBColors DataProvider
     * @return array
     */
    public function getGrayscaleRGBColorsDataProvider()
    {
        return array(
            array(new RGBColor(50, 50, 100), new RGBColor(56, 56, 56)),
            array(new RGBColor(255, 0, 0), new RGBColor(76, 76, 76)),
            array(new RGBColor(0, 0, 0), new RGBColor(0, 0, 0)),
        );
    }

    /**
     * @dataProvider getRGBValuesDataProvider
     *
     * @param integer                $rgb
     * @param boolean                $hasalpha
     * @param \Jaguar\Color\RGBColor $expected
     */
    public function testfromValue($rgb, $hasalpha, RGBColor $expected)
    {
        $this->assertTrue(RGBColor::fromValue($rgb, $hasalpha)->equals($expected));
    }

    /**
     * RGB Values DataProvider
     * @return array
     */
    public function getRGBValuesDataProvider()
    {
        return array(
            array(16711680, false, new RGBColor(255, 0, 0)),
            array(838861055, true, new RGBColor(0, 0, 255, 50))
        );
    }

    /**
     *
     * @dataProvider getInvalidHexRGBColorsDataProvider
     * @expectedException \InvalidArgumentException
     *
     * @param string $hex
     */
    public function testFromHexThrowInvalidArgumentException($hex)
    {
        RGBColor::fromHex($hex);
    }

    /**
     * Invalid HexRGBColors DataProvider
     * @return type
     */
    public function getInvalidHexRGBColorsDataProvider()
    {
        return array(
            array('#0000000'),
            array('#ff'),
            array('#JJJ'),
        );
    }

    /**
     * @dataProvider getHexRGBColorsDataProvider
     *
     * @param string                 $hex      color in hex format
     * @param \Jaguar\Color\RGBColor $expected
     */
    public function testFromHex($hex, RGBColor $expected)
    {
        $this->assertTrue(RGBColor::fromHex($hex)->equals($expected));
    }

    /**
     * Hex RGBColors DataProvider
     *
     * @return array
     */
    public function getHexRGBColorsDataProvider()
    {
        return array(
            array('#ff0000', new RGBColor(255, 0, 0)),
            array('#fff', new RGBColor(255, 255, 255)),
            array('#000', new RGBColor()),
        );
    }

    /**
     * @dataProvider colorsBelndProvider
     *
     * @param \Jaguar\Color\RGBColor $color1
     * @param \Jaguar\Color\RGBColor $color2
     * @param integer                $amount
     * @param \Jaguar\Color\RGBColor $expected
     */
    public function testBlend(RGBColor $color1, RGBColor $color2, $amount, RGBColor $expected)
    {
        $this->assertTrue($expected->equals(RGBColor::blend($color1, $color2, $amount)));
    }

    /**
     * Colors for belnd provider
     *
     * @return array
     */
    public function colorsBelndProvider()
    {
        return array(
            array(
                new RGBColor(230, 0, 0),
                new RGBColor(128, 0, 0),
                1.1,
                new RGBColor(240, 0, 0)
            ),
            array(
                new RGBColor(1, 2, 3),
                new RGBColor(50, 25, 32),
                0.4,
                new RGBColor(21, 11, 15)
            )
        );
    }

}
