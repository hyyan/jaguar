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

class Font implements EqualsInterface
{
    private $font;
    private $size;

    /**
     * Creat new font object
     *
     * @param string  $font  font path
     * @param integer $size  font size
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($font, $size = 8)
    {
        $this->setFile($font);
        $this->setSize($size);
    }

    /**
     * Set font file
     *
     * @param string $font font path
     *
     * @return \Jaguar\Font
     * @throws \InvalidArgumentException
     */
    protected function setFile($font)
    {
        if (is_file($font) && is_readable($font)) {
            $this->font = (string) $font;

            return $this;
        }
        throw new \InvalidArgumentException(sprintf(
                'Font File "%s" Is Not Readable', $font
        ));
    }

    /**
     * Get the font file
     *
     * @return string font's path
     */
    public function getFile()
    {
        return $this->font;
    }

    /**
     * Get file object
     * 
     * @return \SplFileInfo
     */
    public function getFileObject()
    {
        return new \SplFileInfo($this->getFile());
    }

    /**
     * Set font size
     *
     * @param  integer      $size
     * @return \Jaguar\Font
     */
    public function setSize($size)
    {
        $this->size = (int) $size;

        return $this;
    }

    /**
     * Get font size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Font Object');
        }

        if (md5(file_get_contents($this->getFile())) !== md5(file_get_contents($other->getFile()))) {
            return false;
        }

        if ($this->getSize() !== $other->getSize()) {
            return false;
        }

        return true;
    }

    /**
     * Get string representation for the current font object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFile();
    }

}
