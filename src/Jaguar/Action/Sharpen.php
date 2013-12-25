<?php

/*
 * This file is part of the Jaguar package.
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Action;

use Jaguar\CanvasInterface;

class Sharpen extends AbstractAction
{
    const SHARPEN_MULTISTEP = 'sharpen.multistep';
    const SHARPEN_STRONG = 'sharpen.strong';
    const SHARPEN_MEDIUM = 'sharpen.medium';
    const SHARPEN_SOFT = 'sharpen.soft';

    private $type = null;
    private static $Supported = array(
        self::SHARPEN_MULTISTEP => array(
            array(-1.2, -1, -1.2),
            array(-1, 20, -1),
            array(-1.2, -1, -1.2)
        ),
        self::SHARPEN_STRONG => array(
            array(-1.4, -1.2, -1.4),
            array(-1.2, 16, -1.2),
            array(-1.4, -1.2, -1.4)
        ),
        self::SHARPEN_MEDIUM => array(
            array(-1, -1, -1),
            array(-1, 16, -1),
            array(-1, -1, -1)
        ),
        self::SHARPEN_SOFT => array(
            array(-1, -1, -1),
            array(-1, 20, -1),
            array(-1, -1, -1)
        )
    );

    /**
     * construct new sharpen action
     *
     * @param string $type
     */
    public function __construct($type = self::SHARPEN_MULTISTEP)
    {
        $this->setType($type);
    }

    /**
     * Set sharpen type
     *
     * @param string $type
     *
     * @throws \InvalidArgumentException
     */
    public function setType($type)
    {
        if (!array_key_exists($type, self::$Supported)) {
            throw new \InvalidArgumentException(sprintf(
                    'Invalid Sharpen Type "%s"', $type
            ));
        }
        $this->type = $type;
    }

    /**
     * Get sharpen type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    protected function doApply(CanvasInterface $canvas)
    {
        $matrix = self::$Supported[$this->getType()];
        $con = new Convolution(
                $matrix
                , array_sum(array_map('array_sum', $matrix))
        );
        $con->apply($canvas);
    }

}
