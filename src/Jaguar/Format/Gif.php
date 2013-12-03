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

use Jaguar\ImageFile;
use Jaguar\Exception\CanvasCreationException;
use Jaguar\Exception\CanvasOutputException;
use Jaguar\AbstractCanvas;

class Gif extends AbstractCanvas
{
    /**
     * Check if the given file is gif file
     *
     * @param  string  $filename
     * @return boolean true if gif file,false otherwise
     */
    public static function isGifFile($filename)
    {
        try {
            $image = new ImageFile($filename);
            if (strtolower($image->getMime()) !== @image_type_to_mime_type(IMAGETYPE_GIF)) {
                return false;
            }

            return true;
        } catch (\RuntimeException $ex) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($filename)
    {
        if (false == @imagegif($this->getHandler(), $filename)) {
            throw new CanvasOutputException(sprintf(
                    'Faild Outputting The Gif Canvas "%s" To "%s"'
                    , (string) $this, $filename
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doLoadFromFile($filename)
    {
        $this->assertGifFile($filename);
        $handler = @imagecreatefromgif($filename);
        if (false == $handler) {
            throw new CanvasCreationException(sprintf(
                    'Faild To Create The Gif Canvas From The File "%s"', $filename
            ));
        }
        $this->setHandler($handler);
    }

    /**
     * {@inheritdoc}
     */
    protected function getToStringProperties()
    {
        return array(
            'Format' => 'Gif',
            'Dimension' => (string) $this->getDimension()
        );
    }

    /**
     * Check If The File Is valid gif file
     *
     * @param string $filename
     *
     * @throws \InvalidArgumentException
     */
    protected function assertGifFile($filename)
    {
        if (!self::isGifFile($filename)) {
            throw new \InvalidArgumentException(
            sprintf("(%s) Is Not valid Gif File", $filename)
            );
        }
    }

}
