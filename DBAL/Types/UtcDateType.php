<?php

namespace Linkin\Component\DoctrineUTCDateTime\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateType;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class UtcDateType extends DateType
{
    use UtcTypeTrait;

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($date, AbstractPlatform $platform)
    {
        if ($date === null) {
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
        if ($date === null) {
            return null;
        }

        $value = \DateTime::createFromFormat('!' . $platform->getDateFormatString(), $date, $this->getUTC());

        if (!$value) {
            throw ConversionException::conversionFailed($date, $this->getName());
        }

        $errors = $value->getLastErrors();

        return $errors['warning_count'] > 0 && (int)$value->format('Y') < 0 ? null : $value;
    }
}
