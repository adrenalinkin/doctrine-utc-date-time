<?php

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
