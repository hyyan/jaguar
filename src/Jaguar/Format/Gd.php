<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Format;

use Jaguar\Exception\CanvasCreationException;
use Jaguar\Exception\CanvasOutputException;
use Jaguar\AbstractCanvas;
use Jaguar\Box;

class Gd extends AbstractCanvas
{
    private $GD2Compressed = true;
    private $GD2chunkSize = 0;

    /**
     * construct new gd canvas
     *
     * @param \Jaguar\Dimension|\Jaguar\CanvasInterface|file|null $source
     * @param boolean                                             $compressed
     * @param integer                                             $size
     */
    public function __construct($source = null, $compressed = true, $size = 0)
    {
        parent::__construct($source);
        $this->setCompressed($compressed)->setChunkSize($size);
    }

    /**
     * Set Compressed
     *
     * @param boolean $bool true to compresse the resource
     *
     * @return \Jaguar\Format\Gd
     */
    public function setCompressed($bool)
    {
        $this->GD2Compressed = $bool;

        return $this;
    }

    /**
     * Get Compressed
     *
     * @return boolean
     *
     * @codeCoverageIgnore
     */
    public function getCompressed()
    {
        return $this->GD2Compressed;
    }

    /**
     * Set Chunk Size
     *
     * @param integer $size
     *
     * @return \Jaguar\Format\Gd
     */
    public function setChunkSize($size)
    {
        $this->GD2chunkSize = (integer) $size;

        return $this;
    }

    /**
     * Get Chunk Size
     *
     * @return integer
     */
    public function getChunkSize()
    {
        return $this->GD2chunkSize;
    }

    /**
     * Check if the given file is gd file
     *
     * @param string $filename
     *
     * @return boolean                   true if gd file,false otherwise
     * @throws \InvalidArgumentException
     */
    public static function isGdFile($filename)
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new \InvalidArgumentException(sprintf(
                    '"%s" Is Not A Readable File', $filename
            ));
        }
        $result = false;
        $f = null;
        if (($f = @fopen($filename, 'r'))) {
            if (($id = @fread($f, 3))) {
                $result = ('gd2' === strtolower($id)) ? true : false;
            }
        }
        @fclose($f);

        return $result;
    }

    /**
     * Load Part Of gd canvas from file
     *
     * <b>Note :</b>
     * This method will not check if the coordinat is valid coordinate for the
     * resource and it won't check the Dimension either.
     *
     * @param string      $file
     * @param \Jaguar\Box $box
     *
     * @return \Jaguar\Format\Gd
     *
     * @throws \InvalidArgumentException
     * @throws \Jaguar\Exception\CanvasCreationException
     */
    public function partFromFile($file, Box $box)
    {
        $this->isValidFile($file);
        $this->assertGdFile($file);
        $x = $box->getX();
        $y = $box->getY();
        $width = $box->getWidth();
        $height = $box->getHeight();
        $result = @imagecreatefromgd2part($file, $x, $y, $width, $height);
        if (false == $result) {
            throw new CanvasCreationException(sprintf(
                    'Faild To Create The Part "%s" Of The Gd Canvas From The File "%s"'
                    , $file, (string) $box
            ));
        }
        $this->setHandler($result);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function doLoadFromFile($filename)
    {
        $this->assertGdFile($filename);
        $result = @imagecreatefromgd2($filename);
        if (false == $result) {
            throw new CanvasCreationException(sprintf(
                    'Faild To Create The Gd Canvas From The File "%s"', $filename
            ));
        }
        $this->setHandler($result);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($filename)
    {
        if (
                false == @imagegd2(
                        $this->getHandler()
                        , $filename
                        , $this->getChunkSize()
                        , $this->getCompressed() == true ? IMG_GD2_COMPRESSED : IMG_GD2_RAW
                )
        ) {
            throw new CanvasOutputException(sprintf(
                    'Faild Outputting The Gd Canvas "%s" To "%s"'
                    , (string) $this, $filename
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getToStringProperties()
    {
        return array(
            'Format' => 'Gd',
            'Dimension' => (string) $this->getDimension(),
            'Compressed' => (string) $this->getCompressed(),
            'ChunkSize' => (string) $this->getChunkSize()
        );
    }

    /**
     * Check If The File Is valid gd file
     *
     * @param string $filename
     *
     * @throws \InvalidArgumentException
     */
    protected function assertGdFile($filename)
    {
        if (!self::isGdFile($filename)) {
            throw new \InvalidArgumentException(
            sprintf("(%s) Is Not valid Gd File", $filename)
            );
        }
    }

}
