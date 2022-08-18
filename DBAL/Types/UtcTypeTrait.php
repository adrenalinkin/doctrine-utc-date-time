<?php

declare(strict_types=1);

/*
 * This file is part of the DoctrineUTCDateTime component package.
 *
 * (c) Viktor Linkin <adrenalinkin@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Linkin\Component\DoctrineUTCDateTime\DBAL\Types;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Types\ConversionException;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
trait UtcTypeTrait
{
    /**
     * @var DateTimeZone
     */
    private static $utc;

    private static function getUTC(): DateTimeZone
    {
        if (!self::$utc) {
            self::$utc = new DateTimeZone('UTC');
        }

        return self::$utc;
    }

    /**
     * @throws ConversionException
     */
    private function convertToDateTime(?string $dateString, string $dateFormat): ?DateTime
    {
        if (null === $dateString) {
            return null;
        }

        $converted = DateTime::createFromFormat($dateFormat, $dateString, self::getUTC());

        if (!$converted) {
            throw ConversionException::conversionFailed($dateString, $this->getName());
        }

        $errors = $converted::getLastErrors();

        return $errors['warning_count'] > 0 && (int) $converted->format('Y') < 0 ? null : $converted;
    }
}
