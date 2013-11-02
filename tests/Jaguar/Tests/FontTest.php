<?php

namespace Jaguar\Tests;

use Jaguar\Font;
use Jaguar\Color;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class FontTest extends JaguarTestCase {

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEqualsThrowInvalidArgumentException() {
        $font = new Font($this->getFixture('fonts/arial.ttf'));
        $font->equals('invalid');
    }

    public function testEquals() {
        $font = new Font($this->getFixture('fonts/arial.ttf'));
        $fontClone = clone $font;
        $font2 = new Font($this->getFixture('fonts/arialbi.ttf'));

        $this->assertTrue($font->equals($fontClone));
        $this->assertFalse($font->equals($font2));

        $fontClone->setSize(15);
        $this->assertFalse($font->equals($fontClone));

        $fontClone->setSize(8);
        $fontClone->setColor(new Color(255));

        $this->assertFalse($font->equals($fontClone));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFontConstrcutorThrowInvalidArgumentException() {
        new Font('non readable file');
    }

    public function testToString() {
        $this->assertInternalType(
                'string'
                , (string) new Font($this->getFixture('fonts/arial.ttf'))
        );
    }

}

