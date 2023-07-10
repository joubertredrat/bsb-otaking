<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Helper\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testWithDateTime(): void
    {
        $dateTimeExpected = '2023-07-10 20:21:22';
        $dateTimeGot = DateTime::getString(new \DateTimeImmutable($dateTimeExpected));

        self::assertEquals($dateTimeExpected, $dateTimeGot);
    }

    public function testWithNull(): void
    {
        $dateTimeExpected = null;
        $dateTimeGot = DateTime::getString(null);

        self::assertEquals($dateTimeExpected, $dateTimeGot);
    }
}
