<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Tests\JaguarTestCase;

abstract class AbstractActionTest extends JaguarTestCase
{

    /**
     * Get action instance
     *
     * @return array
     */
    abstract public function getAction();

    /**
     * Get canvas instance
     *
     * @return \Jaguar\Canvas
     */
    public function getCanvas()
    {
        return new \Jaguar\Canvas(new \Jaguar\Dimension(100, 100));
    }

    /**
     * @expectedException \Jaguar\Exception\CanvasEmptyException
     */
    public function testApplyThrowCanvasEmptyException()
    {
        $this->getAction()->apply(new \Jaguar\Tests\Mock\EmptyCanvasMock());
    }
}
