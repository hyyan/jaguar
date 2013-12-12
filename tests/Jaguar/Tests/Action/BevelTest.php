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
use Jaguar\Action\Bevel;

class BevelTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Bevel();
    }

    /**
     * @dataProvider widthsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param integer $width
     */
    public function testSetWidthThrowInvalidArgumnetException($width)
    {
        $this->getAction()->setWidth($width);
    }

    /**
     * Bevel widths provider
     *
     * @return array
     */
    public function widthsProvider()
    {
        return array(
            array(0), array(-5)
        );
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Bevel'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
