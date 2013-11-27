<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar;

use Jaguar\Dimension;

class ImageFile extends \SplFileInfo
{
    private $imageExtension;
    private $toString = '';
    protected $imageMime = null;
    protected $imageY = 0;
    protected $imageX = 0;

    /**
     * Construct new Image File Object
     *
     * @param string $file
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __construct($file)
    {
        parent::__construct($file);

        if (!$this->isFile() || !$this->isReadable()) {
            throw new \InvalidArgumentException(
            sprintf('"%s" Is Not A Readable File', $file)
            );
        }

        $imageInfo = @getimagesize($file);
        $pathInfo = @pathinfo($file);

        if (!$imageInfo || !$pathInfo) {
            throw new \RuntimeException(
            sprintf("(%s) is Not Valid Image File ", $file)
            );
        }

        $this->imageExtension = $pathInfo['extension'];
        $this->imageMime = $imageInfo['mime'];
        $this->imageX = $imageInfo[0];
        $this->imageY = $imageInfo[1];
        $this->toString = $imageInfo[3];
    }

    /**
     * Get Image File Extension
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->imageExtension;
    }

    /**
     * Get Image Mime Type
     *
     * @return string
     */
    public function getMime()
    {
        return $this->imageMime;
    }

    /**
     * Get Image Width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->imageX;
    }

    /**
     * Get Image Height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->imageY;
    }

    /**
     * Get image's dimension object
     *
     * @return \Jaguar\Dimension
     */
    public function getDimension()
    {
        return new Dimension($this->getWidth(), $this->getHeight());
    }

    /**
     * Get text string with the correct height="yyy" width="xxx" string that
     * can be used directly in an IMG tag
     *
     * @return string
     */
    public function __toString()
    {
        parent::__toString();

        return $this->toString;
    }

}
