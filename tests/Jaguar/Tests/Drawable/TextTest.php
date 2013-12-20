<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Drawable;

use Jaguar\Drawable\Text;

class TextTest extends AbstractDrawableTest
{

    public function getDrawable()
    {
        return new Text('Jaguar Rocks!');
    }

    public function testGetBoundingBox()
    {
        $this->assertInstanceOf('\Jaguar\Box', $this->getDrawable()->getBoundingBox());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetLineSpacingThrowInvalidArgumentException()
    {
        $this->getDrawable()->setLineSpacing(-9);
    }

    public function testEquals()
    {
        $text = $this->getDrawable();
        $clone = clone $text;

        $this->assertTrue($text->equals($clone));

        $clone->setString('Changed The String');
        $this->assertFalse($text->equals($clone));

        $clone->setString($text->getString());
        $clone->setAngle(90);
        $this->assertFalse($text->equals($clone));

        $clone->setAngle(0);
        $clone->getFont()->setFontSize(50);
        $this->assertFalse($text->equals($clone));

        $clone->getFont()->setFontSize($text->getFont()->getFontSize());
        $clone->getColor()->setRed(255);
        $this->assertFalse($text->equals($clone));
    }

}
