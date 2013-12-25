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
use Jaguar\Action\Overlay;
use Jaguar\Box;

class OverlayTest extends AbstractActionTest
{

    public function getAction()
    {
        $c = $this->getCanvas();

        return new Overlay($c, 75, new Box($c->getDimension()));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCloneThrowRuntimeException()
    {
        clone $this->getAction();
    }

    /**
     * @dataProvider mountsProvider
     * @expectedException \InvalidArgumentException
     *
     * @param integer $mount
     */
    public function testSetMountThrowInvalieArgumentException($mount)
    {
        $this->getAction()->setAmount($mount);
    }

    /**
     * Overlay Mounts provider
     * @return type
     */
    public function mountsProvider()
    {
        return array(
            array(-5), array(200)
        );
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Overlay'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
