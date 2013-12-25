<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests;

use Jaguar\ImageFile;
use Jaguar\Dimension;

class ImageFileTest extends JaguarTestCase
{
    /**
     * @dataProvider fixturesDataProvider
     *
     * @param string            $file fixture file
     * @param \Jaguar\Dimension $ed   expected dimension
     * @param type              $em   expected mime type
     * @param type              $ee   expected extension
     */
    public function testAllImageGets($file, Dimension $ed, $em, $ee)
    {
        $if = new ImageFile($file);

        $this->assertTrue($if->getDimension()->equals($ed));
        $this->assertEquals($em, $if->getMime());
        $this->assertEquals($ee, $if->getExtension());
        $this->assertEquals(
                sprintf('width="%s" height="%s"', $if->getWidth(), $if->getHeight())
                , $if->__toString()
        );
    }

    /**
     * Fixtures Data Provider
     *
     * @return array
     */
    public function fixturesDataProvider()
    {
        return array(
            array(
                $this->getFixture('google.png'),
                new Dimension(538, 190),
                'image/png',
                'png'
            ),
            array(
                $this->getFixture('sky.jpg'),
                new Dimension(400, 300),
                'image/jpeg',
                'jpg'
            ),
            array(
                $this->getFixture('linux.gif'),
                new Dimension(256, 256),
                'image/gif',
                'gif'
            )
        );
    }

    public function testconstructorThrowInvalidArgumentException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        new ImageFile('invalid');
    }

    public function testconstructorThrowRuntimeException()
    {
        $this->setExpectedException('\RuntimeException');
        new ImageFile($this->getFixture('fonts/arial.ttf'));
    }

}
