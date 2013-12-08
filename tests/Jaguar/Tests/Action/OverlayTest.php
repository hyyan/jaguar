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
use Jaguar\Action\Preset;

class OverlayTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Overlay($this->getCanvas(), 75);
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
        $this->getAction()->setMount($mount);
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
                '\Jaguar\Action\Preset'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

}
