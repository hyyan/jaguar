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
use Jaguar\Dimension;
use Jaguar\Exception\CanvasCreationException;
use Jaguar\Exception\CanvasOutputException;
use Jaguar\Exception\CanvasException;
use Jaguar\CompressableCanvas;

class Png extends CompressableCanvas
{
    const NO_FILTER = PNG_NO_FILTER;
    const FILTER_NONE = PNG_FILTER_NONE;
    const FILTER_SUB = PNG_FILTER_SUB;
    const FILTER_UP = PNG_FILTER_UP;
    const FILTER_AVG = PNG_FILTER_AVG;
    const FILTER_PAETH = PNG_FILTER_PAETH;
    const ALL_FILTERS = PNG_ALL_FILTERS;

    private $PNGIsSaveAlpha;
    private $filter;

    /**
     * construct new png canvas
     *
     * @param \Jaguar\Dimension|\Jaguar\CanvasInterface|file|null $source
     * @param integer                                             $quality   default 40
     * @param boolean                                             $saveAlpha default true
     */
    public function __construct(
    $source = null, $quality = 40, $saveAlpha = true, $filter = self::ALL_FILTERS)
    {
        parent::__construct($source, $quality);
        $this->setSaveAlpha($saveAlpha);
        $this->setFilter($filter);
    }

    /**
     * Save Alpha Channel Information
     *
     * Sets the flag to attempt to save full alpha channel information
     * (as opposed to single-color transparency) when <b>saving</b> PNG images.
     *
     * Also Note that the alphaBelnding will be set to false in order to enable
     * this option.
     *
     * <b>Note </b>
     * Alpha channel is not supported by all browsers.
     *
     * @param boolean $bool
     *
     * @return Jaguar\Format\Png
     */
    public function setSaveAlpha($bool)
    {
        $this->PNGIsSaveAlpha = (boolean) $bool;

        return $this;
    }

    /**
     * Get Save Alpha
     *
     * Check if the channel information will be saved with canvas or not
     *
     * @return boolean
     *
     */
    public function getSaveAlpha()
    {
        return $this->PNGIsSaveAlpha;
    }

    /**
     * Set the png filter constant
     *
     * @param integer $filter
     *
     * @return Jaguar\Format\Png
     */
    public function setFilter($filter)
    {
        $validFilters = self::NO_FILTER |
                self::FILTER_NONE | self::FILTER_SUB |
                self::FILTER_UP | self::FILTER_AVG |
                self::FILTER_PAETH | self::ALL_FILTERS;

        $filter = $filter & $validFilters;

        $this->filter = (integer) $filter;

        return $this;
    }

    /**
     * Get the png filter constant
     *
     * @return integer
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Check if the given file is png file
     *
     * @param  string  $filename
     * @return boolean true if png file,false otherwise
     */
    public static function isPngFile($filename)
    {
        try {
            $image = new ImageFile($filename);
            if (strtolower($image->getMime()) !== @image_type_to_mime_type(IMAGETYPE_PNG)) {
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
        try {
            $this->saveAlpha($this, $this->getSaveAlpha());
        } catch (CanvasException $e) {
            throw new CanvasOutputException($e->getMessage());
        }
        $quality = 9 - floor(($this->getQuality() * 9) / 100);
        if (false == @imagepng($this->getHandler(), $filename, $quality, $this->getFilter())) {
            throw new CanvasOutputException(sprintf(
                    'Faild Outputting The Png Canvas "%s" To "%s"'
                    , (string) $this, $filename
            ));
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doLoadFromFile($filename)
    {
        $this->assertPngFile($filename);
        $handler = @imagecreatefrompng($filename);
        if (false == $handler) {
            throw new CanvasCreationException(sprintf(
                    'Faild To Create The Png Canvas From The File "%s"', $filename
            ));
        }
        $this->setHandler($handler);
    }

    /**
     * Save The Alpha Channel Information For Png Resource
     *
     * @param Jaguar\Format\Png $png
     * @param boolean           $flag true to save false to ignore
     *
     * @return \Jaguar\Format\Png
     * @throws \Jaguar\Exception\CanvasException
     */
    protected function saveAlpha(Png $png, $flag)
    {
        if ($flag) {
            $png->alphaBlending(false);
            if (false == @imagesavealpha($png->getHandler(), $flag)) {
                throw new CanvasException(sprintf(
                        'Faild Saving The Alpha Channel Information To The Png Canvas "%s"'
                        , (string) $this
                ));
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getToStringProperties()
    {
        return array(
            'Format' => 'Png',
            'Dimension' => (string) $this->getDimension(),
            'Alpha' => (string) $this->getSaveAlpha()
        );
    }

    /**
     * Check If The File Is valid png file
     * @param string $filename
     *
     * @throws \InvalidArgumentException
     */
    protected function assertPngFile($filename)
    {
        if (!self::isPngFile($filename)) {
            throw new \InvalidArgumentException(sprintf(
                    '(%s) Is Not valid Png File', $filename
            ));
        }
    }

}
