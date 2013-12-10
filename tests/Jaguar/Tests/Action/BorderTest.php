<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Tests\Action\AbstractActionTest;
use Jaguar\Action\Border;

class BorderTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Border();
    }

    /**
     * @dataProvider sizesProvider
     * @expectedException \InvalidArgumentException
     *
     * @param integer $size
     */
    public function testSetSizeThrowInvalidArgumentException($size)
    {
        $this->getAction()->setSize($size);
    }

    /**
     * Border sizes provider
     *
     * @return array
     */
    public function sizesProvider()
    {
        return array(
            array(0), array(-5)
        );
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Border'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
