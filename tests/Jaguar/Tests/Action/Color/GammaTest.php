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
use Jaguar\Action\Color\Gamma;

class GammaTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Gamma();
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
            array(5), array(6)
        );
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Color\Gamma'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
