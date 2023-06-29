<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Timestampable;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TimestampableTest extends TestCase
{
    function testAttributes(): void
    {
        $foo = new class {
            use Timestampable;
        };

        self::assertNull($foo->getUpdatedAt());
        self::assertNull($foo->getUpdatedAt());

        $foo->setCreatedAtNow();
        self::assertInstanceOf(DateTimeImmutable::class, $foo->getCreatedAt());
        $createdAtExpected = new DateTimeImmutable('2023-06-29 15:14:13');
        $foo->setCreatedAt($createdAtExpected);
        self::assertEquals($createdAtExpected, $foo->getCreatedAt());

        $foo->setUpdatedAtNow();
        self::assertInstanceOf(DateTimeImmutable::class, $foo->getUpdatedAt());
        $updatedAtExpected = new DateTimeImmutable('2023-06-29 17:14:13');
        $foo->setUpdatedAt($updatedAtExpected);
        self::assertEquals($updatedAtExpected, $foo->getUpdatedAt());
    }
}
