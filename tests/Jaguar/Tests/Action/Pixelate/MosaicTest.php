<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Pixelate;

use Jaguar\Action\Pixelate\Mosaic;

class MosaicTest extends AbstractPixelateTest
{

    public function getAction()
    {
        return new Mosaic();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Pixelate\Mosaic'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
