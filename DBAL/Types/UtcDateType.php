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
    public function convertToDatabaseValue($date, AbstractPlatform $platform): ?string
    {
        if (null === $date) {
            return null;
        }

        if ($date instanceof DateTime) {
            return parent::convertToDatabaseValue($date->setTimezone($this::getUTC()), $platform);
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
}
