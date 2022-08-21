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
use DateTimeZone;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Linkin\Component\DoctrineUTCDateTime\DBAL\Types\UtcDateType;
use PHPUnit\Framework\TestCase;

/**
 * @author Viktor Linkin <adrenalinkin@gmail.com>
 */
class UtcDateTypeTest extends TestCase
{
    /**
     * @var UtcDateType
     */
    private $sut;

    public static function setUpBeforeClass(): void
    {
        Type::addType('utc_date', UtcDateType::class);
    }

    protected function setUp(): void
    {
        $this->sut = Type::getType('utc_date');
    }

    /**
     * @dataProvider canConvertToDatabaseValueDataProvider
     */
    public function testCanConvertToDatabaseValue(string $defaultTimezone, ?string $value, ?string $expected): void
    {
        date_default_timezone_set($defaultTimezone);

        $platform = new SqlitePlatform();

        $resultNull = $this->sut->convertToDatabaseValue(null, $platform);
        self::assertNull($resultNull);

        $result = $this->sut->convertToDatabaseValue(new DateTime($value), $platform);
        self::assertSame($expected, $result, "Timezone $defaultTimezone");

        $resultImmutable = $this->sut->convertToDatabaseValue(new DateTimeImmutable($value), $platform);
        self::assertSame($expected, $resultImmutable, "Timezone $defaultTimezone");

        date_default_timezone_set('UTC');
    }

    public function canConvertToDatabaseValueDataProvider(): array
    {
        return [
            ['UTC', '1991-05-02 00:00:00', '1991-05-02'],
            ['America/Chicago', '1991-05-02 00:00:00', '1991-05-02'],
            ['Europe/Moscow', '1991-05-02 00:00:00', '1991-05-01'],
        ];
    }

    public function testFailConvertToDatabaseValue(): void
    {
        $platform = new SqlitePlatform();
        $this->expectException(ConversionException::class);
        $this->sut->convertToDatabaseValue('1991-05-02 01:00:00', $platform);
    }

    /**
     * @dataProvider canConvertToPHPValueDataProvider
     */
    public function testCanConvertToPHPValue(string $defaultTimezone): void
    {
        date_default_timezone_set($defaultTimezone);

        $platform = new SqlitePlatform();
        $result = $this->sut->convertToPHPValue(null, $platform);

        self::assertNull($result);

        $result = $this->sut->convertToPHPValue('1991-05-02', $platform);
        $expected = DateTime::createFromFormat(
            $platform->getDateTimeFormatString(),
            '1991-05-02 00:00:00',
            new DateTimeZone('UTC')
        );

        self::assertSame($expected->getTimestamp(), $result->getTimestamp());

        date_default_timezone_set('UTC');
    }

    public function canConvertToPHPValueDataProvider(): array
    {
        return [
            ['UTC'],
            ['America/Chicago'],
            ['Europe/Moscow'],
        ];
    }

    public function testFailConvertToPHPValue(): void
    {
        $platform = new SqlitePlatform();
        $this->expectException(ConversionException::class);
        $this->sut->convertToPHPValue('19999/05/02/04/00/00', $platform);
    }

    public function testRequiresSQLCommentHint(): void
    {
        $platform = new SqlitePlatform();
        $result = $this->sut->requiresSQLCommentHint($platform);

        self::assertTrue($result);
    }
}
