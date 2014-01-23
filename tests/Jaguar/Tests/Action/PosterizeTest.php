<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Posterize;

class PosterizeTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Posterize();
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

    public function levelsProvider()
    {
        return array(
            array(101), array(-100)
        );
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Posterize'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
