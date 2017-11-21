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

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class UtcDateTimeType extends DateTimeType
{
    use UtcTypeTrait;

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($date, AbstractPlatform $platform)
    {
        if (is_null($date)) {
            return null;
        }

        if ($date instanceof \DateTime) {
            return parent::convertToDatabaseValue($date->setTimezone($this->getUTC()), $platform);
        }

        throw new ConversionException(sprintf(
            'Invalid date format. Received: "%s". Expected: \DateTime',
            is_object($date) ? get_class($date) : gettype($date)
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($date, AbstractPlatform $platform)
    {
        if (is_null($date)) {
            return null;
        }

        $value = \DateTime::createFromFormat($platform->getDateTimeFormatString(), $date, $this->getUTC());

        if (!$value) {
            throw ConversionException::conversionFailed($date, $this->getName());
        }

        $errors = $value->getLastErrors();

        return $errors['warning_count'] > 0 && (int) $value->format('Y') < 0 ? null : $value;
    }
}
