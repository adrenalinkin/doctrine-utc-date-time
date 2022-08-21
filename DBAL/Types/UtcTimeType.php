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
use Doctrine\DBAL\Types\TimeType;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class UtcTimeType extends TimeType
{
    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($date, AbstractPlatform $platform): ?string
    {
        if ($date instanceof DateTimeInterface) {
            return parent::convertToDatabaseValue($date->setTimezone(new DateTimeZone('UTC')), $platform);
        }

        return parent::convertToDatabaseValue($date, $platform);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($date, AbstractPlatform $platform): ?DateTimeInterface
    {
        $phpDate = parent::convertToPHPValue($date, $platform);

        if (null === $phpDate) {
            return null;
        }

        $formatString = $platform->getTimeFormatString();

        return DateTime::createFromFormat('!'.$formatString, $phpDate->format($formatString), new DateTimeZone('UTC'));
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
