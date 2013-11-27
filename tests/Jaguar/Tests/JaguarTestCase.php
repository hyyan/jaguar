<?php

/*
 * This file is part of the Jaguar package.
 *
 * (c) Hyyan Abo Fakher <tiribthea4hyyan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Jaguar\Tests;

abstract class JaguarTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Get fixture from fixtures folder
     *
     * @param  string $file
     * @return string the full path for the fixture file
     */
    public function getFixture($file)
    {
        return __DIR__ . '/../Fixtures/' . $file;
    }

}
