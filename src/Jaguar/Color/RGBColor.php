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
     *                             - RGBColor::CHANNEL_RED
     *                             - RGBColor::CHANNEL_GREEN,
     *                             - RGBColor::CHANNEL_BLUE,
     *                             - RGBColor::CHANNEL_ALPHA,
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
        $this->alpha = (((integer) $alpha & 0xFF) << 24);

        return $this;
    }

    /**
     * Get alpha value
     *
     * @return integer
     */
    public function getAlpha()
    {
        return ($this->getValue() >> 24) & 0xff;
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
        $this->red = (((integer) $value & 0xFF) << 16);

        return $this;
    }

    /**
     * Get red value
     *
     * @return integer
     */
    public function getRed()
    {
        return ($this->getValue() >> 16) & 0xFF;
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
        $this->green = (((integer) $value & 0xFF) << 8);

        return $this;
    }

    /**
     * Get green value
     *
     * @return integer
     */
    public function getGreen()
    {
        return ($this->getValue() >> 8) & 0xFF;
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
        $this->blue = (((integer) $value & 0xFF) << 0);

        return $this;
    }

    /**
     * Get blue value
     *
     * @return integer
     */
    public function getBlue()
    {
        return ($this->getValue() >> 0) & 0xFF;
    }

    /**
     * Get color value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->red |
                $this->green |
                $this->blue |
                $this->alpha;
    }

    /**
     * Set new color
     *
     * @param \Jaguar\Color\RGBColor $color
     *
     * @return \Jaguar\Color\RGBColor
     */
    public function setRGBColor(RGBColor $color)
    {
        return $this->setRed($color->getRed())
                        ->setGreen($color->getGreen())
                        ->setBlue($color->getBlue())
                        ->setAlpha($color->getAlpha());
    }

    /**
     * Get new color object which equals to the current one
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
     * Returns a copy of current color, incrementing the alpha channel by the
     * given amount
     *
     * @param integer $alpha
     *
     * @return \Jaguar\Color\RGBColor
     * @throws \InvalidArgumentException
     */
    public function dissolve($alpha)
    {
        return new self(
                $this->getRed()
                , $this->getGreen()
                , $this->getBlue()
                , $this->getAlpha() + $alpha
        );
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

        return new self(
                min(array((integer) ($r / $shade), 255))
                , min(array((integer) ($g / $shade), 255))
                , min(array((integer) ($b / $shade), 255))
                , $alpha
        );
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
        return new self(
                max(array((integer) $this->getRed() * $shade, 0))
                , max(array((integer) $this->getGreen() * $shade, 0))
                , max(array((integer) $this->getBlue() * $shade, 0))
                , $this->getAlpha()
        );
    }

    /**
     * Returns a gray related to the current color
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

        return new self($gray, $gray, $gray, $this->getAlpha());
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
     * Return new color object from rgb integer
     *
     * @param integer $rgb
     * @param boolean $hasalpha true if the rgb contains the alpha and false
     *                          if not
     *
     * @return \Jaguar\Color\RGBColor
     * @throws InvalidArgumentException
     */
    public static function fromValue($rgb, $hasalpha = true)
    {
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = ($rgb >> 0) & 0xFF;
        if ($hasalpha) {
            $a = ($rgb >> 24) & 0xff;

            return new self($r, $g, $b, $a);
        }

        return new self($r, $g, $b);
    }

    private static $HexRegex = '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/';

    /**
     * Retuen new color object from hex string
     *
     * @param string  $hex   color int hex format
     * @param integer $alpha alpha value
     *
     * @return \Jaguar\Color\RGBColor
     * @throws InvalidArgumentException
     */
    public static function fromHex($hex, $alpha = 0)
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

        return new self($color[0], $color[1], $color[2], $alpha);
    }

    /**
     * Blend two colors given an amount
     *
     * @param RGBColor $color1
     * @param RGBColor $color2
     * @param float    $amount The amount of color2 in color1
     *
     * @return RGBColor
     */
    public static function blend(RGBColor $color1, RGBColor $color2, $amount)
    {
        return new self(
                min(255, min($color1->getRed(), $color2->getRed()) + round(abs($color2->getRed() - $color1->getRed()) * $amount))
                , min(255, min($color1->getGreen(), $color2->getGreen()) + round(abs($color2->getGreen() - $color1->getGreen()) * $amount))
                , min(255, min($color1->getBlue(), $color2->getBlue()) + round(abs($color2->getBlue() - $color1->getBlue()) * $amount))
                , min(100, min($color1->getAlpha(), $color2->getAlpha()) + round(abs($color2->getAlpha() - $color1->getAlpha()) * $amount))
        );
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
