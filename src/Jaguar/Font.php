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

class Font extends \SplFileInfo implements EqualsInterface
{
    private $font;
    private $fontsize;

    /**
     * Create new font object
     *
     * @param string  $font     font path
     * @param integer $fontsize font fontsize
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($font, $fontsize = 9)
    {
        parent::__construct($font);

        if (!$this->isFile() || !$this->isReadable()) {
            throw new \InvalidArgumentException(sprintf(
                    'Font File "%s" Is Not Readable', $font
            ));
        }
        $this->font = (string) $font;
        $this->setFontSize($fontsize);
    }

    /**
     * Set font fontsize
     *
     * @param  integer      $fontsize
     * @return \Jaguar\Font
     */
    public function setFontSize($fontsize)
    {
        $this->fontsize = (int) $fontsize;

        return $this;
    }

    /**
     * Get font fontsize
     *
     * @return string
     */
    public function getFontSize()
    {
        return $this->fontsize;
    }

    /**
     * {@inheritdoc}
     */
    public function equals($other)
    {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Font Object');
        }

        if (md5(file_get_contents($this->getPathname())) !== md5(file_get_contents($other->getPathname()))) {
            return false;
        }

        if ($this->getFontSize() !== $other->getFontSize()) {
            return false;
        }

        return true;
    }

}
