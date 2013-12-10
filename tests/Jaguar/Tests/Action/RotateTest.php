<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\Rotate;

class RotateTest extends AbstractActionTest
{

    public function getAction()
    {
        return new Rotate();
    }

    public function actionFilesProvider()
    {
        return array(
            array(
                $this->getFixture('sky.jpg')
                , new Rotate(90)
                , new \Jaguar\Dimension(300, 400)
            ),
            array(
                $this->getFixture('google.png')
                , new Rotate(180)
                , new \Jaguar\Dimension(538, 190)
            )
        );
    }

    /**
     * @dataProvider actionFilesProvider
     *
     * @param string                $file
     * @param \Jaguar\Action\Rotate $action
     * @param \Jaguar\Dimension     $expectedDimension
     */
    public function testApply($file, Rotate $action, \Jaguar\Dimension $expectedDimension)
    {
        $canvas = new \Jaguar\Canvas();
        $canvas->fromFile($file);

        $this->assertInstanceOf('\Jaguar\Action\Rotate', $action->apply($canvas));
        $this->assertTrue($canvas->getDimension()->equals($expectedDimension));
    }

}
