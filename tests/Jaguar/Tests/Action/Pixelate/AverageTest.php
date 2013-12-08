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
use Jaguar\Action\Pixelate\Average;

class AverageTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Average();
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                '\Jaguar\Action\Pixelate\Average'
                , $this->getAction()->apply($this->getCanvas())
        );
    }

    public function testFoo()
    {

        $canvas = new \Jaguar\Canvas();
        $canvas->fromFile($this->getFixture('sky.jpg'));

        $action = new Average(4);
        $action->apply($canvas);

        $canvas->save('c:/wamp/res.png');
    }

}
