<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Drawable\Text;

use Jaguar\CanvasInterface;
use Jaguar\Drawable\Text;

class Plain implements TextDrawerInterface
{

    /**
     * {@inheritdoc}
     */
    public function draw(CanvasInterface $canvas, Text $text)
    {
        return (boolean) @imagefttext(
                        $canvas->getHandler()
                        , $text->getFontSize()
                        , $text->getAngle()
                        , $text->getCoordinate()->getX()
                        , $text->getCoordinate()->getY() + $text->getFontSize()
                        , $text->getColor()->getValue()
                        , $text->getFont()
                        , $text->getString()
                        , array('linespacing' => $text->getLineSpacing())
        );
    }

}
