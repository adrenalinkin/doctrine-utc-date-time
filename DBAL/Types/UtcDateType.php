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
use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateType;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class UtcDateType extends DateType
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($date, AbstractPlatform $platform): ?string
    {
        if (null === $date) {
            return null;
        }

        if ($date instanceof DateTimeInterface) {
            return parent::convertToDatabaseValue($date->setTimezone(new DateTimeZone('UTC')), $platform);
        }

        throw ConversionException::conversionFailedInvalidType($date, $this->getName(), ['null', 'DateTime']);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($date, AbstractPlatform $platform): ?DateTime
    {
        return $this->convertToDateTime($date, '!'.$platform->getDateFormatString());
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    /**
     * @throws ConversionException
     */
    private function convertToDateTime(?string $dateString, string $dateFormat): ?DateTime
    {
        if (null === $dateString) {
            return null;
        }

        $converted = DateTime::createFromFormat($dateFormat, $dateString, new DateTimeZone('UTC'));

        if (!$converted) {
            throw ConversionException::conversionFailed($dateString, $this->getName());
        }

        $errors = $converted::getLastErrors();

        return $errors['warning_count'] > 0 && (int) $converted->format('Y') < 0 ? null : $converted;
    }
}
