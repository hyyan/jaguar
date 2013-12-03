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
use Jaguar\CompressableCanvas;

class Jpeg extends CompressableCanvas
{
    /**
     * Check if the given file is jpeg file
     *
     * @param  string  $filename
     * @return boolean true if jpeg false othewise
     */
    public static function isJpegFile($filename)
    {
        try {
            $image = new ImageFile($filename);
            if (strtolower($image->getMime()) !== @image_type_to_mime_type(IMAGETYPE_JPEG)) {
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
        if (false == @imagejpeg($this->getHandler(), $filename, $this->getQuality())) {
            throw new CanvasOutputException(sprintf(
                    'Faild Outputting The Jpeg Canvas "%s" To "%s"'
                    , (string) $this, $filename
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doLoadFromFile($filename)
    {
        $this->assertJpegFile($filename);
        if (false == ($handler = @imagecreatefromjpeg($filename))) {
            throw new CanvasCreationException(sprintf(
                    'Faild To Create The Jpeg Canvas From The File "%s"', $filename
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
            'Format' => 'Jpeg',
            'Dimension' => (string) $this->getDimension()
        );
    }

    /**
     * Check If The File Is valid jpeg file
     *
     * @param string $filename
     *
     * @throws \InvalidArgumentException
     */
    protected function assertJpegFile($filename)
    {
        if (!self::isJpegFile($filename)) {
            throw new \InvalidArgumentException(
            sprintf("(%s) Is Not valid Jpeg File", $filename)
            );
        }
    }

}
