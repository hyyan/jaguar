<?php

namespace Jaguar\Tests;

use Jaguar\Color;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ColorTest extends JaguarTestCase {

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEqualThrowInvalidArgumentException() {
        $c = new Color();
        $c->equals('invalid');
    }

    public function testEqual() {
        $c = new Color();
        $clone = clone $c;

        $this->assertTrue($c->equals($clone));

        $clone->setAlpha(50);
        $this->assertFalse($c->equals($clone));
    }

    /**
     * @dataProvider invalidColorsDataProvider
     * @expectedException \InvalidArgumentException
     * 
     * @param integer $r
     * @param integer $g
     * @param integer $b
     * @param integer $a
     */
    public function testSetChannelsThrowException($r, $g, $b, $a) {
        new Color($r, $g, $b, $a);
    }

    /**
     * Invalid Colors Data Provider
     * @return array
     */
    public function invalidColorsDataProvider() {
        return array(
            array(1000, 0, 0, 0),
            array(-1000, 0, 0, 0),
            array(0, 0, 0, 1000),
            array(0, 0, 0, -1000),
        );
    }

    public function testChannels() {
        $c = new Color(255, 150, 0, 50);

        $this->assertEquals($c->getRed(), 255);
        $this->assertEquals($c->getGreen(), 150);
        $this->assertEquals($c->getBlue(), 0);
        $this->assertEquals($c->getAlpha(), 50);
    }

    public function testSetGetColor() {

        $c = new Color();
        $nc = new Color(255, 0, 0);

        $c->setColor($nc);
        $getNc = $c->getColor();


        $this->assertNotSame($getNc, $nc);
        $this->assertTrue($getNc->equals($nc));
    }

    public function testIsOpaque() {
        $c = new Color();
        $this->assertTrue($c->isOpaque());

        $c->setAlpha(127);
        $this->assertFalse($c->isOpaque());
    }

    public function testIsTransparent() {

        $c = new Color();
        $this->assertFalse($c->isTransparent());

        $c->setAlpha(127);
        $this->assertTrue($c->isTransparent());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testIsValidChannelValueThrowInvalidArgumentException() {
        $c = new Color();
        $c->isValidChannelValue(255, 'Unknown Channel');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDissloveThrowInvalidArgumentException() {
        $color = new Color(0, 0, 0, 127);
        $color->dissolve(1);
    }

    public function testDissolve() {
        $color = new Color();
        $alpha = $color->getAlpha();
        $string = (string) $color;

        $disslovedColor = $color->dissolve(2);

        $this->assertNotSame($color, $disslovedColor);
        $this->assertEquals(2 + $alpha, $disslovedColor->getAlpha());
        $this->assertNotEquals($string, (string) $disslovedColor);
    }

    /**
     * @dataProvider getColorsDataProvider
     * 
     * @param integer $r
     * @param integer $g
     * @param integer $b
     */
    public function testBrighter($r, $g, $b) {

        $c = new Color($r, $g, $b);
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
     * @dataProvider getColorsDataProvider
     * 
     * @param integer $r
     * @param integer $g
     * @param integer $b
     */
    public function testDarker($r, $g, $b) {
        $c = new Color($r, $g, $b);
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

    public function getColorsDataProvider() {
        return array(
            array(200, 0, 0), // red 
            array(0, 0, 0, 0), // black (should return gray on bright)
            array(0, 0, 255), // blue (no bright color)
        );
    }

    /**
     * @dataProvider getGrayscaleColorsDataProvider
     * 
     * @param \Jaguar\Color $color
     * @param \Jaguar\Color $expected
     */
    public function testGrayscale(Color $color, Color $expected) {
        $this->assertTrue($color->grayscale()->equals($expected));
    }

    /**
     * gGrayscale Colors DataProvider
     * @return array
     */
    public function getGrayscaleColorsDataProvider() {
        return array(
            array(new Color(50, 50, 100), new Color(56, 56, 56)),
            array(new Color(255, 0, 0), new Color(76, 76, 76)),
            array(new Color(0, 0, 0), new Color(0, 0, 0)),
        );
    }

    /**
     * @dataProvider getRGBDataProvider
     * 
     * @param integer $rgb
     * @param boolean $hasalpha
     * @param \Jaguar\Color $expected
     */
    public function testfromRGB($rgb, $hasalpha, Color $expected) {
        $this->assertTrue(Color::fromRGB($rgb, $hasalpha)->equals($expected));
    }

    /**
     * RGB DataProvider
     * @return array
     */
    public function getRGBDataProvider() {
        return array(
            array(16711680, false, new Color(255, 0, 0)),
            array(838861055, true, new Color(0, 0, 255, 50))
        );
    }

    /**
     * 
     * @dataProvider getInvalidHexColorsDataProvider
     * @expectedException \InvalidArgumentException
     * 
     * @param string $hex
     */
    public function testFromHexThrowInvalidArgumentException($hex) {
        Color::fromHex($hex);
    }

    /**
     * Invalid HexColors DataProvider
     * @return type
     */
    public function getInvalidHexColorsDataProvider() {
        return array(
            array('#0000000'),
            array('#ff'),
            array('#JJJ'),
        );
    }

    /**
     * @dataProvider getHexColorsDataProvider
     * 
     * @param string $hex color in hex format
     * @param \Jaguar\Color $expected 
     */
    public function testFromHex($hex, Color $expected) {
        $this->assertTrue(Color::fromHex($hex)->equals($expected));
    }

    /**
     * Hex Colors DataProvider
     * 
     * @return array
     */
    public function getHexColorsDataProvider() {
        return array(
            array('#ff0000', new Color(255, 0, 0)),
            array('#fff', new Color(255, 255, 255)),
            array('#000', new Color()),
        );
    }

}

