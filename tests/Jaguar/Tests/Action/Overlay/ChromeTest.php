<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action\Overlay;

use Jaguar\Tests\Action\AbstractActionTest;
use Jaguar\Action\Overlay\Chrome;

class ChromeTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Chrome();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Overlay\Chrome'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

    public function testFoo()
    {

        $canvas = new \Jaguar\Canvas();
        $canvas->fromFile($this->getFixture('lady.jpg'));

        $action = new Chrome();
        $action->apply($canvas);

        $canvas->save('c:/wamp/res.png');
    }

}
