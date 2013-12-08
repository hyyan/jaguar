<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Pixelate;

use Jaguar\Tests\Action\AbstractActionTest;

abstract class AbstractPixelateTest extends AbstractActionTest
{

    /**
     * @dataProvider blockSizeProvider
     * @expectedException \InvalidArgumentException
     *
     * @param integer $size
     */
    public function testSetBlockSizeThrowInvalidArgumentException($size)
    {
        $this->getAction()->setBlockSize($size);
    }

    public function blockSizeProvider()
    {
        return array(
            array(0),
            array(1),
            array(-5)
        );
    }

}
