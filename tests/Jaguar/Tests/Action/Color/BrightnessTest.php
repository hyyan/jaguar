<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Color;

use Jaguar\Tests\Action\AbstractActionTest;
use Jaguar\Action\Color\Brightness;

class BrightnessTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Brightness();
    }

    /**
     * @dataProvider levelsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param integer $level
     */
    public function testSetLevelThrowInvalidArugmentException($level)
    {
        $this->getAction()->setLevel($level);
    }

    /**
     * Level Provider
     *
     * @return array
     */
    public function levelsProvider()
    {
        return array(
            array(101), array(-101)
        );
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Color\Brightness'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
