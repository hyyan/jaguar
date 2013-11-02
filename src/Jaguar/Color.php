<?php

namespace Jaguar;

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Color implements EqualsInterface {

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
     * Constrcut new color object
     * 
     * @param integer $r red channel
     * @param integer $g green channel
     * @param integer $b blue channel
     * @param integer $a alpha channel
     */
    public function __construct($r = 0, $g = 0, $b = 0, $a = 0) {
        $this->setRed($r)
                ->setGreen($g)
                ->setBlue($b)
                ->setAlpha($a);
    }

    /**
     * Check if the given value is valid for the given channel name
     * 
     * @param integer $value 
     * @param string $channel on of the following :
     *                             - Color::CHANNEL_RED
     *                             - Color::CHANNEL_GREEN,
     *                             - Color::CHANNEL_BLUE,
     *                             - Color::CHANNEL_ALPHA,
     * 
     * @return boolean
     * @throws \InvalidArgumentException if the channel name is not supported
     */
    public function isValidChannelValue($value, $channel) {

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
     * @return Boolean
     */
    public function isOpaque() {
        return 0 === $this->getAlpha();
    }

    /**
     * set alpha value
     * 
     * @param integer $alpha in range (0,255)
     * 
     * @return \Jaguar\Color
     * @throws \InvalidArgumentException
     */
    public function setAlpha($alpha) {
        $this->assertChannelValue($alpha, self::CHANNEL_ALPHA);
        $this->alpha = (((integer) $alpha & 0xFF) << 24);
        return $this;
    }

    /**
     * Get alpha value
     * 
     * @return integer 
     */
    public function getAlpha() {
        return ($this->getRGB() >> 24) & 0xff;
    }

    /**
     * Set red value
     * 
     * @param integer $value in range (0,255)
     * 
     * @return \Jaguar\Color
     * @throws \InvalidArgumentException
     */
    public function setRed($value) {
        $this->assertChannelValue($value, self::CHANNEL_RED);
        $this->red = (((integer) $value & 0xFF) << 16);
        return $this;
    }

    /**
     * Get red value
     * 
     * @return integer
     */
    public function getRed() {
        return ($this->getRGB() >> 16) & 0xFF;
    }

    /**
     * Set green value
     * 
     * @param integer $value in range (0,255)
     * 
     * @return \Jaguar\Color
     * @throws \InvalidArgumentException
     */
    public function setGreen($value) {
        $this->assertChannelValue($value, self::CHANNEL_GREEN);
        $this->green = (((integer) $value & 0xFF) << 8);
        return $this;
    }

    /**
     * Get green value
     * 
     * @return integer 
     */
    public function getGreen() {
        return ($this->getRGB() >> 8) & 0xFF;
    }

    /**
     * Set blue value
     * 
     * @param integer $value in range (0,255)
     * 
     * @return \Jaguar\Color
     * @throws \InvalidArgumentException
     */
    public function setBlue($value) {
        $this->assertChannelValue($value, self::CHANNEL_BLUE);
        $this->blue = (((integer) $value & 0xFF) << 0);
        return $this;
    }

    /**
     * Get blue value
     * 
     * @return integer 
     */
    public function getBlue() {
        return ($this->getRGB() >> 0) & 0xFF;
    }

    /**
     * Get color value
     * 
     * @return integer
     */
    public function getRGB() {
        return $this->red |
                $this->green |
                $this->blue |
                $this->alpha;
    }

    /**
     * Set new color 
     * 
     * @param \Jaguar\Color$color
     * 
     * @return \Jaguar\Color
     */
    public function setColor(Color $color) {
        return $this->setRed($color->getRed())
                        ->setGreen($color->getGreen())
                        ->setBlue($color->getBlue())
                        ->setAlpha($color->getAlpha());
    }

    /**
     * Get new color object which equals to the current one
     * 
     * @return \Jaguar\Color
     */
    public function getColor() {
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
     * @return \Jaguar\Color
     * @throws \InvalidArgumentException
     */
    public function dissolve($alpha) {
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
     * @return \Jaguar\Color
     */
    public function brighter($shade = 0.7) {

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
     * @return \Jaguar\Color
     */
    public function darker($shade = 0.7) {
        return new Color(
                max(array((integer) $this->getRed() * $shade, 0))
                , max(array((integer) $this->getGreen() * $shade, 0))
                , max(array((integer) $this->getBlue() * $shade, 0))
                , $this->getAlpha()
        );
    }

    /**
     * Returns a gray related to the current color
     *
     * @return \Jaguar\Color
     */
    public function grayscale() {
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
     * {@inheritdoc}
     */
    public function equals($other) {
        if (!($other instanceof self)) {
            throw new \InvalidArgumentException('Invalid Color Object');
        }
        return ($other->getRGB() == $this->getRGB()) ? true : false;
    }

    /**
     * Get string representation for the current color object
     * 
     * @return string 
     */
    public function __toString() {
        return get_called_class()
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
     * @return \Jaguar\Color
     * @throws InvalidArgumentException
     */
    public static function fromRGB($rgb, $hasalpha = true) {
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
     * @param string $hex color int hex format
     * @param integer $alpha alpha value
     * 
     * @return \Jaguar\Color
     * @throws InvalidArgumentException
     */
    public static function fromHex($hex, $alpha = 0) {
        
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
     * Assert that the given value for the given channel name is valid
     * 
     * @param integer $value
     * @param string $channel
     * 
     * @return \Jaguar\Color\Color
     * @throws \InvalidArgumentException
     */
    protected function assertChannelValue($value, $channel) {
        if (!$this->isValidChannelValue($value, $channel)) {
            throw new \InvalidArgumentException(
            sprintf('Invalid Value "%s" For The %s Channel'
                    , $value, ucfirst($value))
            );
        }
        return $this;
    }

}

