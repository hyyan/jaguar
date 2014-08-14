<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Color;

class RGBColor extends AbstractColor
{
    const CHANNEL_RED = 'red';
    const CHANNEL_GREEN = 'green';
    const CHANNEL_BLUE = 'blue';
    const CHANNEL_ALPHA = 'alpha';

    private static $channels = array(
        self::CHANNEL_RED,
        self::CHANNEL_GREEN,
        self::CHANNEL_BLUE,
        self::CHANNEL_ALPHA,
    );
    private $red;
    private $green;
    private $blue;
    private $alpha;

    /**
     * construct new color object
     *
     * @param integer $r red channel
     * @param integer $g green channel
     * @param integer $b blue channel
     * @param integer $a alpha channel
     */
    public function __construct($r = 0, $g = 0, $b = 0, $a = 0)
    {
        $this->setRed($r)
                ->setGreen($g)
                ->setBlue($b)
                ->setAlpha($a);
    }

    /**
     * Check if the given value is valid for the given channel name
     *
     * @param integer $value
     * @param string  $channel on of the following :
     *                         - RGBColor::CHANNEL_RED
     *                         - RGBColor::CHANNEL_GREEN,
     *                         - RGBColor::CHANNEL_BLUE,
     *                         - RGBColor::CHANNEL_ALPHA,
     *
     * @return boolean
     * @throws \InvalidArgumentException if the channel name is not supported
     */
    public function isValidChannelValue($value, $channel)
    {
        if (!in_array($channel, self::$channels)) {
            throw new \InvalidArgumentException('Invalid Channel Name');
        }

        if ($channel == self::CHANNEL_ALPHA) {
            if ($value >= 0 && $value <= 127) {
                return true;
            }
        } else {
            if ($value >= 0 && $value <= 255) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if the current color is opaque
     *
     * @return boolean true if opaque , false otherwise
     */
    public function isOpaque()
    {
        return 0 == $this->getAlpha();
    }

    /**
     * Checks if the current color is transparent
     *
     * @return boolean true if transparent , false otherwise
     */
    public function isTransparent()
    {
        return 127 == $this->getAlpha();
    }

    /**
     * set alpha value
     *
     * @param integer $alpha in range (0,255)
     *
     * @return \Jaguar\Color\RGBColor
     * @throws \InvalidArgumentException
     */
    public function setAlpha($alpha)
    {
        $this->assertChannelValue($alpha, self::CHANNEL_ALPHA);
        $this->alpha = $alpha;

        return $this;
    }

    /**
     * Get alpha value
     *
     * @return integer
     */
    public function getAlpha()
    {
        return $this->alpha;
    }

    /**
     * Set red value
     *
     * @param integer $value in range (0,255)
     *
     * @return \Jaguar\Color\RGBColor
     * @throws \InvalidArgumentException
     */
    public function setRed($value)
    {
        $this->assertChannelValue($value, self::CHANNEL_RED);
        $this->red = $value;

        return $this;
    }

    /**
     * Get red value
     *
     * @return integer
     */
    public function getRed()
    {
        return $this->red;
    }

    /**
     * Set green value
     *
     * @param integer $value in range (0,255)
     *
     * @return \Jaguar\Color\RGBColor
     * @throws \InvalidArgumentException
     */
    public function setGreen($value)
    {
        $this->assertChannelValue($value, self::CHANNEL_GREEN);
        $this->green = $value;

        return $this;
    }

    /**
     * Get green value
     *
     * @return integer
     */
    public function getGreen()
    {
        return $this->green;
    }

    /**
     * Set blue value
     *
     * @param integer $value in range (0,255)
     *
     * @return \Jaguar\Color\RGBColor
     * @throws \InvalidArgumentException
     */
    public function setBlue($value)
    {
        $this->assertChannelValue($value, self::CHANNEL_BLUE);
        $this->blue = $value;

        return $this;
    }

    /**
     * Get blue value
     *
     * @return integer
     */
    public function getBlue()
    {
        return $this->blue;
    }

    /**
     * Get color value
     *
     * @return integer
     */
    public function getValue()
    {
        return (((int) $this->getRed() & 0xFF) << 16) |
                (((int) $this->getGreen() & 0xFF) << 8) |
                (((int) $this->getBlue() & 0xFF)) |
                (((int) $this->getAlpha() & 0xFF) << 24);
    }

    /**
     * Set color from another color object
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function setFromRGBColor(RGBColor $color)
    {
        return $this->setRed($color->getRed())
                        ->setGreen($color->getGreen())
                        ->setBlue($color->getBlue())
                        ->setAlpha($color->getAlpha());
    }

    /**
     * Set color from array
     *
     * @param array $color array with (red,green,blue,alpha) values
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function setFromArray(array $color)
    {
        return $this->setRed($color[0])
                        ->setGreen($color[1])
                        ->setBlue($color[2])
                        ->setAlpha($color[3]);
    }

    /**
     * Set color from rgb integer
     *
     * @param integer $rgb
     * @param boolean $hasalpha true if the rgb contains the alpha and false if not
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function setFromValue($rgb, $hasalpha = true)
    {
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = ($rgb >> 0) & 0xFF;
        if ($hasalpha) {
            $a = ($rgb >> 24) & 0xff;

            return $this->setRed($r)
                            ->setGreen($g)
                            ->setBlue($b)
                            ->setAlpha($a);
        }

        return $this->setRed($r)
                        ->setGreen($g)
                        ->setBlue($b);
    }

    private static $HexRegex = '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/';

    /**
     * Set color  from hex string
     *
     * @param string  $hex   color in hex format
     * @param integer $alpha alpha value
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function setFromHex($hex, $alpha = 0)
    {
        if (!preg_match(self::$HexRegex, $hex)) {
            throw new \InvalidArgumentException(sprintf(
                    'Inavlid Hex Color "%s"', $hex
            ));
        }

        $ehex = ltrim($hex, '#');

        if (strlen($ehex) === 3) {
            $ehex = $ehex[0] . $ehex[0] .
                    $ehex[1] . $ehex[1] .
                    $ehex[2] . $ehex[2];
        }

        $color = array_map('hexdec', str_split($ehex, 2));

        return $this->setRed($color[0])
                        ->setGreen($color[1])
                        ->setBlue($color[2])
                        ->setAlpha($alpha);
    }

    /**
     * Get new color object which is equal to the current one
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function getRGBColor()
    {
        return new self(
                $this->getRed()
                , $this->getGreen()
                , $this->getBlue()
                , $this->getAlpha()
        );
    }

    /**
     * incrementing the alpha channel by the given amount
     *
     * @param integer $alpha
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function dissolve($alpha)
    {
        return $this->setAlpha($this->getAlpha() + $alpha);
    }

    /**
     * Create Brighter version of the current color using the specified number
     * of shades
     *
     * @param float shade default 0.7
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function brighter($shade = 0.7)
    {
        $r = $this->getRed();
        $g = $this->getGreen();
        $b = $this->getBlue();
        $alpha = $this->getAlpha();

        $i = (integer) (1.0 / (1.0 - $shade));

        if ($r == 0 && $g == 0 && $b == 0) {
            return new self($i, $i, $i, $alpha);
        }

        if ($r > 0 && $r < $i)
            $r = $i;
        if ($g > 0 && $g < $i)
            $g = $i;
        if ($b > 0 && $b < $i)
            $b = $i;

        return $this->setFromArray(array(
                    min(array((integer) ($r / $shade), 255))
                    , min(array((integer) ($g / $shade), 255))
                    , min(array((integer) ($b / $shade), 255))
                    , $alpha
        ));
    }

    /**
     * Create darker version of the current color using the specified number
     * of shades
     *
     * @param float shade default 0.7
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function darker($shade = 0.7)
    {
        return $this->setFromArray(array(
                    max(array((integer) $this->getRed() * $shade, 0))
                    , max(array((integer) $this->getGreen() * $shade, 0))
                    , max(array((integer) $this->getBlue() * $shade, 0))
                    , $this->getAlpha()
        ));
    }

    /**
     * Blend current color with the given new color and the amount
     *
     * @param RGBColor $color  another color
     * @param float    $amount The amount of curennt color in the given color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function blend(RGBColor $color, $amount)
    {
        return $this->setFromArray(array(
                    min(255, min($this->getRed(), $color->getRed()) + round(abs($color->getRed() - $this->getRed()) * $amount))
                    , min(255, min($this->getGreen(), $color->getGreen()) + round(abs($color->getGreen() - $this->getGreen()) * $amount))
                    , min(255, min($this->getBlue(), $color->getBlue()) + round(abs($color->getBlue() - $this->getBlue()) * $amount))
                    , min(100, min($this->getAlpha(), $color->getAlpha()) + round(abs($color->getAlpha() - $this->getAlpha()) * $amount))
        ));
    }

    /**
     * Gray current color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function grayscale()
    {
        $gray = min(
                255
                , round(
                        0.299 * $this->getRed() +
                        0.587 * $this->getGreen() +
                        0.114 * $this->getBlue()
                )
        );

        return $this->setFromArray(array(
                    $gray, $gray, $gray, $this->getAlpha()
        ));
    }

    /**
     * Get string representation for the current color object
     *
     * @return string
     */
    public function __toString()
    {
        return get_called_class()
                . "("
                . $this->getValue()
                . ")"
                . "["
                . "r={$this->getRed()},"
                . "g={$this->getGreen()},"
                . "b={$this->getBlue()},"
                . "alpha={$this->getAlpha()}"
                . "]";
    }

    /**
     * @see RGBColor::setFromValue
     *
     * @codeCoverageIgnore
     */
    public static function fromValue($rgb, $hasalpha = true)
    {
        $color = new self();

        return $color->setFromValue($rgb, $hasalpha);
    }

    /**
     * @see RGBColor::setFromHex
     *
     * @codeCoverageIgnore
     */
    public static function fromHex($hex, $alpha = 0)
    {
        $color = new self();

        return $color->setFromHex($hex, $alpha);
    }

    /**
     * @see RGBColor::setFromArray
     *
     * @codeCoverageIgnore
     */
    public static function fromArray(array $array)
    {
        $color = new self();

        return $color->setFromArray($array);
    }

    /**
     * Assert that the given value for the given channel name is valid
     *
     * @param integer $value
     * @param string  $channel
     *
     * @return \Jaguar\Color\RGBColor
     * @throws \InvalidArgumentException
     */
    protected function assertChannelValue($value, $channel)
    {
        if (!$this->isValidChannelValue($value, $channel)) {
            throw new \InvalidArgumentException(
            sprintf('Invalid Value "%s" For The %s Channel'
                    , $value, ucfirst($value))
            );
        }

        return $this;
    }

}
