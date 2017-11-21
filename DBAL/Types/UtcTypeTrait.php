<?php

/*
 * This file is part of the DoctrineUTCDateTime component package.
 *
 * (c) Viktor Linkin <adrenalinkin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Linkin\Component\DoctrineUTCDateTime\DBAL\Types;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
trait UtcTypeTrait
{
    /**
     * @var \DateTimeZone|null
     */
    static private $utc = null;

    /**
     * @return \DateTimeZone
     */
    private static function getUTC()
    {
        if (!self::$utc) {
            self::$utc = new \DateTimeZone('UTC');
        }

        return self::$utc;
    }
}
