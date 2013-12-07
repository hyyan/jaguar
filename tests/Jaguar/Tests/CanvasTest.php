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

use Jaguar\Canvas;
use Jaguar\Tests\JaguarTestCase;
use Jaguar\Dimension;

class CanvasTest extends JaguarTestCase
{
    /**
     * Canvas  provider
     *
     * @return array
     */
    public function canvasProvider()
    {
        return array(
            array(new Canvas(new Dimension(100, 100), Canvas::Format_JPEG)),
            array(new Canvas(new Dimension(100, 100), Canvas::Format_GIF)),
            array(new Canvas(new Dimension(100, 100), Canvas::Format_PNG)),
            array(new Canvas(new Dimension(100, 100), Canvas::Format_GD)),
        );
    }

    /**
     * Canvas and files provider
     *
     * @return array
     */
    public function canvasFilesProvider()
    {
        return array(
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_JPEG),
                $this->getFixture('sky.jpg')
            ),
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_GIF),
                $this->getFixture('linux.gif')
            ),
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_PNG),
                $this->getFixture('google.png')
            ),
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_GD),
                $this->getFixture('gd.gd2')
            )
        );
    }

    /**
     * Different canvas and files provider
     *
     * @return array
     */
    public function differentCanvasFilesProvider()
    {
        return array(
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_JPEG),
                $this->getFixture('linux.gif'),
                Canvas::Format_GIF
            ),
            array(new Canvas(new Dimension(100, 100), Canvas::Format_GIF),
                $this->getFixture('sky.jpg'),
                Canvas::Format_JPEG
            ),
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_JPEG),
                $this->getFixture('google.png'),
                Canvas::Format_PNG
            ),
            array(
                new Canvas(new Dimension(100, 100), Canvas::Format_JPEG),
                $this->getFixture('gd.gd2'),
                Canvas::Format_GD
            )
        );
    }

    /**
     * Canvas And Special Methods Provider
     *
     * @return array
     */
    public function canvasAndSpecialMethodsProvider()
    {
        return array(
            array(
                $gd = new Canvas(new Dimension(100, 100), Canvas::Format_GD),
                array(
                    array('setCompressed', array(false), $gd),
                    array('getCompressed', array(), false),
                    array('getChunkSize', array(), 0)
                )
            ),
            array(
                $png = new Canvas(new Dimension(100, 100), Canvas::Format_PNG),
                array(
                    array('setSaveAlpha', array(false), $png),
                    array('getSaveAlpha', array(), false),
                    array('getFilter', array(), \Jaguar\Format\Png::ALL_FILTERS)
                )
            )
        );
    }

    /**
     * @dataProvider canvasFilesProvider
     *
     * @param \Jaguar\Canvas $canvas
     * @param string         $file
     */
    public function testFromFile(Canvas $canvas, $file)
    {
        $result = $canvas->fromFile($file);
        $this->assertTrue($canvas->isHandlerSet());
        $this->assertSame($canvas, $result);
    }

    /**
     * @dataProvider differentCanvasFilesProvider
     *
     * @param \Jaguar\Canvas $canvas
     * @param string         $file
     * @param string         $expectedType
     */
    public function testFromFileCanLoadDifferentFiles(Canvas $canvas, $file, $expectedType)
    {
        $result = $canvas->fromFile($file);
        $this->assertTrue($canvas->isHandlerSet());
        $this->assertSame($canvas, $result);
        $this->assertSame($canvas->getActiveFactoryName(), $expectedType);
    }

    /**
     * @expectedException \Jaguar\Exception\CanvasCreationException
     */
    public function testLoadFromFileThrowCanvasCreationExceptionOnUnsupportedType()
    {
        $canvas = new Canvas();
        $canvas->fromFile($this->getFixture('icon.ico'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetFormatThrowInvalidArgumentException()
    {
        $canvas = new Canvas();
        $canvas->setFormat('unknown Format');
    }

    /**
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testSetGetHandler(Canvas $canvas)
    {
        $new = new Canvas(new Dimension(100, 100));

        $this->assertSame($canvas, $canvas->setHandler($new->getHandler()));
        $this->assertSame($canvas->getHandler(), $new->getHandler());
    }

    /**
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testGetCopy(Canvas $canvas)
    {
        $copy = $canvas->getCopy();

        $this->assertInstanceOf(get_class($canvas), $copy);
        $this->assertNotSame($canvas, $copy);
        $this->assertNotSame($canvas->getHandler(), $copy->getHandler());
        $this->assertTrue($canvas->getDimension()->equals($copy->getDimension()));
    }

    /**
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testSave(Canvas $canvas)
    {
        $path = sys_get_temp_dir() . '/tesSave.canvas';

        if (file_exists($path)) {
            unlink($path);
        }

        $canvas->save($path);

        $this->assertFileExists($path);

        unlink($path);
    }

    /**
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testToString(Canvas $canvas)
    {
        $this->assertInternalType('string', (string) $canvas);
    }

    /**
     * @requires function xdebug_get_headers
     *
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testShow(Canvas $canvas)
    {
        ob_start();
        $key = trim(sprintf('Content-Type: %s', $canvas->getMimeType()));
        $canvas->show();

        $this->assertContains($key, xdebug_get_headers());

        $copy = $canvas->getCopy();
        $copy->fromString(ob_get_contents());

        $this->assertTrue($canvas->getDimension()->equals($copy->getDimension()));
        $this->assertEquals($canvas->getMimeType(), $copy->getMimeType());
        $this->assertEquals($canvas->getExtension(), $copy->getExtension());

        ob_end_clean();
    }

    /**
     * @expectedException \Jaguar\Exception\CanvasEmptyException
     *
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testShowCanCatchExceptionsAndRethrowThem(Canvas $canvas)
    {
        $canvas = new Canvas();
        $canvas->show();
    }

    public function testFactoryManipulationMethods()
    {
        $canvas = new Canvas();
        $name = 'My-JPG';
        $Format = '\Jaguar\Factory\JpegFactory';

        $canvas->addFactory($name, new $Format);

        $this->assertTrue($canvas->hasFactory($name));
        $this->assertInstanceOf($Format, $canvas->getFactory($name));
        $this->assertTrue($canvas->removeFactory($name));
        $this->assertFalse($canvas->getFactory($name));
        $this->assertFalse($canvas->removeFactory('No Found Format'));
    }

    /**
     * @expectedException \RuntimeException
     *
     * @dataProvider canvasProvider
     *
     * @param \Jaguar\Canvas $canvas
     */
    public function testCallThorwRuntimeException(Canvas $canvas)
    {
        $canvas->noopeMethod();
    }

    /**
     * @dataProvider canvasAndSpecialMethodsProvider
     *
     * @param \Jaguar\Canvas $canvas
     * @param array          $data
     */
    public function testCall(Canvas $canvas, array $data)
    {
        foreach ($data as $test) {

            $method = $test[0];
            $arguments = $test[1];
            $return = $test[2];

            $this->assertTrue(is_callable(array($canvas->getActiveCanvas(), $method)));

            if ($return) {
                $this->assertEquals(
                        call_user_func_array(
                                array($canvas, $method)
                                , $arguments
                        ), $return
                );
            }
        }
    }

}
