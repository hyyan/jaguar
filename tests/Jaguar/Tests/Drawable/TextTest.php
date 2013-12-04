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

    public function testEquals()
    {
        $text = $this->getDrawable();
        $clone = clone $text;

        $this->assertTrue($text->equals($clone));

        $clone->setString('Changed The String');
        $this->assertFalse($text->equals($clone));

        $clone->setString($text->getString());
        $clone->getCoordinate()->move(50, 50);
        $this->assertFalse($text->equals($clone));

        $clone->getCoordinate()->move(0, 0);
        $clone->setAngle(90);
        $this->assertFalse($text->equals($clone));

        $clone->setAngle(0);
        $clone->setLineSpacing(2.0);
        $this->assertFalse($text->equals($clone));

        $clone->setLineSpacing(1.0);
        $clone->getFont()->setFontSize(50);
        $this->assertFalse($text->equals($clone));

        $clone->getFont()->setFontSize($text->getFont()->getFontSize());
        $clone->getColor()->setRed(255);
        $this->assertFalse($text->equals($clone));
    }

}
