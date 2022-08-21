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

namespace DBAL\Types;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateTimeType;
use PHPUnit\Framework\TestCase;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class UtcDateTimeTypeTest extends TestCase
{
    /**
     * @var UtcDateTimeType
     */
    private $sut;

    public static function setUpBeforeClass(): void
    {
        Type::addType('utc_datetime', UtcDateTimeType::class);
    }

    protected function setUp(): void
    {
        $this->sut = Type::getType('utc_datetime');
    }

    /**
     * @dataProvider convertToDatabaseValueDataProvider
     */
    public function testCanConvertToDatabaseValue(?DateTimeInterface $value, ?string $expected): void
    {
        $platform = new SqlitePlatform();
        $result = $this->sut->convertToDatabaseValue($value, $platform);

        self::assertSame($expected, $result);
    }

    public function convertToDatabaseValueDataProvider(): array
    {
        $zone = new DateTimeZone('Europe/Moscow');

        return [
            [null, null],
            [new DateTime('1991-02-05 04:00:00', $zone), '1991-02-05 01:00:00'],
            [new DateTimeImmutable('1991-02-05 04:00:00', $zone), '1991-02-05 01:00:00'],
        ];
    }

    public function testFailConvertToDatabaseValue(): void
    {
        $platform = new SqlitePlatform();
        $this->expectException(ConversionException::class);
        $this->sut->convertToDatabaseValue('1991-02-05 01:00:00', $platform);
    }

    public function testCanConvertToPHPValue(): void
    {
        $platform = new SqlitePlatform();
        $result = $this->sut->convertToPHPValue(null, $platform);

        self::assertNull($result);

        $result = $this->sut->convertToPHPValue('1991-02-05 04:00:00', $platform);
        $expected = DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            '1991-02-05 04:00:00',
            new DateTimeZone('UTC')
        );

        self::assertSame($expected->getTimestamp(), $result->getTimestamp());
    }

    public function testFailConvertToPHPValue(): void
    {
        $platform = new SqlitePlatform();
        $this->expectException(ConversionException::class);
        $this->sut->convertToPHPValue('19910205040000', $platform);
    }

    public function testRequiresSQLCommentHint(): void
    {
        $platform = new SqlitePlatform();
        $result = $this->sut->requiresSQLCommentHint($platform);

        self::assertTrue($result);
    }
}
