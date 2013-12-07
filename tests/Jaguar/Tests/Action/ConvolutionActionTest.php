<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests\Action;

use Jaguar\Action\ConvolutionAction;

class ConvolutionActionTest extends AbstractActionTest
{

    public function getAction()
    {
        return new ConvolutionAction(array(
            array(0, 0, 0), array(0, 0, 0), array(0, 0, 0)
        ));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetMatrixThrowRuntimeExceptionIfMainArrayItemsAreNotArrays()
    {
        new ConvolutionAction(array(1, 1, 1));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetMatrixThrowRuntimeExceptionIfMainArrayLengthIsLessThanThree()
    {
        new ConvolutionAction(array(
            array(0, 0, 0), array(0, 0, 0)
        ));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetMatrixThrowRuntimeExceptionIfSubArraysLengthIsLessThanThree()
    {
        new ConvolutionAction(array(
            array(0), array(0), array(0)
        ));
    }

    public function testApply()
    {
        $this->assertInstanceOf(
                'Jaguar\Action\ConvolutionAction', $this->getAction()->apply($this->getCanvas())
        );
    }

}
