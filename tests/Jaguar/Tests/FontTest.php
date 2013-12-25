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

use Jaguar\Font;

class FontTest extends JaguarTestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEqualsThrowInvalidArgumentException()
    {
        $this->getFont()->equals('invalid');
    }

    public function testEquals()
    {
        $font = $this->getFont();
        $fontClone = clone $font;
        $font2 = new Font($this->getFixture('fonts/arialbi.ttf'));

        $this->assertTrue($font->equals($fontClone));

        $this->assertFalse($font->equals($font2));

        $fontClone->setFontSize(15);
        $this->assertFalse($font->equals($fontClone));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFontconstructorThrowInvalidArgumentExceptionOnNonReadableFiles()
    {
        new Font('non readable file');
    }

    public function testToString()
    {
        $this->assertInternalType(
                'string'
                , (string) $this->getFont()
        );
    }

    public function getFont()
    {
        return new Font($this->getFixture('fonts/arial.ttf'));
    }

}
