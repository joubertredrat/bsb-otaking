<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueObject;

use App\Exception\ValueObject\Total\InvalidTotalException;
use App\ValueObject\Total;
use PHPUnit\Framework\TestCase;

class TotalTest extends TestCase
{
    public function testAttributes(): void
    {
        $valueExpected = 15;
        $total = new Total($valueExpected);

        self::assertEquals($valueExpected, $total->value);
    }

    public function testAttributesWithInvalidTotal(): void
    {
        $this->expectException(InvalidTotalException::class);
        new Total(-15);
    }
}
